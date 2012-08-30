<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdimages extends CI_Model{

	var $id			= 0;
	var $image		= '';
	var $title		= '';
	var $pageid		= '';
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data,$pageid){
			
		$this->title	= htmlspecialchars($data['title']);
		$this->image	= $data['image'];
		$this->pageid	= $pageid;
		
		$this->db->insert('images',$this);
		return $this->db->insert_id();
	}
	
	function read_records($pageid){
		
		$this->db->select('id,title,pageid');
		$this->db->where_in('pageid',$pageid);
		$query = $this->db->get('images');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function read_record($id){
		
		$this->db->select('id,title,pageid');
		$this->db->where('id',$id);
		$query = $this->db->get('images',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_field($id,$field){
			
		$this->db->where('id',$id);
		$query = $this->db->get('images',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('images');
		return $this->db->affected_rows();
	}
	
	function get_image($mid){
		
		$this->db->where('id',$mid);
		$this->db->select('image');
		$query = $this->db->get('images');
		$data = $query->result_array();
		return $data[0]['image'];
	}
}