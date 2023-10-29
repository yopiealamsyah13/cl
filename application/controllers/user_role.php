
        <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

        class User_role extends CI_Controller {

            public $data = array(
            'modul' => 'user_role',
            'breadcrumb' => 'user role',
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
                $this->load->model('user_role_model');
            }

            public function index()
            {
            $role = $this->input->get('role');
            
            $per_page = abs($this->input->get('per_page'));
            $limit = 10;
            $tot = $this->user_role_model->all($role);
            $data['role']   = $this->user_role_model->limit($role, $limit, $per_page);
            
            $pagination['page_query_string']  = TRUE;    
            $pagination['base_url']           = site_url().'/user_role?';
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
            $user_role = $this->acl->get_user_permissions()->user_role;
                  if($this->session->userdata('logged_in') and $user_role==1)
                  {
                        $data['isi'] = 'user_role/list';
                        $this->load->view('preview', $data, true);
                        $this->load->view('template/template', $this->data); 
                  }
                  else
                  {
                        redirect('login','refresh');
                  } 
            }

            public function add()
            {
            
                $this->form_validation->set_rules('role', 'role', 'required');    
                
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');
            if ($this->form_validation->run() == FALSE)
            {
                  $user_role = $this->acl->get_user_permissions()->user_role;
                  if($this->session->userdata('logged_in') and $user_role==1)
                  {
                        $data['isi'] = 'user_role/add';
                        $this->load->view('preview', $data, true);
                        $this->load->view('template/template', $this->data); 
                  }
                  else
                  {
                        redirect('login','refresh');
                  } 
            }else{

            $perm = array(
                  'admin_login' => $this->input->post('admin_login'),
                  'user_list' => $this->input->post('user_list'),
                  'user_role' => $this->input->post('user_role'),
                  'admin_view' => $this->input->post('admin_view'),
                  'request' => $this->input->post('request'),
                  'view_request' => $this->input->post('view_request'),
                  'add_request' => $this->input->post('add_request'),
                  'customer' => $this->input->post('customer'),
                  'notification' => $this->input->post('notification'),
                  'outstanding' => $this->input->post('outstanding')
                  );
            $json_perm = json_encode($perm,JSON_NUMERIC_CHECK);

            $data = array(
            'name_role' =>$this->input->post('role'),
            'permissions' => $json_perm);
            $this->user_role_model->add($data);
            redirect('user_role');
            }     
            }

            public function update()
            {
            $id = $this->uri->segment(3);
            $role = $this->user_role_model->userbyid($id)->row();
            if ($id==$role->id && $id!="") {
                $this->form_validation->set_rules('role', 'role', 'required');  
            if ($this->form_validation->run() == FALSE)
            {
            
            $data['role'] = $this->user_role_model->userbyid($id);
                  $user_role = $this->acl->get_user_permissions()->user_role;
                  if($this->session->userdata('logged_in') and $user_role==1)
                  {
                        $data['isi'] = 'user_role/update';
                        $this->load->view('preview', $data, true);
                        $this->load->view('template/template', $this->data); 
                  }
                  else
                  {
                        redirect('login','refresh');
                  } 
            }else{

            $perm = array(
                  'admin_login' => $this->input->post('admin_login'),
                  'user_list' => $this->input->post('user_list'),
                  'user_role' => $this->input->post('user_role'),
                  'admin_view' => $this->input->post('admin_view'),
                  'request' => $this->input->post('request'),
                  'view_request' => $this->input->post('view_request'),
                  'add_request' => $this->input->post('add_request'),
                  'customer' => $this->input->post('customer'),
                  'notification' => $this->input->post('notification'),
                  'outstanding' => $this->input->post('outstanding')
                  );
            $json_perm = json_encode($perm,JSON_NUMERIC_CHECK);

            $data = array(
            'name_role' =>$this->input->post('role'),
            'permissions' => $json_perm);
            $this->user_role_model->update($id,$data);
            redirect('user_role');
            }     
            }else{
            redirect('user_role');
            }
            }

            public function delete(){
            $id = $this->uri->segment(3);
            $role = $this->user_role_model->userbyid($id)->row();
            if($id==$role->id && $id!=""){
            $this->user_role_model->delete($id);    
            redirect('user_role');
            }}
        }    
        