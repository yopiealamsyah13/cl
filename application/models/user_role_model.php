
        <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

        class User_role_model extends CI_Model {

            public function __construct() {
                parent::__construct();
                $this->load->database();
            }

            function all($role) {
            $this->db->select('*');
            $this->db->from('db_roles');
               
            if($role!=""){
            $this->db->like('name_role',$role);    
            }    
            
            return  $this->db->get();
            }

            function limit($role,$limit,$per_page) {
            $this->db->select('*');
            $this->db->from('db_roles');
            
            if($role!=""){
            $this->db->like('name_role',$role);    
            }
            
            $this->db->limit($limit,$per_page);
            return  $this->db->get();
            }

            function userbyid($id)
            {
            $this->db->where('id',$id);
            return $this->db->get('db_roles');
            }

            function add($data)
            {
            $this->db->insert('db_roles',$data);
            }

            function update($id,$data)
            {
            $this->db->where('id',$id);
            $this->db->update('db_roles',$data);
            }

            function delete($id)
            {
            $this->db->where('id',$id);
            $this->db->delete('db_roles');
            }
        }        
        