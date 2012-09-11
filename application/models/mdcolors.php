<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdcolors extends CI_Model{

	var $id			= 0;
	var $code		= '';
	var $title		= '';
	var $number		= '';
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data){
			
		$this->title = htmlspecialchars($data['title']);
		$this->number = $data['number'];
		$this->code = $data['code'];
		
		$this->db->insert('colors',$this);
		return $this->db->insert_id();
	}
	
	function read_records(){
		
		$this->db->order_by('id');
		$query = $this->db->get('colors');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function count_records(){
		
		return $this->db->count_all('colors');
	}
	
	function read_record($id){
		
		$this->db->where('id',$id);
		$query = $this->db->get('colors',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_field($id,$field){
			
		$this->db->where('id',$id);
		$query = $this->db->get('colors',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('colors');
		return $this->db->affected_rows();
	}
}