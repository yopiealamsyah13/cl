<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public $data = array(
        'modul' => 'welcome',
        'breadcrumb' => 'HOME',
        'pesan' => '',
        'pagination' => '',
        'tabel_data' => '',
        'main_view' => 'preview',
        'form_action' => '',
        'form_value' => ''
        );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('request_model');
    }

    public function index()
    {
        if($this->session->userdata('logged_in'))
        {
            $data['pending'] = $this->request_model->get_total_pending();
            $data['closed'] = $this->request_model->get_total_close();
            $data['total'] = $this->request_model->get_total_request();
            $data['area_user'] = $this->request_model->get_total_by_area();
            $data['isi'] = 'welcome_message';
            $this->load->view('preview', $data, true);
            $this->load->view('template/template', $this->data);
            
        }
        else
        {
            redirect('login','refresh');
        }
    }

    public function get_notification()
    {
        
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */