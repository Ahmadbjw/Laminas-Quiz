<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace User;

use Laminas\Db\Adapter\Adapter;
use User\Model\Table\ForgotTable;
use User\Model\Table\RolesTable;
use User\Model\Table\UsersTable;
use User\Plugin\AuthPlugin;
use User\Plugin\Factory\AuthPluginFactory;

class Module
{
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
    	return [
    		'factories'  =>  [
                RolesTable::class => function($m){
                    $dbAdapter = $sm->get(Adapter::class);
                    return new RolesTable($dbAdapter);
                },
                ForgotTable::class => function($sm) {
                    $dbAdapter = $sm->get(Adapter::class);
                    return new ForgotTable($dbAdapter);
                },
    			UsersTable::class => function($sm){
    				$dbAdaper = $sm->get(Adapter::class);
    				return new UsersTable($dbAdaper);
    			}
    		]
    	];
    }

    public function getControllerPluginConfig()
    {
        return [
            'aliases' =>[
                'authPlugin' => AuthPlugin::class,
            ],
        'factories' => [
             AuthPlugin::class  => AuthPluginFactory::class
            ],
        ];

    }
}
