<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Role extends DataMapper
{
	var $has_many = array('user');
	function __construct($id=NULL)
	{
		parent::__construct($id);
	}

	function post_model_init($from_cache = FALSE)
	{
	}
}