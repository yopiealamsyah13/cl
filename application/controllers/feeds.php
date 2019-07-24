<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feeds extends CI_Controller
{
    public $data = array(
        'modul' => 'feeds',
        'breadcrumb' => 'FEEDS TIMELINE',
        'pesan' => '',
        'pagination' => '',
        'tabel_data' => '',
        'main_view' => 'preview',
        'form_action' => '',
        'form_value' => ''
    );

    function __cosnstruct()
    {
        parent::__cosnstruct();
    }

    public function index()
    {
        if($this->session->userdata('logged_in'))
        {
            $data['isi'] = 'feeds/timeline';
            $this->load->view('preview', $data, true);
            $this->load->view('template/template', $this->data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
}