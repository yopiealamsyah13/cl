<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

        class Request extends CI_Controller {

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
                $this->load->model('request_model');
            }

            function index()
            {
                $per_page = abs($this->input->get('per_page'));
                $limit = 10;
                $cari = $this->input->get('search');

                $tot = $this->request_model->all();
                $data['name'] = $this->request_model->limit($limit,$per_page,$cari);
                $data['status'] = $this->request_model->get_request_status();
                $data['customer'] = $this->request_model->get_all_customer();
                $data['user'] = $this->request_model->get_user();

                $pagination['page_query_string']  = TRUE;    
                $pagination['base_url']           = site_url().'/request?search='.$cari;
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

                $request = $this->acl->get_user_permissions()->request;
                    if($this->session->userdata('logged_in') and $request=='1')
                    {
                        $data['isi'] = 'request/list';
                        $this->load->view('preview', $data, true);
                        $this->load->view('template/template', $this->data);
                    }
                    else
                    {
                        redirect('login','refresh');
                    }
                $this->db->close();
            }

            function add_request()
            {
                $id_role = $this->session->userdata('id_role');

                $this->form_validation->set_rules('id_customer', 'Customer Name', 'required');
                $this->form_validation->set_rules('po_amount', 'PO Amount', 'required');
                $this->form_validation->set_rules('requested_note', 'Note', 'required');

                
                $this->form_validation->set_error_delimiters('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');


                if ($this->form_validation->run() == FALSE)
                {
                    $data['status'] = $this->request_model->get_request_status();
                    $data['customer'] = $this->request_model->get_customer();

                    $request = $this->acl->get_user_permissions()->request;
                    if($this->session->userdata('logged_in') and $request=='1')
                    {
                        $data['isi'] = 'request/add';
                        $this->load->view('preview', $data, true);
                        $this->load->view('template/template', $this->data);
                    }
                    else
                    {
                        redirect('login','refresh');
                    }
                    $this->db->close();
                }
                else
                {
                    date_default_timezone_set('Asia/Jakarta');
                    $requested_date = date('Y-m-d H:i:s');
                    $id_user = $this->session->userdata('id');
                    $po_amount = $this->input->post('po_amount');
                    $po = str_replace(".", "", $po_amount);
                    $idc = $this->input->post('id_customer');
                    $datas = $this->request_model->get_user_id($id_user);
                    $cus = $this->request_model->get_customer_by_id($idc);

                    $data = array(
                    'id_user' =>$id_user,
                    'id_customer' =>$idc,
                    'top' =>$this->input->post('top'),
                    'po_amount' =>$po,
                    'requested_note' =>$this->input->post('requested_note'),
                    'requested_date' =>$requested_date,
                    'id_request_status' =>1
                    );

                    $req = $this->request_model->add_request($data);

                    $data3 = array(
                        'id_request' => $req,
                        'id_user' => $id_user,
                        'date_timeline' => $requested_date,
                        'id_request_status' => 1
                    );

                    $this->request_model->add_timeline($data3);

                    //upload file ke db_file
 
                    $config['upload_path']      = './myfile/';
                    $config['allowed_types']    = 'jpg|jpeg|png|pdf|xls|xlsx';
                    $config['overwrite']        = false;
             
                    if(!empty($_FILES['files']['name'])){
             
                        $files = $_FILES;
                        $count = count($_FILES['files']['name']);
             
                        for ($i=0; $i < $count ; $i++) {

                            $_FILES['files']['name']     = $files['files']['name'][$i];
                            $_FILES['files']['type']     = $files['files']['type'][$i];
                            $_FILES['files']['tmp_name'] = $files['files']['tmp_name'][$i];
                            $_FILES['files']['error']    = $files['files']['error'][$i];
                            $_FILES['files']['size']     = $files['files']['size'][$i];
             
                           $this->load->library('upload',$config);
                           $this->upload->initialize($config);
             
                           if($this->upload->do_upload('files')){
                            $filedata = $this->upload->data();
                            $data4[$i]['id_request'] = $req;
                            $data4[$i]['file_name'] = $filedata['file_name'];
                            }
                        }
                    }
             
                    if(!empty($data4)){
                    $this->request_model->insert_file($data4);
                    }

                    $notification_link = site_url().'/request/view_request/'.$req.'/'.$idc;
                    $notification_label = $datas->row()->name_user.' create new request for <br><i class="fa fa-plus text-green"></i> '.$cus->row()->name_customer.'  ['.$req.']';
                    
                    $reference_type = 1;

                    $data2 = array(
                        'notification_label' =>$notification_label,
                        'notification_link' =>$notification_link,
                        'notification_datetime' =>$requested_date,
                        'notification_reference_type' =>$reference_type,
                        'notification_reference_id' =>$req,
                        'id_user' =>$id_user
                    );

                    $this->request_model->add_notification($data2);

                    redirect('request');
                    $this->db->close();
                }
            }

            function edit_request()
            {
                $id = $this->uri->segment(3);
                $idc = $this->uri->segment(4);
                $this->form_validation->set_rules('credit_limit', 'Credit Limit', 'required');
                $this->form_validation->set_rules('top', 'TOP', 'required');
                $this->form_validation->set_rules('max_top', 'max outstanding days', 'required');
                $this->form_validation->set_rules('po_amount', 'PO Amount', 'required');

                
                $this->form_validation->set_error_delimiters('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');

                if ($this->form_validation->run() == FALSE)
                {
                    $data['data'] = $this->request_model->view_request($id);
                    $data['customer'] = $this->request_model->get_customer_by_id($idc);

                    $request = $this->acl->get_user_permissions()->request;
                    if($this->session->userdata('logged_in') and $request=='1')
                    {
                        $data['isi'] = 'request/edit';
                        $this->load->view('preview', $data, true);
                        $this->load->view('template/template', $this->data);
                    }
                    else
                    {
                        redirect('login','refresh');
                    }
                    $this->db->close();
                }
                else
                {
                    $credit_limit = $this->input->post('credit_limit');
                    $cl = str_replace(".", "", $credit_limit);
                    $po_amount = $this->input->post('po_amount');
                    $po = str_replace(".", "", $po_amount);

                    $data = array(
                    'credit_limit' =>$cl,
                    'top' =>$this->input->post('top'),
                    'max_top' =>$this->input->post('max_top'),
                    'po_amount' =>$po,
                    'requested_note' =>$this->input->post('requested_note')
                    );

                    $this->request_model->edit_request($id,$data);

                    redirect('request/view_request/'.$id.'/'.$idc);
                    $this->db->close();
                }
            }

            function delete_request()
            {
                $id = $this->uri->segment(3);
                $idc = $this->uri->segment(4);

                $query = $this->db->select('*');
                $query = $this->db->from('db_request_file');
                $query = $this->db->where('id_request',$id);
                $query = $this->db->get();

                foreach($query->result() as $row){
                    $link = $row->file_name;
                    $file = "./myfile/$link";
                unlink($file);
                }

                $this->request_model->delete_request($id);

                redirect('request');
                $this->db->close();
            }

            function view_request()
            {
                $id = $this->uri->segment(3);
                $idc = $this->uri->segment(4);
                $data['data'] = $this->request_model->view_request($id);
                $data['status'] = $this->request_model->get_request_status();
                $data['customer'] = $this->request_model->get_customer_by_id($idc);
                $data['user'] = $this->request_model->get_user();
                $data['file'] = $this->request_model->get_file($id);
                $data['comment'] = $this->request_model->get_comment($id);
                $data['timeline'] = $this->request_model->get_timeline($id);

                $request = $this->acl->get_user_permissions()->request;
                if($this->session->userdata('logged_in') and $request=='1')
                {
                    $data['isi'] = 'request/view';
                    $this->load->view('preview', $data, true);
                    $this->load->view('template/template', $this->data); 
                }
                else
                {
                    redirect('login','refresh');
                } 
            }

            function add_attachment()
            {
                $config['upload_path'] = './myfile/';
                $config['allowed_types'] = 'pdf|xlsx|xls|csv|doc|docx';
                $config['no_space'] = TRUE;

                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('file_upload'))
                {
                    print_r($this->upload->display_errors());
                    //$data = array('error' => $this->upload->display_errors());
                }
                else
                {
                    $this->load->library('upload', $config);
                    $filename = $this->upload->data();
                    $file = $filename['file_name'];

                    $id = $this->uri->segment(3);
                    $idc = $this->uri->segment(4);

                    $data = array(
                        'id_request' => $id,
                        'file_name' =>$file,
                        'status_confidential' =>$this->input->post('status_confidential')
                    );

                    $this->request_model->add_request_file($data);

                    redirect('request/view_request/'.$id.'/'.$idc);
                    $this->db->close();
                }
            }

            function delete_attachment()
            {
                $id = $this->uri->segment(3);
                $ida = $this->uri->segment(4);
                $idf = $this->uri->segment(5);
                $idc = $this->uri->segment(6);

                $this->request_model->delete_file($ida,$idf);   
                redirect('request/view_request/'.$id.'/'.$idc);
            }

            function add_comment()
            {
                $id = $this->uri->segment(3);
                $idc = $this->uri->segment(4);
                $id_user = $this->session->userdata('id');
                $note_comment = $this->input->post('note_comment');

                date_default_timezone_set('Asia/Jakarta');
                $date = date('Y-m-d H:i:s');

                $query = $this->request_model->get_user_id($id_user);

                $notification_link = site_url().'/request/view_request/'.$id.'/'.$idc;
                $notification_label = $query->row()->name_user.' commented on request no. '.$id.'<br> <i class="fa fa-comment text-aqua"></i> "'.$this->input->post('note_comment').'"';
                
                $data = array(
                    'id_request' => $id,
                    'id_user' => $id_user,
                    'note_comment' => $note_comment,
                    'date_comment' => $date
                );

                $last = $this->request_model->add_comment($data);

                
                $data2 = array(
                    'notification_label' =>$notification_label,
                    'notification_link' =>$notification_link,
                    'notification_datetime' =>$date,
                    'notification_reference_type' =>1,
                    'notification_reference_id' =>$id,
                    'id_user' =>$id_user,
                    'id_comment' => $last
                );

                $this->request_model->add_notification($data2);
                echo json_encode($last);

                //redirect('request/view_request/'.$id.'/'.$idc);
            }

            function delete_comment()
            {
                $id = $this->uri->segment(3);
                $idc = $this->uri->segment(4);
                $idk = $this->uri->segment(5);

                $this->request_model->delete_comment($idc);   
                redirect('request/view_request/'.$id.'/'.$idk);
            }

            //delete ajax
            function delete_comm_ajax()
            {
                $idc = $this->uri->segment(3);
                $data = $this->request_model->delete_comment($idc);
                echo json_encode($data);
            }

            function change_state()
            {
                $id = $this->uri->segment(3);
                $idc = $this->uri->segment(4);
                $id_user = $this->session->userdata('id');
                $new_state = $this->input->post('id_request_status');

                date_default_timezone_set('Asia/Jakarta');
                $date = date('Y-m-d H:i:s');

                $query = $this->request_model->get_user_id($id_user);
                $query1 = $this->request_model->get_request_status_id($new_state);
                $query2 = $this->request_model->get_name_request_status($id);
                
                $notification_link = site_url().'/request/view_request/'.$id.'/'.$idc;
                $notification_label1 = $query->row()->name_user.' has change state for Request no '.$id.'<br> from '.$query2->row()->name_request_status.'  <i class="fa fa-arrow-right text-green"></i> '.$query1->row()->name_request_status;
                $link_email = "<a href='http://localhost/cl/index.php/request/view_request/$id/$idc'>Disini</a>"; //link untuk email

                if($new_state != $query2->row()->id_request_status)
                {
                    $reference_id = 1;
                    if($new_state == 5){
                        $reference_id = 2;
                    }
                    $data2 = array(
                                'notification_label' =>$notification_label1,
                                'notification_link' =>$notification_link,
                                'notification_datetime' =>$date,
                                'notification_reference_type' =>$reference_id,
                                'notification_reference_id' =>$id,
                                'id_user' =>$id_user
                            );
                            
                    $this->request_model->add_notification($data2);

                    $data = array(
                        'id_request_status' => $new_state,
                        'update_by' => $id_user,
                        'update_date' => $date
                    );

                    $this->request_model->edit_request($id,$data);
                    $this->add_comment();
                    //kirim email sesuai perubahan state
                    $this->send_mail($new_state,$id,$link_email);

                }else{
                    $this->add_comment();
                }
                
                $data3 = array(
                    'id_request' => $id,
                    'id_user' => $id_user,
                    'date_timeline' => $date,
                    'id_request_status' => $new_state
                );

                $this->request_model->add_timeline($data3);

                redirect('request/view_request/'.$id.'/'.$idc);
            }

            function total_pending()
            {
                $data['data'] = $this->request_model->get_total_pending();
                $this->load->view('template/total_request',$data);
            }

            function history()
            {
                $per_page = abs($this->input->get('per_page'));
                $limit = 20;
                $cari = $this->input->get('search');

                $tot = $this->request_model->all_history();
                $data['name'] = $this->request_model->limit_history($limit,$per_page,$cari);
                $data['status'] = $this->request_model->get_request_status();
                $data['customer'] = $this->request_model->get_all_customer();
                $data['user'] = $this->request_model->get_user();

                $pagination['page_query_string']  = TRUE;    
                $pagination['base_url']           = site_url().'/request/history?search=';
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


                $request = $this->acl->get_user_permissions()->request;
                    if($this->session->userdata('logged_in') and $request=='1')
                    {
                        $data['isi'] = 'request/list_history';
                        $this->load->view('preview', $data, true);
                        $this->load->view('template/template', $this->data);
                    }
                    else
                    {
                        redirect('login','refresh');
                    }
                $this->db->close();
            }

            function admin_update()
            {
                $id = $this->uri->segment(3);
                $id_user = $this->session->userdata('id');
                date_default_timezone_set('Asia/Jakarta');
                $update_date = date('Y-m-d H:i:s');

                $request = $this->acl->get_user_permissions()->request;
                if($this->session->userdata('logged_in') and $request=='1')
                {
                    $data = array(
                    'approved_status' => 5,
                    'update_by' => $id_user,
                    'update_date' => $update_date
                );
                $this->request_model->update_note($id,$data);
                redirect('request');
                }
                else
                {
                    redirect('login','refresh');
                } 
            }

            function total_notification()
            {
                $id_user = $this->session->userdata('id');
                $data['data'] = $this->request_model->get_tot_notif($id_user);
                $this->load->view('template/total_notification',$data);
            }

            function notification()
            {
                $id_user = $this->session->userdata('id');
                $data['data'] = $this->request_model->get_notification($id_user);
                $data['notifid'] = $this->request_model->get_user_id($id_user);
                $data['unread'] = $this->request_model->get_unread_notification($id_user);
                
                $this->load->view('template/notification',$data);
            }

            function read()
            {
                $id = $this->uri->segment(3);

                $data = array(
                    'notification_read' =>1
                );

                $hsl = $this->request_model->up($id,$data);
                echo json_encode($hsl);
            }

            //function insert read db_read_notification
            function insert_read()
            {
                date_default_timezone_set('Asia/Jakarta');
                $date = date('Y-m-d H:i:s');
                $id = $this->uri->segment(3);
                $id_request = $this->uri->segment(4);
                $id_user = $this->session->userdata('id');
                

                $hsl = $this->request_model->add_request_notification($id,$id_user,$id_request,$date);
                echo json_encode($hsl);
            }

            //function update db_user notification_id
            function update_notification_id()
            {
                $id_request = $this->uri->segment(3);
                $id_user = $this->session->userdata('id');

                $data = array(
                    'notification_id' => $id_request
                );

                $hsl = $this->request_model->update_notification_id($id_user,$data);
                echo json_encode($hsl);
            }

            //comment ajax
            function get_comm()
            {
                $id = $this->uri->segment(3);

                $data = $this->request_model->get_comments($id);
                echo json_encode($data);
            }

            //kirim email bila state berubah
            function send_mail($new_state,$id,$link_email)
            {
                $from_email = 'info@sefasgroup.com';

                if($new_state == '5'){
                    $to_email = 'yopie.alamsyah@sefasgroup.com'; //alamat email yang dituju
                    $subject = 'New Approved Credit limit';
                    $message = '<p>Credit limit untuk request '.$id.' diubah menjadi status approve </p><br> Click '.$link_email.' untuk melihat data';
                }else if($new_state == '3'){
                    $to_email = 'yopie.alamsyah@sefasgroup.com';
                    $subject = 'New Recommended Credit limit';
                    $message = '<p>Credit limit untuk request '.$id.' diubah menjadi status recommend </p><br> Click '.$link_email.' untuk melihat data';
                }else if($new_state == '7'){
                    $to_email = 'yopie.alamsyah@sefasgroup.com';
                    $subject = 'Credit Limit Request has Closed';
                    $message = '<p>Credit limit untuk request '.$id.' diubah menjadi status closed </p><br> Click '.$link_email.' untuk melihat data';
                }

                $config = array(
                    'prototcol' => 'smtp',
                    'smtp_host' => 'ssl://mail.sefasgroup.com',
                    'smtp_port' => 465,
                    'smtp_user' => $from_email,
                    'smtp_pass' => '_Tr4nsf0rm.',
                    'smtp_timeout' => '4',
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1'
                );

                $this->load->library('email');

                $this->email->initialize($config);
                $this->email->set_newline('\r\n');

                $this->email->from($from_email,'info@sefasgroup.com');
                $this->email->to($to_email);
                //$this->email->cc() bila ingin menambahkan cc
                $this->email->subject($subject);
                $this->email->message($message);

                if($this->email->send())
                {
                    return true;
                }else{
                    show_error($this->email->print_debugger());
                }
            }
        }