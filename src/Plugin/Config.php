<?php
/**
 * Copyright © Vaimo Group. All rights reserved.
 * See LICENSE_VAIMO.txt for license details.
 */
namespace Vaimo\GeckoDriver\Plugin;

use Vaimo\GeckoDriver\Installer\PlatformAnalyser as Platform;

class Config
{
    const REQUEST_VERSION = 'base';
    const REQUEST_DOWNLOAD = 'base';
    
    /**
     * @var \Composer\Package\PackageInterface
     */
    private $configOwner;

    /**
     * @param \Composer\Package\PackageInterface $configOwner
     */
    public function __construct(
        \Composer\Package\PackageInterface $configOwner
    ) {
        $this->configOwner = $configOwner;
    }

    public function getPreferences()
    {
        $extra = $this->configOwner->getExtra();

        $defaults = [
            'version' => null
        ];

        return array_replace(
            $defaults,
            isset($extra['geckodriver']) ? $extra['geckodriver'] : []
        );
    }

    public function getDriverName()
    {
        return 'GeckoDriver';
    }
    
    public function getRequestUrlConfig()
    {
        $baseUrl = 'https://geckodriver.storage.googleapis.com';
        
        return [
            self::REQUEST_VERSION => sprintf('%s/LATEST_RELEASE', $baseUrl),
            self::REQUEST_DOWNLOAD => sprintf('%s/{{version}}/{{file}}', $baseUrl)
        ];
    }
    
    public function getBrowserBinaryPaths()
    {
        return [
            Platform::TYPE_LINUX32 => [
                '/usr/bin/google-chrome'
            ],
            Platform::TYPE_LINUX64 => [
                '/usr/bin/google-chrome'
            ],
            Platform::TYPE_MAC64 => [
                '/Applications/Google\ Chrome.app/Contents/MacOS/Google\ Chrome'
            ]
        ];
    }
    
    public function getBrowserVersionPollingConfig()
    {
        return [
            '%s -version' => ['Google Chrome %s']  
        ];
    }
    
    public function getDriverVersionPollingConfig()
    {
        return [
            '%s --version' => ['GeckoDriver %s (']
        ];
    }
    
    public function getBrowserDriverVersionMap()
    {
        return [
            '72' => '',
            '69' => '2.44',
            '68' => '2.42',
            '67' => '2.41',
            '66' => '2.40',
            '65' => '2.38',
            '64' => '2.37',
            '63' => '2.36',
            '62' => '2.35',
            '61' => '2.34',
            '60' => '2.33',
            '57' => '2.28',
            '54' => '2.25',
            '53' => '2.24',
            '51' => '2.22',
            '44' => '2.19',
            '42' => '2.15'
        ];
    }
    
    public function getRemoteFileNames()
    {
        return [
            Platform::TYPE_LINUX32 => 'geckodriver_linux32.zip',
            Platform::TYPE_LINUX64 => 'geckodriver_linux64.zip',
            Platform::TYPE_MAC64 => 'geckodriver_mac64.zip',
            Platform::TYPE_WIN32 => 'geckodriver_win32.zip',
            Platform::TYPE_WIN64 => 'geckodriver_win32.zip'
        ];
    }

    public function getExecutableFileNames()
    {
        return [
            Platform::TYPE_LINUX32 => 'geckodriver',
            Platform::TYPE_LINUX64 => 'geckodriver',
            Platform::TYPE_MAC64 => 'geckodriver',
            Platform::TYPE_WIN32 => 'geckodriver.exe',
            Platform::TYPE_WIN64 => 'geckodriver.exe'
        ];
    }
}
