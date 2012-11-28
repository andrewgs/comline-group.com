<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdcategory extends CI_Model{

	var $id							= 0;
	var $page_title					= '';
	var $titlepage_description		= '';
	var $page_content				= '';
	var $translit					= '';
	var $date						= '';
	var $showitem					= '';
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data,$translit){
			
		$this->title	= htmlspecialchars($data['title']);
		$this->page_title	= htmlspecialchars($data['title']);
		$this->translit	= $translit;
		$this->date		= date("Y-m-d");
		$this->showitem	= $data['showitem'];
		
		$this->db->insert('category',$this);
		return $this->db->insert_id();
	}
	
	function update_record($id,$data,$translit){
		
		$this->db->set('title',htmlspecialchars($data['title']));
		$this->db->set('page_title',htmlspecialchars($data['title']));
		$this->db->set('translit',$translit);
		$this->db->set('showitem',$data['showitem']);
		
		$this->db->where('id',$id);
		$this->db->update('category');
		return $this->db->affected_rows();
	}
	
	function read_records(){
		
		$this->db->order_by('id');
		$query = $this->db->get('category');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function read_showed_records(){
		
		$this->db->where('showitem',1);
		$this->db->order_by('id');
		$query = $this->db->get('category');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function count_records(){
		
		return $this->db->count_all('category');
	}
	
	function read_record($id){
		
		$this->db->where('id',$id);
		$query = $this->db->get('category',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_field($id,$field){
			
		$this->db->where('id',$id);
		$query = $this->db->get('category',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function read_field_translit($translit,$field){
			
		$this->db->where('translit',$translit);
		$query = $this->db->get('category',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('category');
		return $this->db->affected_rows();
	}
	
	function read_in_records($ids){
		
		$this->db->where('showitem',1);
		$this->db->where_in('id',$ids);
		$this->db->order_by('id');
		$query = $this->db->get('category');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
}