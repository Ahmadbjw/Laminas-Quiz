<?php
declare (strict_types=1);

namespace User\Form\Auth;

use Laminas\Form\Form;
use Laminas\Form\Element;

class CreateForm extends Form 
{
	public function __construct()
	{
		parent::__construct('new_account');
		$this->setAttribute('method', 'post');

		#username inputfield

		$this->add([
			'type' 		=> Element\Text::class,
			'name' 		=> 'username',
			'options' 	=> [
				'label' => 'Username'
			],
			'attributes' => [
				'required' 		=> true,
				'size' 			=> 40,
				'maxlength' 	=> 25,
				'pattern' 		=> '^[a-zA-Z0-9]+$',
				'data-toggle' 	=> 'tooltip',
				'class' 		=> 'form-control',
				'title' 		=> 'Username must consist of alphanumeric chracters only',
				'placeholder' 	=> 'Enter Your Username', 
			]
		]);

		#gender inputfield
		$this->add([
			'type'  	=> Element\Select::class,
			'name' 		=> 'gender',
			'options' 	=> [
				'label' 		=> 'Gener',
				'empty_option' 	=> 'Select..',
				'value_options' => [
					'Male' 			=> 'Male',
					'Female' 		=> 'Female',
					'Other' 		=> 'Other',
				],
			],
			'attributes' 	=> [
				'required' 	=> true,
				'class' 	=> 'custom-select',
			]
		]);

		#Email inputfield
		$this->add([
			'type' 		=> Element\Email::class,
			'name' 		=> 'email',
			'options' 	=> [
				'label' => 'Email Address',
			],
			'attributes'=> [
				'required' 		=> true,
				'size' 			=> 40,
				'maxlength' 	=> 128,
				'pattern' 		=> '^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$',
				'autocomplete' 	=> false,
				'data-toggle' 	=> 'tooltip',
				'class' 		=> 'form-control',
				'title' 		=> 'Provide a valid and working Email Address',
				'placeholder' 	=> 'Enter your Email address',
			]
		]);

		#confirm Email inputfield
		$this->add([
			'type' 		=> Element\Email::class,
			'name' 		=> 'confirm_email',
			'options' 	=> [
				'label' => 'Verify Email Address',
			],
			'attributes'	=> [
				'required' 	=> true,
				'size' 		=> 40,
				'maxlength' => 128,
				'pattern' 	=> '^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$',
				'autocomplete' 	=> false,
				'data-toggle' 	=> 'tooltip',
				'class' 		=> 'form-control',
				'title' 		=> 'Email address must match with that provided above ',
				'placeholder' 	=> 'Enter your Email address Again',
			]
		]);

		#Birthday Select inputfield
		$this->add([
			'type' 		=> Element\DateSelect::class,
			'name' 		=>  'birthday',
			'options' 	=> [
				'label' => 'Select Your Date of Birth',
				'create_empty_option' 	=> true,
				'max_year' 				=> date('Y') - 13, #we want use above the age of 13
				'year_attributes' 		=> [
					'class' => 'custom-select  w-30'
				],
				'month_attributes' 		=> [
					'class' => 'custom-select  w-30'
				],
				'day_attributes' 		=> [
					'class' => 'custom-select  w-30',
					'id'	=> 'day'
				],
			],
			'attributes' 	=> [
				'required' 	=> true
			]
		]);

		#Password Inputfield
		$this->add([
			'type' 		=> Element\Password::class,
			'name' 		=> 'password',
			'options' 	=> [
				'label' =>  'Password'
			],
			'attributes'=> [
				'required' 		=> true,
				'size' 			=> 40,
				'maxlength' 	=> 25,
				'autocomplete' 	=> false,
				'data-toggle' 	=> 'tooltip',
				'class' 		=> 'form-control',
				'title' 		=> 'Password must have between 8 and 25 characters',
				'placeholder' 	=> 'Enter Your Password'
			]
		]);

		#Confirm Password
		$this->add([
			'type' 		=> Element\Password::class,
			'name' 		=> 'confirm_password',
			'options' => [
				'label' =>  'Verify Password'
			],
			'attributes' => [
				'required' 		=> true,
				'size'			=> 40,
				'maxlength' 	=> 25,
				'autocomplete' 	=> false,
				'data-toggle' 	=> 'tooltip',
				'class' 		=> 'form-control',
				'title' 		=> 'Password must match that provided above',
				'placeholder' 	=> 'Enter Your Password Again'
			]
		]);

		#cross-site-request forgery(csrf) field
		$this->add([
			'type' 		=> Element\Csrf::class,
			'name' 		=> 'csrf',
			'options' 	=> [
				'csrf_options' => [
					'timeout' => 600, #5 minutes	
				] ,
				
			]
		]);

		#Submit Button
		$this->add([
			'type' => Element\Submit::class,
			'name' => 'create_account',
			'attributes' => [
				'value' => 'Add Account',
				'class' => 'btn btn-primary'
			]
		]);

	}
}



?>