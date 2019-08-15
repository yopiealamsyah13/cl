<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

    public $data = array(
        'modul' => 'customer',
        'breadcrumb' => 'Customer',
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
        $this->load->model('customer_model');
    }

    function index()
    {
        $name = $this->input->get('term');
        $per_page = abs($this->input->get('per_page'));
        $limit = 20;

        $tot = $this->customer_model->all($name);
        $data['name'] = $this->customer_model->limit($name,$limit,$per_page);

        $pagination['page_query_string']  = TRUE;    
        $pagination['base_url']           = site_url().'/customer?term='.$name;
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

        $customer = $this->acl->get_user_permissions()->customer;
            if($this->session->userdata('logged_in') and $customer=='1')
            {
                $data['isi'] = 'customer/list';
                $this->load->view('preview', $data, true);
                $this->load->view('template/template', $this->data);
            }
            else
            {
                redirect('login','refresh');
            }
        $this->db->close();
    }

    function edit_customer()
    {
        $id = $this->uri->segment(3);

        $credit_limit = $this->input->post('credit_limit');
        $cl = str_replace(".", "", $credit_limit);

        $data = array(
        'credit_limit' => $cl,
        'outstanding_over' => $this->input->post('outstanding_over')
        );
        $this->customer_model->edit_customer($id,$data);

        redirect('customer');
    }

    function customer_profile()
    {
        $id_customer = $this->uri->segment(3);

        $data['profile'] = $this->customer_model->customer_profile($id_customer);
        $data['request'] = $this->customer_model->customer_request($id_customer);
        $data['activity'] = $this->customer_model->customer_activity($id_customer);
        $data['timeline'] = $this->customer_model->customer_timeline($id_customer);

        $customer = $this->acl->get_user_permissions()->customer;
        if($this->session->userdata('logged_in') and $customer=='1')
        {
            $data['isi'] = 'customer/profile';
            $this->load->view('preview', $data, true);
            $this->load->view('template/template', $this->data); 
        }
        else
        {
            redirect('login','refresh');
        } 
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */