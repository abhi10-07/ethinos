<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    var $global_scope_var;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->driver("session");
		$this->load->model('user_account_model');
    }
        
    /* -------------------------------------------------------login check------------------------------------------------- */
    public function is_logged_in($log = null)
    {
        $is_logged_id = $this->session->userdata('is_logged_in');
        
        if (!isset($is_logged_id) || $is_logged_id != true) {
            redirect('/user');
        }
    }
    
    
    /* -------------------------------------------------------Index------------------------------------------------ */
    public function index()
    {
        $is_logged_id = $this->session->userdata('is_logged_in');
        
        if (!isset($is_logged_id) || $is_logged_id != true) {
            $this->load->view('login');
        } else {
            redirect('user/user_account');
        }
    }
    
    function check_credentials()
    {
        $json = $this->user_account_model->validate();
        
        if ($json) {
            $result = json_decode($json, true);
            //          echo $result[0]['username'];
            $data   = array(
                'name' => $result[0]['name'],
                'username' => $result[0]['username'],
                'user_id' => $result[0]['id'],
                'is_logged_in' => true
            );
            
            $this->session->set_userdata($data);
            echo 1;
        } else {
            echo 0;
        }
        
    }
    
    /* -------------------------------------------------------User account------------------------------------------------- */
    function user_account()
    {
        $this->is_logged_in();
        $tableName    = 'users';
        $fields       = 'email, name, phone';
        $where        = 'id = ' . $this->session->userdata('user_id') . ' and flag = 1';
        $order_by     = 'id';
        $result_array = $this->user_account_model->getDataFromTableJoin($tableName, $where, $fields, null, null, $order_by);
        if ($result_array) {
            $data['result'] = $result_array;
        }
        $this->load->view('user_account', $data);
    }
    
    
    /* -------------------------------------------------------logout------------------------------------------------ */
    function logout()
    {
        
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('is_logged_in');
        $this->session->sess_destroy();
        
        redirect('/user');
    }
    
    function check_email()
    {
        $count = $this->user_account_model->check_email();
        echo $count;
    }
    
    
    /* -------------------------------------------------------Register----------------------------------------------- */
    public function register()
    {
        $config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'gif|jpg|png|pdf|doc';
		$config['max_size']             = 100;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
		$new_name = time().$_FILES["userfile"]['name'];
		$config['file_name'] = $new_name;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
				
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        $this->form_validation->set_rules('fname', 'Required', 'trim|required');
        $this->form_validation->set_rules('lname', 'Required', 'trim|required');
        $this->form_validation->set_rules('rpassword', 'Required', 'trim|required');
        $this->form_validation->set_rules('rcpassword', 'Mismatch', 'trim|required|matches[rpassword]');
        $this->form_validation->set_rules('email', 'Required', 'trim|required|valid_email');
        $this->form_validation->set_rules('phone', 'Required', 'trim|required|regex_match[/^[0-9]{10}$/]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->data['active'] = '';
			$this->load->view('login');			
        } else {

			if ( ! $this->upload->do_upload('userfile')) {         
				$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
				$error = array('error' => $this->upload->display_errors());
				$this->load->view('login', $error);
			}else {
				$data = array('upload_data' => $this->upload->data());
				// print_r($data['upload_data']['file_name']); exit;
				$data['fileName'] = $data['upload_data']['file_name'];
			}

            if ($query = $this->user_account_model->register($data)) {
                $data = array(
                    'name' => $this->input->post('fname'),
                    'username' => $this->input->post('email'),
                    'user_id' => $query,
                    'is_logged_in' => true
                );
                $this->session->set_userdata($data);
                
                $from    = 'abhi.figo.10@gmail.com';
                $to      = $this->input->post('email');
                $subject = 'Welcome to Ethinos';
                $message = "
                    <div style=\"text-align:center;\"><table width=\"50%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" summary=\"Request Information\"><tr style=\"background:#e4e4e4;\"><th style=\"text-align:center;\"colspan=\"2\"><h2>User Credentials</h2></th></tr><tr><th style=\"text-align:left;padding-left:10px;\" width=\"25%\" scope=\"row\">Username</th><td style=\"text-align:left;padding-left:10px;\">" . $this->input->post('email') . "</td></tr><tr><th style=\"text-align:left;padding-left:10px;\" width=\"25%\" scope=\"row\">Password</th><td style=\"text-align:left;padding-left:10px;\">" . $this->input->post('rpassword') . "</td></tr>              
                    ";
                $message .= "  
                    </table></div>​";
                
                $this->send_mail($from, $to, $message, $subject);
                
                redirect('user/user_account');
            } else {
                $data['active'] = '';
                $this->load->view('login');
            }
        }
    }
    
    
    
    function booking()
    {
        $this->is_logged_in();
        $this->load->view('booking');
    }

    function ajaxHotel()
    {
        $this->is_logged_in();

        $data   = array(
            'dataFrom' => $this->input->post('fromDate'),
            'dataTo' => $this->input->post('toDate'),
        );
        
        $this->session->set_userdata($data);

        $tableName = 'hotels';
        $fields = 'name, cost, address, image, id';
        $where = 'flag = 1';
        $order_by = 'id';
        $result_array = $this->user_account_model->getDataFromTableJoin($tableName, $where, $fields, null , null,  $order_by);
        $data['result']['hotels'] = $result_array;

        $start = $this->session->userdata('dataFrom');
        $end = $this->session->userdata('dataTo');
        $result_array = json_decode($this->user_account_model->getAvailableRooms($start, $end, null), true);
        $data['result']['rooms'] = $result_array;

        return $this->load->view('ajax_search_hotels', $data);
    }

    function inner_hotel($id) {
        $this->is_logged_in();

        $tableName = 'hotels';
        $fields = 'name, cost, address, image, id';
        $where = 'id ='.$id;
        $order_by = 'id';
        $result_array = $this->user_account_model->getDataFromTableJoin($tableName, $where, $fields, null , null,  $order_by);
        $data['hotel_name'] = $result_array[0]['name'];

        $data['dataFrom'] = $start = $this->session->userdata('dataFrom');
        $data['dataTo'] = $end = $this->session->userdata('dataTo');
        $hotel = $id;
        $result_array = json_decode($this->user_account_model->getAvailableRooms($start, $end, $hotel), true);
        $data['result'] = $result_array;
    
        $this->load->view('inner-hotel', $data);
    }
    
    function doBooking()
    {
        $this->is_logged_in();

        $data = array(
            'user_id' => $this->session->userdata('user_id')
        );
        
        if ($query = $this->user_account_model->do_booking($data)) {
            
            $from    = 'abhi.figo.10@gmail.com';
            $to      = $this->session->userdata('username');
            $subject = 'Booking details';
            $message = "
                <div style=\"text-align:center;\"><table width=\"50%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" summary=\"Request Information\"><tr style=\"background:#e4e4e4;\"><th style=\"text-align:center;\"colspan=\"2\"><h2>Booking Details</h2></th></tr><tr><th style=\"text-align:left;padding-left:10px;\" width=\"25%\" scope=\"row\">Service</th><td style=\"text-align:left;padding-left:10px;\">" . $this->input->post('book_type') . "</td></tr><tr><th style=\"text-align:left;padding-left:10px;\" width=\"25%\" scope=\"row\">Date</th><td style=\"text-align:left;padding-left:10px;\">" . $this->input->post('book_from') . "</td></tr>              
                ";
            $message .= "  
                </table></div>​";
            
            $this->send_mail($from, $to, $message, $subject);
            $to_admin = 'abhi.figo.10@gmail.com';
            $this->send_mail($from, $to_admin, $message, $subject);
            
            redirect('user/all_booking');
        }
    }
    
    function all_booking()
    {
        $this->is_logged_in();

        $result_array = json_decode($this->user_account_model->getListBooking(), true);
        $data['result'] = $result_array;
        $this->load->view('all_booking', $data);
    }
    
    
    /* -------------------------------------------------------Mail---------------------------------------------- */
    public function send_mail($from, $to, $message, $subject)
    {
        $from_email = $from;
        $to_email   = $to;
        $subject    = $subject;
        
        //Load email library 
        $this->load->library('email');
        
        $this->email->from($from_email, 'Ethinos');
        $this->email->to($to_email);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->set_newline("\r\n");
        $this->email->set_mailtype('html');
        $email = $this->email->send();
        //Send mail 
        /* if($email) 
        echo "Email sent successfully."; 
        else  
        echo $this->email->print_debugger(); */
    }
    
    
}