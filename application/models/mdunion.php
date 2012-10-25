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
	
	function read_products_in_brends($gender,$brands,$seasons,$category,$count,$from){
		
		$gin = '';
		if($gender == 2):
			$gin = '0,1,2';
		else:
			$gin = $gender;
		endif;
		
		$bin = $sin = $cin = '';
		for($i=0;$i<count($brands);$i++):
			$bin .=$brands[$i];
			if(isset($brands[$i+1])):
				$bin .= ',';
			endif;
		endfor;
		for($i=0;$i<count($seasons);$i++):
			$sin .=$seasons[$i];
			if(isset($seasons[$i+1])):
				$sin .= ',';
			endif;
		endfor;
		for($i=0;$i<count($category);$i++):
			$cin .=$category[$i];
			if(isset($category[$i+1])):
				$cin .= ',';
			endif;
		endfor;
		$query = "SELECT products.id,products.translit,products.title,products_category.category,products.gender,products.brand,brands.title AS btitle,products_images.id AS imgid,products_seasons.season AS season FROM products INNER JOIN brands ON products.brand = brands.id INNER JOIN products_images ON products.id = products_images.product_id INNER JOIN products_category ON products.id = products_category.product INNER JOIN products_seasons ON products.id = products_seasons.product WHERE products.gender IN ($gin) AND products.brand IN ($bin) AND products_category.category IN ($cin) AND products_seasons.season IN ($sin) AND products_images.main = 1 AND products.showitem = 1 ORDER BY products_category.category, products.id LIMIT $from,$count";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function count_products_in_brends($gender,$brands,$seasons,$category){
		
		$gin = '';
		if($gender == 2):
			$gin = '0,1,2';
		else:
			$gin = $gender;
		endif;
		
		$bin = $sin = $cin = '';
		for($i=0;$i<count($brands);$i++):
			$bin .=$brands[$i];
			if(isset($brands[$i+1])):
				$bin .= ',';
			endif;
		endfor;
		for($i=0;$i<count($seasons);$i++):
			$sin .=$seasons[$i];
			if(isset($seasons[$i+1])):
				$sin .= ',';
			endif;
		endfor;
		for($i=0;$i<count($category);$i++):
			$cin .=$category[$i];
			if(isset($category[$i+1])):
				$cin .= ',';
			endif;
		endfor;
		$query = "SELECT products.id,products.translit,products.title,products_category.category,products.gender,products.brand,brands.title AS btitle,products_images.id AS imgid FROM products INNER JOIN brands ON products.brand = brands.id INNER JOIN products_images ON products.id = products_images.product_id INNER JOIN products_category ON products.id = products_category.product INNER JOIN products_seasons ON products.id = products_seasons.product WHERE products.gender IN ($gin) AND products.brand IN ($bin) AND products_category.category IN ($cin) AND products_seasons.season IN ($sin) AND products_images.main = 1 AND products.showitem = 1";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if(count($data)) return count($data);
		return NULL;
	}
	
	function read_products_slider($gender,$brand,$category){
		
		if($gender == 2):
			$gender = '0,1,2';
		endif;
		
		$query = "SELECT products.id,products.translit FROM products INNER JOIN products_category ON products.id = products_category.product INNER JOIN products_images ON products.id = products_images.product_id WHERE gender IN ($gender) AND brand = $brand AND products_category.category = $category AND products.showitem = 1 AND products_images.main = 1";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function read_showed_category($gender,$brands){
		
		$gin = '';
		if($gender == 2):
			$gin = '0,1,2';
		else:
			$gin = $gender;
		endif;
		
		$bin = '';
		for($i=0;$i<count($brands);$i++):
			$bin .=$brands[$i];
			if(isset($brands[$i+1])):
				$bin .= ',';
			endif;
		endfor;
		
		$query = "SELECT category.id FROM category,products_category,products,products_images WHERE category.id = products_category.category AND products_category.product = products.id AND products_images.product_id = products.id AND products.gender IN ($gin) AND products.brand IN ($bin) AND products_images.main = 1 AND category.showitem = 1 GROUP BY category.id";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
}