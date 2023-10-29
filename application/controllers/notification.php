<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller {

    public $data = array(
        'modul' => 'notification',
        'breadcrumb' => 'Notification',
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
        $this->load->model('notification_model');
    }

    function index()
    {
        $per_page = abs($this->input->get('per_page'));
        $limit = 30;

        $tot = $this->notification_model->all();
        $data['notification'] = $this->notification_model->limit($limit,$per_page);

        $data['unread'] = $this->notification_model->get_unread_notification(); 

        $pagination['page_query_string']  = TRUE;    
        $pagination['base_url']           = site_url().'/notification?';
        $pagination['total_rows']         = $tot->num_rows();
        $pagination['per_page']           = $limit;
        $pagination['uri_segment']        = $per_page;
        $pagination['num_links']          = 2;

        $pagination['full_tag_open'] = '<ul class="pagination">';
        $pagination['full_tag_close'] = '</ul>';

        $pagination['first_link'] = '<<';
        $pagination['first_tag_open'] = '<li class="prev page">';
        $pagination['first_tag_close'] = '</li>';

        $pagination['last_link'] = '>>';
        $pagination['last_tag_open'] = '<li class="next page">';
        $pagination['last_tag_close'] = '</li>';

        $pagination['next_link'] = '>';
        $pagination['next_tag_open'] = '<li class="next page">';
        $pagination['next_tag_close'] = '</li>';

        $pagination['prev_link'] = '<';
        $pagination['prev_tag_open'] = '<li class="prev page">';
        $pagination['prev_tag_close'] = '</li>';

        $pagination['cur_tag_open'] = '<li class="active"><a href="">';
        $pagination['cur_tag_close'] = '</a></li>';

        $pagination['num_tag_open'] = '<li class="page">';
        $pagination['num_tag_close'] = '</li>';

        $this->pagination->initialize($pagination);

        $notification = $this->acl->get_user_permissions()->notification;
            if($this->session->userdata('logged_in') and $notification=='1')
            {
                $data['isi'] = 'notification';
                $this->load->view('preview', $data, true);
                $this->load->view('template/template', $this->data);
            }
            else
            {
                redirect('login','refresh');
            }
        $this->db->close();
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */