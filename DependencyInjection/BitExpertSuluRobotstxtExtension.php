<?php
/*
 * This file is part of the Sulu Robotstxt bundle.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace BitExpert\Sulu\RobotstxtBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class BitExpertSuluRobotstxtExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container): void
    {
        if ($container->hasExtension('sulu_admin')) {
            $container->prependExtensionConfig(
                'sulu_admin',
                [
                    'forms' => [
                        'directories' => [
                            __DIR__.'/../Resources/config/forms',
                        ],
                    ],
                    'lists' => [
                        'directories' => [
                            __DIR__.'/../Resources/config/lists',
                        ],
                    ],
                    'resources' => [
                        'robotstxt' => [
                            'routes' => [
                                'list' => 'bitexpert.get_robotstxt_list',
                                'detail' => 'bitexpert.get_robotstxt',
                            ],
                        ],
                    ],
                ]
            );
        }

        $container->loadFromExtension('framework', [
            'default_locale' => 'en',
            'translator' => ['paths' => [__DIR__.'/../Resources/config/translations/']],
        ]);

        if ($container->hasExtension('doctrine_migrations')) {
            $container->prependExtensionConfig('doctrine_migrations', [
                'migrations_paths' => [
                    'BitExpert\\Sulu\\RobotstxtBundle\\Migrations' => __DIR__.'/../Migrations',
                ],
            ]);
        }
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
    }
}
