<?php
/**
 * Copyright © Vaimo Group. All rights reserved.
 * See LICENSE_VAIMO.txt for license details.
 */
namespace Vaimo\GeckoDriver\Installer;

class EnvironmentAnalyser
{
    /**
     * @var \Vaimo\GeckoDriver\Plugin\Config
     */
    private $pluginConfig;
    
    /**
     * @var \Vaimo\GeckoDriver\Installer\PlatformAnalyser
     */
    private $platformAnalyser;
    
    /**
     * @var \Vaimo\GeckoDriver\Installer\VersionResolver
     */
    private $versionResolver;

    /**
     * @param \Vaimo\GeckoDriver\Plugin\Config $pluginConfig
     */
    public function __construct(
        \Vaimo\GeckoDriver\Plugin\Config $pluginConfig
    ) {
        $this->pluginConfig = $pluginConfig;
        
        $this->platformAnalyser = new \Vaimo\GeckoDriver\Installer\PlatformAnalyser();
        $this->versionResolver = new \Vaimo\GeckoDriver\Installer\VersionResolver();
    }

    public function resolveBrowserVersion()
    {
        $platformCode = $this->platformAnalyser->getPlatformCode();
        $binaryPaths = $this->pluginConfig->getBrowserBinaryPaths();

        if (!isset($binaryPaths[$platformCode])) {
            return '';
        }

        return $this->versionResolver->pollForVersion(
            $binaryPaths[$platformCode],
            $this->pluginConfig->getBrowserVersionPollingConfig()
        );
    }
}
