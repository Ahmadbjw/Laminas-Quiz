<?php
declare(strict_types=1);
namespace User\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class BjsController extends AbstractActionController
{
	public function testingAction()
	{

		return new ViewModel();
	}

	public function pdfshowAction()
	{
		
		return new ViewModel();
	}
}

?>