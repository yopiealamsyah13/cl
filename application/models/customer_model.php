<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

      class Customer_model extends CI_Model {

            public function __construct() {
                  parent::__construct();
            }

            function all($name)
            {
                  $this->otherdb = $this->load->database('otherdb', TRUE);
                  $id_user = $this->session->userdata('id');
                  $id_area = $this->session->userdata('id_area');
                  $id_role = $this->session->userdata('id_role');
                  $id_company = $this->session->userdata('id_company');

                  $this->otherdb->select('a.id_internal, a.companyname, a.salesrepname, a.credit_limit, a.master_credit_limit, a.outstanding_over, a.firstname, a.middlename, a.lastname, a.id_netsuite, a.balance');
                  $this->otherdb->from('db_customers a');
		      $this->otherdb->join('db_employee b','a.salesrepid=b.internalid');
		      $this->otherdb->where('a.id_internal !=','');
		      $this->otherdb->where('a.salesrepid !=','');
                  $this->otherdb->order_by('a.companyname','ASC');

                  if($name!='')
                  {
                        $this->otherdb->like('a.companyname',$name);
                  }

                  if($id_role=='10')
                  {
                        if($id_user!='179' and $id_user!='170')
                        {
                              $this->otherdb->where('b.id_company',$id_company);
                        }
                  }

                  //if($id_role=='7' || $id_role=='8' || $id_role=='9')
                  //{
                  //      if($id_area == '17'){
                  //            $this->otherdb->where('c.id_area','17');
                  //      }else{
                  //            $this->otherdb->where('c.id_area !=','17');
                  //      }
                  //}
                  return $this->otherdb->get();
            }

            function limit($name,$limit,$per_page)
            {
                  $this->otherdb = $this->load->database('otherdb', TRUE);
                  $id_user = $this->session->userdata('id');
                  $id_area = $this->session->userdata('id_area');
                  $id_role = $this->session->userdata('id_role');
                  $id_company = $this->session->userdata('id_company');

                  $this->otherdb->select('a.id_internal, a.companyname, a.salesrepname, a.credit_limit, a.master_credit_limit, a.outstanding_over, a.firstname, a.middlename, a.lastname, a.id_netsuite, a.balance');
                  $this->otherdb->from('db_customers a');
		      $this->otherdb->join('db_employee b','a.salesrepid=b.internalid');
                  $this->otherdb->where('a.id_internal !=','');
		      $this->otherdb->where('a.salesrepid !=','');
                  $this->otherdb->order_by('a.companyname','ASC');
                  if($name!='')
                  {
                        $this->otherdb->like('a.companyname',$name);
                  }

                  if($id_role=='10')
                  {
                        if($id_user!='179' and $id_user!='170')
                        {
                              $this->otherdb->where('b.id_company',$id_company);
                        }
                  }
                  
                  //if($id_role=='7' || $id_role=='8' || $id_role=='9')
                  //{
                  //      if($id_area == '17'){
                  //            $this->otherdb->where('c.id_area','17');
                  //      }else{
                  //            $this->otherdb->where('c.id_area !=','17');
                  //      }
                  //}

                  $this->otherdb->limit($limit,$per_page);
                  return $this->otherdb->get();
            }

            function edit_customer($id,$data)
            {
                  $this->otherdb = $this->load->database('otherdb', TRUE);
                  $this->otherdb->where('id_internal',$id);
                  $this->otherdb->update('db_customers',$data); 
            }

            function get_data()
            {
                  //$this->db->limit(1);
                  $this->db->select('distinct(id_customer), credit_limit, max_top,id_internal');
                  $this->db->from('db_requests');
                  $this->db->where('id_request_status','5');
                  $this->db->order_by('update_date','DESC');
                  $this->db->group_by('id_customer');
                  return $this->db->get();
            }

            function get_outstanding()
            {
                  $this->db->select('id_internal, sum(outstanding_amount) as total');
                  $this->db->from('db_outstandings');
                  $this->db->group_by('id_customer');
                  return $this->db->get();
            }

            function customer_profile($idc)
            {
                  $this->otherdb = $this->load->database('otherdb', TRUE);
                  $this->otherdb->select('id_internal, id_netsuite, companyname, name_alias, phone_customer, fax_customer, website_customer, salesrepname, npwp_customer, firstname, middlename, lastname');
                  $this->otherdb->from('db_customers');
                  $this->otherdb->where('id_internal',$idc);
                  return $this->otherdb->get();
            }

            function customer_request($idc)
            {
                  $this->db->select('requested_date');
                  $this->db->from('db_requests');
                  $this->db->where('id_internal',$idc);
                  $this->db->order_by('id_request','DESC');
                  $this->db->limit(1);
                  return $this->db->get();
            }

            function customer_activity($idc)
            {
                  $this->db->select('a.id_request, a.id_internal, a.id_request_status, requested_note, name_request_status, requested_date, credit_limit');
                  $this->db->from('db_requests a');
                  $this->db->join('db_request_status b','a.id_request_status=b.id_request_status');
                  $this->db->where('a.id_internal',$idc);
                  $this->db->order_by('a.id_request','DESC');
                  return $this->db->get();
            }

            function total_cl($idc)
            {
                  $this->db->select('id_internal, sum(credit_limit) as total');
                  $this->db->from('db_requests');
                  $this->db->where('id_internal',$idc);
                  return $this->db->get();
            }
      }
