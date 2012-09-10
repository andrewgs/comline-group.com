<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdcatalogs extends CI_Model{

	var $id		= 0;
	var $title	= '';
	var $translit= '';
	var $text	= '';
	var $html	= '';
	var $brand	= 0;
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data,$translit,$brand){
			
		$this->title = htmlspecialchars($data['title']);
		$this->translit = $translit;
		$this->text = $data['text'];
		$this->html = $data['html'];
		$this->brand = $brand;
		
		$this->db->insert('catalogs',$this);
		return $this->db->insert_id();
	}
	
	function update_record($id,$data,$translit,$brand){
		
		$this->db->set('title',htmlspecialchars($data['title']));
		$this->db->set('translit',$translit);
		$this->db->set('text',$data['text']);
		$this->db->set('html',$data['html']);
		$this->db->where('id',$id);
		$this->db->where('brand',$brand);
		$this->db->update('catalogs');
		return $this->db->affected_rows();
	}
	
	function read_records($brand){
		
		$this->db->where('brand',$brand);
		$query = $this->db->get('catalogs');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function count_records(){
		
		return $this->db->count_all('catalogs');
	}
	
	function read_record($id){
		
		$this->db->where('id',$id);
		$query = $this->db->get('catalogs',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_field_translit($translit,$field,$brand){
			
		$this->db->where('translit',$translit);
		$this->db->where('brand',$brand);
		$query = $this->db->get('catalogs',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function read_field($id,$field){
			
		$this->db->where('id',$id);
		$query = $this->db->get('catalogs',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('catalogs');
		return $this->db->affected_rows();
	}
	
	function delete_records($brand){
	
		$this->db->where('brand',$brand);
		$this->db->delete('catalogs');
		return $this->db->affected_rows();
	}
}