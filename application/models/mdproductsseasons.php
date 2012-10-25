<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdproductsseasons extends CI_Model{

	var $id			= 0;
	var $product	= 0;
	var $season		= 0;
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($product,$season){
			
		$this->product = $product;
		$this->season = $season;
		
		$this->db->insert('products_seasons',$this);
		return $this->db->insert_id();
	}
	
	function group_insert($product,$seasons){
		$query = '';
		for($i=0;$i<count($seasons);$i++):
			$query .= '('.$product.','.$seasons[$i]['seasons'].')';
			if($i+1<count($seasons)):
				$query.=',';
			endif;
		endfor;
		$this->db->query("INSERT INTO products_seasons (product,season) VALUES ".$query);
	}
	
	function read_records($product){
		
		$this->db->where('product',$product);
		$query = $this->db->get('products_seasons');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function count_records(){
		
		return $this->db->count_all('products_seasons');
	}
	
	function read_record($id){
		
		$this->db->where('id',$id);
		$query = $this->db->get('products_seasons',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_field($id,$field){
			
		$this->db->where('id',$id);
		$query = $this->db->get('products_seasons',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('products_seasons');
		return $this->db->affected_rows();
	}
	
	function delete_season_records($season){
	
		$this->db->where('season',$season);
		$this->db->delete('products_seasons');
		return $this->db->affected_rows();
	}

	function delete_product_records($product){
	
		$this->db->where('product',$product);
		$this->db->delete('products_seasons');
		return $this->db->affected_rows();
	}
}