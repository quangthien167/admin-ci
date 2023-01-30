<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
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
        $this->load->view('dashboard/index');
    }

    function logout()
	{
        $this->check();
		$this->session->sess_destroy();
        $this->session->set_flashdata('message','Đăng xuất thành công');
		redirect(site_url('auth/login'));
	}
}
