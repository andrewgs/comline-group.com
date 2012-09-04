<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdunion extends CI_Model{

	function __construct(){
		parent::__construct();
	}
	
	function events_limit($count,$from){
		
		$query = "SELECT id,title,translit,text,date,type FROM events ORDER BY date DESC,id DESC LIMIT $from,$count";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function events_type_limit($type,$count,$from){
		
		$query = "SELECT id,title,translit,text,date,type FROM events WHERE type = $type ORDER BY date DESC,id DESC LIMIT $from,$count";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function events_type_without_limit($type,$without,$count,$from){
		
		$query = "SELECT id,title,translit,text,date,type FROM events WHERE type = $type AND id != $without ORDER BY date DESC,id DESC LIMIT $from,$count";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
}