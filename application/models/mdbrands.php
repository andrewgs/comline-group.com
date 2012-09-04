<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdbrands extends CI_Model{

	var $id			= 0;
	var $title		= '';
	var $translit	= '';
	var $image		= '';
	var $pdf		= '';
	var $text		= '';
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data,$translit){
			
		$this->title	= htmlspecialchars($data['title']);
		$this->translit	= $translit;
		$this->image	= $data['image'];
		$this->pdf		= $data['pdf'];
		$this->text		= $data['text'];
		
		$this->db->insert('brands',$this);
		return $this->db->insert_id();
	}
	
	function update_record($id,$data,$translit){
		
		$this->db->set('title',htmlspecialchars($data['title']));
		$this->db->set('translit',$translit);
		if(isset($data['image'])):
			$this->db->set('image',$data['image']);
		endif;
		if(isset($data['pdf'])):
			$this->db->set('pdf',$data['pdf']);
		endif;
		$this->db->where('id',$id);
		$this->db->update('brands');
		return $this->db->affected_rows();
	}
	
	function read_records(){
		
		$this->db->select('id,title,translit,text,pdf');
		$this->db->order_by('id');
		$query = $this->db->get('brands');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function read_records_rand_limit($count){
		
		$query = "SELECT id,title,translit,text,pdf FROM brands ORDER BY RAND() LIMIT $count";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function count_records(){
		
		return $this->db->count_all('brands');
	}
	
	function read_record($id){
		
		$this->db->select('id,title,translit,text,pdf');
		$this->db->where('id',$id);
		$query = $this->db->get('brands',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_field($id,$field){
			
		$this->db->where('id',$id);
		$query = $this->db->get('brands',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function read_field_translit($translit,$field){
			
		$this->db->where('translit',$translit);
		$query = $this->db->get('brands',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('brands');
		return $this->db->affected_rows();
	}
	
	function get_image($id){
		
		$this->db->where('id',$id);
		$this->db->select('image');
		$query = $this->db->get('brands');
		$data = $query->result_array();
		return $data[0]['image'];
	}
}