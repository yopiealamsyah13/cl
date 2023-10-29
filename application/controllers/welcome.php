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
            $bulan = $this->input->get('bulan');
            $tahun = $this->input->get('tahun');

            $data['pending'] = $this->request_model->get_total_pending($bulan,$tahun);
            $data['closed'] = $this->request_model->get_total_close($bulan,$tahun);
            $data['total'] = $this->request_model->get_total_request($bulan,$tahun);
            $data['area_user'] = $this->request_model->get_total_by_area($bulan,$tahun);
            $data['get_chart'] = $this->request_model->get_history_request();
            $data['month'] = $this->request_model->get_month();
            $data['year'] = $this->request_model->get_year();
            $data['new_request'] = $this->request_model->get_new_request($bulan,$tahun);
            $data['new_area'] = $this->request_model->get_new_by_area($bulan,$tahun);
            $data['count_new_customer'] = $this->request_model->get_new_customer($bulan,$tahun);

            $data['isi'] = 'welcome_message';
            $this->load->view('preview', $data, true);
            $this->load->view('template/template', $this->data);
            
        }
        else
        {
            redirect('login','refresh');
        }
    }

    function change_picture()
    {
        $id_user = $this->session->userdata('id');
       $old = $this->input->post('old');
 
        $config['upload_path'] = './assets/photo/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['width']= 354;
        $config['height']= 354;
        $config['remove_spaces'] = true;
        $config['detect_mime'] = true;
 
        $this->upload->initialize($config);
 
        if ( ! $this->upload->do_upload('file_upload'))
        {
            ?>
                <script type="text/javascript">
                    alert("This photo can't be upload");
                </script>
            <?php
            redirect('welcome','refresh');
        }
        else
        {
            $filename = $this->upload->data();
 
            $new_image['image_library'] = 'gd2';
            $new_image['source_image'] = './assets/photo/'.$filename['file_name'];
            $new_image['new_image'] = './assets/photo/'.$filename['file_name'];
            $new_image['create_thumb']= false;
            $new_image['maintain_ratio']= false;
            $new_image['quality']= '100%';
            $new_image['width'] = $this->input->post('w');
            $new_image['height'] = $this->input->post('h');
            $new_image['x_axis'] = $this->input->post('x');
            $new_image['y_axis'] = $this->input->post('y');
            $new_image['master_dim']= 'auto';
 
            $this->load->library('image_lib', $new_image);
            $this->image_lib->crop();

            $this->image_lib->clear();

            $new_image['image_library'] = 'gd2';
            $new_image['source_image'] = './assets/photo/'.$filename['file_name'];
            $new_image['new_image'] = './assets/photo/'.$filename['file_name'];
            $new_image['width'] = 354;
            $new_image['height'] = 354;

            $this->image_lib->initialize($new_image);

            if ( ! $this->image_lib->resize())
            {
                echo $this->image_lib->display_errors();
            }


            $file = $filename['file_name'];

            if($old != null){
                unlink('./assets/photo/'.$old);
            }
            
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
