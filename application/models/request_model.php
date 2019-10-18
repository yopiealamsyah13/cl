<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

      class Request_model extends CI_Model {

            public function __construct() {
                  parent::__construct();
            }

            function all($area,$bulan,$tahun)
            {
                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $id_area = $this->session->userdata('id_area');


                  $this->db->select('*');
                  $this->db->from('db_requests a');
                  $this->db->join('db_request_status b','a.id_request_status=b.id_request_status');
                  $this->db->join('db_users c','a.id_user=c.id');
                  $this->db->order_by('a.requested_date','DESC');

                  if($id_role=='1')
                  {
                        //if($id_area == '5')
                        //{
                        //      $this->db->where('c.id_area =','5');
                        //}

                        $this->db->where('a.id_request_status !=','7');
                        
                  }

                  if($id_role=='7')
                  {
                        $this->db->where('a.id_request_status !=','7');
                  }

                  if($id_role=='8' or $id_role=='9')
                  {
                        //$this->db->where('a.id_request_status !=','1');
                        $this->db->where('a.id_request_status !=','7');
                  }

                  if($id_role=='10')
                  {
                        $this->db->where('a.id_user',$id_user);
                        $this->db->where('a.id_request_status !=','7');
                  }

                  if($area!='')
                  {
                        $this->db->where('c.id_area',$area);
                  }

                  if($bulan != '')
                  {
                        $this->db->where('month(a.requested_date)',$bulan);
                  }
                  
                  if($tahun != '')
                  {
                        $this->db->where('year(a.requested_date)',$tahun);
                  }
                  
                  return  $this->db->get();
            }

            function limit($limit,$per_page,$area,$bulan,$tahun)
            {
                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $id_area = $this->session->userdata('id_area');

                  $this->db->select('*');
                  $this->db->from('db_requests a');
                  $this->db->join('db_request_status b','a.id_request_status=b.id_request_status');
                  $this->db->join('db_users c','a.id_user=c.id');
                  $this->db->order_by('a.requested_date','DESC');

                  if($id_role=='1')
                  {
                        //if($id_area == '5')
                        //{
                        //      $this->db->where('c.id_area =','5');
                        //}

                        $this->db->where('a.id_request_status !=','7');
                  }

                  if($id_role=='7')
                  {
                        $this->db->where('a.id_request_status !=','7');
                  }

                  if($id_role=='8' or $id_role=='9')
                  {
                        //$this->db->where('a.id_request_status !=','1');
                        $this->db->where('a.id_request_status !=','7');
                  }

                  if($id_role=='10')
                  {
                        $this->db->where('a.id_user',$id_user);
                        $this->db->where('a.id_request_status !=','7');
                  }
                  
                  if($area!='')
                  {
                        $this->db->where('c.id_area',$area);
                  }
                  
                  if($bulan != '')
                  {
                        $this->db->where('month(a.requested_date)',$bulan);
                  }
                  
                  if($tahun != '')
                  {
                        $this->db->where('year(a.requested_date)',$tahun);
                  }
       
                  $this->db->limit($limit,$per_page);
                  return  $this->db->get();
            }

            function add_request($data)
            {
                  $this->db->insert('db_requests', $data);
                  $req_id = $this->db->insert_id();

                  return $req_id;
            }

            function edit_request($id,$data)
            {
                  $this->db->where('id_request',$id);
                  $this->db->update('db_requests',$data);
            }

            function delete_request($id)
            {
                  $id_user = $this->session->userdata('id');

                  $this->db->where('id_request',$id);
                  $this->db->delete('db_requests');

                  $this->db->where('id_request',$id);
                  $this->db->delete('db_comment');

                  $this->db->where('id_request',$id);
                  $this->db->delete('db_request_file');

                  $this->db->where('id_request',$id);
                  $this->db->delete('db_request_timeline');

                  $this->db->where('notification_reference_id',$id);
                  $this->db->delete('db_notification');

                  $this->db->where('id_request',$id);
                  $this->db->delete('db_read_notification');
            }

            function add_comment($data)
            {
                  $this->db->insert('db_comment', $data);
                  $last = $this->db->insert_id();
                  return $last;
            }

            function get_comment($id)
            {
                  $id_role = $this->session->userdata('id_role');
                  $this->db->select('*');
                  $this->db->from('db_comment');
                  $this->db->where('id_request',$id);

                  if($id_role=='10')
                  {
                        $this->db->where('status_confidential','0');
                  }

                  $this->db->order_by('date_comment','ASC');
                  return $this->db->get();
            }

            function delete_comment($idc)
            {
                  $this->db->where('id_comment',$idc);
                  $result = $this->db->delete('db_comment');

                  $this->db->where('id_comment',$idc);
                  $this->db->delete('db_notification');
                  
                  return $result;
            }

            function add_timeline($data3)
            {
                  $this->db->insert('db_request_timeline', $data3);
            }

            function get_timeline($id)
            {
                  $this->db->select('a.date_timeline,b.name_request_status,c.name_user,a.id_request_status,a.id_user');
                  $this->db->from('db_request_timeline a');
                  $this->db->join('db_request_status b','a.id_request_status=b.id_request_status');
                  $this->db->join('db_users c','a.id_user=c.id');
                  $this->db->where('a.id_request',$id);
                  $this->db->order_by('a.date_timeline','DESC');
                  return $this->db->get();
            }

            function add_request_file($data2)
            {
                  $this->db->insert('db_request_file', $data2);
            }

            function insert_file($data4)
            {
                  $this->db->insert_batch('db_request_file',$data4);
            }

            function get_request_status()
            {
                  $this->db->select('*');
                  $this->db->from('db_request_status');
                  return $this->db->get();
            }

            function view_request($id)
            {
                  $this->db->select('*');
                  $this->db->from('db_requests');
                  $this->db->where('id_request',$id);
                  return $this->db->get();
            }

            function get_file($id)
            {
                  $id_role = $this->session->userdata('id_role');
                  
                  $this->db->select('*');
                  $this->db->from('db_request_file');
                  $this->db->where('id_request',$id);

                  if($id_role=='10')
                  {
                        $this->db->where('status_confidential','0');
                  }

                  return $this->db->get();
            }

            function delete_file($ida,$idf)
            {
                  $this->db->where('id_request_file',$ida);
                  $this->db->delete('db_request_file');

                  $file = FCPATH."myfile/".$idf;

                  unlink($file);
            }

            function update_note($id,$data)
            {
                  $this->db->where('id_request',$id);
                  $this->db->update('db_requests',$data);
            }

            function get_customer_by_id($idc)
            {
                  $this->otherdb = $this->load->database('otherdb', TRUE);

                  $this->otherdb->select('id_customer,name_customer,name_user,project_code,status_existing,mobile_phone,credit_limit,outstanding_over,name_entity');
                  $this->otherdb->from('db_customers a');
                  $this->otherdb->join('db_users b','a.id_user=b.id');
                  $this->otherdb->join('db_business_entity c','a.id_entity=c.id_entity');
                  $this->otherdb->where('a.id_customer',$idc);
                  return $this->otherdb->get();
            }

            function get_customer()
            {
                  $this->otherdb = $this->load->database('otherdb', TRUE);
                  $id_user = $this->session->userdata('id');
                  $id_area = $this->session->userdata('id_area');
                  $id_role = $this->session->userdata('id_role');

                  $this->otherdb->select('id_customer,name_customer,name_user,name_entity');
                  $this->otherdb->from('db_customers a');
                  $this->otherdb->join('db_users b','a.id_user=b.id');
                  $this->otherdb->join('db_business_entity c','a.id_entity=c.id_entity');
                  $this->otherdb->where('a.status_delete','0');
                  $this->otherdb->where('b.id_company !=','6');
                  $this->otherdb->order_by('a.name_customer','ASC');

                  if($id_role=='10')
                  {
                        if( $id_user != '171')
                        {
                              $this->otherdb->where('b.id_area',$id_area);
                        }
                  }

                  return $this->otherdb->get();
            }

            function get_all_customer()
            {
                  $this->otherdb = $this->load->database('otherdb', TRUE);
                  $this->otherdb->select('id_customer,name_customer,name_user,project_code,status_existing,mobile_phone,name_entity,alias_company');
                  $this->otherdb->from('db_customers a');
                  $this->otherdb->join('db_users b','a.id_user=b.id');
                  $this->otherdb->join('db_business_entity c','a.id_entity=c.id_entity');
                  $this->otherdb->join('db_companies d','b.id_company=d.id_company');
                  $this->otherdb->where('a.status_delete','0');
                  $this->otherdb->where('b.id_company !=','6');
                  $this->otherdb->order_by('a.name_customer','ASC');
                  return $this->otherdb->get();
            }

            function get_user()
            {
                  $this->db->select('id,name_user,photo');
                  $this->db->from('db_users');
                  return $this->db->get();
            }

            function get_total_pending($bulan,$tahun)
            {
                  
                  date_default_timezone_set('Asia/Jakarta');
                  $bulan_now = date('m');
                  $tahun_now = date('Y');

                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');

                  $this->db->select('count(id_request) as total,month(requested_date) as bulan,year(requested_date) as tahun');
                  $this->db->from('db_requests');

                  if($id_role=='1')
                  {
                        $this->db->where('id_request_status','5');
                  }

                  if($id_role=='7')
                  {
                        $this->db->where('id_request_status !=','7');
                  }

                  if($id_role=='8' or $id_role=='9')
                  {
                        $this->db->where('id_request_status !=','1');
                        $this->db->where('id_request_status !=','7');
                  }

                  if($id_role=='10')
                  {
                        $this->db->where('id_user',$id_user);
                        $this->db->where('id_request_status !=','7');
                  }

                  if($bulan!='' and $tahun != '')
                  {
                        $this->db->where('month(requested_date)',$bulan);
                        $this->db->where('year(requested_date)',$tahun);
                  }else{
                        $this->db->where('month(requested_date)',$bulan_now);
                        $this->db->where('year(requested_date)',$tahun_now);
                  }

                  return $this->db->get();
            }              

            function get_total_close($bulan,$tahun)
            {
                  date_default_timezone_set('Asia/Jakarta');
                  $bulan_now = date('m');
                  $tahun_now = date('Y');

                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $this->db->select('count(id_request) as total,month(requested_date) as bulan,year(requested_date) as tahun');
                  $this->db->from('db_requests');
                  $this->db->where('id_request_status','7');

                  if($id_role=='10')
                  {
                        $this->db->where('id_user',$id_user);
                  }

                  if($bulan!='' and $tahun != '')
                  {
                        $this->db->where('month(requested_date)',$bulan);
                        $this->db->where('year(requested_date)',$tahun);
                  }else{
                        $this->db->where('month(requested_date)',$bulan_now);
                        $this->db->where('year(requested_date)',$tahun_now);
                  }

                  return $this->db->get();
            }

            function get_total_request($bulan,$tahun)
            {
                  date_default_timezone_set('Asia/Jakarta');
                  $bulan_now = date('m');
                  $tahun_now = date('Y');
                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');

                  $this->db->select('count(id_request) as total,month(requested_date) as bulan,year(requested_date) as tahun');
                  $this->db->from('db_requests');

                  if($id_role=='10')
                  {
                        $this->db->where('id_user',$id_user);
                  }

                  if($bulan != '')
                  {
                        $this->db->where('month(requested_date)',$bulan);
                  }else{
                        $this->db->where('month(requested_date)',$bulan_now);
                  }

                  if($tahun != '')
                  {
                        $this->db->where('year(requested_date)',$tahun);
                  }else{
                        $this->db->where('year(requested_date)',$tahun_now);
                  }

                  return $this->db->get();
            }

            function get_total_by_area($bulan,$tahun)
            {
                  date_default_timezone_set('Asia/Jakarta');
                  $bulan_now = date('m');
                  $tahun_now = date('Y');
                  
                  $this->db->select('b.id_area, name_company, name_area, alias_company, count(a.id_request) as total');
                  $this->db->from('db_requests a');
                  $this->db->join('db_users b','a.id_user=b.id');
                  $this->db->join('db_companies c','b.id_company=c.id_company');
                  $this->db->join('db_company_areas d','b.id_area=d.id_area');
                  $this->db->group_by('b.id_area');

                  if($bulan != '')
                  {
                        $this->db->where('month(requested_date)',$bulan);
                  }else{
                        $this->db->where('month(requested_date)',$bulan_now);
                  }

                  if($tahun != '')
                  {
                        $this->db->where('year(requested_date)',$tahun);
                  }else{
                        $this->db->where('year(requested_date)',$tahun_now);
                  }

                  return $this->db->get();
            }

            function all_history($area,$bulan,$tahun)
            {
                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $id_area = $this->session->userdata('id_area');

                  $this->db->select('*');
                  $this->db->from('db_requests a');
                  $this->db->join('db_request_status b','a.id_request_status=b.id_request_status');
                  $this->db->join('db_users c','a.id_user=c.id');
                  $this->db->order_by('a.update_date','DESC');
                  $this->db->where('a.id_request_status','7');

                  if($id_role=='10')
                  {
                        $this->db->where('a.id_user',$id_user);   
                  }

                  if($area != '') {
                        $this->db->where('c.id_area',$area);
                  }

                  if($bulan!='' and $tahun!='')
                  {
                        $this->db->where('month(a.requested_date)',$bulan);
                        $this->db->where('year(a.requested_date)',$tahun);
                  }

                  return  $this->db->get();
            }

            function limit_history($limit,$per_page,$area,$bulan,$tahun)
            {
                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $id_area = $this->session->userdata('id_area');

                  $this->db->select('*');
                  $this->db->from('db_requests a');
                  $this->db->join('db_request_status b','a.id_request_status=b.id_request_status');
                  $this->db->join('db_users c','a.id_user=c.id');
                  $this->db->order_by('a.update_date','DESC');
                  $this->db->where('a.id_request_status','7');

                  if($id_role=='10')
                  {
                        $this->db->where('id_user',$id_user);   
                  }

                  if($area != '') {
                        $this->db->where('c.id_area',$area);
                  }

                  if($bulan!='' and $tahun!='')
                  {
                        $this->db->where('month(a.requested_date)',$bulan);
                        $this->db->where('year(a.requested_date)',$tahun);
                  }
       
                  $this->db->limit($limit,$per_page);
                  return  $this->db->get();
            }

            //baru 26/09/2019
            function all_history_search($area,$bulan,$tahun,$cari)
            {
                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $id_area = $this->session->userdata('id_area');

                  $this->db->select('a.id_request,a.id_user,a.id_customer,credit_limit,top,max_top,po_amount,requested_note,requested_date,a.id_request_status,name_user,name_request_status,note_comment,update_date,update_by');
                  $this->db->from('db_requests a');
                  $this->db->join('db_request_status b','a.id_request_status=b.id_request_status');
                  $this->db->join('db_users c','a.id_user=c.id');
                  $this->db->join('db_comment d','a.id_request=d.id_request');
                  $this->db->where('a.id_request_status','7');

                  if($id_role=='10')
                  {
                        $this->db->where('a.id_user',$id_user);   
                  }

                  if($area != '') 
                  {
                        $this->db->where('c.id_area',$area);
                  }

                  if($bulan!='' and $tahun!='')
                  {
                        $this->db->where('month(a.requested_date)',$bulan);
                        $this->db->where('year(a.requested_date)',$tahun);
                  }

                  if($cari != '')
                  {
                        //$this->db->where('d.note_comment LIKE','%'.$cari.'%');
                        //$this->db->or_where('a.id_request LIKE','%'.$cari.'%');
                        $this->db->like('d.note_comment',$cari);
                        $this->db->or_like('a.id_request',$cari);
                  }

                  
                  $this->db->order_by('a.update_date','DESC');
                  $this->db->group_by('a.id_request');
                  return  $this->db->get();
            }

            function limit_history_search($limit,$per_page,$area,$bulan,$tahun,$cari)
            {
                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $id_area = $this->session->userdata('id_area');

                  $this->db->select('a.id_request,a.id_user,a.id_customer,credit_limit,top,max_top,po_amount,requested_note,requested_date,a.id_request_status,name_user,name_request_status,note_comment,update_by,update_date');
                  $this->db->from('db_requests a');
                  $this->db->join('db_request_status b','a.id_request_status=b.id_request_status');
                  $this->db->join('db_users c','a.id_user=c.id');
                  $this->db->join('db_comment d','a.id_request=d.id_request');
                  $this->db->where('a.id_request_status','7');

                  if($id_role=='10')
                  {
                        $this->db->where('a.id_user',$id_user);
                  }

                  if($area != '') 
                  {
                        $this->db->where('c.id_area',$area);
                  }

                  if($bulan!='' and $tahun!='')
                  {
                        $this->db->where('month(a.requested_date)',$bulan);
                        $this->db->where('year(a.requested_date)',$tahun);
                  }
                  
                  if($cari != '')
                  {
                        //$this->db->where('d.note_comment LIKE','%'.$cari.'%');
                        //$this->db->or_where('a.id_request LIKE','%'.$cari.'%');
                        $this->db->like('d.note_comment',$cari);
                        $this->db->or_like('a.id_request',$cari);
                  }

                  $this->db->order_by('a.update_date','DESC');
                  $this->db->group_by('a.id_request');
                  $this->db->limit($limit,$per_page);
                  return  $this->db->get();
            }
            
            function add_notification($data2)
            {
                  $result = $this->db->insert('db_notification',$data2);
                  return $result;
            }

            function get_total_notification()
            {                    
                  $id_user = $this->session->userdata('id');
                  $this->db->select('count(notification_id) as total');
                  $this->db->from('db_notification');
                  $this->db->where('id_user !=',$id_user);
                  $this->db->where('notification_read','0');
                  return $this->db->get();
            }

            //test
            function up($id,$data)
            {
                  $this->db->where('notification_id',$id);
                  $hsl = $this->db->update('db_notification',$data);
                  return $hsl;
            }

             //baru
             function get_user_id($id_user)
             {
                   $this->db->select('*');
                   $this->db->from('db_users');
                   $this->db->where('id',$id_user);
                   return $this->db->get();
             }

            //baru
            function get_request_status_id($new_state)
            {
                  $this->db->select('*');
                  $this->db->from('db_request_status');
                  $this->db->where('id_request_status',$new_state);
                  return $this->db->get();
            }
            //baru
            function get_name_request_status($id)
            {
                $this->db->select('a.id_request_status,name_request_status');
                $this->db->from('db_requests a');
                $this->db->join('db_request_status b','a.id_request_status=b.id_request_status');
                $this->db->where('id_request',$id);
                return $this->db->get();
            }

            //get notif
            function get_notification($id_user)
            {
                  date_default_timezone_set('Asia/Jakarta');
                  $id_role = $this->session->userdata('id_role');
                  $id_area = $this->session->userdata('id_area');
                  $now = date('Y-m-d H:i:s');  //mengambil tanggal sekarang

                  $this->db->select('a.notification_id,notification_link,photo,notification_label,notification_datetime,notification_read,a.id_user,c.id_customer,notification_reference_id');
                  $this->db->from('db_notification a');
                  $this->db->join('db_users b','a.id_user=b.id');
                  $this->db->join('db_requests c','a.notification_reference_id=c.id_request','left');
                  $this->db->where('a.id_user !=',$id_user);
                  $this->db->order_by('a.notification_id','DESC');
                  
                  if($id_role == 1)
                  {
                        $this->db->where('c.id_request_status',5);
                        $this->db->where('a.notification_reference_type',2);
                  }

                  if($id_role == 10)
                  {
                        $this->db->where('c.id_user',$id_user);
                        $this->db->where('a.notification_reference_type !=',4); //agar tidak mendapat notif comment confident
                  }

                  if($id_role == 11)
                  {
                        $this->db->where('c.requested_date + interval c.max_top day >',$now); //semetara
                        $this->db->group_by('a.notification_reference_id');
                  }

                  $this->db->limit(5);
                  $hasil = $this->db->get();
                  return $hasil->result();
            }

            //add read
            function add_request_notification($id,$id_user,$id_request,$date)
            {

                  $this->db->where('id_notification',$id);
                  $this->db->where('id_user',$id_user);
                  $query = $this->db->get('db_read_notification');

                  if ($query->num_rows()>0) {   
                        return true;
                  }else{

                        $this->db->select('a.notification_id');
                        $this->db->from('db_notification a');
                        $this->db->where('a.id_user !=',$id_user);
                        $this->db->where('a.notification_reference_id',$id_request);
                        $this->db->where('a.notification_id not in(SELECT id_notification FROM db_read_notification WHERE id_user ='.$id_user.')',null,false);
                        $query2 = $this->db->get();
                        
                        $data = array();

                        foreach ($query2->result() as $value) {
                              $data[] = array(
                                    'id_notification' => $value->notification_id,
                                    'id_user' => $id_user,
                                    'id_request' => $id_request,
                                    'date' => $date
                              );
                        } 

                        $hasil = $this->db->insert_batch('db_read_notification',$data);
                        return $hasil;
                  }
            }

            //new notif from db_notification not in db_read_notification
            function get_unread_notification($id_user)
            {
                  $this->db->select('a.notification_id');
                  $this->db->from('db_notification a');
                  $this->db->where('a.id_user !=',$id_user);
                  $this->db->where('a.notification_id not in(SELECT id_notification FROM db_read_notification WHERE id_user ='.$id_user.')',null,false);
                  return $this->db->get();
            }


            //update notification id
            function update_notification_id($id_user,$data)
            {
                  $this->db->select('notification_id');
                  $this->db->from('db_users');
                  $this->db->where('id',$id_user);
                  $query = $this->db->get();

                  if($query->row()->notification_id <= $data['notification_id']){
                        $this->db->where('id',$id_user);
                        $hsl = $this->db->update('db_users',$data);
                        return $hsl;
                  }else{
                        return true;
                  }
            }

             //total notif unread new
             function get_total_notif()
             {
                   $id_user = $this->session->userdata('id');
                   $this->db->select('notification_id');
                   $this->db->from('db_users');
                   $this->db->where('id',$id_user);
                   $query = $this->db->get();

                   $this->db->select('count(b.notification_id) as total');
                   $this->db->from('db_notification a');
                   $this->db->join('db_users b','a.id_user=b.id');
                   $this->db->where('a.id_user !=',$id_user);
                   $this->db->where('a.notification_id >',$query->row()->notification_id);
                   return $this->db->get();
             }

             //total notif from db_read_notification
             function get_tot_notif($id_user)
             {
                  date_default_timezone_set('Asia/Jakarta');
                  $id_role = $this->session->userdata('id_role');
                  $now = date('Y-m-d H:i:s');

                  $this->db->select('count(a.notification_id) as total');
                  $this->db->from('db_notification a');
                  $this->db->join('db_requests c','a.notification_reference_id=c.id_request','left');
                  $this->db->where('a.id_user !=',$id_user);
                  $this->db->where('a.notification_id not in(SELECT id_notification FROM db_read_notification WHERE id_user ='.$id_user.')',null,false);
                  
                  if($id_role == 1)
                  {
                        $this->db->where('c.id_request_status',5);
                        $this->db->where('a.notification_reference_type',2);
                  }
                  
                  if($id_role == 10)
                  {
                        $this->db->where('c.id_user',$id_user);
                        $this->db->where('a.notification_reference_type !=',4);
                  }

                  if($id_role == 11)
                  {
                        $this->db->where('c.id_user',$id_user);
                        //$this->db->where('c.requested_date + interval c.max_top day >',$now); //sementara
                        //$this->db->group_by('a.notification_reference_id');
                  }

                  return $this->db->get();
             }

             //get comment ajax
            function get_comments($id)
            {
                  $this->db->select('id_comment,id_request,a.id_user,note_comment,date_comment,b.name_user,b.photo');
                  $this->db->from('db_comment a');
                  $this->db->join('db_users b','a.id_user=b.id');
                  $this->db->where('a.id_request',$id);
                  $this->db->order_by('a.date_comment','ASC');
                  $result = $this->db->get();
                  return $result->result();
            }

            //change profile picture
            function change_picture($data,$id_user)
            {
                  $this->db->where('id',$id_user);
                  $this->db->update('db_users',$data);
            }

            //function untuk insert notification read yang memiliki id request sama
            function get_notification_batch($id_user,$idr)
            {
                  $this->db->select('id_notification,notification_label');
                  $this->db->from('db_notification');
                  $this->db->where('id_user !=',$id_user);
                  $this->db->where('notification_reference_id',$idr);
                  return $this->db->get();
            }

            function get_approval_note()
            {
                  $this->db->select('id_request, note_comment');
                  $this->db->from('db_comment');
                  $this->db->where('id_request_status = 5 or id_request_status = 6');
                  $this->db->order_by('date_comment','DESC');
                  $this->db->group_by('id_request');
                  return $this->db->get();
            }

            function get_list_area()
            {
                  $this->db->select('id_area, name_company, name_area');
                  $this->db->from('db_companies a');
                  $this->db->join('db_company_areas b','a.id_company=b.id_company');
                  $this->db->order_by('name_company','ASC');
                  return $this->db->get();
            }

            function get_history_request()
            {
                  $id_user = $this->session->userdata('id');
                  $this->db->select('requested_date,count(id_request) as total');
                  $this->db->from('db_requests');
                  $this->db->where('id_user',$id_user);
                  $this->db->where('year(requested_date)','2019');
                  $this->db->group_by('month(requested_date)');
                  $this->db->group_by('year(requested_date)');

                  return  $this->db->get();
            }

            function get_month()
            {
                  $this->db->select('month(requested_date) as bulan,requested_date');
                  $this->db->from('db_requests');
                  $this->db->group_by('month(requested_date)');
                  $this->db->order_by('requested_date','DESC');
                  return $this->db->get();
            }

            function get_year()
            {
                  $this->db->select('year(requested_date) as year');
                  $this->db->from('db_requests');
                  $this->db->group_by('year(requested_date)');
                  $this->db->order_by('requested_date','DESC');
                  return $this->db->get();
            }

            //baru 12/10/2019
            function get_notification_list()
            {
                  $this->db->select('notification_reference_id,max(notification_id) as notification_id');
                  $this->db->from('db_notification a');
                  $this->db->group_by('notification_reference_id');
                  $hasil = $this->db->get();
                  return $hasil->result();
            }

            function delete_notification($id)
            {
                  $this->db->where('notification_reference_id',$id);
                  $this->db->where('notification_reference_type !=',3);
                  $this->db->delete('db_notification');

                  $this->db->where('id_request',$id);
                  $this->db->delete('db_read_notification');
            }

            //baru 19/09/2019
            function get_user_closed($bulan,$tahun)
            {
                  date_default_timezone_set('Asia/Jakarta');
                  $bulan_now = date('m');
                  $tahun_now = date('Y');

                  $this->db->select('name_user,update_by,update_date,count(id_request) as total, month(a.requested_date) as bulan,year(a.requested_date) as tahun');
                  $this->db->from('db_requests a');
                  $this->db->join('db_users b','a.update_by=b.id');
                  $this->db->where('a.id_request_status',7);

                  if($bulan != '')
                  {
                        $this->db->where('month(a.requested_date)',$bulan);
                  }else{
                        $this->db->where('month(a.requested_date)',$bulan_now);
                  }

                  if($tahun != '')
                  {
                        $this->db->where('year(a.requested_date)',$tahun);
                  }else{
                        $this->db->where('year(a.requested_date)',$tahun_now);
                  }

                  $this->db->group_by('a.update_by');
                  $this->db->order_by('count(update_by)','DESC');
                  return $this->db->get();
            }

            function get_total_pending_notif()
            {
                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $this->db->select('count(id_request) as total,month(requested_date) as bulan,year(requested_date) as tahun');
                  $this->db->from('db_requests');

                  if($id_role=='1')
                  {
                        $this->db->where('id_request_status','5');
                  }

                  if($id_role=='7')
                  {
                        $this->db->where('id_request_status !=','7');
                  }

                  if($id_role=='8' or $id_role=='9')
                  {
                        $this->db->where('id_request_status !=','1');
                        $this->db->where('id_request_status !=','7');
                  }

                  if($id_role=='10')
                  {
                        $this->db->where('id_user',$id_user);
                        $this->db->where('id_request_status !=','7');
                  }

                  return $this->db->get();
            }

            function get_new_request($bulan,$tahun)
            {
                  date_default_timezone_set('Asia/Jakarta');
                  $bulan_now = date('m');
                  $tahun_now = date('Y');

                  $this->otherdb = $this->load->database('otherdb', TRUE);
                  
                  if($bulan != '' && $tahun != ''){
                  $query = $this->db->query('SELECT id_request,a.id_customer,name_customer,d.id_company,alias_company,a.id_request_status,name_request_status,c.id_area,name_area
                                                FROM cl.db_requests a 
                                                JOIN crrm2.db_customers b ON a.id_customer=b.id_customer
                                                JOIN crrm2.db_users c ON b.id_user=c.id
                                                JOIN cl.db_companies d ON c.id_company=d.id_company
                                                JOIN cl.db_request_status e ON a.id_request_status=e.id_request_status
                                                JOIN cl.db_company_areas f ON c.id_area=f.id_area
                                                WHERE b.status_delete = 0
                                                AND b.status_existing = 0
                                                AND a.id_request_status = 7
                                                AND month(a.requested_date) ='.$bulan.'
                                                AND year(a.requested_date) ='.$tahun.'
                                                ORDER BY a.requested_date DESC');
                  }else{
                  $query = $this->db->query('SELECT id_request,a.id_customer,name_customer,d.id_company,alias_company,a.id_request_status,name_request_status,c.id_area,name_area
                                                FROM cl.db_requests a 
                                                JOIN crrm2.db_customers b ON a.id_customer=b.id_customer
                                                JOIN crrm2.db_users c ON b.id_user=c.id
                                                JOIN cl.db_companies d ON c.id_company=d.id_company
                                                JOIN cl.db_request_status e ON a.id_request_status=e.id_request_status
                                                JOIN cl.db_company_areas f ON c.id_area=f.id_area
                                                WHERE b.status_delete = 0
                                                AND b.status_existing = 0
                                                AND a.id_request_status = 7
                                                AND month(a.requested_date) ='.$bulan_now.'
                                                AND year(a.requested_date) ='.$tahun_now.'
                                                ORDER BY a.requested_date DESC');

                  }
                  
                  return $query->result();

            }

            function get_new_by_area($bulan,$tahun)
            {
                  date_default_timezone_set('Asia/Jakarta');
                  $bulan_now = date('m');
                  $tahun_now = date('Y');

                  $this->db->select('d.id_area, c.id_company,name_company, name_area, alias_company,count(a.id_request) as total');
                  $this->db->from('db_requests a');
                  $this->db->join('db_users b','a.id_user=b.id');
                  $this->db->join('db_companies c','b.id_company=c.id_company');
                  $this->db->join('db_company_areas d','b.id_area=d.id_area');
                  
                  if($bulan != '')
                  {
                        $this->db->where('month(a.requested_date)',$bulan);
                  }else{
                        $this->db->where('month(a.requested_date)',$bulan_now);
                  }

                  if($tahun != '')
                  {
                        $this->db->where('year(a.requested_date)',$tahun);
                  }else{
                        $this->db->where('year(a.requested_date)',$tahun_now);
                  }
                  
                  $this->db->group_by('b.id_area');
                  return $this->db->get();
            }

            function get_new_customer($bulan,$tahun)
            {
                  date_default_timezone_set('Asia/Jakarta');
                  $bulan_now = date('m');
                  $tahun_now = date('Y');

                  $this->otherdb = $this->load->database('otherdb', TRUE);
                  
                  if($bulan != '' && $tahun != ''){
                  $query = $this->db->query('SELECT c.id_area,count(a.id_request) as total
                                                FROM cl.db_requests a 
                                                JOIN crrm2.db_customers b ON a.id_customer=b.id_customer
                                                JOIN crrm2.db_users c ON b.id_user=c.id
                                                WHERE b.status_delete = 0
                                                AND b.status_existing = 0
                                                AND a.id_request_status = 7
                                                AND month(a.requested_date) ='.$bulan.'
                                                AND year(a.requested_date) ='.$tahun.'
                                                GROUP BY c.id_area
                                                ORDER BY a.requested_date DESC');
                  }else{
                  $query = $this->db->query('SELECT c.id_area,count(a.id_request) as total
                                                FROM cl.db_requests a 
                                                JOIN crrm2.db_customers b ON a.id_customer=b.id_customer
                                                JOIN crrm2.db_users c ON b.id_user=c.id
                                                WHERE b.status_delete = 0
                                                AND b.status_existing = 0
                                                AND a.id_request_status = 7
                                                AND month(a.requested_date) ='.$bulan_now.'
                                                AND year(a.requested_date) ='.$tahun_now.'
                                                GROUP BY c.id_area
                                                ORDER BY a.requested_date DESC');

                  }
                  
                  return $query->result();
            }
      }