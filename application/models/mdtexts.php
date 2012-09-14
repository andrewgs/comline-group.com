<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdtexts extends CI_Model{

	var $id		= 0;
	var $text	= 0;
	var $image	= 0;
	var $noimage= 1;
	var $pageid	= '';
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data,$pageid){
			
		$this->text = $date['text'];
		if($data['image']):
			$this->image = $data['image'];
			$this->noimage = 0;
		else:
			$this->image = '';
			$this->noimage = 1;
		endif;
		$this->pageid = $pageid;
		
		$this->db->insert('texts',$this);
		return $this->db->insert_id();
	}
	
	function update_record($id,$data){
		
		$this->db->set('text',$data['text']);
		$this->db->set('noimage',$noimage);
		if(isset($data['image'])):
			$this->db->set('image',$data['image']);
		endif;
		$this->db->where('id',$id);
		$this->db->update('texts');
		return $this->db->affected_rows();
	}
	
	
	function read_records(){
		
		$this->db->order_by('id');
		$query = $this->db->get('texts');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function count_records(){
		
		return $this->db->count_all('texts');
	}
	
	function read_record($id){
		
		$this->db->where('id',$id);
		$query = $this->db->get('texts',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_field($id,$field){
			
		$this->db->where('id',$id);
		$query = $this->db->get('texts',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function update_field($id,$field,$value){
			
		$this->db->set($field,$value);
		$this->db->where('id',$id);
		$this->db->update('texts');
		return $this->db->affected_rows();
	}
	
	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('texts');
		return $this->db->affected_rows();
	}
	
	function get_image($id){
		
		$this->db->where('id',$id);
		$this->db->select('image');
		$query = $this->db->get('texts');
		$data = $query->result_array();
		return $data[0]['image'];
	}
}