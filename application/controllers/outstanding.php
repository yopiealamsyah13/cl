<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

        class Outstanding extends CI_Controller {

            public $data = array(
            'modul' => 'customer',
            'breadcrumb' => 'CREDIT LIMIT REQUEST',
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
                $this->load->model('outstanding_model');
            }

            function index()
            {
                $cust = $this->input->get('cust');
                $per_page = abs($this->input->get('per_page'));
                $limit = 10;

                $tot = $this->outstanding_model->all($cust);
                $data['name'] = $this->outstanding_model->limit($cust,$limit,$per_page);
                $data['customer'] = $this->outstanding_model->get_customer();

                //baru
                //$data['list'] = $this->outstanding_model->limit_new($cust,$limit,$per_page);

                $pagination['page_query_string']  = TRUE;    
                $pagination['base_url']           = site_url().'/outstanding?cust='.$cust;
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

                $outstanding = $this->acl->get_user_permissions()->outstanding;
                    if($this->session->userdata('logged_in') and $outstanding=='1')
                    {
                        $data['isi'] = 'outstanding/list';
                        $this->load->view('preview', $data, true);
                        $this->load->view('template/template', $this->data);
                    }
                    else
                    {
                        redirect('login','refresh');
                    }
                $this->db->close();
            }

            function add_outstanding()
            {
                date_default_timezone_set('Asia/Jakarta');
                $date = date('Y-m-d H:i:s');
                $invoice_date = strtotime($this->input->post('invoice_date'));
                $date1 = date('Y-m-d',$invoice_date);
                $receive_date = strtotime($this->input->post('receive_date'));
                $date2 = date('Y-m-d',$receive_date);
                $invoice_amount = $this->input->post('invoice_amount');
                $invoice = str_replace(".", "", $invoice_amount);
 
                $data = array(
                'input_date' =>$date,
                'id_customer' =>$this->input->post('id_customer'),
                'id_user' =>$this->session->userdata('id'),
                'po_number' =>$this->input->post('po_number'),
                'invoice_no' =>$this->input->post('invoice_no'),
                'invoice_date' =>$date1,
                'receive_date' =>$date2,
                'invoice_amount' =>$invoice,
                'outstanding_amount' =>$invoice,
                'remark' =>$this->input->post('remark')
                );
 
                $req = $this->outstanding_model->add_outstanding($data);
 
                redirect('outstanding');
                $this->db->close();
            }

            function edit_outstanding()
            {
                $id = $this->uri->segment(3);

                date_default_timezone_set('Asia/Jakarta');
                $invoice_date = strtotime($this->input->post('invoice_date'));
                $date1 = date('Y-m-d',$invoice_date);
                $receive_date = strtotime($this->input->post('receive_date'));
                $date2 = date('Y-m-d',$receive_date);
                $invoice_amount = $this->input->post('invoice_amount');
                $invoice = str_replace(".", "", $invoice_amount);
 
                $data = array(
                'id_customer' =>$this->input->post('id_customer'),
                'po_number' =>$this->input->post('po_number'),
                'invoice_no' =>$this->input->post('invoice_no'),
                'invoice_date' =>$date1,
                'receive_date' =>$date2,
                'invoice_amount' =>$invoice,
                'outstanding_amount' =>$invoice,
                'remark' =>$this->input->post('remark')
                );

                $this->outstanding_model->edit_outstanding($id,$data);

                redirect('outstanding');
                $this->db->close();
            }

            function input_payment()
            {
                $id = $this->uri->segment(3);

                date_default_timezone_set('Asia/Jakarta');
                $payment_date = strtotime($this->input->post('payment_date'));
                $date = date('Y-m-d',$payment_date);
                $payment_amount = $this->input->post('payment_amount');
                $payment = str_replace(".", "", $payment_amount);

                $query = $this->db->select('outstanding_amount');
                $query = $this->db->from('db_outstandings');
                $query = $this->db->where('id_outstanding',$id);
                $query = $this->db->get();

                $outstanding_amount = $query->row()->outstanding_amount;
                $sisa = $outstanding_amount-$payment;
 
                $data = array(
                'id_outstanding' =>$id,
                'payment_amount' =>$payment,
                'payment_date' =>$date
                );

                $this->outstanding_model->add_payment($data);

                $data = array(
                'outstanding_amount' => $sisa,
                'remark' =>$this->input->post('remark')
                );

                $this->outstanding_model->edit_outstanding($id,$data);

                redirect('outstanding');
                $this->db->close();
            }
        }