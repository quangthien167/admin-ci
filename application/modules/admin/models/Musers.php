<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Musers extends CI_Model{
        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }
        var $table = 'ci_user';
        var $column_order = array('id','user_role_id','user_name','date_entered','status',null);
        var $column_search = array('user_role_id','user_name','date_entered');
        var $order = array('id' => 'asc');

        private function filter()
        {
            $i = 0;
         
            foreach ($this->column_search as $item){
                if($_POST['search']['value']){
                    if($i===0){
                        $this->db->group_start(); 
                        $this->db->like($item, $_POST['search']['value']);
                    }
                    else{
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
     
                    if(count($this->column_search) - 1 == $i)
                        $this->db->group_end();
                }
                $i++;
            }
             
            if(isset($_POST['order'])){
                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->order)){
                $order = $this->order;
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }

        private function _get_datatables_query()
        {
            $this->db->select('ci_user.*, ci_user_role.name');
            $this->db->from('ci_user');
            $this->db->join('ci_user_role','ci_user_role.id=ci_user.user_role_id');
            $this->db->order_by('ci_user.id');

            $this->filter();
        }

        
        public function getDataTable(){
            
            $this->filter();
            
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

            $this->db->select('ci_user.*, ci_user_role.name');
            $this->db->select("
                case
                    when status = 1 then 'Đang hoạt động'
                    when status = 0 then 'Ngưng hoạt động'
                    end as 'status'");
            $this->db->from('ci_user');
            $this->db->join('ci_user_role','ci_user_role.id=ci_user.user_role_id');
            $this->db->like('user_role_id', $this->input->post('user_role_id'));
            $this->db->like('user_name', $this->input->post('user_name'));
            $this->db->like('date_entered',$this->input->post('date_entered'));
            $this->db->order_by('ci_user.id');
            return $this->db->get()->result_array();
        }

        public function count_filtered()
        {
            $this->_get_datatables_query();
            $query = $this->db->get();
            return $query->num_rows();
        }
    
        public function count_all()
        {
            $this->db->from($this->table);
            return $this->db->count_all_results();
        }

        public function get_roles(){
            return $this->db->get('ci_user_role')->result_array();
        }

        public function getDataIdView($id)
        {
            $this->db->select('ci_user.*, ci_user_role.name');
            $this->db->select("
            case
                when status = 1 then 'Đang hoạt động'
                when status = 0 then 'Ngưng hoạt động'
                end as 'status'");
            $this->db->join('ci_user_role','ci_user_role.id=ci_user.user_role_id');
            $this->db->where('ci_user.id',$id);
            $query = $this->db->get('ci_user');
            return $query->row();
        }

        public function create_user($input){
            $this->db->insert('ci_user', $input);
             return $this->db->affected_rows();
        }

        public function username_check($username)
        {
            $this->db->select("*");
            $this->db->from("ci_user");
            $this->db->where("user_name",$username);
            $query = $this->db->get();

            if($query->num_rows()>0){
                return false;
            }return true;
        }

        public function getDataId($id){
            return $this->db->get_where($this->table,['id' => $id])->row_array();
        }

        public function update($where, $input){
            $this->db->update($this->table,$input,$where);
            return $this->db->affected_rows();
        }

        public function delete($id){
            $this->db->delete($this->table,['id' => $id]);
            return $this->db->affected_rows();
        }

    }
?>