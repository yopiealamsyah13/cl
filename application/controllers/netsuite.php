<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Netsuite extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('netsuite_model');
    }

    function index()
    {
	$name = $this->input->get('term');
        $per_page = abs($this->input->get('per_page'));
        $limit = 20;

        $tot = $this->netsuite_model->all($name);
        $data['customer'] = $this->netsuite_model->limit($name,$limit,$per_page);

        $pagination['page_query_string']  = TRUE;    
        $pagination['base_url']           = site_url().'/netsuite?term='.$name;
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

        $this->load->view('netsuite_customer', $data);

        $this->db->close();
    }

    function employee()
    {
	$name = $this->input->get('term');
        $per_page = abs($this->input->get('per_page'));
        $limit = 20;

        $tot = $this->netsuite_model->all_employee($name);
        $data['employee'] = $this->netsuite_model->limit_employee($name,$limit,$per_page);

        $pagination['page_query_string']  = TRUE;    
        $pagination['base_url']           = site_url().'/netsuite/employee?term='.$name;
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

        $this->load->view('netsuite_employee', $data);

        $this->db->close();
    }

    function activity()
    {
	$name = $this->input->get('term');
        $per_page = abs($this->input->get('per_page'));
        $limit = 20;

        $tot = $this->netsuite_model->all_activity($name);
        $data['activity'] = $this->netsuite_model->limit_activity($name,$limit,$per_page);

        $pagination['page_query_string']  = TRUE;    
        $pagination['base_url']           = site_url().'/netsuite/activity?term='.$name;
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

        $this->load->view('netsuite_activity', $data);

        $this->db->close();
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
