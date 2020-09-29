<?php
declare(strict_types=1);

namespace User\Controller\Factory;

use Laminas\Db\Adapter\Adapter;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use User\Controller\PasswordController;
use User\Model\Table\ForgotTable;
use User\Model\Table\UsersTable;

class PasswordControllerFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $ccontainer,$requestedName, Array $options=null)
	{
		return new PasswordController(
			$ccontainer->get(ForgotTable::class),
			$ccontainer->get(UsersTable::class),
		);
	}	
}


?>