<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdproducts extends CI_Model{

	var $id			= 0;
	var $title		= '';
	var $translit	= '';
	var $date		= '';
	var $showitem	= '';
	var $art		= '';
	var $text		= '';
	var $gender		= 2;
	var $category	= '';
	var $brand		= '';
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data,$translit){
			
		$this->title	= htmlspecialchars($data['title']);
		$this->translit	= $translit;
		$this->date		= date("Y-m-d");
		$this->showitem = $data['showitem'];
		$this->art		= $data['art'];
		$this->text		= $data['text'];
		$this->gender	= $data['gender'];
		$this->category	= $data['category'];
		$this->brand	= $data['brand'];
		
		$this->db->insert('products',$this);
		return $this->db->insert_id();
	}
	
	function update_record($id,$data,$translit){
		
		$this->db->set('title',htmlspecialchars($data['title']));
		$this->db->set('translit',$translit);
		$this->db->set('showitem',$data['showitem']);
		$this->db->set('art',$data['art']);
		$this->db->set('text',$data['text']);
		$this->db->set('gender',$data['gender']);
		$this->db->set('category',$data['category']);
		$this->db->set('brand',$data['brand']);
		
		$this->db->where('id',$id);
		$this->db->update('products');
		return $this->db->affected_rows();
	}
	
	function read_records(){
		
		$this->db->order_by('id');
		$query = $this->db->get('products');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function count_records(){
		
		return $this->db->count_all('products');
	}
	
	function read_record($id){
		
		$this->db->where('id',$id);
		$query = $this->db->get('products',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_field($id,$field){
			
		$this->db->where('id',$id);
		$query = $this->db->get('products',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function read_field_translit($translit,$field){
			
		$this->db->where('translit',$translit);
		$query = $this->db->get('products',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('products');
		return $this->db->affected_rows();
	}
}