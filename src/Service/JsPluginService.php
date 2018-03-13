<?php declare(strict_types=1);

namespace Project\Service;

use Project\Configuration;

/**
 * Class JsPluginService
 * @package Project\Service
 */
class JsPluginService
{
    /** @var Configuration $configuration */
    private $configuration;

    /**
     * JsPluginService constructor.
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     *
     *
     * @return array
     */
    public function getMainPackages(): array
    {
        $jsMainPackage = [];
        $jsBox = $this->configuration->getEntryByName('js-boxes');

        if (isset($jsBox['main'])) {
            foreach ($jsBox['main'] as $package => $enabled) {
                if ($enabled === true) {
                    $jsMainPackage[] = $this->getPackageByPackageName($package);
                }
            }
        }

        return $jsMainPackage;
    }

    /**
     *
     *
     * @param string $routeName
     * @return array
     */
    public function getPackagesByRouteName(string $routeName): array
    {
        $jsRoutePackage = [];
        $route = $this->configuration->getEntryByName('route')[$routeName];

        if (empty($route) === false) {
            if (empty($route['js-packages']) === false) {
                foreach ($route['js-packages'] as $routePackage => $enabled) {
                    if ($enabled === true) {
                        $jsRoutePackage[] = $this->getPackageByPackageName($routePackage);
                    }
                }
            }
        }

        return $jsRoutePackage;
    }

    /**
     *
     *
     * @param string $packageName
     * @return string
     */
    protected function getPackageByPackageName(string $packageName): string
    {
        $jsPackage = $this->configuration->getEntryByName('js-packages');

        if (isset($jsPackage[$packageName]) === false) {
            return '';
        }
        return $jsPackage[$packageName];
    }
}