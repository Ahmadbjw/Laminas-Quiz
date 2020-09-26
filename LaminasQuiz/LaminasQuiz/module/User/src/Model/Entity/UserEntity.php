<?php
declare(strict_types=1);

namespace User\Model\Entity;

class UserEntity
{
	protected $user_id;
	protected $username;
	protected $email;
	protected $password;
	protected $birthday;
	protected $gender;
	protected $photo;
	protected $role_id;
	protected $active;
	protected $views;
	protected $created;
	protected $modified;
	protected $role;

	public function getUserId(){
		$this->user_id;
	}

	public function setUserId($user_id)
	{
		$this->user_id	= $user_id;
	}

	public function getUserName(){
		$this->username;
	}

	public function setUserName($username)
	{
		$this->username	= $username;
	}

	public function getEmail(){
		$this->email;
	}

	public function setEmail($email)
	{
		$this->email	= $email;
	}

	public function getPassword(){
		$this->password;
	}

	public function setPassword($password)
	{
		$this->password	= $password;
	}

	public function getBirthday(){
		$this->birthday;
	}

	public function setBirthday($birthday)
	{
		$this->birthday	= $birthday;
	}

	public function getGender(){
		$this->gender;
	}

	public function setGender($gender)
	{
		$this->gender	= $gender;
	}

	public function getPhoto(){
		$this->photo;
	}

	public function setPhoto($photo)
	{
		$this->photo	= $photo;
	}

	public function getRoleId(){
		$this->role_id;
	}

	public function setRoleId($role_id)
	{
		$this->role_id	= $role_id;
	}

	public function getActive(){
		$this->active;
	}

	public function setActive($active)
	{
		$this->active	= $active;
	}

	public function getViews(){
		$this->views;
	}

	public function setViews($views)
	{
		$this->views	= $views;
	}

	public function getCreated(){
		$this->created;
	}

	public function setCreated($created)
	{
		$this->created	= $created;
	}

	public function getModified(){
		$this->modified;
	}

	public function setModified($modified)
	{
		$this->modified	= $modified;
	}

	public function getRole(){
		$this->role;
	}

	public function setRole($role)
	{
		$this->role	= $role;
	}

}


?>