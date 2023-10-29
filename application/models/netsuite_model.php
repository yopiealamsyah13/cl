<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

      class Netsuite_model extends CI_Model {

            public function __construct() {
                  parent::__construct();
            }

            function all($name)
            {
                  $this->otherdb = $this->load->database('otherdb', TRUE);

                  $this->otherdb->select('*');
                  $this->otherdb->from('db_customers');
		  $this->otherdb->where('companyname !=','');
                  $this->otherdb->order_by('companyname','DESC');
		
		  if($name!='')
                  {
                        $this->otherdb->like('companyname',$name);
                  }
                  
                  return $this->otherdb->get();
            }

            function limit($name,$limit,$per_page)
            {
                  $this->otherdb = $this->load->database('otherdb', TRUE);

                  $this->otherdb->select('*');
                  $this->otherdb->from('db_customers');
		  $this->otherdb->where('companyname !=','');
                  $this->otherdb->order_by('companyname','DESC');
		  
		  if($name!='')
                  {
                        $this->otherdb->like('companyname',$name);
                  }

                  $this->otherdb->limit($limit,$per_page);
                  return $this->otherdb->get();
            }

	    function all_employee($name)
            {
                  $this->otherdb = $this->load->database('otherdb', TRUE);

                  $this->otherdb->select('*');
                  $this->otherdb->from('db_employee');
		  $this->otherdb->where('internalid !=','');
                  $this->otherdb->order_by('firstname','ASC');
		
		  if($name!='')
                  {
                        $this->otherdb->like('firstname',$name);
                  }
                  
                  return $this->otherdb->get();
            }

            function limit_employee($name,$limit,$per_page)
            {
                  $this->otherdb = $this->load->database('otherdb', TRUE);

                  $this->otherdb->select('*');
                  $this->otherdb->from('db_employee');
		  $this->otherdb->where('internalid !=','');
                  $this->otherdb->order_by('firstname','ASC');
		  
		  if($name!='')
                  {
                        $this->otherdb->like('firstname',$name);
                  }

                  $this->otherdb->limit($limit,$per_page);
                  return $this->otherdb->get();
            }

	    function all_activity($name)
            {
                  $this->otherdb = $this->load->database('otherdb2', TRUE);

                  $this->otherdb->select('*');
                  $this->otherdb->from('db_activity');
		  $this->otherdb->where('internalid !=','');
                  $this->otherdb->order_by('internalid','ASC');
		
		  if($name!='')
                  {
                        $this->otherdb->like('title',$name);
                  }
                  
                  return $this->otherdb->get();
            }

            function limit_activity($name,$limit,$per_page)
            {
                  $this->otherdb = $this->load->database('otherdb2', TRUE);

                  $this->otherdb->select('*');
                  $this->otherdb->from('db_activity');
		  $this->otherdb->where('internalid !=','');
                  $this->otherdb->order_by('internalid','ASC');
		  
		  if($name!='')
                  {
                        $this->otherdb->like('title',$name);
                  }

                  $this->otherdb->limit($limit,$per_page);
                  return $this->otherdb->get();
            }
      }
