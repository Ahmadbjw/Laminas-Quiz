<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */
declare(strict_types=1);


namespace User\Controller;

use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Form\Auth\CreateForm;
use User\Model\Table\UsersTable;
use RuntimeException;

class AuthController extends AbstractActionController
{
    private $usersTable;
    public function __construct(UsersTable $usersTable)
    {
        $this->usersTable = $usersTable;

    }

    	
    public function CreateAction()
    {
    	// $this->flashMessenger()->addInfoMessage('Just here for your Sing Up');
        #Make  sure only visitors with no seesion access this page
        $auth = new AuthenticationService();
        if($auth->hasIdentity()){
            return $this->redirect()->toRoute('home');
        }

    	$createForm = new CreateForm();
        $request = $this->getRequest();

        if($request->isPost()){
            $formData = $request->getPost()->toArray();
        // var_export($formData);
        // die();

            $createForm->setInputFilter($this->usersTable->getCreateFormFilter());

            // var_export($createForm);
            // die();
            $createForm->setData($formData);
            if($createForm->isValid()){
                try{
                    $data =  $createForm->getData();
                    $this->usersTable->saveAccount($data);
                    $this->flashMessenger()->addSuccessMessage('Account  Successfully created. You can now Login');
                    return $this->redirect()->toRoute('home');
                }catch(RuntimeException $exception){
                    $this->flashMessenger()->addErrorMessage($exception->getMessage());
                    return $this->redirect()->refresh();
                }
            }
            else {
                    $this->flashMessenger()->addErrorMessage('Form is not valid');


            }
        }
        return new ViewModel(['form' => $createForm]);
    }
}

