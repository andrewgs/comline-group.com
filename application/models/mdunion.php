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
	
	function read_products_in_brends($gender,$brands,$category){
		
		$gin = '';
		if($gender == 2):
			$gin = '0,1,2';
		else:
			$gin = $gender;
		endif;
		
		$bin = '';$cin = '';
		for($i=0;$i<count($brands);$i++):
			$bin .=$brands[$i];
			if(isset($brands[$i+1])):
				$bin .= ',';
			endif;
		endfor;
		for($i=0;$i<count($category);$i++):
			$cin .=$category[$i];
			if(isset($category[$i+1])):
				$cin .= ',';
			endif;
		endfor;
		$query = "SELECT products.id,products.translit,products.title,products_category.category,products.gender,products.brand,brands.title AS btitle,products_images.id AS imgid FROM products INNER JOIN brands ON products.brand = brands.id INNER JOIN products_images ON products.id = products_images.product_id INNER JOIN products_category ON products.id = products_category.product WHERE products.gender IN ($gin) AND products.brand IN ($bin) AND products_category.category IN ($cin) AND products_images.main = 1 AND products.showitem = 1 ORDER BY products_category.category, products.date DESC,products.title";
//		print_r($query);
		$query = $this->db->query($query);
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
}