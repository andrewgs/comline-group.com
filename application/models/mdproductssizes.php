<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdproductssizes extends CI_Model{

	var $id			= 0;
	var $product_id	= 0;
	var $sizes_id	= 0;
	var $code		= '';
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data,$product_id,$code){
			
		$this->title = htmlspecialchars($code);
		$this->product_id = $product_id;
		$this->sizes_id = $product_id;
		
		$this->db->insert('products_sizes',$this);
		return $this->db->insert_id();
	}
	
	function group_insert($product_id,$data){
		$query = '';
		for($i=0;$i<count($data);$i++):
			$query .= '('.$product_id.','.$data[$i]['sizes_id'].',"'.$data[$i]['code'].'")';
			if($i+1<count($data)):
				$query.=',';
			endif;
		endfor;
		$this->db->query("INSERT INTO products_sizes (product_id,sizes_id,code) VALUES ".$query);
	}
	
	function read_records($product_id){
		
		$this->db->where('product_id',$product_id);
		$query = $this->db->get('products_sizes');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function count_records(){
		
		return $this->db->count_all('products_sizes');
	}
	
	function read_record($id){
		
		$this->db->where('id',$id);
		$query = $this->db->get('products_sizes',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_field($id,$field){
			
		$this->db->where('id',$id);
		$query = $this->db->get('products_sizes',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('products_sizes');
		return $this->db->affected_rows();
	}
	
	function delete_product_records($product_id){
	
		$this->db->where('product_id',$product_id);
		$this->db->delete('products_sizes');
		return $this->db->affected_rows();
	}
}