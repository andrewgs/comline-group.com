<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdbrandseasons extends CI_Model{

	var $id		= 0;
	var $brand	= 0;
	var $season	= 0;
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($brand,$season){
			
		$this->brand = $brand;
		$this->season = $season;
		
		$this->db->insert('brand_seasons',$this);
		return $this->db->insert_id();
	}
	
	function group_insert($brand,$seasons){
		$query = '';
		for($i=0;$i<count($seasons);$i++):
			$query .= '('.$brand.','.$seasons[$i]['sid'].')';
			if($i+1<count($seasons)):
				$query.=',';
			endif;
		endfor;
		$this->db->query("INSERT INTO brand_seasons (brand,season) VALUES ".$query);
	}
	
	function read_records($brand){
		
		$this->db->where('brand',$brand);
		$query = $this->db->get('brand_seasons');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function read_all_records(){
		
		$this->db->order_by('season');
		$query = $this->db->get('brand_seasons');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function count_records(){
		
		return $this->db->count_all('brand_seasons');
	}
	
	function read_record($id){
		
		$this->db->where('id',$id);
		$query = $this->db->get('brand_seasons',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_field($id,$field){
			
		$this->db->where('id',$id);
		$query = $this->db->get('brand_seasons',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('brand_seasons');
		return $this->db->affected_rows();
	}
	
	function delete_brand_records($brand){
	
		$this->db->where('brand',$brand);
		$this->db->delete('brand_seasons');
		return $this->db->affected_rows();
	}

	function delete_season_records($season){
	
		$this->db->where('season',$seasons);
		$this->db->delete('brand_seasons');
		return $this->db->affected_rows();
	}
}