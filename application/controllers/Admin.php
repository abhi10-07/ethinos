<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
	var $global_scope_var;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->driver("session");
		$this->load->model('admin_model'); 
	}
	
	
	/* -------------------------------------------------------login check------------------------------------------------- */
	public function is_logged_in($log=null){
		$is_logged_id = $this->session->userdata('is_admin_logged_in');
		
		if(!isset($is_logged_id) || $is_logged_id != true) {				
			redirect('admin/');
		}
	}
	
	
	/* -------------------------------------------------------Index------------------------------------------------ */
	public function index(){ 
		$is_logged_id = $this->session->userdata('is_admin_logged_in');
		
		if(!isset($is_logged_id) || $is_logged_id != true)
        {														
			$this->load->view('admin/vw_admin_login');
        }
		else
		{
            $result_array = json_decode($this->admin_model->getListBooking(), true);
			$data['result']['booking'] = $result_array;

			$tableName = 'users';
            $fields = 'username, name, phone, file_upload, id';
            $where = 'flag = 1';
            $order_by = 'id';
            $result_array = $this->admin_model->getDataFromTableJoin($tableName, $where, $fields, null , null,  $order_by);
			$data['result']['users'] = $result_array;
			
            $this->load->view('admin/vw_all_booking', $data);
		}
    }
    
	
	
	function check_credentials()
    {
		$json = $this->admin_model->validate();
		
		if($json)
		{
			$result = json_decode($json, true);
			//          echo $result[0]['username'];
			$data = array(
				'admin_username'=>$result[0]['username'],
				'admin_user_id'=>$result[0]['id'],
				'is_admin_logged_in'=>true
			);
			
			$this->session->set_userdata($data);
			echo 1;
		}
		else
		{
			echo 0;
		}
		
	}
	
	
	
	
	/* -------------------------------------------------------logout------------------------------------------------ */
    function logout()
    {
		
		$this->session->unset_userdata('admin_username');
		$this->session->unset_userdata('admin_user_id'); 
		$this->session->unset_userdata('is_admin_logged_in');
		$this->session->sess_destroy();
		
        redirect('/admin');
	}
	
	
	function updateIntoTableAjax(){
		
		$tableName = $this->input->post('table');
		$formData = array('approved' => 1);
		$where = 'id = '.$this->input->post('id');
		
		$this->db->update($tableName, $formData, $where);
		$output = $this->db->affected_rows();
		if($output){ return true; }else{ return false; }
		
	}
	
	
	
	
	
	
}
