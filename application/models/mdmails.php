<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdmails extends CI_Model{

	var $id			= 0;
	var $email		= '';
	var $date		= '';
	var $text		= '';
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data,$translit){
			
		$this->email	= $data['email'];
		$this->datre	= date("Y-m-d");
		$this->text		= $data['text'];
		
		$this->db->insert('mails',$this);
		return $this->db->insert_id();
	}
	
	function read_records(){
		
		$this->db->order_by('id');
		$query = $this->db->get('mails');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function count_records(){
		
		return $this->db->count_all('mails');
	}
	
	function read_record($id){
		
		$this->db->where('id',$id);
		$query = $this->db->get('mails',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_field($id,$field){
			
		$this->db->where('id',$id);
		$query = $this->db->get('mails',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('mails');
		return $this->db->affected_rows();
	}
}