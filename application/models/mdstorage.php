<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdstorage extends CI_Model{

	var $id			= 0;
	var $title		= '';
	var $address		= '';
	var $metro		= '';
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data){
			
		$this->title	= htmlspecialchars($data['title']);
		$this->address	= $data['address'];
		$this->metro	= $data['metro'];
		
		$this->db->insert('storage',$this);
		return $this->db->insert_id();
	}
	
	function update_record($id,$data){
		
		$this->db->set('title',htmlspecialchars($data['title']));
		$this->db->set('address',$data['address']);
		$this->db->set('metro',$data['metro']);
		
		$this->db->where('id',$id);
		$this->db->update('storage');
		return $this->db->affected_rows();
	}
	
	function read_records(){
		
		$this->db->order_by('id');
		$query = $this->db->get('storage');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function count_records(){
		
		return $this->db->count_all('storage');
	}
	
	function read_record($id){
		
		$this->db->where('id',$id);
		$query = $this->db->get('storage',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_field($id,$field){
			
		$this->db->where('id',$id);
		$query = $this->db->get('storage',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('storage');
		return $this->db->affected_rows();
	}
}