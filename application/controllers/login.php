<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller
{
	private $page_name = 'Login';
	private $title = 'Login Panel Admin';
	private $description = 'Selamat datang di CRRM';
	private $keyword = 'login, selamat datang';
	public $credit = 'Dion';
	private $error_message = '';

	public function index()
	{
		$data['page_name'] = $this->page_name;
		$data['title'] = $this->title;
		$data['description'] = $this->description;
		$data['keyword'] = $this->keyword;
		$data['credit'] = $this->credit;

		$prev = $this->input->post('prev'); //menampung url data dari input hidden
        if(isset($_SERVER['HTTP_REFERER'])){ //cek apa url yang ingin dituju ada atau tidak
        $this->session->set_userdata('previous_url',$_SERVER['HTTP_REFERER']); //jika ada selanjutnya set url kedalam session
        }

		if($this->input->post('email') !== FALSE and $this->input->post('password') !== FALSE)
		{
			$check_login = $this->acl->get_login($this->input->post('email'),$this->input->post('password'));
			if($check_login and $this->acl->get_user_permissions()->admin_login)
			{
				if (isset($prev)) { // jika variable prev ada isi/url yang ingin dituju maka
                    header('location:'.$prev); //redirect ke halaman tersebut
                }else{ //jika tidak
                    redirect($this->default_class,'refresh'); //redirect ke class default
                }
			}
			else
			{
				$this->error_message = $this->acl->error_message;
			}
		}
		$data['error_message'] = $this->error_message;
		$this->load->view('view_login',$data);
	}

	public function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION)) 
    	{ 
       		session_start();
       		// 10 mins in seconds
            $inactive = 600;
            
            $session_life = time() - $_session['timeout'];
            
            if($session_life > $inactive)
            {  session_destroy(); header("Location: login.php");     }
            
            $_session['timeout']=time();
    	} 
	}
}