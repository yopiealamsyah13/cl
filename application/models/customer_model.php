<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

      class Customer_model extends CI_Model {

            public function __construct() {
                  parent::__construct();
                  $this->otherdb = $this->load->database('otherdb', TRUE);
            }

            function all($name)
            {
                  $id_area = $this->session->userdata('id_area');

                  $this->otherdb->select('id_customer,name_customer,name_user,credit_limit,outstanding_over');
                  $this->otherdb->from('db_customers a');
                  $this->otherdb->join('db_users b','a.id_user=b.id');
                  $this->otherdb->where('a.status_delete','0');
                  $this->otherdb->order_by('a.name_customer','ASC');
                  if($name!='')
                  {
                        $this->otherdb->like('a.name_customer',$name);
                  }
                  return $this->otherdb->get();
            }

            function limit($name,$limit,$per_page)
            {
                  $id_area = $this->session->userdata('id_area');

                  $this->otherdb->select('id_customer,name_customer,name_user,credit_limit,outstanding_over');
                  $this->otherdb->from('db_customers a');
                  $this->otherdb->join('db_users b','a.id_user=b.id');
                  $this->otherdb->where('a.status_delete','0');
                  $this->otherdb->order_by('a.name_customer','ASC');
                  if($name!='')
                  {
                        $this->otherdb->like('a.name_customer',$name);
                  }
                  $this->otherdb->limit($limit,$per_page);
                  return $this->otherdb->get();
            }

            function edit_customer($id,$data)
            {
                  $this->otherdb->where('id_customer',$id);
                  $this->otherdb->update('db_customers',$data); 
            }

            function customer_profile($id_customer)
            {
                  $this->otherdb->select('id_customer,name_customer,name_alias,phone_customer,fax_customer,website_customer,create_date_customer,name_user,name_customer_type');
                  $this->otherdb->from('db_customers a');
                  $this->otherdb->join('db_users b','a.id_user=b.id');
                  $this->otherdb->join('db_customer_types c','a.id_customer_type=c.id_customer_type');
                  $this->otherdb->where('a.id_customer',$id_customer);
                  return $this->otherdb->get();
            }

            function customer_request($id_customer)
            {
                  $this->db->select('*');
                  $this->db->from('db_requests');
                  $this->db->where('id_customer',$id_customer);
                  $this->db->order_by('id_request','DESC');
                  $this->db->limit(1);
                  return $this->db->get();
            }

            function customer_activity($id_customer)
            {

            }

            function customer_timeline($id_customer)
            {
                  $this->db->select('a.id_request,a.id_customer,a.id_request_status,requested_note,name_request_status');
                  $this->db->from('db_requests a');
                  $this->db->join('db_request_status b','a.id_request_status=b.id_request_status');
                  $this->db->where('a.id_customer',$id_customer);
                  $this->db->order_by('a.id_request','DESC');
                  return $this->db->get();
            }
      }