<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace User;

use Laminas\Db\Adapter\Adapter;
use User\Model\Table\UsersTable;

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
    			UsersTable::class => function($sm){
    				$dbAdaper = $sm->get(Adapter::class);
    				return new UsersTable($dbAdaper);
    			}
    		]
    	];
    }
}
