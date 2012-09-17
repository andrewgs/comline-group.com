<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdimages extends CI_Model{

	var $id			= 0;
	var $image		= '';
	var $title		= '';
	var $link		= '';
	var $sort		= 100000;
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data){
			
		$this->title	= htmlspecialchars($data['title']);
		$this->image	= $data['image'];
		$this->link		= $data['link'];
		if(!empty($data['sort'])):
			$this->sort = $data['sort'];
		endif;
		
		$this->db->insert('images',$this);
		return $this->db->insert_id();
	}
	
	function update_record($id,$data){
		
		$this->db->set('title',htmlspecialchars($data['title']));
		$this->db->set('link',$data['link']);
		if(isset($data['image'])):
			$this->db->set('image',$data['image']);
		endif;
		if(empty($data['sort'])):
			$this->db->set('sort',100000);
		else:
			$this->db->set('sort',$data['sort']);
		endif;
		$this->db->where('id',$id);
		$this->db->update('images');
		return $this->db->affected_rows();
	}
	
	function read_records(){
		
		$this->db->select('id,title,link,sort');
		$this->db->order_by('sort');
		$this->db->order_by('id');
		$query = $this->db->get('images');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function read_record($id){
		
		$this->db->select('id,title,link,sort');
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