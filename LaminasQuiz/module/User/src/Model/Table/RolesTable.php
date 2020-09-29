<?php
declare(strict_types=1);
namespace User\Model\Table;

class RolesTable 
{
	protected $table= 'forgot';
	protected $adapter;
	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->initialize();
	}
}


?>