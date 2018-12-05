<?php
/**
 * Copyright © Vaimo Group. All rights reserved.
 * See LICENSE_VAIMO.txt for license details.
 */
namespace Vaimo\GeckoDriver\Installer;

use Vaimo\GeckoDriver\Plugin\Config;

class ProjectAnalyser
{
    /**
     * @var \Composer\Package\Version\VersionParser
     */
    private $versionParser;
    
    /**
     * @var \Vaimo\GeckoDriver\Plugin\Config
     */
    private $pluginConfig;

    /**
     * @var \Vaimo\GeckoDriver\Installer\EnvironmentAnalyser
     */
    private $environmentAnalyser;

    /**
     * @var \Vaimo\GeckoDriver\Installer\PlatformAnalyser
     */
    private $platformAnalyser;

    /**
     * @var \Vaimo\GeckoDriver\Installer\VersionResolver
     */
    private $versionResolver;

    /**
     * @var \Composer\Package\CompletePackage
     */
    private $ownerPackage;
    
    /**
     * @var \Vaimo\GeckoDriver\Installer\Utils
     */
    private $utils;
    
    /**
     * @param \Vaimo\GeckoDriver\Plugin\Config $pluginConfig
     */
    public function __construct(
        \Vaimo\GeckoDriver\Plugin\Config $pluginConfig
    ) {
        $this->pluginConfig = $pluginConfig;

        $this->environmentAnalyser = new \Vaimo\GeckoDriver\Installer\EnvironmentAnalyser($pluginConfig);

        $this->versionParser = new \Composer\Package\Version\VersionParser();

        $this->platformAnalyser = new \Vaimo\GeckoDriver\Installer\PlatformAnalyser();
        $this->versionResolver = new \Vaimo\GeckoDriver\Installer\VersionResolver();
        $this->utils = new \Vaimo\GeckoDriver\Installer\Utils();
    }
    
    public function resolveInstalledDriverVersion($binaryDir)
    {
        $platformCode = $this->platformAnalyser->getPlatformCode();

        $executableNames = $this->pluginConfig->getExecutableFileNames();
        $remoteFiles = $this->pluginConfig->getRemoteFileNames();

        if (!isset($executableNames[$platformCode], $remoteFiles[$platformCode])) {
            throw new \Exception('Failed to resolve a file for the platform. Download driver manually');
        }

        $executableName = $executableNames[$platformCode];

        return $this->versionResolver->pollForVersion(
            [$this->utils->composePath($binaryDir, $executableName)],
            $this->pluginConfig->getDriverVersionPollingConfig()
        );
    }

    public function resolveRequiredDriverVersion()
    {
        $preferences = $this->pluginConfig->getPreferences();
        $requestConfig = $this->pluginConfig->getRequestUrlConfig();

        $version = $preferences['version'];
        
        if (!$preferences['version']) {
            $version = $this->resolveBrowserDriverVersion(
                $this->environmentAnalyser->resolveBrowserVersion()
            );

            $versionCheckUrl = $requestConfig[Config::REQUEST_VERSION];

            if (!$version && $versionCheckUrl) {
                $version = trim(@file_get_contents($versionCheckUrl));
            }
        }

        try {
            $this->versionParser->parseConstraints($version);
        } catch (\UnexpectedValueException $exception) {
            throw new \Exception(sprintf('Incorrect version string: "%s"', $version));
        }
        
        return $version;
    }

    private function resolveBrowserDriverVersion($browserVersion)
    {
        $chromeVersion = $browserVersion;

        if (!$chromeVersion) {
            return '';
        }

        $majorVersion = strtok($chromeVersion, '.');

        $driverVersionMap = $this->pluginConfig->getBrowserDriverVersionMap();

        foreach ($driverVersionMap as $browserMajor => $driverVersion) {
            if ($majorVersion < $browserMajor) {
                continue;
            }

            return $driverVersion;
        }

        return '';
    }

    public function resolvePackageForNamespace(array $packages, $namespace)
    {
        if ($this->ownerPackage === null) {
            foreach ($packages as $package) {
                if ($package->getType() !== 'composer-plugin') {
                    continue;
                }

                $autoload = $package->getAutoload();

                if (!isset($autoload['psr-4'])) {
                    continue;
                }

                $matches = array_filter(
                    array_keys($autoload['psr-4']),
                    function ($item) use ($namespace) {
                        return strpos($namespace, rtrim($item, '\\')) === 0;
                    }
                );

                if (!$matches) {
                    continue;
                }

                $this->ownerPackage = $package;

                break;
            }
        }

        if (!$this->ownerPackage) {
            throw new \Exception('Failed to detect the plugin package');
        }

        return $this->ownerPackage;
    }
}
