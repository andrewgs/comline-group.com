<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Users_interface extends CI_Controller{
	
	var $user = array('uid'=>0,'ulogin'=>'','uemail'=>'');
	var $loginstatus = array('status'=>FALSE);
	var $months = array("01"=>"января","02"=>"февраля","03"=>"марта","04"=>"апреля","05"=>"мая","06"=>"июня","07"=>"июля","08"=>"августа","09"=>"сентября","10"=>"октября","11"=>"ноября","12"=>"декабря");
	
	function __construct(){
		
		parent::__construct();
		$this->load->model('mdadmins');
		$this->load->model('mdunion');
		$this->load->model('mdbrands');
		$this->load->model('mdcategory');
		$this->load->model('mdcolors');
		$this->load->model('mdevents');
		$this->load->model('mdproducts');
		$this->load->model('mdproductscolors');
		$this->load->model('mdproductsimages');
		$this->load->model('mdproductssizes');
		$this->load->model('mdrss');
		$this->load->model('mdtexts');
		$this->load->model('mdstorage');
		$this->load->model('mdmails');
		
		$cookieuid = $this->session->userdata('logon');
		if(isset($cookieuid) and !empty($cookieuid)):
			$this->user['uid'] = $this->session->userdata('userid');
			if($this->user['uid']):
				$userinfo = $this->mdadmins->read_record($this->user['uid']);
				if($userinfo):
					$this->user['ulogin']			= $userinfo['login'];
					$this->user['uemail']			= '';
					$this->loginstatus['status'] 	= TRUE;
				endif;
			endif;
			
			if($this->session->userdata('logon') != md5($userinfo['login'])):
				$this->loginstatus['status'] = FALSE;
				$this->user = array();
			endif;
		endif;
	}
	
	public function index(){
		
		$pagevar = array(
			'title'			=> 'Комфорт Лайн :: Одежда для дома и отдыха',
			'description'	=> '',
			'author'		=> '',
			'baseurl' 		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'category'		=> $this->mdcategory->read_showed_records(),
			'brands'		=> $this->mdbrands->read_records_rand_limit(4),
			'news'			=> $this->mdevents->read_records_limit(array(1),3,0),
			'stock'			=> $this->mdevents->read_records_limit(array(2),3,0),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		for($i=0;$i<count($pagevar['news']);$i++):
			$pagevar['news'][$i]['date'] = $this->operation_dot_date($pagevar['news'][$i]['date']);
			$pagevar['news'][$i]['text'] = strip_tags($pagevar['news'][$i]['text']);
			if(mb_strlen($pagevar['news'][$i]['text'],'UTF-8') > 150):
				$pagevar['news'][$i]['text'] = mb_substr($pagevar['news'][$i]['text'],0,150,'UTF-8');
				$pos = mb_strrpos($pagevar['news'][$i]['text'],' ',0,'UTF-8');
				$pagevar['news'][$i]['text'] = mb_substr($pagevar['news'][$i]['text'],0,$pos,'UTF-8');
				$pagevar['news'][$i]['text'] .= ' ... ';
			endif;
		endfor;
		for($i=0;$i<count($pagevar['stock']);$i++):
			$pagevar['stock'][$i]['date'] = $this->operation_dot_date($pagevar['stock'][$i]['date']);
			$pagevar['stock'][$i]['text'] = strip_tags($pagevar['stock'][$i]['text']);
			if(mb_strlen($pagevar['stock'][$i]['text'],'UTF-8') > 150):
				$pagevar['stock'][$i]['text'] = mb_substr($pagevar['stock'][$i]['text'],0,150,'UTF-8');
				$pos = mb_strrpos($pagevar['stock'][$i]['text'],' ',0,'UTF-8');
				$pagevar['stock'][$i]['text'] = mb_substr($pagevar['stock'][$i]['text'],0,$pos,'UTF-8');
				$pagevar['stock'][$i]['text'] .= ' ... ';
			endif;
		endfor;
		$this->load->view("users_interface/index",$pagevar);
	}
	
	public function admin_login(){
	
		$pagevar = array(
			'title'			=> 'Комфорт Лайн | Авторизация',
			'description'	=> '',
			'author'		=> '',
			'baseurl' 		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			$_POST['submit'] == NULL;
			$user = $this->mdadmins->auth_user($this->input->post('login'),$this->input->post('password'));
			if(!$user):
				$this->session->set_userdata('msgr','Имя пользователя и пароль не совпадают');
				redirect($this->uri->uri_string());
			else:
				$session_data = array('logon'=>md5($user['login']),'userid'=>$user['id']);
				$this->session->set_userdata($session_data);
				redirect("admin-panel/actions/control");
			endif;
		endif;
		
		if($this->loginstatus['status']):
			redirect('admin-panel/actions/control');
		endif;
		
		$this->load->view("admin_interface/login",$pagevar);
	}

	/******************************************************** functions ******************************************************/	
	
	public function viewimage(){
		
		$section = $this->uri->segment(1);
		$id = $this->uri->segment(3);
		switch ($section):
			case 'news' 	: $image = $this->mdevents->get_image($id); break;
			case 'stock' 	: $image = $this->mdevents->get_image($id); break;
			case 'brands' 	: $image = $this->mdbrands->get_image($id); break;
		endswitch;
		header('Content-type: image/gif');
		echo $image;
	}
	
	public function operation_date($field){
			
		$list = preg_split("/-/",$field);
		$nmonth = $this->months[$list[1]];
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5 $nmonth \$1 г."; 
		return preg_replace($pattern, $replacement,$field);
	}
	
	public function operation_dot_date($field){
			
		$list = preg_split("/-/",$field);
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5.$3.\$1"; 
		return preg_replace($pattern, $replacement,$field);
	}

	public function operation_no_year($field){
			
		$list = preg_split("/-/",$field);
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5.$3"; 
		return preg_replace($pattern, $replacement,$field);
	}

}