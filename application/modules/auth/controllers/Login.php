<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('index');
    }

    public function login()
    {
        $this->form_validation->set_rules('username','Tài khoản','trim|required',['required'=>'Vui lòng nhập đúng %s']);
        $this->form_validation->set_rules('password','Mật khẩu','trim|required',['required'=>'Vui lòng nhập đúng %s']);

        if($this->form_validation->run() == TRUE){
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));
            $this->load->model('Mlogin');
            $result = $this->Mlogin->checkLogin($username,$password);
            if(count($result) > 0){
                $session_array = array(
                    'id' => $result[0]->id,
                    'user_role_id' => $result[0]->user_role_id,
                );
                $this->session->set_userdata('LoggedIn',$session_array);
                if($result[0]->user_role_id === '1'){
                    redirect(base_url('/admin'));
                }elseif($result[0]->user_role_id === '2'){
                    redirect(base_url('/ess'));
                }elseif($result[0]->user_role_id === '3'){
                    redirect(base_url('/supervisor'));
                }else{
                    redirect(base_url('/p_admin'));
                }
                $this->session->set_flashdata('success','Đăng nhập thành công');
                
            }else{
                $this->session->set_flashdata('error', 'Đăng nhập không thành công');
                redirect(base_url('/auth/login'));
            }
        }else{
            $this->index();
        }
    }
}
