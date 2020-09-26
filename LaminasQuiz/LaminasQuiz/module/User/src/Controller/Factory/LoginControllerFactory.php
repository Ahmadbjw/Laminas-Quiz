<?php
declare(strict_types=1);

namespace User\Controller\Factory;

use Laminas\Db\Adapter\Adapter;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use User\Controller\LoginController;
use User\Model\Table\UsersTable;

class LoginControllerFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $ccontainer,$requestedName, Array $options=null)
	{
		return new LoginController(
			$ccontainer->get(Adapter::class),
			$ccontainer->get(UsersTable::class),
		);
	}	
}


?>