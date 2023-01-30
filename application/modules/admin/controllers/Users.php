<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->database();
        $this->load->model("Musers");
    }

    function check()
	{
        if(!$this->session->userdata('LoggedIn')){
            redirect(base_url('/auth/login'));
        }
    }

    function logout()
	{
        $this->check();
		$this->session->sess_destroy();
        $this->session->set_flashdata('message','Đăng xuất thành công');
		redirect(site_url('auth/login'));
	}

    public function index()
    {
        $this->check();
        $data['role'] = $this->Musers->get_roles();
        $this->load->view('users/index',$data);
    }

    public function getData()
    {
        $results = $this->Musers->getDataTable();
        $data = [];
        $data = array();

        foreach($results as $result){
            $row = array();
            $row[] = $result['id'];
            $row[] = $result['name'];
            $row[] = $result['user_name'];
            $row[] = $result['date_entered'];
            $row[] = $result['status'];
            
            $row[] = '
            <a href="#" class="btn btn-success btn-sm" onclick="view('."'".$result['id']."','view'".')"> Xem </a>
            <a href="'."".'admin/users/edit/'.$result['id'].'/edit'."".'" class="btn btn-info btn-sm"> Sửa </a>
            <a href="#" class="btn btn-danger btn-sm" onclick="byid('."'".$result['id']."','delete'".')"> Xóa </a>
            ';
                
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Musers->count_all(),
            "recordsFiltered" => $this->Musers->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);

    }

    public function byIdView($id)
    {
        $data = $this->Musers->getDataIdView($id);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function create()
    {
        $data['role'] = $this->Musers->get_roles();
        
        $this->form_validation->set_rules('user_name','Tài khoản','trim|required',['required'=>'Vui lòng nhập %s']);
        $this->form_validation->set_rules('user_password','Mật khẩu','trim|required',['required'=>'Vui lòng nhập %s']);
        $this->form_validation->set_rules('date_entered','Ngày tạo','trim|required',['required'=>'Vui lòng nhập %s']);

        if($this->form_validation->run()==FALSE){
            $this->load->view('admin/users/create',$data);
        }else{
            $input = [
                'user_role_id' => $this->input->post('role'),
                'user_name'=>$this->input->post('user_name'),
                'user_password'=>md5($this->input->post('user_password')),
                'date_entered' => $this->input->post('date_entered'),
            ];
            $check_username = $this->Musers->username_check($input['user_name']);

            if($check_username){
                if($this->Musers->create_user($input)>0){
                    $this->session->set_flashdata('success', 'Thêm tài khoản thành công');
                    redirect('admin/users/create');
                }
            }else{
                $this->session->set_flashdata('error', 'Thêm tài khoản không thành công');
                redirect('admin/users/create');
            }
        }
    }

    public function edit($id, $type)
    {
        $data['user_role_id'] = $this->Musers->get_roles();
        $dataU = $this->Musers->getDataId($id);

        if($type == 'edit'){
            $data['byId'] = $dataU;
            $this->form_validation->set_rules('user_name','Tài khoản','trim|required',['required'=>'Vui lòng nhập %s']);
            $this->form_validation->set_rules('user_password','Mật khẩu','trim|required',['required'=>'Vui lòng nhập %s']);
            $this->form_validation->set_rules('date_entered','Ngày tạo','trim|required',['required'=>'Vui lòng nhập %s']);
            $this->form_validation->set_rules('date_modified','Ngày sửa','trim|required',['required'=>'Vui lòng nhập %s']);

            if($this->form_validation->run()==FALSE){
                $this->load->view('admin/users/edit',$data);
            }else{
                $input = [
                    'user_role_id' => $this->input->post('user_role_id'),
                    'user_name'=>$this->input->post('user_name'),
                    'user_password'=>md5($this->input->post('user_password')),
                    'date_entered'=>$this->input->post('date_entered'),
                    'date_modified'=>$this->input->post('date_modified'),
                ];
                if($this->Musers->update(array('id' => $this->input->post('uId')),$input) >= 0){
                    $this->session->set_flashdata('success', 'Sửa tài khoản thành công');
                    redirect('users');
                }else{
                    $this->session->set_flashdata('error', 'Sửa tài khoản không thành công');
                redirect('admin/users/edit');
                }
            }
        }else{
            $this->output->set_content_type('application/json')->set_output(json_encode($dataU));
        }
        
    }

    public function byid($id)
    {
        $data = $this->Musers->getDataId($id);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function delete($id)
    {
        if($this->Musers->delete($id) > 0){
            $message['status'] = 'success';
        }else{
            $message['status'] = 'failed';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($message));

    }
}