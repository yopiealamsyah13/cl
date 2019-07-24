<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
      class User_list_model extends CI_Model {

            public function __construct() {
                parent::__construct();
                $this->load->database();
            }

            function all($name,$company)
            {
                  $this->db->select('*');
                  $this->db->from('db_users a');
                  $this->db->join('db_roles_users b','a.id=b.user_id');
                  $this->db->join('db_roles c','c.id=b.role_id');
                  $this->db->join('db_companies d','d.id_company=a.id_company');
                  $this->db->join('db_company_areas e','a.id_area=e.id_area');
                  $this->db->where('a.name_user !=','');
            
                  if($name!=""){
                        $this->db->like('name_user',$name);
                  }
            
                  if($company!=""){
                        $this->db->where('d.name_company',$company);
                  }
                  $this->db->order_by('a.name_user','ASC'); 
            
                  return  $this->db->get();
            }

            function limit($name,$company,$limit,$per_page) {
            $this->db->select('*');
            $this->db->from('db_users a');
            
            $this->db->join('db_roles_users b','a.id=b.user_id');
            $this->db->join('db_roles c','c.id=b.role_id');
            $this->db->join('db_companies d','d.id_company=a.id_company');
            $this->db->join('db_company_areas e','a.id_area=e.id_area');
            $this->db->where('a.name_user !=','');
            
            if($name!=""){
            $this->db->like('name_user',$name);    
            }    
            
            if($company!=""){
            $this->db->where('d.name_company',$company);
            }

            $this->db->order_by('a.name_user','ASC'); 
            $this->db->limit($limit,$per_page);
            return  $this->db->get();
            }

            function userbyid($id)
            {
            $this->db->select('*');
            $this->db->from('db_users a');
                  
            $this->db->join('db_roles_users b','a.id=b.user_id');
            $this->db->join('db_roles c','c.id=b.role_id');
            $this->db->join('db_companies d','d.id_company=a.id_company');
            $this->db->where('b.user_id',$id);
            return $this->db->get();
            }

            function add($data)
            {
            $this->db->insert('db_users',$data);
            $user_id = $this->db->insert_id();

            return $user_id;
            }

            function add_role_user($data)
            {
            $this->db->insert('db_roles_users',$data);
            }

            function update($id,$data)
            {
            $this->db->where('id',$id);
            $this->db->update('db_users',$data);
            }

            function update_role_user($id,$data)
            {
            $this->db->where('user_id',$id);
            $this->db->update('db_roles_users',$data);
            }

            function delete($id,$data)
            {
                  $this->db->where('id',$id);
                  $this->db->update('db_users',$data);    
            /*$this->db->where('id',$id);
            $this->db->delete('db_users');
            $this->db->where('user_id',$id);
            $this->db->delete('db_roles_users');
            $this->db->where('id_user',$id);
            $this->db->delete('db_user_targets');
            $this->db->where('id_user',$id);
            $this->db->delete('db_history_point');*/
            }

            function get_company() {
            $this->db->select('*');
            $this->db->from('db_companies');
            return  $this->db->get();
            }

            function get_area() {
            $this->db->select('*');
            $this->db->from('db_company_areas');
            return  $this->db->get();
            }

            function get_role() {
            $this->db->select('*');
            $this->db->from('db_roles');
            return  $this->db->get();
            }
 
            function get_area_list(){
            $tes = $this->input->post('id_company');
            $this->db->select('*');
            $this->db->from('db_company_areas');
            $this->db->where('id_company',$tes);
            return $this->db->get();
            }

            function get_user()
            {
                  $this->db->select('*');
                  $this->db->from('db_users');
                  return $this->db->get();
            }

            function get_data_user($id)
            {
                  $this->db->select('*');
                  $this->db->from('db_users');
                  $this->db->where('id',$id);
                  return $this->db->get();
            }
        }        
        