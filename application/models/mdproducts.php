<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdproducts extends CI_Model{

	var $id			= 0;
	var $title		= '';
	var $translit	= '';
	var $date		= '';
	var $showitem	= '';
	var $art		= '';
	var $composition= '';
	var $text		= '';
	var $gender		= 2;
	var $category	= '';
	var $brand		= '';
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data,$gender,$translit){
			
		$this->title	= htmlspecialchars($data['title']);
		$this->composition	= htmlspecialchars($data['composition']);
		$this->translit	= $translit;
		$this->date		= date("Y-m-d");
		$this->showitem = $data['showitem'];
		$this->art		= $data['art'];
		$this->text		= $data['text'];
		$this->gender	= $gender;
		$this->category	= $data['category'];
		$this->brand	= $data['brand'];
		
		$this->db->insert('products',$this);
		return $this->db->insert_id();
	}
	
	function update_record($id,$data,$translit){
		
		$this->db->set('title',htmlspecialchars($data['title']));
		$this->db->set('composition',htmlspecialchars($data['composition']));
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
		$this->db->where('showitem',1);
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
		$this->db->where('showitem',1);
		$query = $this->db->get('products',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_slider($gender,$brand,$category){
		
		$this->db->select('id,translit');
		if($gender == 2):
			$this->db->where_in('gender',array(0,1,2));
		else:
			$this->db->where('gender',$gender);
		endif;
		$this->db->where('category',$category);
		$this->db->where('brand',$brand);
		$this->db->where('showitem',1);
		$query = $this->db->get('products');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function read_field($id,$field){
			
		$this->db->where('id',$id);
		$query = $this->db->get('products',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function read_field_translit($translit,$field,$gender,$brand,$category){
			
		$this->db->where('translit',$translit);
		if($gender == 2):
			$this->db->where_in('gender',array(0,1,2));
		else:
			$this->db->where('gender',$gender);
		endif;
		$this->db->where('category',$category);
		$this->db->where('brand',$brand);
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
	
	function delete_records_category($category){
	
		$this->db->where('category',$category);
		$this->db->delete('products');
		return $this->db->affected_rows();
	}
	
	function delete_records_brand($brand){
	
		$this->db->where('brand',$brand);
		$this->db->delete('products');
		return $this->db->affected_rows();
	}

	function read_limit_records($count,$from){
		
		$this->db->limit($count,$from);
		$this->db->where('showitem',1);
		$this->db->order_by('category');
		$this->db->order_by('brand');
		$query = $this->db->get('products');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function read_admin_limit_records($count,$from){
		
		$this->db->limit($count,$from);
		$this->db->order_by('category');
		$this->db->order_by('brand');
		$query = $this->db->get('products');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function read_admin_record($id){
		
		$this->db->where('id',$id);
		$query = $this->db->get('products',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
}