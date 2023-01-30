<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Memployee extends CI_Model{
        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        var $table = 'ci_hr_employee';
        var $column_order = array('emp_number', 'employee_id','fullname','emp_nick_name','emp_gender','joined_date',null);
        var $column_search = array('employee_id','emp_lastname ','emp_middle_name','emp_firstname','emp_nick_name','joined_date');
        var $order = array('emp_number' => 'asc');

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
            $this->db->select('CONCAT(emp_lastname," ",emp_middle_name," ",emp_firstname) as fullname');
            $this->db->from('ci_hr_employee');
            $this->db->order_by('ci_hr_employee.emp_number');
            $this->filter();
        }

        public function getDataTable(){
            
            $this->filter();

            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

            $this->db->select('ci_hr_employee.*');
            $this->db->select('CONCAT(emp_lastname," ",emp_middle_name," ",emp_firstname) as fullname');
            $this->db->select("
                case
                    when emp_gender = 1 then 'Nam'
                    when emp_gender = 0 then 'Nữ'
                    end as 'emp_gender'");
            $this->db->from('ci_hr_employee');
            $this->db->like('employee_id', $this->input->post('employee_id'));
            // $this->db->like( 'CONCAT(emp_lastname," ",emp_middle_name," ",emp_firstname) LIKE "%' . $this->input->post('fullname') . '%" ESCAPE "!" ');
            $this->db->like('CONCAT(emp_lastname," ",emp_middle_name," ",emp_firstname)', $this->input->post('fullname'));
            $this->db->like('emp_nick_name',$this->input->post('emp_nick_name'));
            $this->db->like('joined_date',$this->input->post('joined_date'));
            $this->db->order_by('ci_hr_employee.emp_number');
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

        public function getDataIdViewEmployee($id)
        {
            $this->db->select("ci_hr_employee.*");
            $this->db->select('CONCAT(emp_lastname," ",emp_middle_name," ",emp_firstname) as fullname');
            $this->db->select("
                case
                    when emp_gender = 1 then 'Nam'
                    when emp_gender = 0 then 'Nữ'
                    end as 'emp_gender'");
            $this->db->where('emp_number',$id);
            $query = $this->db->get('ci_hr_employee');
            return $query->row();
        }

        public function check_employeeId($check)
        {
            $this->db->select("*");
            $this->db->from("ci_hr_employee");
            $this->db->where("employee_id",$check);
            $query = $this->db->get();

            if($query->num_rows()>0){
                return false;
            }return true;
        }

        public function create($input){
            $this->db->insert('ci_hr_employee',$input);
            return $this->db->affected_rows();
        }

        public function getDataId($emp_number){
            return $this->db->get_where($this->table,['emp_number' => $emp_number])->row_array();
        }

        public function update($where, $input){
            $this->db->update($this->table,$input,$where);
            return $this->db->affected_rows();
        }

        public function delete($id){
            $this->db->delete($this->table,['emp_number' => $id]);
            return $this->db->affected_rows();
        }

    }
?>