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

    public function change_picture()
            {
                $id_user = $this->session->userdata('id');
                $old = $this->input->post('old');

                $config['upload_path'] = './assets/photo/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                //$config['file_name'] = $id_user;
                //$config['overwrite'] = TRUE;

                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('file_upload'))
                {
                    print_r($this->upload->display_errors());
                }
                else
                {
                    $filename = $this->upload->data();

                    $config['image_liblary'] = 'gd2';
                    $config['source_image'] = './assets/photo/'.$filename['file_name'];
                    $config['create_thumb']= FALSE;
                    $config['maintain_ratio']= FALSE;
                    $config['quality']= '100%';
                    $config['width']= 354;
                    $config['height']= 354;
                    //$config['x_axis'] = 150;
                    //$config['y_axis'] = 150;
                    $config['new_image'] = './assets/photo/'.$filename['file_name'];

                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    //$this->image_lib->crop();
                    $file = $filename['file_name'];

                    unlink('./assets/photo/'.$old);

                    $data = array(
                        'photo' => $file
                    );

                    $this->request_model->change_picture($data,$id_user);
                    redirect('welcome','refresh');
                }
            }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */