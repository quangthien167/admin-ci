<?php
    class Mlogin extends CI_Model{
        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        public function checkLogin($username, $password)
        {
            $query = $this->db->where('user_name',$username)->where('user_password',$password)->get('ci_user');
            return $query->result();  
        }
    }
?>