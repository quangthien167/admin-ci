<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->database();
        $this->load->model("Memployee");
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
        $this->load->view('employee/index');
    }

    public function getData()
    {
        $results = $this->Memployee->getDataTable();
        $data = [];
        $data = array();

        foreach($results as $result){
            $row = array();
            $row[] = $result['emp_number'];
            $row[] = $result['employee_id'];
            $row[] = $result['fullname'];
            $row[] = $result['emp_nick_name'];
            $row[] = $result['emp_gender'];
            $row[] = $result['joined_date'];
            
            $row[] = '
            <a href="#" class="btn btn-success btn-sm" onclick="view('."'".$result['emp_number']."','view'".')"> Xem </a>
            <a href="'."".'admin/employee/edit/'.$result['emp_number'].'/edit'."".'" class="btn btn-info btn-sm"> Sửa </a>
            <a href="#" class="btn btn-danger btn-sm" onclick="byid('."'".$result['emp_number']."','delete'".')"> Xóa </a>
            ';
                
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Memployee->count_all(),
            "recordsFiltered" => $this->Memployee->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);

    }

    public function byIdViewEmployee($id)
    {
        $data = $this->Memployee->getDataIdViewEmployee($id);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function create()
    {
        $this->form_validation->set_rules('el_id','Mã nhân viên','trim|required',['required'=>'Vui lòng nhập %s']);
        $this->form_validation->set_rules('middlename','Tên đệm','required',['required'=>'Vui lòng nhập %s']);
        $this->form_validation->set_rules('firstname','Tên','required',['required'=>'Vui lòng nhập %s']);
        $this->form_validation->set_rules('lastname','Họ','required',['required'=>'Vui lòng nhập %s']);
        $this->form_validation->set_rules('nickname','Biệt danh','required',['required'=>'Vui lòng nhập %s']);
        $this->form_validation->set_rules('marital','Tình trạng hôn nhân','required',['required'=>'Vui lòng nhập %s']);
        $this->form_validation->set_rules('date','Ngày tạo','trim|required',['required'=>'Vui lòng nhập %s']);
        $this->form_validation->set_rules('gender','Giới tính','required',['required'=>'Vui lòng nhập %s']);
        
        if($this->form_validation->run()==FALSE){
            $this->load->view('admin/employee/create');
        }else{
            $input = [
                'employee_id' => htmlspecialchars($this->input->post('el_id')),
                'emp_middle_name' => htmlspecialchars($this->input->post('middlename')),
                'emp_firstname' => htmlspecialchars($this->input->post('firstname')),
                'emp_lastname' => htmlspecialchars($this->input->post('lastname')),
                'emp_nick_name' => htmlspecialchars($this->input->post('nickname')),
                'emp_marital_status' => htmlspecialchars($this->input->post('marital')),
                'joined_date' => htmlspecialchars($this->input->post('date')),
                'emp_gender' => htmlspecialchars($this->input->post('gender')),
            ];

            $check_employeeId = $this->Memployee->check_employeeId($input['employee_id']);

            if($check_employeeId){
                if($this->Memployee->create($input) > 0){
                    $this->session->set_flashdata('success','Thêm nhân viên thành công');
                    redirect('admin/employee/create');
                }
            }else{
                $this->session->set_flashdata('error','Nhân viên đã tồn tại');
                redirect('admin/employee/create');
            }
        }
    }

    public function edit($emp_number, $type)
    {
        $dataU = $this->Memployee->getDataId($emp_number);

        if($type == 'edit'){
            $data['byId'] = $dataU;
            $this->form_validation->set_rules('el_id','Mã nhân viên','trim|required',['required'=>'Vui lòng nhập %s']);
            $this->form_validation->set_rules('middlename','Tên đệm','trim|required',['required'=>'Vui lòng nhập %s']);
            $this->form_validation->set_rules('firstname','Tên','trim|required',['required'=>'Vui lòng nhập %s']);
            $this->form_validation->set_rules('lastname','Họ','trim|required',['required'=>'Vui lòng nhập %s']);
            $this->form_validation->set_rules('nickname','Biệt danh','trim|required',['required'=>'Vui lòng nhập %s']);
            $this->form_validation->set_rules('marital','Tình trạng hôn nhân','required',['required'=>'Vui lòng nhập %s']);
            $this->form_validation->set_rules('date','Ngày tạo','trim|required',['required'=>'Vui lòng nhập %s']);
            $this->form_validation->set_rules('gender','Giới tính','trim|required',['required'=>'Vui lòng chọn %s']);

            if($this->form_validation->run()==FALSE){
                $this->load->view('admin/employee/edit',$data);
            }else{
                $input = [
                    'employee_id' => htmlspecialchars($this->input->post('el_id')),
                    'emp_middle_name' => htmlspecialchars($this->input->post('middlename')),
                    'emp_firstname' => htmlspecialchars($this->input->post('firstname')),
                    'emp_lastname' => htmlspecialchars($this->input->post('lastname')),
                    'emp_nick_name' => htmlspecialchars($this->input->post('nickname')),
                    'emp_marital_status' => htmlspecialchars($this->input->post('marital')),
                    'joined_date' => htmlspecialchars($this->input->post('date')),
                    'emp_gender' => htmlspecialchars($this->input->post('gender')),
                ];
                if($this->Memployee->update(array('emp_number' => $this->input->post('uId')),$input) >= 0){
                    $this->session->set_flashdata('success', 'Sửa nhân viên thành công');
                    redirect('employee');
                }else{
                    $this->session->set_flashdata('error', 'Sửa nhân viên không thành công');
                    redirect('admin/employee/edit');
                }
            }
        }else{
            $this->output->set_content_type('application/json')->set_output(json_encode($dataU));
        }
        
    }

    public function byid($emp_number)
    {
        $data = $this->Memployee->getDataId($emp_number);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function delete($emp_number)
    {
        if($this->Memployee->delete($emp_number) > 0){
            $message['status'] = 'success';
        }else{
            $message['status'] = 'failed';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($message));

    }
}
