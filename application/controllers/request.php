<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

        class Request extends CI_Controller {

            const NETSUITE_CONSUMER_KEY = '48634a8cf1d39603b61c63e710ad4775fc5971c1c8deaa0e36b69fcd28bd33e6';
            const NETSUITE_ACCOUNT = '6381871';
            const NETSUITE_CONSUMER_SECRET = '582b3de5e8424785cef63ce8a47278672c66401500ffaee3182efa4d04cf2586';
            const NETSUITE_TOKEN_ID = '03b6539ea7acafee2686782721bb2b1f7c71f017c1247ecaf152bff028c88836';
            const NETSUITE_TOKEN_SECRET = '52d4d71f679dadeff54490493da2dee8093f6efe9124eb022f08f4c2a3ab1681'; 
     
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
                $startdate = $this->input->get('startdate');
                $enddate = $this->input->get('enddate');

                $area = $this->input->get('area');
                $per_page = abs($this->input->get('per_page'));
                $limit = 20;

                $tot = $this->request_model->all($area,$startdate,$enddate);
                $data['name'] = $this->request_model->limit($area,$startdate,$enddate,$limit,$per_page);
                $data['status'] = $this->request_model->get_request_status();
                $data['customer'] = $this->request_model->get_all_customer();
                $data['user'] = $this->request_model->get_user();
                $data['area'] = $this->request_model->get_list_area();
                $data['month'] = $this->request_model->get_month();
                $data['year'] = $this->request_model->get_year();
                $data['notif'] = $this->request_model->get_notification_list();

                $pagination['page_query_string']  = TRUE;    
                $pagination['base_url']           = site_url().'/request?area='.$area.'&startdate='.$startdate.'&enddate='.$enddate;
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
                $this->form_validation->set_rules('id_customer', 'Customer Name', 'required');
                $this->form_validation->set_rules('requested_note', 'Note', 'required');
 
               
                $this->form_validation->set_error_delimiters('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');
 

                if ($this->form_validation->run() == FALSE)
                {
                    $data['status'] = $this->request_model->get_request_status();
                    $data['customer'] = $this->request_model->get_customer();
                    $data['terms'] = $this->request_model->get_terms();

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
                    $id_role = $this->session->userdata('id_role');
                    $po_amount = $this->input->post('po_amount');
                    $po = str_replace(".", "", $po_amount);
                    $credit_limit = $this->input->post('credit_limit');
                    $cl = str_replace(".", "", $credit_limit);

                    $customer = $this->input->post('id_customer');
                    $id_customer = explode('|',$customer);

                    $datas = $this->request_model->get_user_id($id_user);
                    $cus = $this->request_model->get_customer_by_id($idc);
                    $status = $this->input->post('status_customer');

                    if($id_role=='7')
                    {
                        $id_request_status = 3;
                    }
                    else
                    {
                        $id_request_status = 1;
                    }
 
                    $data = array(
                    'id_user' =>$id_user,
                    'id_customer' =>$id_customer[0],
                    'id_netsuite' =>$id_customer[2],
                    'id_internal' =>$id_customer[1],
                    'credit_limit' =>$cl,
                    'id_terms' =>$this->input->post('top'),
                    'po_amount' =>$po,
                    'requested_note' =>$this->input->post('requested_note'),
                    'requested_date' =>$requested_date,
                    'id_request_status' =>$id_request_status,
                    'status_existing' =>$status
                    );
 
                    $req = $this->request_model->add_request($data);
 
                    $data3 = array(
                        'id_request' => $req,
                        'id_user' => $id_user,
                        'date_timeline' => $requested_date,
                        'id_request_status' => $id_request_status
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
                    if($id_role == '7'){
                        $reference_type = 3;
                    }
 
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
                $this->form_validation->set_rules('po_amount', 'PO Amount', 'required');

                
                $this->form_validation->set_error_delimiters('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');

                if ($this->form_validation->run() == FALSE)
                {
                    $data['data'] = $this->request_model->view_request($id);
                    $data['customer'] = $this->request_model->get_customer_by_id($idc);
                    $data['terms'] = $this->request_model->get_terms();

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
                    'id_terms' =>$this->input->post('top'),
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

                //Status Closed
                $data['status_closed'] = $this->request_model->get_request_status_closed();

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
                $new = $_FILES['file_upload']['name'];
                $new_name = preg_replace('/[^a-zA-Z0-9.]/','',$new);

                $config['upload_path'] = './myfile/';
                $config['allowed_types'] = 'pdf|xlsx|xls|csv|doc|docx|jpg|jpeg|png';
                //$config['no_space'] = TRUE;
                $config['file_name'] = $new_name;
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('file_upload'))
                {
                    print_r($this->upload->display_errors());
                }
                else
                {
                    $filename = $this->upload->data();
                    $file = $filename['file_name'];
                    
                    $id = $this->uri->segment(3);
                    $idc = $this->uri->segment(4);

                    $id_user = $this->session->userdata('id');
                    date_default_timezone_set('Asia/Jakarta');
                    $date = date('Y-m-d H:i:s');

                    $data = array(
                        'id_request' => $id,
                        'file_name' => $file,
                        'status_confidential' =>$this->input->post('status_confidential')
                    );

                    $this->request_model->add_request_file($data);

                     //notifikasi bila ada penambahan attachment
                     $query = $this->request_model->get_user_id($id_user);
                     $reference_id = 1;
 
                     $notification_link = site_url().'/request/view_request/'.$id.'/'.$idc;
                     $notification_label1 = $query->row()->name_user.'<br><i class="fa fa-file text-green"></i> Add Attachment for Activity no '.$id;
 
                     $data2 = array(
                         'notification_label' =>$notification_label1,
                         'notification_link' =>$notification_link,
                         'notification_datetime' =>$date,
                         'notification_reference_type' =>$reference_id,
                         'notification_reference_id' =>$id,
                         'id_user' =>$id_user
                     );
                     
                     $this->request_model->add_notification($data2);


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
                $ids = $this->uri->segment(5);
                $id_user = $this->session->userdata('id');
                $note_comment = $this->input->post('note_comment');
                $confidential = $this->input->post('status_confidential');
 
                date_default_timezone_set('Asia/Jakarta');
                $date = date('Y-m-d H:i:s');
 
                $query = $this->request_model->get_user_id($id_user);
 
                $notification_link = site_url().'/request/view_request/'.$id.'/'.$idc;
                $notification_label = $query->row()->name_user.' commented on request no. '.$id.'<br> <i class="fa fa-comment text-aqua"></i> "'.$this->input->post('note_comment').'"';
                
                $data = array(
                    'id_request' => $id,
                    'id_request_status' => $ids,
                    'id_user' => $id_user,
                    'note_comment' => $note_comment,
                    'date_comment' => $date,
                    'status_confidential' => $confidential
                );
 
                $last = $this->request_model->add_comment($data);
 
                //jika komentar berstatus confidential maka notification type berubah jadi 4
                if($confidential == 1)
                {
                    $nontification_reference_type = 4;
                }else{
                    $nontification_reference_type = 1;
                }
 
                $data2 = array(
                    'notification_label' =>$notification_label,
                    'notification_link' =>$notification_link,
                    'notification_datetime' =>$date,
                    'notification_reference_type' =>$nontification_reference_type,
                    'notification_reference_id' =>$id,
                    'id_user' =>$id_user
                );
 
                $this->request_model->add_notification($data2);
                //echo json_encode($last);
 
                redirect('request/view_request/'.$id.'/'.$idc);
            }

            function add_comment_change_state($new_state)
            {
                $id = $this->uri->segment(3);
                $idc = $this->uri->segment(4);
                $id_user = $this->session->userdata('id');
 
                date_default_timezone_set('Asia/Jakarta');
                $date = date('Y-m-d H:i:s');
 
                $this->db->select('name_user');
                $this->db->from('db_users');
                $this->db->where('id',$id_user);
                $query = $this->db->get();
 
                $notification_link = site_url().'/request/view_request/'.$id.'/'.$idc;
                $notification_label = $query->row()->name_user.' commented on request no. '.$id.'<br> <i class="fa fa-comment text-aqua"></i> "'.$this->input->post('note_comment').'"';
               
                $data = array(
                    'id_request' => $id,
                    'id_request_status' => $new_state,
                    'id_user' => $id_user,
                    'note_comment' => $this->input->post('note_comment'),
                    'date_comment' => $date
                );
                $this->request_model->add_comment($data);
               
                $data2 = array(
                    'notification_label' =>$notification_label,
                    'notification_link' =>$notification_link,
                    'notification_datetime' =>$date,
                    'notification_reference_type' =>1,
                    'notification_reference_id' =>$id,
                    'id_user' =>$id_user
                );
 
                $this->request_model->add_notification($data2);
            }

            function delete_comment()
            {
                $id = $this->uri->segment(3);
                $idc = $this->uri->segment(4);
                $idk = $this->uri->segment(5);

                $this->request_model->delete_comment($idc);   
                redirect('request/view_request/'.$id.'/'.$idk);
            }

             //membuat signature header NETSUITE
             public function restletBaseString($httpMethod, $url, $consumerKey, $tokenKey, $nonce, $timestamp, $version, $signatureMethod, $postParams){
                //http method must be upper case
                $baseString = strtoupper($httpMethod) .'&';
                
                //include url without parameters, schema and hostname must be lower case
                if (strpos($url, '?')){
                  $baseUrl = substr($url, 0, strpos($url, '?'));
                  $getParams = substr($url, strpos($url, '?') + 1);
                } else {
                 $baseUrl = $url;
                 $getParams = "";
                }
                $hostname = strtolower(substr($baseUrl, 0,  strpos($baseUrl, '/', 10)));
                $path = substr($baseUrl, strpos($baseUrl, '/', 10));
                $baseUrl = $hostname . $path;
                $baseString .= rawurlencode($baseUrl) .'&';
                
                //all oauth and get params. First they are decoded, next alphabetically sorted, next each key and values is encoded and finally whole parameters are encoded
                $params = array();
                $params['oauth_consumer_key'] = array($consumerKey);
                $params['oauth_token'] = array($tokenKey);
                $params['oauth_nonce'] = array($nonce);
                $params['oauth_timestamp'] = array($timestamp);
                $params['oauth_signature_method'] = array($signatureMethod);
                $params['oauth_version'] = array($version);
                 
                foreach (explode('&', $getParams ."&". $postParams) as $param) {
                  $parsed = explode('=', $param);
                  if ($parsed[0] != "") {
                    $value = isset($parsed[1]) ? urldecode($parsed[1]): "";
                    if (isset($params[urldecode($parsed[0])])) {
                      array_push($params[urldecode($parsed[0])], $value);
                    } else {
                      $params[urldecode($parsed[0])] = array($value);
                    }
                  }
                }
                 
                //all parameters must be alphabetically sorted
                ksort($params);
                 
                $paramString = "";
                foreach ($params as $key => $valueArray){
                  //all values must be alphabetically sorted
                  sort($valueArray);
                  foreach ($valueArray as $value){
                    $paramString .= rawurlencode($key) . '='. rawurlencode($value) .'&';
                  }
                }
                $paramString = substr($paramString, 0, -1);
                 $baseString .= rawurlencode($paramString);
                
                return $baseString;
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
 
 
                if($new_state != $query2->row()->id_request_status)
                {
                    if($new_state == 5 || $new_state == 6){
                        $reference_id = 2;
                    }elseif($new_state == 7){
                        $reference_id = 3;
                    }else{
                        $reference_id = 1;
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
 
                    $data3 = array(
                    'id_request' => $id,
                    'id_user' => $id_user,
                    'date_timeline' => $date,
                    'id_request_status' => $new_state
                    );
     
                    $this->request_model->add_timeline($data3);
 
                    $this->add_comment_change_state($new_state);
 
                    //menghapus notifikasi dan read notifikasi request closed
                    $this->delete_notification($new_state,$id);

                    //jika status approve
                    if($new_state == 5)
                    {
                              //$datanetsuite = array(
                              //    'recordtype' => 'customer',
                              //    'internalid' => $this->input->post('id_internal'),
                              //    'creditlimit' => $this->input->post('creditlimit'),
                              //    'custentitycust_sync_to_webcl_customer' => TRUE
                              //  );
                              //$hasil = json_encode($datanetsuite);
                        
                            $hasil = '{"type":"customer","internalid":'.$this->input->post('id_internal').',"creditlimit":'.$this->input->post('creditlimit').',"custentitycust_sync_to_webcl_customer":true}';
                            //Update CL to netsuite
                            $oauth_nonce = md5(mt_rand());
                            $oauth_timestamp = time();
                            $oauth_signature_method = 'HMAC-SHA256';
                            $oauth_version = "1.0";
                            $url = "https://6381871.restlets.api.netsuite.com/app/site/hosting/restlet.nl?script=348&deploy=1";
                            
                            // generate Signature 
                            $baseString = $this->restletBaseString("PUT",
                            $url,
                            self::NETSUITE_CONSUMER_KEY,
                            self::NETSUITE_TOKEN_ID,
                            $oauth_nonce,
                            $oauth_timestamp,
                            $oauth_version,
                            $oauth_signature_method,null);
                            
                            
                            $key = rawurlencode(self::NETSUITE_CONSUMER_SECRET) .'&'. rawurlencode(self::NETSUITE_TOKEN_SECRET);
                        
                            $signature = base64_encode(hash_hmac('sha256', $baseString, $key, true)); 
                            
                            // GENERATE HEADER TO PASS IN CURL
                            $header = 'Authorization: OAuth '
                                    .'realm="' .rawurlencode(self::NETSUITE_ACCOUNT) .'", '
                                    .'oauth_consumer_key="' .rawurlencode(self::NETSUITE_CONSUMER_KEY) .'", '
                                    .'oauth_token="' .rawurlencode(self::NETSUITE_TOKEN_ID) .'", '
                                    .'oauth_nonce="' .rawurlencode($oauth_nonce) .'", '
                                    .'oauth_timestamp="' .rawurlencode($oauth_timestamp) .'", '
                                    .'oauth_signature_method="' .rawurlencode($oauth_signature_method) .'", '
                                    .'oauth_version="' .rawurlencode($oauth_version) .'", '
                                    .'oauth_signature="' .rawurlencode($signature) .'"';
                    
                            $curl = curl_init();
                    
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => $url,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_SSL_VERIFYHOST=>false,
                                CURLOPT_SSL_VERIFYPEER=>false,
                                CURLOPT_CUSTOMREQUEST => "PUT",
                                CURLOPT_POSTFIELDS => $hasil,
                                CURLOPT_HTTPHEADER => array(
                                $header,
                                "content-type: application/json"
                                ),
                            ));
                    
                            $response = curl_exec($curl);
                    
                            curl_close($curl);
                            $message = json_decode(json_decode($response));
                            //var_dump($message);
                            if(count($message->total_transaction_created) > 0){
                                $this->session->set_flashdata('success', $message->success_transaction[0]);
                            }
                            if(count($message->total_transaction_failed_created) > 0){
                                $this->session->set_flashdata('failed', $message->failed_transaction[0]);
                            }
                            
                        //end update
                    }
                }else{
                    $this->add_comment_change_state($new_state);
                }
 
                redirect('request/view_request/'.$id.'/'.$idc);
            }

            
            function approve()
            {
                $id = $this->uri->segment(3);
                $idc = $this->uri->segment(4);
                $id_user = $this->session->userdata('id');
                $new_state = 5;
 
                date_default_timezone_set('Asia/Jakarta');
                $date = date('Y-m-d H:i:s');
 
                $query = $this->request_model->get_user_id($id_user);
                $query1 = $this->request_model->get_request_status_id($new_state);
                $query2 = $this->request_model->get_name_request_status($id);
               
                $notification_link = site_url().'/request/view_request/'.$id.'/'.$idc;
                $notification_label1 = $query->row()->name_user.' has change state for Request no '.$id.'<br> from '.$query2->row()->name_request_status.'  <i class="fa fa-arrow-right text-green"></i> '.$query1->row()->name_request_status;
                    
                $data2 = array(
                            'notification_label' =>$notification_label1,
                            'notification_link' =>$notification_link,
                            'notification_datetime' =>$date,
                            'notification_reference_type' =>2,
                            'notification_reference_id' =>$id,
                            'id_user' =>$id_user
                        );
                        
                $this->request_model->add_notification($data2);

                $data = array(
                    'id_request_status' => 5,
                    'update_by' => $id_user,
                    'update_date' => $date
                );

                $this->request_model->edit_request($id,$data);

                $data3 = array(
                'id_request' => $id,
                'id_user' => $id_user,
                'date_timeline' => $date,
                'id_request_status' => $new_state
                );
    
                $this->request_model->add_timeline($data3);

                $this->add_comment_change_state($new_state);

                //menghapus notifikasi dan read notifikasi request closed
                $this->delete_notification($new_state,$id);

                    
                $hasil = '{"type":"customer","internalid":'.$this->input->post('id_internal').',"creditlimit":'.$this->input->post('creditlimit').',"custentitycust_sync_to_webcl_customer":true}';
                
                //Update CL to netsuite
                $oauth_nonce = md5(mt_rand());
                $oauth_timestamp = time();
                $oauth_signature_method = 'HMAC-SHA256';
                $oauth_version = "1.0";
                $url = "https://6381871.restlets.api.netsuite.com/app/site/hosting/restlet.nl?script=348&deploy=1";
                
                // generate Signature 
                $baseString = $this->restletBaseString("PUT",
                $url,
                self::NETSUITE_CONSUMER_KEY,
                self::NETSUITE_TOKEN_ID,
                $oauth_nonce,
                $oauth_timestamp,
                $oauth_version,
                $oauth_signature_method,null);
                
                
                $key = rawurlencode(self::NETSUITE_CONSUMER_SECRET) .'&'. rawurlencode(self::NETSUITE_TOKEN_SECRET);
            
                $signature = base64_encode(hash_hmac('sha256', $baseString, $key, true)); 
                
                // GENERATE HEADER TO PASS IN CURL
                $header = 'Authorization: OAuth '
                        .'realm="' .rawurlencode(self::NETSUITE_ACCOUNT) .'", '
                        .'oauth_consumer_key="' .rawurlencode(self::NETSUITE_CONSUMER_KEY) .'", '
                        .'oauth_token="' .rawurlencode(self::NETSUITE_TOKEN_ID) .'", '
                        .'oauth_nonce="' .rawurlencode($oauth_nonce) .'", '
                        .'oauth_timestamp="' .rawurlencode($oauth_timestamp) .'", '
                        .'oauth_signature_method="' .rawurlencode($oauth_signature_method) .'", '
                        .'oauth_version="' .rawurlencode($oauth_version) .'", '
                        .'oauth_signature="' .rawurlencode($signature) .'"';
        
                $curl = curl_init();
        
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_SSL_VERIFYHOST=>false,
                    CURLOPT_SSL_VERIFYPEER=>false,
                    CURLOPT_CUSTOMREQUEST => "PUT",
                    CURLOPT_POSTFIELDS => $hasil,
                    CURLOPT_HTTPHEADER => array(
                    $header,
                    "content-type: application/json"
                    ),
                ));
        
                $response = curl_exec($curl);
        
                curl_close($curl);
                $message = json_decode(json_decode($response));
                //var_dump($response);
                if(count($message->total_transaction_created) > 0){
                    $this->session->set_flashdata('success', $message->success_transaction[0]);
                }
                if(count($message->total_transaction_failed_created) > 0){
                    $this->session->set_flashdata('failed', $message->failed_transaction[0]);
                }
                    
                //end update
 
                redirect('request/view_request/'.$id.'/'.$idc);
            }

            function delete_notification($new_state,$id)
            {
                if($new_state=='7')
                {
                    $this->request_model->delete_notification($id);
                }
                else
                {
                    return false;
                }
            }

            function total_pending()
            {
                $bulan = $this->input->get('bulan');
                $tahun = $this->input->get('tahun');

                $data['data'] = $this->request_model->get_total_pending($bulan,$tahun);
                $this->load->view('template/total_request',$data);
            }

            //notif sidebar
            function total_pending_notif()
            {
                $data['data'] = $this->request_model->get_total_pending_notif();
                $this->load->view('template/total_request',$data);
            }

            function history()
            {
		        $startdate = $this->input->get('startdate');
                $enddate = $this->input->get('enddate');
                $note = $this->input->get('note');

                $this->session->set_userdata('ses_startdate',$startdate);
                $this->session->set_userdata('ses_enddate',$enddate);

                $area = $this->input->get('area');
                $per_page = abs($this->input->get('per_page'));
                $limit = 20;

                $tot = $this->request_model->all_history($area,$startdate,$enddate,$note);
                $data['name'] = $this->request_model->limit_history($limit,$per_page,$area,$startdate,$enddate,$note);
                $data['status'] = $this->request_model->get_request_status();
                $data['customer'] = $this->request_model->get_all_customer();
                $data['user'] = $this->request_model->get_user();
                $data['note'] = $this->request_model->get_approval_note();
                $data['area'] = $this->request_model->get_list_area();
                $data['month'] = $this->request_model->get_month();
                $data['year'] = $this->request_model->get_year();

                $pagination['page_query_string']  = TRUE;    
                $pagination['base_url']           = site_url().'/request/history?area='.$area.'&startdate='.$startdate.'&enddate='.$enddate;
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

            function read()
            {
                $id = $this->uri->segment(3);

                $data = array(
                    'notification_read' =>1
                );

                $hsl = $this->request_model->up($id,$data);
                echo json_encode($hsl);
            }

            function notification()
            {
                $id_user = $this->session->userdata('id');
                $data['data'] = $this->request_model->get_notification($id_user);
                $data['unread'] = $this->request_model->get_unread_notification($id_user);
               
                $this->load->view('template/notification',$data);
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

            function export_history()
            {
                
                $ses_startdate = $this->session->userdata('ses_startdate');
                $ses_enddate = $this->session->userdata('ses_enddate');

                $data['report'] = $this->request_model->report_history($ses_startdate,$ses_enddate);
                $data['status'] = $this->request_model->get_request_status();
                $data['customer'] = $this->request_model->get_all_customer();
                $data['user'] = $this->request_model->get_user();
                $data['note'] = $this->request_model->get_approval_note();

                if($this->session->userdata('logged_in'))
                {
                    $this->load->view('request/history_export', $data);
                }
                else
                {
                    redirect('login','refresh');
                    
                } 
            }

            function export_history_request()
            {
                $this->load->library("excel");

                $object = new PHPExcel();

                $object->setActiveSheetIndex(0); 

                $ses_startdate = $this->session->userdata('ses_startdate');
                $ses_enddate = $this->session->userdata('ses_enddate');

                $report = $this->request_model->report_history($ses_startdate,$ses_enddate);
                $status = $this->request_model->get_request_status();
                $customer = $this->request_model->get_all_customer();
                $user = $this->request_model->get_user();
                $note = $this->request_model->get_approval_note();

                $table_columns = array("State","No.","Request Date","Request By","Entity","Sales Name","Customer Name","Note","Lead Time");

                $column = 0;

                foreach ($table_columns as $field) {
                            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                            $column++;
                        }
                
                $excel_row = 2;

                $no = 1;
                
                foreach ($report->result() as $baris) {
                    
                    foreach($status->result() as $rows){
                        if($baris->id_request_status == $rows->id_request_status){
                        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $rows->name_request_status);   
                        }
                    }

                    $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $baris->id_request);
                    $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $baris->requested_date);
                    
                    foreach($user->result() as $rowu){
                        if($baris->id_user == $rowu->id){
                        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $rowu->name_user);   
                        }
                    }

                    foreach($customer->result() as $rowc){
                        if($baris->id_internal == $rowc->id_internal){
                        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $rowc->subsidiaryname);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $rowc->salesrepname);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $rowc->companyname."".$rowc->firstname." ".$rowc->middlename." ".$rowc->lastname);   
                        }
                    }

                    foreach($note->result() as $rown){
                        if($baris->id_request == $rown->id_request){
                        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $rown->note_comment);   
                        }
                    }

                    $now = new DateTime('now');
                    $requested_date = new DateTime($baris->requested_date);
                    $update_date = new DateTime($baris->update_date);

                    if($update_date->diff($requested_date)->format('%a')>0)
                    {
                        $lead_time = $update_date->diff($requested_date)->format('%a days');
                    }
                        elseif($update_date->diff($requested_date)->format('%h')>0)
                    {
                        $lead_time = $update_date->diff($requested_date)->format('%h hours');
                    }
                        elseif($update_date->diff($requested_date)->format('%i')>0)
                    {
                        $lead_time = $update_date->diff($requested_date)->format('%i minutes');
                    }

                    $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $lead_time);
                    

                    $excel_row++;
                }

                    
                    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="Activity Report.xls"');
                    $object_writer->save('php://output');
            }
        }
