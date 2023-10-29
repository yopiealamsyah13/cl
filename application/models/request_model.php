<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

      class Request_model extends CI_Model {

            public function __construct() {
                  parent::__construct();
            }

            function all($area,$startdate,$enddate)
            {
                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $id_area = $this->session->userdata('id_area');

                  $this->db->select('a.id_request_status, a.id_request, a.requested_date, a.id_internal, a.id_user');
                  $this->db->from('db_requests a');
                  $this->db->join('db_request_status b','a.id_request_status=b.id_request_status');
                  $this->db->join('db_users c','a.id_user=c.id');
                  $this->db->order_by('a.requested_date','DESC');

                  if($id_role=='1')
                  {
			$this->db->where('(a.id_request_status=3 or a.id_request_status=4 or a.id_request_status=8)');
                  }

                  if($id_role == 7)
                  {
                        if($id_area == '17'){
                              $this->db->where('c.id_area','17');
                              $this->db->or_where('c.id_area','19');
                        }else{
                              $this->db->where('c.id_area !=','17');
                              $this->db->where('c.id_area !=','19');
                        }
                        $this->db->where('a.id_request_status !=','5');
                        $this->db->where('a.id_request_status !=','6');
                        $this->db->where('a.id_request_status !=','7');
                  }

                  if($id_role=='8' or $id_role=='9')
                  {
                        if($id_area == '17'){
                              $this->db->where('c.id_area','17');
                              $this->db->or_where('c.id_area','19');
                        }else{
                              $this->db->where('c.id_area !=','17');
                              $this->db->where('c.id_area !=','19');
                        }
                        //$this->db->where('a.id_request_status !=','1');
                        $this->db->where('a.id_request_status !=','5');
			      $this->db->where('a.id_request_status !=','6');
                        $this->db->where('a.id_request_status !=','7');
                  }

                  if($id_role=='10')
                  {
                        $this->db->where('a.id_user',$id_user);
                        $this->db->where('a.id_request_status !=','5');
                        $this->db->where('a.id_request_status !=','6');
                        $this->db->where('a.id_request_status !=','7');
                  }
                  
                  if($id_role=='12')
                  {
                        $this->db->where('c.id_area',$id_area);
                        $this->db->where('a.id_request_status !=','5');
			      $this->db->where('a.id_request_status !=','6');
                        $this->db->where('a.id_request_status !=','7');
                  }

                  if($area!='')
                  {
                        $this->db->where('c.id_area',$area);
                  }

                  if($startdate!='' and $enddate!='')
                  {
                        $date1 = date('Y-m-d', strtotime($startdate));
                  	$date2 = date('Y-m-d', strtotime($enddate));
                  	$this->db->where('a.requested_date >=',$date1);
                  	$this->db->where('a.requested_date <=',$date2);
                  }
                  
                  return  $this->db->get();
            }

            function limit($area,$startdate,$enddate,$limit,$per_page)
            {
                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $id_area = $this->session->userdata('id_area');

                  $this->db->select('a.id_request_status, a.id_request, a.requested_date, a.id_internal, a.id_user');
                  $this->db->from('db_requests a');
                  $this->db->join('db_request_status b','a.id_request_status=b.id_request_status');
                  $this->db->join('db_users c','a.id_user=c.id');
                  $this->db->order_by('a.requested_date','DESC');

                  if($id_role=='1')
                  {
			$this->db->where('(a.id_request_status=3 or a.id_request_status=4 or a.id_request_status=8)');
                  }

                  if($id_role == 7)
                  {
                        if($id_area == '17'){
                              $this->db->where('c.id_area','17');
                              $this->db->or_where('c.id_area','19');
                        }else{
                              $this->db->where('c.id_area !=','17');
                              $this->db->where('c.id_area !=','19');
                        }

                        $this->db->where('a.id_request_status !=','5');
			      $this->db->where('a.id_request_status !=','6');
                        $this->db->where('a.id_request_status !=','7');
                  }

                  if($id_role=='8' or $id_role=='9')
                  {
                        if($id_area == '17'){
                              $this->db->where('c.id_area','17');
                              $this->db->or_where('c.id_area','19');
                        }else{
                              $this->db->where('c.id_area !=','17');
                              $this->db->where('c.id_area !=','19');
                        }
                        //$this->db->where('a.id_request_status !=','1');
                        $this->db->where('a.id_request_status !=','5');
			      $this->db->where('a.id_request_status !=','6');
                        $this->db->where('a.id_request_status !=','7');
                  }

                  if($id_role=='10')
                  {
                        $this->db->where('a.id_user',$id_user);
                        $this->db->where('a.id_request_status !=','5');
			      $this->db->where('a.id_request_status !=','6');
                        $this->db->where('a.id_request_status !=','7');
                  }
                  
                  if($id_role=='12')
                  {
                        $this->db->where('c.id_area',$id_area);
                        $this->db->where('a.id_request_status !=','5');
			      $this->db->where('a.id_request_status !=','6');
                        $this->db->where('a.id_request_status !=','7');
                  }

                  if($area!='')
                  {
                        $this->db->where('c.id_area',$area);
                  }

                  if($startdate!='' and $enddate!='')
                  {
                        $date1 = date('Y-m-d', strtotime($startdate));
                  	$date2 = date('Y-m-d', strtotime($enddate));
                  	$this->db->where('a.requested_date >=',$date1);
                  	$this->db->where('a.requested_date <=',$date2);
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

            function delete_notification($id)
            {
                  $this->db->where('notification_reference_id',$id);
                  $this->db->where('notification_reference_type !=',3);
                  $this->db->delete('db_notification');
 
                  $this->db->where('id_request',$id);
                  $this->db->delete('db_read_notification');
            }

            function add_comment($data)
            {
                  $this->db->insert('db_comment', $data);
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

                  $this->db->order_by('date_comment','DESC');
                  return $this->db->get();
            }

            function delete_comment($idc)
            {
                  $this->db->where('id_comment',$idc);
                  $this->db->delete('db_comment');
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

            function get_request_status_closed()
            {
                  $id_role = $this->session->userdata('id_role');
                  $this->db->select('*');
                  $this->db->from('db_request_status');

                  if($id_role != '1'){
                        $this->db->where('id_request_status !=','2');
			$this->db->where('id_request_status !=','7');
                  }
                  
                  return $this->db->get();
            }

            function view_request($id)
            {
                  $this->db->select('*');
                  $this->db->from('db_requests a');
                  $this->db->join('db_terms b','a.id_terms=b.id_terms','LEFT');
                  $this->db->where('a.id_request',$id);
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

                  $file = "./myfile/$idf";
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

                  $this->otherdb->select('id_internal, id_netsuite, credit_limit, master_credit_limit, balance, overdue_balance, outstanding_over,companyname, salesrepname, firstname, middlename, lastname');
                  $this->otherdb->from('db_customers');
                  $this->otherdb->where('id_internal',$idc);
                  return $this->otherdb->get();
            }

            function get_customer()
            {
                  $this->otherdb = $this->load->database('otherdb', TRUE);
                  $id_user = $this->session->userdata('id');
                  $id_area = $this->session->userdata('id_area');
                  $id_role = $this->session->userdata('id_role');
                  $id_company = $this->session->userdata('id_company');

                  $this->otherdb->select('a.id_customer,id_internal,id_netsuite,name_customer,companyname,salesrepname, firstname, middlename, lastname');
                  $this->otherdb->from('db_customers a');
                  //$this->otherdb->join('db_users b','a.salesrepid=b.internalid');
                  //$this->otherdb->where('a.status_delete','0');
                  //$this->otherdb->where('b.id_company !=','6');
                  $this->otherdb->where('a.id_internal !=','');
                  $this->otherdb->order_by('a.companyname','ASC');

                  //if($id_role=='10')
                  //{
                  //      if($id_user!='179' and $id_user!='170')
                  //      {
                  //            $this->otherdb->where('b.id_company',$id_company);
                  //      }
                  //}

                  //if($id_role=='10' && $id_area == '17')
                  //{
                  //      $this->otherdb->where('b.id_area','17');
                  //      $this->otherdb->or_where('b.id_area','19');
                  //}

                  //if($id_role=='7' && $id_area == '17')
                  //{
                  //      $this->otherdb->where('b.id_area','17');
                  //      $this->otherdb->or_where('b.id_area','19');
                  //}

                  $result = $this->otherdb->get();
                  return $result->result();
            }

            function get_all_customer()
            {
                  $this->otherdb = $this->load->database('otherdb', TRUE);
                  $this->otherdb->select('a.id_internal, a.companyname, a.salesrepname, a.id_netsuite, a.firstname, a.middlename, a.lastname, b.firstname as empfirstname, b.middlename as empmiddlename, b.lastname as emplastname, b.sbuname,a.subsidiaryname');
                  $this->otherdb->from('db_customers a');
                  $this->otherdb->join('db_employee b','a.salesrepid=b.internalid');
                  $this->otherdb->where('a.status_delete','0');
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
                  $id_area = $this->session->userdata('id_area');

                  $this->db->select('count(id_request) as total,month(requested_date) as bulan,year(requested_date) as tahun');
                  $this->db->from('db_requests a');
                  $this->db->join('db_users b','a.id_user=b.id');

                  if($id_role=='1')
                  {
                        $this->db->where('a.id_request_status !=','5');
			$this->db->where('a.id_request_status !=','6');
                        $this->db->where('a.id_request_status !=','7');
                  }

                  if($id_role=='7')
                  {
                        if($id_area == '17'){
                              $this->db->where('b.id_area','17');
                              $this->db->or_where('b.id_area','19');
                        }else{
                              $this->db->where('b.id_area !=','17');
                              $this->db->where('b.id_area !=','19');
                        }

                        $this->db->where('a.id_request_status !=','5');
			      $this->db->where('a.id_request_status !=','6');
                        $this->db->where('a.id_request_status !=','7');
                  }

                  if($id_role=='8' or $id_role=='9')
                  {
                        if($id_area == '17'){
                              $this->db->where('b.id_area','17');
                              $this->db->or_where('b.id_area','19');
                        }else{
                              $this->db->where('b.id_area !=','17');
                              $this->db->where('b.id_area !=','19');
                        }
                        
                        $this->db->where('id_request_status !=','1');
                        $this->db->where('a.id_request_status !=','5');
			      $this->db->where('a.id_request_status !=','6');
                        $this->db->where('a.id_request_status !=','7');
                  }

                  if($id_role=='10')
                  {
                        $this->db->where('id_user',$id_user);
                        $this->db->where('a.id_request_status !=','5');
			      $this->db->where('a.id_request_status !=','6');
                        $this->db->where('a.id_request_status !=','7');
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
            
            function get_total_pending_notif()
            {
                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $id_area = $this->session->userdata('id_area');

                  $this->db->select('count(id_request) as total,month(requested_date) as bulan,year(requested_date) as tahun');
                  $this->db->from('db_requests a');
                  $this->db->join('db_users b','a.id_user=b.id');
		
                  if($id_role=='1')
                  {
                        $this->db->where('(id_request_status=3 or id_request_status=4 or id_request_status=8)');
                  }

                  if($id_role=='7')
                  {
                        if($id_area == '17'){
                              $this->db->where('b.id_area','17');
                              $this->db->or_where('b.id_area','19');
                        }else{
                              $this->db->where('b.id_area !=','17');
                              $this->db->where('b.id_area !=','19');
                        }

                        $this->db->where('id_request_status !=','5');
			      $this->db->where('id_request_status !=','6');
			      $this->db->where('id_request_status !=','7');
                  }

                  if($id_role=='8' or $id_role=='9')
                  {
                        if($id_area == '17'){
                              $this->db->where('b.id_area','17');
                              $this->db->or_where('b.id_area','19');
                        }

                        $this->db->where('id_request_status !=','1');
                        $this->db->where('id_request_status !=','5');
                        $this->db->where('id_request_status !=','6');
                        $this->db->where('id_request_status !=','7');
                  }

                  if($id_role=='10')
                  {
                        $this->db->where('id_user',$id_user);
                        $this->db->where('id_request_status !=','5');
                        $this->db->where('id_request_status !=','6');
                        $this->db->where('id_request_status !=','7');
                  }

                  if($id_role=='12')
                  {
                        $this->db->where('b.id_area',$id_area);
                        $this->db->where('a.id_request_status !=','5');
			      $this->db->where('a.id_request_status !=','6');
                        $this->db->where('a.id_request_status !=','7');
                  }

                  return $this->db->get();
            }

            function get_total_close($bulan,$tahun)
            {
                  date_default_timezone_set('Asia/Jakarta');
                  $bulan_now = date('m');
                  $tahun_now = date('Y');
                  $id_area = $this->session->userdata('id_area');

                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $this->db->select('count(id_request) as total,month(requested_date) as bulan,year(requested_date) as tahun');
                  $this->db->from('db_requests a');
                  $this->db->join('db_users b','a.id_user=b.id');
                  $this->db->where('id_request_status','7');

                  if($id_role=='10')
                  {
                        $this->db->where('id_user',$id_user);
                  }

                  if($id_role=='7' || $id_role=='8' || $id_role=='9')
                  {
                        if($id_area == '17'){
                              $this->db->where('b.id_area','17');
                              $this->db->or_where('b.id_area','19');
                        }else{
                              $this->db->where('b.id_area !=','17');
                              $this->db->where('b.id_area !=','19');
                        }
                  }

                  if($bulan!='' and $tahun!='')
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
                  $id_area = $this->session->userdata('id_area');

                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $this->db->select('count(id_request) as total,month(requested_date) as bulan,year(requested_date) as tahun');
                  $this->db->from('db_requests a');
                  $this->db->join('db_users b','a.id_user=b.id');

                  if($id_role=='10')
                  {
                        $this->db->where('id_user',$id_user);
                  }

                  if($id_role=='7' || $id_role=='8' || $id_role=='9')
                  {
                        if($id_area == '17'){
                              $this->db->where('b.id_area','17');
                              $this->db->or_where('b.id_area','19');
                        }else{
                              $this->db->where('b.id_area !=','17');
                              $this->db->where('b.id_area !=','19');
                        }
                  }

                  if($id_role=='12')
                  {
                        $this->db->where('b.id_area',$id_area);
                  }

                  if($bulan!='' and $tahun!='')
                  {
                        $this->db->where('month(requested_date)',$bulan);
                        $this->db->where('year(requested_date)',$tahun);
                  }else{
                        $this->db->where('month(requested_date)',$bulan_now);
                        $this->db->where('year(requested_date)',$tahun_now);
                  }

                  return $this->db->get();
            }

            function get_total_by_area($bulan,$tahun)
            {
                  date_default_timezone_set('Asia/Jakarta');
                  $bulan_now = date('m');
                  $tahun_now = date('Y');

                  
                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $id_area = $this->session->userdata('id_area');

                  $this->db->select('b.id_area, name_company, name_area, alias_company, count(a.id_request) as total');
                  $this->db->from('db_requests a');
                  $this->db->join('db_users b','a.id_user=b.id');
                  $this->db->join('db_companies c','b.id_company=c.id_company');
                  $this->db->join('db_company_areas d','b.id_area=d.id_area');
                  $this->db->group_by('b.id_area');

                  if($id_role=='7' || $id_role=='8' || $id_role=='9')
                  {
                        if($id_area == '17'){
                              $this->db->where('b.id_area','17');
                              $this->db->or_where('b.id_area','19');
                        }else{
                              $this->db->where('b.id_area !=','17');
                              $this->db->where('b.id_area !=','19');
                        }
                  }
                  
                  if($id_role=='12')
                  {
                        $this->db->where('b.id_area',$id_area);
                  }

                  if($bulan!='' and $tahun!='')
                  {
                        $this->db->where('month(requested_date)',$bulan);
                        $this->db->where('year(requested_date)',$tahun);
                  }else{
                        $this->db->where('month(requested_date)',$bulan_now);
                        $this->db->where('year(requested_date)',$tahun_now);
                  }

                  return $this->db->get();
            }

            function all_history($area,$startdate,$enddate,$note)
            {
                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $id_area = $this->session->userdata('id_area');

                  $this->db->select('a.id_internal, a.id_request, a.id_request_status, b.name_request_status, a.requested_date, a.id_user, a.update_date, a.update_by,note_comment');
                  $this->db->from('db_requests a');
                  $this->db->join('db_request_status b','a.id_request_status=b.id_request_status');
                  $this->db->join('db_users c','a.id_user=c.id');
                  $this->db->join('db_comment d','a.id_request=d.id_request');
                  $this->db->where('(a.id_request_status=5 or a.id_request_status=6 or a.id_request_status=7)');

                  if($id_role=='10')
                  {
                        $this->db->where('a.id_user',$id_user);   
                  }

                  if($id_role=='7' || $id_role=='8' || $id_role=='9')
                  {
                        if($id_area == '17')
			{
                              $this->db->where('(c.id_area = 17 OR c.id_area = 19)',null,false);
                        }
			else
			{
                              $this->db->where('c.id_area !=','17');
                              $this->db->where('c.id_area !=','19');
                        }
                  }
                  
                  if($id_role=='12')
                  {
                        $this->db->where('c.id_area',$id_area);
                  }

                  if($area != '') 
                  {
                        $this->db->where('c.id_area',$area);
                  }

                  if($startdate!='' and $enddate!='')
                  {
                        $date1 = date('Y-m-d', strtotime($startdate));
                  	$date2 = date('Y-m-d', strtotime($enddate));
                  	$this->db->where('a.requested_date >=',$date1);
                  	$this->db->where('a.requested_date <=',$date2);
                  }
                  
                  if($note !='' )
                  {
                  	$this->db->like('d.note_comment', $note);
                  }
                  
                  $this->db->order_by('a.update_date','DESC');
                  $this->db->group_by('a.id_request');
                  return  $this->db->get();
            }

            function limit_history($limit,$per_page,$area,$startdate,$enddate,$note)
            {
                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $id_area = $this->session->userdata('id_area');

                  $this->db->select('a.id_internal, a.id_request, a.id_request_status, b.name_request_status, a.requested_date, a.id_user, a.update_date, a.update_by,note_comment');
                  $this->db->from('db_requests a');
                  $this->db->join('db_request_status b','a.id_request_status=b.id_request_status');
                  $this->db->join('db_users c','a.id_user=c.id');
                  $this->db->join('db_comment d','a.id_request=d.id_request');
                  $this->db->where('(a.id_request_status=5 or a.id_request_status=6 or a.id_request_status=7)');

                  if($id_role=='10')
                  {
                        $this->db->where('a.id_user',$id_user);
                  }

                  if($id_role=='7' || $id_role=='8' || $id_role=='9')
                  {
                        if($id_area == '17')
			      {
                              $this->db->where('(c.id_area = 17 OR c.id_area = 19)',null,false);
                        }
			else
			{
                              $this->db->where('c.id_area !=','17');
                              $this->db->where('c.id_area !=','19');
                        }
                  }
                  
                  if($id_role=='12')
                  {
                        $this->db->where('c.id_area',$id_area);
                  }

                  if($area != '') 
                  {
                        $this->db->where('c.id_area',$area);
                  }

                  if($startdate!='' and $enddate!='')
                  {
                        $date1 = date('Y-m-d', strtotime($startdate));
                  	$date2 = date('Y-m-d', strtotime($enddate));
                  	$this->db->where('a.requested_date >=',$date1);
                  	$this->db->where('a.requested_date <=',$date2);
                  }

                  if($note !='' )
                  {
                  	$this->db->like('d.note_comment', $note);
                  }

                  $this->db->order_by('a.update_date','DESC');
                  $this->db->group_by('a.id_request');
                  $this->db->limit($limit,$per_page);
                  return  $this->db->get();
            }

            function add_notification($data2)
            {
                  $this->db->insert('db_notification',$data2);
            }

            //total notif from db_read_notification
             function get_tot_notif($id_user)
             {
                  date_default_timezone_set('Asia/Jakarta');
                  $id_role = $this->session->userdata('id_role');
                  $id_area = $this->session->userdata('id_area');
                  $now = date('Y-m-d H:i:s');

 
                  $this->db->select('count(a.notification_id) as total');
                  $this->db->from('db_notification a');
                  $this->db->join('db_users b','a.id_user=b.id');
                  $this->db->join('db_requests c','a.notification_reference_id=c.id_request','left');
                  $this->db->where('a.id_user !=',$id_user);
                  $this->db->where('a.notification_id not in(SELECT id_notification FROM db_read_notification WHERE id_user ='.$id_user.')',null,false);
                 
                  if($id_role == 1)
                  {
                        //$this->db->where('c.id_request_status',5);
                        $this->db->where('a.notification_reference_type',2);
                  }
                 
                  if($id_role == 10)
                  {
                        $this->db->where('c.id_user',$id_user);
                  }

                  if($id_role == 11)
                  {
                        $this->db->where('c.id_user',$id_user);
                  }

                  if($id_role == 7 || $id_role == 8 || $id_role == 9)
                  {
                        if($id_area == 17){
                              //$this->db->where('b.id_area',$id_area);
                              $this->db->where('c.id_user in (SELECT id FROM db_users WHERE id_area = 17)',null,false);
                        }else{
                              $this->db->where('b.id_area !=',17);
                              $this->db->where('c.id_user not in (SELECT id FROM db_users WHERE id_area = 17 or id_area = 19)',null,false);
                        }
                  }
                  
                  if($id_role=='12')
                  {
                        $this->db->where('b.id_area',$id_area);
                  }
 
                  return $this->db->get();
             }

            //test
            function up($id,$data)
            {
                  $this->db->where('notification_id',$id);
                  $hsl = $this->db->update('db_notification',$data);
                  return $hsl;
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
                        //$this->db->where('c.id_request_status',5);
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

                  if($id_role == 7 || $id_role == 8 || $id_role == 9)
                  {
                        if($id_area == 17){
                              $this->db->where('b.id_area',$id_area);
                              //$this->db->where('a.notification_reference_type !=',3);
                              $this->db->or_where('c.id_user in (SELECT id FROM db_users WHERE id_area = 17)',null,false);
                        }else{
                              $this->db->where('b.id_area !=',17);
                              //$this->db->where('a.notification_reference_type !=',3);
                              $this->db->where('c.id_user not in (SELECT id FROM db_users WHERE id_area = 17 or id_area = 19)',null,false);
                        }
                  }
                  
                  if($id_role=='12')
                  {
                        $this->db->where('b.id_area',$id_area);
                  }
 
                  $this->db->limit(5);
                  $hasil = $this->db->get();
                  return $hasil->result();
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
 
//add read
            function add_request_notification($id,$id_user,$id_request,$date)
            {
 
                  $this->db->where('id_notification',$id);
                  $this->db->where('id_user',$id_user);
                  $query = $this->db->get('db_read_notification');
 
                  if ($query->num_rows()>0) {
                        return true;
                  }else{
                        
                        $this->db->select('a.notification_id,notification_reference_type');
                        $this->db->from('db_notification a');
                        $this->db->where('a.id_user !=',$id_user);
                        $this->db->where('a.notification_reference_id',$id_request);
                        $this->db->where('a.notification_id not in(SELECT id_notification FROM db_read_notification WHERE id_user ='.$id_user.')',null,false);
                        $query2 = $this->db->get();
                        
                        //validasi bila notifikasi close by it maka di hapus bila tidak di insert
                        if($query2->row()->notification_reference_type != '3'){
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
                        }else{
                              $this->db->where('notification_reference_id',$id_request);
                              $this->db->where('notification_reference_type',3);
                              $this->db->delete('db_notification');
                        }
                  }
            }
 
            //get read
            function get_read_notification($id_user)
            {
                  $this->db->select('*');
                  $this->db->from('db_read_notification');
                  $this->db->where('id_user !=',$id_user);
                  return $this->db->get();
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

            function get_approval_note()
            {
                  $this->db->select('id_request,id_request_status, note_comment');
                  $this->db->from('db_comment');
                  $this->db->where('id_request_status',5);
                  $this->db->or_where('id_request_status',6);
                  $this->db->order_by('date_comment','DESC');
                  $this->db->group_by('id_request');
                  return $this->db->get();
            }

            function get_list_area()
            {
                  $this->db->select('id_area, name_company, name_area');
                  $this->db->from('db_companies a');
                  $this->db->join('db_company_areas b','a.id_company=b.id_company');
		      $this->db->where('b.id_area !=','');
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

            function change_picture($data,$id_user)
            {
                  $this->db->where('id',$id_user);
                  $this->db->update('db_users',$data);
            }

            function get_notification_list()
            {
 
                  $this->db->select('notification_reference_id,max(notification_id) as notification_id');
                  $this->db->from('db_notification a');
                  $this->db->group_by('notification_reference_id');
                  $hasil = $this->db->get();
                  return $hasil->result();
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

            function get_new_request($bulan,$tahun)
            {
                  date_default_timezone_set('Asia/Jakarta');
                  $bulan_now = date('m');
                  $tahun_now = date('Y');
 
                  $this->otherdb = $this->load->database('otherdb', TRUE);
                  
                  if($bulan != '' && $tahun != ''){
                  $query = $this->db->query('SELECT id_request,a.id_customer,name_customer,d.id_company,alias_company,a.id_request_status,name_request_status,c.id_area,name_area
                                                FROM cl2.db_requests a 
                                                JOIN crrm5.db_customers b ON a.id_customer=b.id_customer
                                                JOIN crrm5.db_users c ON b.id_user=c.id
                                                JOIN cl2.db_companies d ON c.id_company=d.id_company
                                                JOIN cl2.db_request_status e ON a.id_request_status=e.id_request_status
                                                JOIN cl2.db_company_areas f ON c.id_area=f.id_area
                                                WHERE b.status_delete = 0
                                                AND b.status_existing = 0
                                                AND a.id_request_status = 7
                                                AND month(a.requested_date) ='.$bulan.'
                                                AND year(a.requested_date) ='.$tahun.'
                                                ORDER BY a.requested_date DESC');
                  }else{
                  $query = $this->db->query('SELECT id_request,a.id_customer,name_customer,d.id_company,alias_company,a.id_request_status,name_request_status,c.id_area,name_area
                                                FROM cl2.db_requests a 
                                                JOIN crrm5.db_customers b ON a.id_customer=b.id_customer
                                                JOIN crrm5.db_users c ON b.id_user=c.id
                                                JOIN cl2.db_companies d ON c.id_company=d.id_company
                                                JOIN cl2.db_request_status e ON a.id_request_status=e.id_request_status
                                                JOIN cl2.db_company_areas f ON c.id_area=f.id_area
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

                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $id_area = $this->session->userdata('id_area');
 
                  $this->db->select('d.id_area, c.id_company,name_company, name_area, alias_company,count(a.id_request) as total');
                  $this->db->from('db_requests a');
                  $this->db->join('db_users b','a.id_user=b.id');
                  $this->db->join('db_companies c','b.id_company=c.id_company');
                  $this->db->join('db_company_areas d','b.id_area=d.id_area');
                  
                  if($id_role=='7' || $id_role=='8' || $id_role=='9')
                  {
                        if($id_area == '17'){
                              $this->db->where('b.id_area','17');
                              $this->db->or_where('b.id_area','19');
                        }else{
                              $this->db->where('b.id_area !=','17');
                              $this->db->where('b.id_area !=','19');
                        }
                        $this->db->where('a.id_request_status !=','7');
                  }

                  
                  if($id_role=='12')
                  {
                        $this->db->where('b.id_area',$id_area);
                  }
                  
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
                                                FROM cl2.db_requests a 
                                                JOIN crrm5.db_customers b ON a.id_customer=b.id_customer
                                                JOIN crrm5.db_users c ON b.id_user=c.id
                                                WHERE b.status_delete = 0
                                                AND b.status_existing = 0
                                                AND a.id_request_status = 7
                                                AND month(a.requested_date) ='.$bulan.'
                                                AND year(a.requested_date) ='.$tahun.'
                                                GROUP BY c.id_area
                                                ORDER BY a.requested_date DESC');
                  }else{
                  $query = $this->db->query('SELECT c.id_area,count(a.id_request) as total
                                                FROM cl2.db_requests a 
                                                JOIN crrm5.db_customers b ON a.id_customer=b.id_customer
                                                JOIN crrm5.db_users c ON b.id_user=c.id
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

            function report_history($ses_startdate,$ses_enddate)
            {
                  $id_user = $this->session->userdata('id');
                  $id_role = $this->session->userdata('id_role');
                  $id_area = $this->session->userdata('id_area');

                  $this->db->select('a.id_request,a.id_internal,a.id_user,a.id_customer,credit_limit,top,max_top,po_amount,requested_note,requested_date,a.id_request_status,name_user,name_request_status,note_comment,update_date,update_by');
                  $this->db->from('db_requests a');
                  $this->db->join('db_request_status b','a.id_request_status=b.id_request_status');
                  $this->db->join('db_users c','a.id_user=c.id');
                  $this->db->join('db_comment d','a.id_request=d.id_request');
                  $this->db->where('(a.id_request_status=5 or a.id_request_status=6 or a.id_request_status=7)');


                  if($id_role=='10')
                  {
                        $this->db->where('a.id_user',$id_user);   
                  }

                  if($id_role=='7' || $id_role=='8' || $id_role=='9')
                  {
                        if($id_area == '17')
                        { 
                              $this->db->where('(c.id_area = 17 OR c.id_area = 19)',null,false);
                        }else{
                              $this->db->where('c.id_area !=','17');
                              $this->db->where('c.id_area !=','19');
                        }
                  }
                  
                  if($id_role=='12')
                  {
                        $this->db->where('c.id_area',$id_area);
                  }

                  if($ses_startdate!='' and $ses_enddate!='')
                  {
                        $date1 = date('Y-m-d', strtotime($ses_startdate));
                  	$date2 = date('Y-m-d', strtotime($ses_enddate));
                  	$this->db->where('a.requested_date >=',$date1);
                  	$this->db->where('a.requested_date <=',$date2);
                  }

                  $this->db->order_by('a.update_date','DESC');
                  $this->db->group_by('a.id_request');
                  return  $this->db->get();
            }
            
            function get_terms()
            {
                  $this->db->select('id_terms,term_description');
                  $this->db->from('db_terms');
                  return  $this->db->get();
            }
      }
