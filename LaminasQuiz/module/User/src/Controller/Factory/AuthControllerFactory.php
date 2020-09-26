<?php
declare(Strict_types=1);

namespace User\Controller\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use User\Controller\AuthController;
use User\Model\Table\UsersTable;

class AuthControllerFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, Array $options=null)
	{
		return new AuthController($container->get(UsersTable::class));
	}
}


?>