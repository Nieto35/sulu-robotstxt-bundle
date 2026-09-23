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

namespace BitExpert\Sulu\RobotstxtBundle\Admin;

use BitExpert\Sulu\RobotstxtBundle\Entity\Robotstxt;
use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\View\ToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;
use Sulu\Bundle\PageBundle\Admin\PageAdmin;
use Sulu\Component\Security\Authorization\PermissionTypes;
use Sulu\Component\Security\Authorization\SecurityCheckerInterface;
use Sulu\Component\Security\Authorization\SecurityCondition;

class RobotstxtAdmin extends Admin
{
    final public const SYSTEM = 'BitExpert';
    final public const SECURITY_CONTEXT = 'bitexpert.robotstxt';
    final public const ROBOTSTXT_LIST_KEY = 'robotstxt';
    final public const ROBOTSTXT_LIST_VIEW = 'bitexpert.robotstxt_list';

    public function __construct(
        private readonly ViewBuilderFactoryInterface $viewBuilderFactory,
        private readonly SecurityCheckerInterface    $securityChecker
    ) {
    }

    public function configureViews(ViewCollection $viewCollection): void
    {
        $securityCondition = new SecurityCondition(static::SECURITY_CONTEXT, null, null, null, self::SYSTEM);

        $toolbarActions = [];

        if ($this->securityChecker->hasPermission($securityCondition, PermissionTypes::ADD)) {
            $toolbarActions[] = new ToolbarAction('sulu_admin.add');
        }

        if ($this->securityChecker->hasPermission($securityCondition, PermissionTypes::DELETE)) {
            $toolbarActions[] = new ToolbarAction('sulu_admin.delete');
        }

        if ($this->securityChecker->hasPermission($securityCondition, PermissionTypes::VIEW)) {
            $viewCollection->add(
                $this->viewBuilderFactory
                    ->createFormOverlayListViewBuilder(static::ROBOTSTXT_LIST_VIEW, '/robotstxt')
                    ->setResourceKey(Robotstxt::RESOURCE_KEY)
                    ->setListKey(self::ROBOTSTXT_LIST_KEY)
                    ->addListAdapters(['table'])
                    ->addAdapterOptions(['table' => ['skin' => 'light']])
                    ->addRouterAttributesToListRequest(['webspace'])
                    ->addRouterAttributesToFormRequest(['webspace'])
                    ->disableSearching()
                    ->setFormKey('robotstxt_details')
                    ->setTabTitle('robotstxt.title')
                    ->setTabOrder(2048)
                    ->addToolbarActions($toolbarActions)
                    ->setParent(PageAdmin::WEBSPACE_TABS_VIEW)
                    ->addRerenderAttribute('webspace')
            );
        }
    }

    public function getSecurityContexts()
    {
        return [
            self::SYSTEM => [
                'Robotstxt' => [
                    static::SECURITY_CONTEXT => [
                        PermissionTypes::VIEW,
                        PermissionTypes::ADD,
                        PermissionTypes::DELETE,
                    ],
                ],
            ],
        ];
    }

    public function getConfigKey(): ?string
    {
        return 'bitexpert.robotstxt';
    }
}
