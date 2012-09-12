<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdevents extends CI_Model{

	var $id			= 0;
	var $title		= '';
	var $type		 = '';
	var $translit	= '';
	var $text 		= '';
	var $date		= '';
	var $image		= '';
	var $noimage	= 0;
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data,$translit){
			
		$this->title	= htmlspecialchars($data['title']);
		$this->type		= $data['type'];
		$this->translit	= $translit;
		$this->text		= $data['text'];
		$this->date		= date("Y-m-d");
		if($data['image']):
			$this->image	= $data['image'];
			$this->noimage = 1;
		else:
			$this->image = '';
			$this->noimage = 1;
		endif;
		
		$this->db->insert('events',$this);
		return $this->db->insert_id();
	}
	
	function update_record($id,$data,$translit,$noimage){
		
		$this->db->set('title',htmlspecialchars($data['title']));
		$this->db->set('translit',$translit);
		$this->db->set('text',$data['text']);
		$this->db->set('noimage',$noimage);
		if(isset($data['image'])):
			$this->db->set('image',$data['image']);
		endif;
		$this->db->where('id',$id);
		$this->db->update('events');
		return $this->db->affected_rows();
	}
	
	function read_records($types){
		
		$this->db->select('id,title,text,date,translit,noimage,type');
		$this->db->where_in('type',$types);
		$this->db->order_by('date','DESC');
		$query = $this->db->get('events');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function read_records_limit($types,$count,$from){
		
		$this->db->select('id,title,text,date,translit,noimage,type');
		$this->db->where_in('type',$types);
		$this->db->order_by('date','DESC');
		$this->db->limit($count,$from);
		$query = $this->db->get('events');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function count_records($types){
		
		$this->db->select('COUNT(*) AS cnt');
		$this->db->where_in('type',$types);
		$this->db->order_by('date','DESC');
		$query = $this->db->get('events');
		$data = $query->result_array();
		if(isset($data[0]['cnt'])) return $data[0]['cnt'];
		return 0;
	}
	
	function read_record($id,$types){
		
		$this->db->select('id,title,text,date,translit,noimage,type');
		$this->db->where('id',$id);
		$this->db->where_in('type',$types);
		$query = $this->db->get('events',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_field($id,$field){
			
		$this->db->where('id',$id);
		$query = $this->db->get('events',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function read_field_translit($translit,$field){
			
		$this->db->where('translit',$translit);
		$query = $this->db->get('events',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('events');
		return $this->db->affected_rows();
	}
	
	function get_image($mid){
		
		$this->db->where('id',$mid);
		$this->db->select('image');
		$query = $this->db->get('events');
		$data = $query->result_array();
		return $data[0]['image'];
	}
}