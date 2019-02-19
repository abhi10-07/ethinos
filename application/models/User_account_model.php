 
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_account_model extends CI_Model
{
	function __construct()
    {
		parent::__construct();
    }
	
	
	function validate()
    {
		$username =  $this->input->post('username');
        $password = md5(trim($this->input->post('password')));
        
		$this->db->select('username, name, phone, id');
		$this->db->from('users');
		$this->db->where('username', $username);
		$this->db->where('password',$password);
		$this->db->where('flag',1);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		if($query->num_rows()>0){
			return json_encode($query->result_array());
		}else{
			return NULL;
		}
        
    }
	
	
	function check_email($username = NULL)
	{
		if($username)
		{
			$email = $username;
		}
		else
		{
			$email = $this->input->post('email');
		}
		
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('username', $email);
		$this->db->where('flag',1);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		if($query->num_rows()>0){
			return $query->num_rows();
		}else{
			return 0;
		}
		
	}
	
	
	function register($data = null){
		$password = $this->input->post('rpassword');
		$new_data = array(
			
			'name' => $this->input->post('fname') .' '.$this->input->post('lname'),
			'username' => $this->input->post('email'),
			'password' => md5($password),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
            
        );
        
        $insert = $this->db->insert('users', $new_data);
		$user_id = $this->db->insert_id();
		
		$new_data = array(
			'created' => date('y-m-d h:i:s'),            
			'user_id' => $user_id          
        );
		
		
		return $user_id;
		
	} #END register

	function do_booking($data) {

		$tableName = 'hotels';
        $fields = 'hotels.name, hotels_feature.cost, hotels_feature.type, hotels_feature.image, hotels.id';
        $join_table = 'hotels_feature';
        $join_condition = 'hotels.id = hotels_feature.hotel_id';
        $where = 'hotels_feature.id = '.$this->input->post('book_id').' and hotels.flag = 1';
        $order_by = 'hotels.id';
        $result_array = $this->user_account_model->getDataFromTableJoin($tableName, $where, $fields, $join_table , $join_condition,  $order_by);
		$result = $result_array;
		$datetime1 = new DateTime(date($this->input->post('book_from')));
		$datetime2 = new DateTime($this->input->post('book_to'));
		$difference = $datetime1->diff($datetime2);
		$no_of_nights = $difference->d;
		$total_cost = $no_of_nights*$result[0]['cost'];
		
		$Insert_data = array(
			'user_id' => $data['user_id'],
            'date_from' => $this->input->post('book_from'),
            'date_to' => $this->input->post('book_to'),
            'inner_hotel_id' => $this->input->post('book_id'),
            'no_of_nights' => $no_of_nights,
            'total_cost' => $total_cost,
		);
		
		// print_r($Insert_data); exit;
		
		return $this->user_account_model->insertIntoTable('booking', $Insert_data);

	}

	function getListBooking() {
		$sql = 'SELECT `hotels`.`name`, `hotels_feature`.`cost`, `hotels_feature`.`type`, `booking`.`date_from`, `booking`.`date_to`, `booking`.`total_cost`, `booking`.`no_of_nights`, `booking`.`approved`, `hotels`.`id` 
		FROM `hotels` 
		JOIN `hotels_feature` ON `hotels`.`id` = `hotels_feature`.`hotel_id` 
		JOIN `booking` ON `booking`.`inner_hotel_id` = `hotels_feature`.`id` 
		WHERE `booking`.`user_id` = '.$this->session->userdata('user_id').' ORDER BY `hotels`.`id`';

		$query = $this->db->query($sql);

		return json_encode($query->result());
	}

	function getAvailableRooms($start, $end, $hotel = null) {

		if($hotel != null) {
			$sqlRoom = 'SELECT * FROM hotels_feature AS hf 
			WHERE hf.id NOT IN( SELECT hf1.id FROM booking AS b 
			JOIN hotels_feature AS hf1  
			ON b.inner_hotel_id = hf1.id 
			WHERE (b.date_from <= "'.$start.'" AND b.date_to >=   "'.$end.'")) AND hf.hotel_id = '.$hotel.'' ;
		}else {
			$sqlRoom = 'SELECT * FROM hotels_feature AS hf 
			WHERE hf.id NOT IN( SELECT hf1.id FROM booking AS b 
			JOIN hotels_feature AS hf1  
			ON b.inner_hotel_id = hf1.id 
			WHERE (b.date_from <= "'.$start.'" AND b.date_to >=   "'.$end.'"))' ;
		}
		

		$query = $this->db->query($sqlRoom);
		// echo $result  = $this->db->last_query(); exit;
		return json_encode($query->result());	

	}
	
	
	function getDataFromTableJoin($tableName, $where = null,$fields="*", $joinTable = null, $joinCond = null,  $order_by=null, $groupby = null, $limit = null){
		$order=($order_by)?$order_by:'ASC';
		if( empty($tableName) &&  empty($where)){
			return false;
		}
		else if( empty($where)){
			
			$this->db->select($fields);
			$query = $this->db->get($tableName);
			$this->db->order_by($order, 'DESC');
			$this->db->limit($limit,0);
			if($query->num_rows() > 0){ return $query->result_array(); }else{ return false; }	
		}
		else{
			$this->db->select($fields);
			$this->db->where($where);
			if (isset($joinTable)) {
				$this->db->join($joinTable, $joinCond);
			}
			if (isset($groupby)) {
				$this->db->group_by($groupby);
			}
			$this->db->order_by($order, 'DESC');
			$this->db->limit($limit,0);
			
			$query = $this->db->get($tableName);
			// echo $result  = $this->db->last_query(); exit;
			if($query->num_rows() > 0){ return $query->result_array(); }else{ return false; }		  
		}
	}
	
	
	
	function insertIntoTable($tableName, $formData){
		
		if( empty($tableName) &&  empty($formData)){
			return false;
		}
		else if( empty($tableName) ||  empty($formData)){
			return false;
		}
		else{			
			$output = $this->db->insert($tableName, $formData);
			if($output){ return $this->db->insert_id(); }else{ return false; }
		}
		
	} #END insertIntoTable
	
	
	
	
}//end of controller