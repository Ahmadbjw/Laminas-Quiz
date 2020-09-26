<?php

declare(strict_types=1);
namespace User\Controller;

use Laminas\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;
use Laminas\Authentication\AuthenticationService;
use Laminas\Crypt\Password\Bcrypt;
use Laminas\Db\Adapter\Adapter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Form\Auth\LoginForm;
use User\Model\Table\UsersTable;


class LoginController extends AbstractActionController
{
	private $adapter;
	private $usersTable;
	public function __construct(Adapter $adapter, UsersTable $usersTable)
	{
		$this->usersTable = $usersTable;
		$this->adapter = $adapter;
	}
	public function indexAction()
	{
		$auth = new AuthenticationService();
		if($auth->hasIdentity()){
			return redirect()->toRoute('home');
		}
		$loginForm = new LoginForm();
		$request = $this->getRequest();
		if($request->isPost())
		{

			$formData = $request->getPost()->toArray();

			$loginForm->setInputFilter($this->usersTable->getLoginFormFilter());
			
			$loginForm->setData($formData);
			if($loginForm->isValid())
			{
			
				$authAdapter	= new CredentialTreatmentAdapter($this->adapter);
				
				$authAdapter->setTableName($this->usersTable->getTable())
				->setIdentityColumn('email')
				->setCredentialColumn('password')
				->getDbSelect()->where(['active'=>	1]);
				$data = $loginForm->getData();
				$authAdapter->setIdentity($data['email']);
				// var_dump($authAdapter);
				// exit();
				$authAdapter->setIdentity($data['email']);
				$info = $this->usersTable->fetchAccountByEmail($data['email']);

				$hash =  new Bcrypt();

				if($hash->verify($data['password'],$info->getPassword())){
					$authAdapter->setCredential($info->getPassword);
				} else{
					$authAdapter->setCredential('');
				}

				$authResult = $auth->authenticate($authAdapter);
				print_r($authResult);
				exit();
			}
			else
				echo "form is not valid";
			exit();
			// $formData = $request->getPost();
			// print_r($formData);
			// exit();
		}
		// print_r($request);
		// exit();
		#laminas exptects the view in view/user/login/{index.phtml}/required page by default but we can also change the directory or set the diretory by using setTemplate('define directory path where your view resided') like we had done below...
		return (new ViewModel(['form' => $loginForm]))->setTemplate('user/auth/login'); 
	}	
}


?>