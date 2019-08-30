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
                $config['width']= 354;
                $config['height']= 354;
                //$config['file_name'] = $id_user;
                //$config['overwrite'] = TRUE;

                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('file_upload'))
                {
                    ?>
                        <script type="text/javascript">
                            alert("This photo can not be upload");
                        </script>
                    <?php
                    redirect('welcome','refresh');
                }
                else
                {
                    $filename = $this->upload->data();
                    $new_ratio = $config['width'] / $config['height'];

                    $new_image['image_liblary'] = 'gd2';
                    $new_image['source_image'] = './assets/photo/'.$filename['file_name'];
                    $new_image['new_image'] = './assets/photo/'.$filename['file_name'];
                    $new_image['create_thumb']= false;
                    $new_image['maintain_ratio']= false;
                    $new_image['quality']= '100%';
                    //$new_image['width']= $config['width'];
                    //$new_image['height']= round($config['width']/$new_ratio);
                    //$new_image['x_axis']= 0;
                    //$new_image['y_axis']= round($config['width']-$new_image['width']/2);
                    $new_image['width'] = $config['width'];
                    $new_image['height'] = $config['height'];
                    $new_image['master_dim']= 'auto';

                    $this->load->library('image_lib', $new_image);
                    //$this->image_lib->crop();
                    $this->image_lib->resize();
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