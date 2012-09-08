<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdproductsimages extends CI_Model{

	var $id			= 0;
	var $image		= '';
	var $title		= '';
	var $product_id	= '';
	var $main		= '';
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data,$product_id){
			
//		$this->title		= htmlspecialchars($data['title']);
		$this->image		= $data['image'];
		$this->product_id	= $product_id;
		$this->main			= $data['main'];
		
		$this->db->insert('products_images',$this);
		return $this->db->insert_id();
	}
	
	function read_records($product_id){
		
		$this->db->select('id,title,product_id,main');
		$this->db->where_in('product_id',$product_id);
		$query = $this->db->get('products_images');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function read_record($id){
		
		$this->db->select('id,title,product_id,main');
		$this->db->where('id',$id);
		$query = $this->db->get('products_images',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_field($id,$field){
			
		$this->db->where('id',$id);
		$query = $this->db->get('products_images',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function read_main($product_id){
	
		$this->db->select('id');
		$this->db->where('product_id',$product_id);
		$this->db->where('main',1);
		$query = $this->db->get('products_images',1);
		$data = $query->result_array();
		if(isset($data[0]['id'])) return $data[0]['id'];
		return FALSE;
	}
	
	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('products_images');
		return $this->db->affected_rows();
	}
	
	function delete_records($product_id){
	
		$this->db->where('product_id',$product_id);
		$this->db->delete('products_images');
		return $this->db->affected_rows();
	}
	
	function update_field($id,$field,$parametr){
		
		$this->db->set($field,$parametr);
		$this->db->where('id',$id);
		$this->db->update('products_images');
		return $this->db->affected_rows();
	}
	
	function get_image($mid){
		
		$this->db->where('id',$mid);
		$this->db->select('image');
		$query = $this->db->get('products_images');
		$data = $query->result_array();
		return $data[0]['image'];
	}
}