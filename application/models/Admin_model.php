
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends CI_Model
{
	function __construct()
    {
		parent::__construct();
    }
	
	
	function validate()
    {
		$username =  $this->input->post('username');
        $password = md5(trim($this->input->post('password')));
        
		$this->db->select('username, id');
		$this->db->from('admin');
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
	
	function getListBooking() {
		$sql = 'SELECT `hotels`.`name`, `hotels_feature`.`cost`, `hotels_feature`.`type`, `booking`.`date_from`, `booking`.`date_to`, `booking`.`total_cost`, `booking`.`no_of_nights`, `booking`.`approved`, `hotels`.`id` , users.name as username, users.phone
		FROM `hotels` 
		JOIN `hotels_feature` ON `hotels`.`id` = `hotels_feature`.`hotel_id` 
		JOIN `booking` ON `booking`.`inner_hotel_id` = `hotels_feature`.`id` 
		JOIN `users` ON `booking`.`user_id` = `users`.`id` 
		WHERE `booking`.`flag` = 1 ORDER BY `hotels`.`id`';

		$query = $this->db->query($sql);

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
	
	
	
	
	
	
	
	
}//end of controller