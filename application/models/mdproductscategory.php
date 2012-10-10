<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdproductscategory extends CI_Model{

	var $id			= 0;
	var $product	= 0;
	var $category	= 0;
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data,$product,$category){
			
		$this->product = $product;
		$this->category = $category;
		
		$this->db->insert('products_category',$this);
		return $this->db->insert_id();
	}
	
	function group_insert($product,$data){
		$query = '';
		for($i=0;$i<count($data);$i++):
			$query .= '('.$product.','.$data[$i]['category'].')';
			if($i+1<count($data)):
				$query.=',';
			endif;
		endfor;
		$this->db->query("INSERT INTO products_category (product,category) VALUES ".$query);
	}
	
	function read_records($product){
		
		$this->db->where('product',$product);
		$query = $this->db->get('products_category');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function count_records(){
		
		return $this->db->count_all('products_category');
	}
	
	function read_record($id){
		
		$this->db->where('id',$id);
		$query = $this->db->get('products_category',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_field($id,$field){
			
		$this->db->where('id',$id);
		$query = $this->db->get('products_category',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('products_category');
		return $this->db->affected_rows();
	}
	
	function delete_category_records($category){
	
		$this->db->where('category',$category);
		$this->db->delete('products_category');
		return $this->db->affected_rows();
	}

	function delete_product_records($product){
	
		$this->db->where('product',$product);
		$this->db->delete('products_category');
		return $this->db->affected_rows();
	}
}