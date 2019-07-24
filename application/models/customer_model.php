<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

      class Customer_model extends CI_Model {

            public function __construct() {
                  parent::__construct();
            }

            function all($name)
            {
                  $this->otherdb = $this->load->database('otherdb', TRUE);
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
                  $this->otherdb = $this->load->database('otherdb', TRUE);
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
                  $this->otherdb = $this->load->database('otherdb', TRUE);
                  $this->otherdb->where('id_customer',$id);
                  $this->otherdb->update('db_customers',$data); 
            }
      }