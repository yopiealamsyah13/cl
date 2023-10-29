<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

      class Notification_model extends CI_Model {

            public function __construct() {
                  parent::__construct();
            }

            function all()
            {
                  date_default_timezone_set('Asia/Jakarta');
                  $now = date('Y-m-d H:i:s');  //mengambil tanggal sekarang
                  $id_user = $this->session->userdata('id');
                  $id_area = $this->session->userdata('id_area');
                  $id_role = $this->session->userdata('id_role');

                  $this->db->select('*');
                  $this->db->from('db_notification a');
                  $this->db->join('db_users b','a.id_user=b.id');
                  $this->db->join('db_requests c','a.notification_reference_id=c.id_request','left');
                  $this->db->where('a.id_user !=',$id_user);
                  //$this->db->where('a.notification_reference_type !=',3); //menghilangkan notifikasi closed
                  $this->db->order_by('a.notification_id','DESC');

                  if($id_role == 1)
                  {
                        //$this->db->where('c.id_request_status',5);
                        $this->db->where('a.notification_reference_type',2);
                  }

                  if($id_role == 10)
                  {
                        //$this->db->where('a.notification_reference_type !=',3);
                        $this->db->where('c.id_user',$id_user);
                        $this->db->where('a.notification_reference_type !=',4);
                  }

                  if($id_role == 11)
                  {
                        $this->db->where('c.requested_date + interval c.max_top day >',$now); //sementara
                        $this->db->group_by('a.notification_reference_id');
                  }

                  if($id_role == 7 || $id_role == 8 || $id_role == 9)
                  {
                        if($id_area == 17){
                              $this->db->where('b.id_area',$id_area);
                              //$this->db->where('a.notification_reference_type !=',3);
                              //$this->db->where('c.id_user in (SELECT id FROM db_users WHERE id_area = 17)',null,false);
                              $this->db->or_where('c.id_request in (SELECT id_request FROM db_requests a join db_users b ON a.id_user = b.id where a.id_request_status = 7 and b.id_area = 17)');
                              
                        }else{
                              $this->db->where('b.id_area !=',17);
                              //$this->db->where('a.notification_reference_type !=',3);
                              $this->db->where('c.id_user not in (SELECT id FROM db_users WHERE id_area = 17 or id_area = 19)',null,false);
                        }
                  }
            
                  return $this->db->get();
            }

            function limit($limit,$per_page)
            {
                  
                  date_default_timezone_set('Asia/Jakarta');
                  $now = date('Y-m-d H:i:s');  //mengambil tanggal sekarang
                  $id_role = $this->session->userdata('id_role');
                  $id_user = $this->session->userdata('id');
                  $id_area = $this->session->userdata('id_area');
                  $this->db->limit($limit,$per_page);
                  $this->db->select('a.notification_id,notification_link,photo,notification_label,notification_datetime,notification_read,a.id_user,notification_reference_id');
                  $this->db->from('db_notification a');
                  $this->db->join('db_users b','a.id_user=b.id');
                  $this->db->join('db_requests c','a.notification_reference_id=c.id_request','left');
                  $this->db->where('a.id_user !=',$id_user);
                  //$this->db->where('a.notification_reference_type !=',3); //menghilangkan notifikasi closed
                  

                  if($id_role == 1)
                  {
                        //$this->db->where('c.id_request_status',5);
                        $this->db->where('a.notification_reference_type',2);
                  }

                  if($id_role == 10)
                  {
                        //$this->db->where('a.notification_reference_type !=',3);
                        $this->db->where('c.id_user',$id_user);
                        $this->db->where('a.notification_reference_type !=',4);
                  }

                  if($id_role == 11)
                  {
                        $this->db->where('c.requested_date + interval c.max_top day >',$now); //sementara
                        $this->db->group_by('a.notification_reference_id');
                  }

                  if($id_role == 7 || $id_role == 8 || $id_role == 9)
                  {
                        if($id_area == 17){
                              $this->db->where('b.id_area',$id_area);
                              //$this->db->or_where('a.notification_reference_type',3);
                              $this->db->or_where('c.id_request in (SELECT id_request FROM db_requests a join db_users b ON a.id_user = b.id where a.id_request_status = 7 and b.id_area = 17)');
                              //$this->db->or_where('c.id_user in (SELECT id FROM db_users WHERE id_area = 17 and id = '.$id_user.')',null,false);
                        }else{
                              $this->db->where('b.id_area !=',17);
                              //$this->db->where('a.notification_reference_type !=',3);
                              $this->db->where('c.id_user not in (SELECT id FROM db_users WHERE id_area = 17 or id_area = 19)',null,false);
                        }
                  }

                  $this->db->order_by('a.notification_id','DESC');
                  return $this->db->get();
            }

            function get_unread_notification()
            {
                  $id_user = $this->session->userdata('id');
                  $this->db->select('a.notification_id');
                  $this->db->from('db_notification a');
                  $this->db->where('a.id_user !=',$id_user);
                  $this->db->where('a.notification_id not in(SELECT id_notification FROM db_read_notification WHERE id_user ='.$id_user.')',null,false);
                  return $this->db->get();
            }
      }