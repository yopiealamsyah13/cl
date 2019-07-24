<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

        class User_list extends CI_Controller {

            public $data = array(
            'modul' => 'user_list',
            'breadcrumb' => 'user list',
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
                $this->load->model('user_list_model');
            }

            public function index()
            { 
            
            $name = $this->input->get('name');
            $company = $this->input->get('company');
            
            $per_page = abs($this->input->get('per_page'));
            $limit = 40;
            $tot = $this->user_list_model->all($name,$company);
            $data['name']   = $this->user_list_model->limit($name,$company, $limit, $per_page);
            
            $data['company']   = $this->user_list_model->get_company();          

            $pagination['page_query_string']  = TRUE;    
            $pagination['base_url']           = site_url().'/user_list?';
            $pagination['total_rows'] 	      = $tot->num_rows();
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
            $user_list = $this->acl->get_user_permissions()->user_list;
                if($this->session->userdata('logged_in') and $user_list==1)
                {
                    $data['isi'] = 'user_list/list';
                    $this->load->view('preview', $data, true);
                    $this->load->view('template/template', $this->data);
                }
                else
                {
                    redirect('login','refresh');
                } 
            }

            function view()
            {
                $id = $this->uri->segment(3);
                $user = $this->user_list_model->userbyid($id)->row();
                if ($id==$user->user_id && $id!="")
                {
                    $data['user'] = $this->user_list_model->get_data_user($id);
                    $data['company'] = $this->user_list_model->get_company();
                    $data['area'] = $this->user_list_model->get_area();
                    $data['role'] = $this->user_list_model->get_role();
                    $data['isi'] = 'user_list/view';
                    $this->load->view('preview', $data, true);
                    $this->load->view('template/template', $this->data);  
                }
                else
                {
                    redirect('user_list');
                }
            }

            function select_area(){
                $data['option_area'] = $this->user_list_model->get_area_list();
                $this->load->view('user_list/area', $data);
            }

            public function add()
            {
                $this->form_validation->set_rules('name', 'name', 'required');
                $this->form_validation->set_rules('id_company', 'id_company', 'required');
                $this->form_validation->set_rules('role', 'role', 'required');
                $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean|is_unique[db_users.email]');
                $this->form_validation->set_rules('password', 'password', 'required|max_length[30]|min_length[6]|alpha_numeric|md5');
                $this->form_validation->set_rules('phone', 'phone', 'numeric');
                $this->form_validation->set_rules('mobile_phone', 'mobile_phone', 'numeric');
                
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');
            if ($this->form_validation->run() == FALSE)
            {
                $data['role']   = $this->user_list_model->get_role();
                $data['option_company'] = $this->user_list_model->get_company();

                $user_list = $this->acl->get_user_permissions()->user_list;
                if($this->session->userdata('logged_in') and $user_list==1)
                {
                    $data['isi'] = 'user_list/add';
                    $this->load->view('preview', $data, true);
                    $this->load->view('template/template', $this->data);
                }
                else
                {
                    redirect('login','refresh');
                }
            }else{
            $data = array(
            'name_user' =>$this->input->post('name'),
            'email' =>$this->input->post('email'),
            'password' =>$this->input->post('password'),
            'phone' =>$this->input->post('phone'),
            'mobile_phone' =>$this->input->post('mobile_phone'),
            'id_company' =>$this->input->post('id_company'),
            'id_area' =>$this->input->post('id_area'),
            'id_role' =>$this->input->post('role')
            );

            $data = array(
            'role_id' =>$this->input->post('role'), 
            'user_id' =>$this->user_list_model->add($data)
            );
            $this->user_list_model->add_role_user($data);

            redirect('user_list');
            }     
            }

            public function update()
            {
                $id = $this->uri->segment(3);
                $user = $this->user_list_model->userbyid($id)->row();
                if ($id==$user->user_id && $id!="")
                {
                    $this->form_validation->set_rules('name', 'name', 'required');
                    $this->form_validation->set_rules('id_company', 'id_company', 'required');
                    $this->form_validation->set_rules('role', 'role', 'required');
                    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean');
                    $this->form_validation->set_rules('phone', 'phone', 'numeric');
                    $this->form_validation->set_rules('mobile_phone', 'mobile_phone', 'numeric');
                    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');
            
                    if ($this->form_validation->run() == FALSE)
                    {
                        $data['option_company'] = $this->user_list_model->get_company();
                        $data['data'] = $this->user_list_model->userbyid($id);
                        $data['role']   = $this->user_list_model->get_role();
                        $data['area']   = $this->user_list_model->get_area();

                        $user_list = $this->acl->get_user_permissions()->user_list;
                        if($this->session->userdata('logged_in') and $user_list==1)
                        {
                            $data['isi'] = 'user_list/update';
                            $this->load->view('preview', $data, true);
                            $this->load->view('template/template', $this->data); 
                        }
                        else
                        {
                            redirect('login','refresh');
                        } 
                    }
                    else
                    {                       
                        $data = array(
                        'name_user' =>$this->input->post('name'),
                        'email' =>$this->input->post('email'),
                        'phone' =>$this->input->post('phone'),
                        'mobile_phone' =>$this->input->post('mobile_phone'),
                        'id_company' =>$this->input->post('id_company'),
                        'id_area' =>$this->input->post('id_area'),
                        'id_role' =>$this->input->post('role')
                        );
                        $this->user_list_model->update($id,$data);

                        $data = array(
                        'role_id' =>$this->input->post('role')
                        );
                        $this->user_list_model->update_role_user($id,$data);

                        redirect('user_list');
                    }     
                }
                else
                {
                    redirect('user_list');
                }
            }

            public function delete()
            {
                $id = $this->uri->segment(3);
                $user = $this->user_list_model->userbyid($id)->row();

                if($id==$user->user_id && $id!="")
                {
                    $data = array(
                    'status_active' =>1
                    );

                    $this->user_list_model->delete($id,$data);    
                    redirect('user_list');
                }
            }
        }    
        