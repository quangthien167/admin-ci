<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function check()
	{
        if(!$this->session->userdata('LoggedIn')){
            redirect(base_url('/auth/login'));
        }
    }
    public function index()
    {
        $this->check();
        $this->load->view('auth/home');
    }
    //
    public function ess()
    {
        $this->check();
        $this->load->view('auth/ess');
    }
    public function supervisor()
    {
        $this->check();
        $this->load->view('auth/supervisor');
    }
    public function p_admin()
    {
        $this->check();
        $this->load->view('auth/p_admin');
    }
    //
    function logout()
	{
        $this->check();
		$this->session->sess_destroy();
        $this->session->set_flashdata('message','Đăng xuất thành công');
		redirect(site_url('auth/login'));
	}
}
