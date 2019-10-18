<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

      class Outstanding_model extends CI_Model {

            public function __construct() {
                  parent::__construct();
            }

            function all($cust)
            {
                  $month = date('m');
                  $year = date('Y');
                  $this->db->select('*');
                  $this->db->from('db_outstandings');
                  //$this->db->join('db_outstanding_payments b','a.id_outstanding=b.id_outstanding','left');
                  //$this->db->where('outstanding_amount != 0');
                  //$this->db->where('month(b.payment_date)',$month);
                  //$this->db->where('year(b.payment_date)',$year);
                  $this->db->order_by('id_customer','ASC');

                  if($cust!='')
                  {
                        $this->db->where('id_customer',$cust);
                  }
                  
                  return  $this->db->get();
            }

            function limit($cust,$limit,$per_page)
            {
                  $month = date('m');
                  $year = date('Y');
                  $this->db->select('*');
                  $this->db->from('db_outstandings');
                  //$this->db->join('db_outstanding_payments b','a.id_outstanding=b.id_outstanding','left');
                  //$this->db->where('outstanding_amount != 0');
                  //$this->db->where('month(b.payment_date)',$month);
                  //$this->db->where('year(b.payment_date)',$year);
                  $this->db->order_by('id_customer','ASC');

                  if($cust!='')
                  {
                        $this->db->where('id_customer',$cust);
                  }

                  $this->db->limit($limit,$per_page);
                  return  $this->db->get();
            }

            function get_customer()
            {
                  $this->otherdb = $this->load->database('otherdb', TRUE);

                  $this->otherdb->select('id_customer,name_customer,name_user,credit_limit,outstanding_over,b.id_area,name_area,alias_company,name_entity');
                  $this->otherdb->from('db_customers a');
                  $this->otherdb->join('db_users b','a.id_user=b.id');
                  $this->otherdb->join('db_company_areas c','b.id_area=c.id_area');
                  $this->otherdb->join('db_companies d','c.id_company=d.id_company');
                  $this->otherdb->join('db_business_entity e','a.id_entity=e.id_entity');
                  $this->otherdb->where('a.status_delete','0');
                  $this->otherdb->where('b.id_company !=','6');
                  $this->otherdb->order_by('a.name_customer','ASC');

                  return $this->otherdb->get();
            }

            function add_outstanding($data)
            {
                  $this->db->insert('db_outstandings', $data);
            }

            function view_outstanding($id)
            {
                  $this->db->select('*');
                  $this->db->from('db_outstandings');
                  $this->db->where('id_outstanding',$id);
                  return $this->db->get();
            }

            function edit_outstanding($id,$data)
            {
                  $this->db->where('id_outstanding',$id);
                  $this->db->update('db_outstandings',$data);
            }

            function add_payment($data)
            {
                  $this->db->insert('db_outstanding_payments', $data);
            }

            ////baru
            //function limit_new($cust,$limit,$per_page)
            //{
            //      $this->otherdb = $this->load->database('otherdb', TRUE);
            //
            //      $query = $this->db->query("SELECT id_outstanding,input_date,id_customer,id_user,invoice_number,invoice_amount,outstanding_amount,po_number,remark 
            //                                    FROM cl.db_outstandings a
            //                                    JOIN crrm2.db_customers b ON a.id_customer=b.id_customer
            //                                    ORDER BY a.id_customer ASC
            //                                    LIMIT ".$limit." OFFSET ".$per_page);
            //      return $query->result();
            //}
      }