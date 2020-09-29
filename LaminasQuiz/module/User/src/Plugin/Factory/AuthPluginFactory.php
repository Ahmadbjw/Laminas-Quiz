<?php
declare(Strict_types=1);

namespace User\Plugin\Factory;

use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use User\Controller\AuthController;
use User\Model\Table\UsersTable;
use User\Plugin\AuthPlugin;

class AuthPluginFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, Array $options=null)
	{
		return new AuthPlugin(
			$container->get(AuthenticationService::class),
			$container->get(UsersTable::class)

		);
	}
}


?>