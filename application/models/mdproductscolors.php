<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdproductscolors extends CI_Model{

	var $id			= 0;
	var $product_id	= 0;
	var $code		= '';
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data,$product_id,$code){
			
		$this->title = htmlspecialchars($code);
		$this->product_id = $product_id;
		
		$this->db->insert('products_colors',$this);
		return $this->db->insert_id();
	}
	
	function read_records(){
		
		$this->db->order_by('id');
		$query = $this->db->get('products_colors');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function count_records(){
		
		return $this->db->count_all('products_colors');
	}
	
	function read_record($id){
		
		$this->db->where('id',$id);
		$query = $this->db->get('products_colors',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_field($id,$field){
			
		$this->db->where('id',$id);
		$query = $this->db->get('products_colors',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('products_colors');
		return $this->db->affected_rows();
	}
}