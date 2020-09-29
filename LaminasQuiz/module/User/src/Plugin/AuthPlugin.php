<?php
declare(strict_types=1);
namespace User\Plugin;

use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\Controller\Plugin\AbstractPlugin;
use User\Model\Table\UsersTable;

class AuthPlugin extends AbstractPlugin  
{	

	protected $authentictionService;
	protected $usersTable;

	public function __construct(AuthenticationService $authentictionService, UsersTable $usersTable)
	{
		$this->authentictionService = $authentictionService;
		$this->usersTable 	= $usersTable;
	}

	public function __invoke()
	{
		if(!$this->authentictionService instanceof AuthenticationService)
		{
			return;
		}

		if(!$this->authentictionService->hasIdentity()){
			return;
		}

		return $this->usersTable->fetchAccountById(
			(int)$this->authentictionService->getIdentity()->user_id
		);
	}	
}



?>