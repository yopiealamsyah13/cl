<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{
	protected $default_class;
	private $current_class;

	function __construct()
	{
		parent::__construct();
		session_start();

		$this->default_class = $this->router->default_controller;
		$this->current_class = $this->router->fetch_class();

		$this->load->library('acl');
		if($this->current_class == 'login')
		{
			$a = $this->acl->get_user_permissions();
			if(!empty($a) and $a->admin_login)
			{
				redirect($this->default_class,'refresh');
			}
		}
		else
		{
			if(empty($a))
			{
				redirect('login','refresh');
			}
		}
	}
}