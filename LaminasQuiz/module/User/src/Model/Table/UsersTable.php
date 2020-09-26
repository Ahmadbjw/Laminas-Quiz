<?php
declare(strict_types=1);

namespace User\Model\Table;

// use Laminas\Crypt\Password\Bcrypt;
// use Laminas\Db\Adapter\Adapter;
// use Laminas\Db\TableGateway\AbstractTableGateway;
// use Laminas\Filter;
// use Laminas\Hydrator\ClassMethodsHydrator;
// use Laminas\I18n;
// use Laminas\InputFilter;
// use Laminas\Validator;
// use User\Model\Entity\UserEntity;

use Laminas\Crypt\Password\Bcrypt;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\AbstractTableGateway;
use Laminas\Filter;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\I18n;
use Laminas\InputFilter;
use Laminas\Paginator\Adapter\DbSelect;
use Laminas\Paginator\Paginator;
use Laminas\Validator;
use User\Model\Entity\UserEntity;

class UsersTable extends AbstractTableGateway 
{
	protected $adapter;
	protected $table = 'users';

	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->initialize();
	}

	public function fetchAccountByEmail(String $email){
		$sqlQuery	=	$this->sql->select()
		->join('roles','roles.role_id=' .$this->table.'role_id',['role_id','role'])
		->where(['email'	=>	$email]);

		$sqlstmt = $this->sql->prepareStatementForSqlObject($sqlQuery);
		// print_r($sqlstmt);
		// exit();
		$handler	= $sqlstmt->execute()->current();
		print_r($handler);
		exit();

		if(!$handler)
		{
			return null;
		}
		$classMethod = new ClassMethodsHyd();
		$entity		= new UserEntity();
		$classMethod->hydrate($handler,$entity);
		// print_r($entity);
		// die();
		return $entity;


	}

	# sanitizes our loginForm
	public function getLoginFormFilter()
	{
		$inputFilter = new InputFilter\InputFilter();
		$factory = new InputFilter\Factory();

		# filter and validate email 
		$inputFilter->add(
			$factory->createInput(
				[
					'name' => 'email',
					'required' => true,
					'filters' => [
						['name' => Filter\StripTags::class],  # removes html tags
						['name' => Filter\StringTrim::class],
						//['name' => Filter\StringToLower::class],
					],
					'validators' => [
						['name' => Validator\NotEmpty::class],
						[
							'name' => Validator\StringLength::class,
							'options' => [
								'min' => 6,  
								'max' => 128,
								'messages' => [
									Validator\StringLength::TOO_SHORT => 'Email address must have at least 6 characters!',
									Validator\StringLength::TOO_LONG => 'Email address must have at most 128 characters!',
								],
							],
						],
						['name' => Validator\EmailAddress::class],
						[
							'name' => Validator\Db\RecordExists::class,
							'options' => [
								'table' => $this->table,
								'field' => 'email',
								'adapter' => $this->adapter,
							],
						],
					],
				]
			)
		);

		# filter and validate password
		$inputFilter->add(
			$factory->createInput(
				[
					'name' => 'password',
					'required' => true,
					'filters' => [
						['name' => Filter\StripTags::class],  # removes html tags
						['name' => Filter\StringTrim::class],
					],
					'validators' => [
						['name' => Validator\NotEmpty::class],
						[
							'name' => Validator\StringLength::class,
							'options' => [
								'min' => 8,
								'max' => 25,
								'messages' => [
									Validator\StringLength::TOO_SHORT => 'Password must have at least 8 characters!',
									Validator\StringLength::TOO_LONG => 'Password must have at most 25 characters!',
								],
							],
						],
					],
				]
			)
		);

		# recall checkbox
		$inputFilter->add(
			$factory->createInput(
				[
					'name' => 'recall',
					'required' => true,
					'filters' => [
						['name' => Filter\StripTags::class],  # removes html tags
						['name' => Filter\StringTrim::class],
						['name' => Filter\ToInt::class],
					],
					'validators' => [
						['name' => Validator\NotEmpty::class],
						['name' => I18n\Validator\IsInt::class],
						[
							'name' => Validator\InArray::class,
							'options' => [
								'haystack' => [0, 1]
							],
						],
					],
				]
			)
		);

		# csrf 
		$inputFilter->add(
			$factory->createInput(
				[
					'name' => 'csrf',
					'required' => true,
					'filters' => [
						['name' => Filter\StripTags::class],  # removes html tags
						['name' => Filter\StringTrim::class],
					],
					'validators' => [
						['name' => Validator\NotEmpty::class],
						[
							'name' => Validator\Csrf::class,
							'options' => [
								'messages' => [
									Validator\Csrf::NOT_SAME => 'Oops! Refill the form and try again',
								],
							],
						],
					],
				]
			)
		);

		# be sure to return the input filter
		return $inputFilter;
	}


	public function getCreateFormFilter()
	{
		$inputFilter = new InputFilter\InputFilter();
		$factory = new InputFilter\Factory();

		# filter and validate username input field
		$inputFilter->add(
			$factory->createInput(
				[
					'name' => 'username',
					'required' => true,
					'filters' => [
						['name' => Filter\StripTags::class], # stips html tags
						['name' => Filter\StringTrim::class], # removes empty spaces
						['name' => I18n\Filter\Alnum::class], # allows only [a-zA-Z0-9] characters
					],
					'validators' => [
						['name' => Validator\NotEmpty::class],
						[
							'name' => Validator\StringLength::class,
							'options' => [
								'min' => 2,
								'max' => 25,
								'messages' => [
									Validator\StringLength::TOO_SHORT => 'Username must have at least 2 characters',
									Validator\StringLength::TOO_LONG => 'Username must have at most 25 characters',
								],
							],
						], 
						[
							'name' => I18n\Validator\Alnum::class,
							'options' => [
								'messages' => [
									I18n\Validator\Alnum::NOT_ALNUM => 'Username must consist of alphanumeric characters only',
								],
							],
						],
						[
							'name' => Validator\Db\NoRecordExists::class,
							'options' => [
								'table' => $this->table, 
								'field' => 'username',
								'adapter' => $this->adapter,
							],
						],
					],
				]
			)
		);

		# filter and validate gender select field
		$inputFilter->add(
			$factory->createInput(
				[
					'name' => 'gender',
					'required' => true,
					'filters' => [
						['name' => Filter\StripTags::class], # stips html tags
						['name' => Filter\StringTrim::class], # removes empty spaces
					],
					'validators' => [
						['name' => Validator\NotEmpty::class], 
						[
							'name' => Validator\InArray::class,
							'options' => [
								'haystack' => ['Female', 'Male', 'Other'],
							],
						],
					],
				]
			)
		);

		# filter and validate email input field
		$inputFilter->add(
			$factory->createInput(
				[
					'name' => 'email',
					'required' => true,
					'filters' => [
						['name' => Filter\StripTags::class],
						['name' => Filter\StringTrim::class], 
						#['name' => Filter\StringToLower::class], comment this line out
					],
					'validators' => [
						['name' => Validator\NotEmpty::class],
						['name' => Validator\EmailAddress::class],
						[
							'name' => Validator\StringLength::class,
							'options' => [
								'min' => 6,
								'max' => 128,
								'messages' => [
									Validator\StringLength::TOO_SHORT => 'Email address must have at least 6 characters',
									Validator\StringLength::TOO_LONG => 'Email address must have at most 128 characters',
								],
							],
						],
						[
							'name' => Validator\Db\NoRecordExists::class,
							'options' => [
								'table' => $this->table,
								'field' => 'email',
								'adapter' => $this->adapter,
							],
						],
					],
				]
			)
		);

		# filter and validate confirm_email input field
		$inputFilter->add(
			$factory->createInput(
				[
					'name' => 'confirm_email',
					'required' => true,
					'filters' => [
						['name' => Filter\StripTags::class], # stips html tags
						['name' => Filter\StringTrim::class], # removes empty spaces
						#['name' => Filter\StringToLower::class], as well as this one
					],
					'validators' => [
						['name' => Validator\NotEmpty::class],
						['name' => Validator\EmailAddress::class],
						[
							'name' => Validator\StringLength::class,
							'options' => [
								'min' => 6,
								'max' => 128,
								'messages' => [
									Validator\StringLength::TOO_SHORT => 'Email address must have at least 6 characters',
									Validator\StringLength::TOO_LONG => 'Email address must have at most 128 characters',
								],
							],
						],
						[
							'name' => Validator\Db\NoRecordExists::class,
							'options' => [
								'table' => $this->table,
								'field' => 'email',
								'adapter' => $this->adapter,
							],
						],
						[
							'name' => Validator\Identical::class,
							'options' => [
								'token' => 'email',  # field to compare against
								'messages' => [ 
									Validator\Identical::NOT_SAME => 'Email addresses do not match!',
								],
							],
						],
					],
				]
			)
		);

		# filter and validate birthday dateselect field
		$inputFilter->add(
			$factory->createInput(
				[
					'name' => 'birthday',
					'required' => true,
					'filters' => [
						['name' => Filter\StripTags::class], # stips html tags
						['name' => Filter\StringTrim::class], # removes empty spaces
					],
					'validators' => [
						['name' => Validator\NotEmpty::class],
						[
							'name' => Validator\Date::class,
							'options' => [
								'format' => 'Y-m-d',
							],
						],
					],	
				]
			)
		);		

		# filter and validate password input field
		$inputFilter->add(
			$factory->createInput(
				[
					'name' => 'password',
					'required' => true,
					'filters' => [
						['name' => Filter\StripTags::class], # stips html tags
						['name' => Filter\StringTrim::class], # removes empty spaces
					],
					'validators' => [
						['name' => Validator\NotEmpty::class],
						[
							'name' => Validator\StringLength::class,
							'options' => [
								'min' => 8,
								'max' => 25,
								'messages' => [
									Validator\StringLength::TOO_SHORT => 'Password must have at least 8 characters',
									Validator\StringLength::TOO_LONG => 'Password must have at most 25 characters',
								],
							],
						],
					],
				]
			)
		);

		# filter and validate confirm_password field
		$inputFilter->add(
			$factory->createInput(
				[
					'name' => 'confirm_password',
					'required' => true,
					'filters' => [
						['name' => Filter\StripTags::class], # stips html tags
						['name' => Filter\StringTrim::class], # removes empty spaces
					],
					'validators' => [
						['name' => Validator\NotEmpty::class], 
						[
							'name' => Validator\StringLength::class,
							'options' => [
								'min' => 8,
								'max' => 25,
								'messages' => [
									Validator\StringLength::TOO_SHORT => 'Password must have at least 8 characters',
									Validator\StringLength::TOO_LONG => 'Password must have at most 25 characters',
								],
							],
						],
						[
							'name' => Validator\Identical::class,
							'options' => [
								'token' => 'password',
								'messages' => [
									Validator\Identical::NOT_SAME => 'Passwords do not match!',
								],
							],
						],
					],
				]
			)
		);

		# csrf field
		$inputFilter->add(
			$factory->createInput(
				[
					'name' => 'csrf',
					'required' => true,
					'filters' => [
						['name' => Filter\StripTags::class], # stips html tags
						['name' => Filter\StringTrim::class], # removes empty spaces
					],
					'validators' => [
						['name' => Validator\NotEmpty::class],
						[
							'name' => Validator\Csrf::class,
							'options' => [
								'messages' => [
									Validator\Csrf::NOT_SAME => 'Oops! Refill the form.',
								],
							],
						],
					],
				]
			)
		);

		return $inputFilter;
	}

	public function saveAccount(array $values)
	{
		$timeNow = date('Y-m-d H:i:s');
		$values = [
			'username'	=> ucfirst($values['username']),
			'email'		=> mb_strtolower($values['email']),
			'password'	=> (new Bcrypt())->create($values['password']),
			'birthday'	=> $values['birthday'],
			'gender'	=> $values['gender'],
			'role_id'	=> $this->assignRoleId(),
			'created'	=> $timeNow,
			'modified'	=> $timeNow
		];

		// var_export($values);
		// die();
		$sqlQuery = $this->sql->insert()->values($values);
		$sqlstmt = $this->sql->prepareStatementForSqlObject($sqlQuery);
		return $sqlstmt->execute();
	}

	public function assignRoleId()
	{
		$sqlQuery 	= $this->sql->select()->where(['role_id'=>1]);
		$sqlstmt	=$this->sql->prepareStatementForSqlObject($sqlQuery);
		$handler	= $sqlstmt->execute()->current();

		return (! $handler) ? 1:2;	
	}

}

?>;
