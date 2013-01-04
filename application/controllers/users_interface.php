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
		$this->load->model('mdproductscategory');
		$this->load->model('mdrss');
		$this->load->model('mdtexts');
		$this->load->model('mdstorage');
		$this->load->model('mdmails');
		$this->load->model('mdimages');
		$this->load->model('mdcatalogs');
		$this->load->model('mdseasons');
		$this->load->model('mdbrandseasons');
		$this->load->model('mdproductsseasons');
		
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
			'title'			=> 'Моделирующее белье | Антибактериальное бесшовное нижнее белье | Женская и мужская домашняя одежда | Ночные пижамы, одежда для беременных',
			'description'	=> '',
			'author'		=> '',
			'baseurl' 		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'baners'		=> $this->mdimages->read_records(),
			'category'		=> $this->mdcategory->read_showed_records(),
			//'brands'		=> $this->mdbrands->read_records_rand_limit(4),
			'brands'		=> $this->mdbrands->read_records(),
			'news'			=> $this->mdevents->read_records_limit(array(1),3,0),
			'stock'			=> $this->mdevents->read_records_limit(array(2),3,0),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('ssubmit')):
			unset($_POST['ssubmit']);
			$this->form_validation->set_rules('email',' ','required|valid_email|trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				$this->index();
				return FALSE;
			else:
				$sid = $this->mdrss->insert_record($_POST);
				if($sid):
					$this->session->set_userdata('msgs','Вы подписались. Спасибо!');
				endif;
				redirect($this->uri->uri_string());
			endif;
		endif;
		
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
	
	public function send_mail(){
		
		$statusval = array('status'=>FALSE,'message'=>'Сообщение не отправлено');
		$data = trim($this->input->post('postdata'));
		if(!$data):
			show_404();
		endif;
		$data = preg_split("/&/",$data);
		for($i=0;$i<count($data);$i++):
			$dataid = preg_split("/=/",$data[$i]);
			$dataval[$i] = $dataid[1];
		endfor;
		if($dataval):
			ob_start();
			if($this->uri->segment(2) == 'partners'):
				?>
				<p>Сообщение от <?=$dataval[1];?></p>
				<p>Компания: <?=$dataval[0];?></p>
				<p>Email: <?=$dataval[2];?></p>
				<p>Контактный номер: <?=$dataval[3];?></p>
				<p>Сообщение: <?=$dataval[4];?></p>
				<?
				$uemail = $dataval[2];
			else:
				?>
				<p>Сообщение от <?=$dataval[0];?></p>
				<p>Контактный номер: <?=$dataval[1];?></p>
				<p>Сообщение: <?=$dataval[2];?></p>
				<?
				$uemail = 'robot@comfline.ru';
			endif;
			$mailtext = ob_get_clean();
			$this->email->clear(TRUE);
			$config['smtp_host'] = 'localhost';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			
			$this->email->initialize($config);
			$this->email->to('sale@comline-group.com');
			$this->email->from('robot@comfline.ru','Пользователь сайта');
			$this->email->bcc('');
			$this->email->subject('Сообщение от пользователя');
			if($this->uri->segment(2) == 'partners'):
				$this->email->subject('Форма "Стать партнером"');
			else:
				$this->email->subject('Форма "Заказать звонок"');
			endif;
			$this->email->message($mailtext);
			if($this->email->send()):
				$statusval['status'] = TRUE;
			endif;
		endif;
		echo json_encode($statusval);
	}
	
	public function about(){
		
		$pagevar = array(
			'title'			=> 'Комфорт Лайн | О компании | Корректирующее белье оптом, пижамы, халаты, домашняя одежда, утягивающее бесшовное белье, одежда на каждый день',
			'description'	=> '',
			'author'		=> '',
			'baseurl' 		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'text'			=> $this->mdtexts->read_field(5,'text'),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		$this->load->view("users_interface/about",$pagevar);
	}
	
	public function vakansii(){
		
		$pagevar = array(
			'title'			=> 'Комфорт Лайн | Вакансии компании в Москве и регионах России',
			'description'	=> '',
			'author'		=> '',
			'baseurl' 		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'text'			=> $this->mdtexts->read_field(6,'text'),
			'noimage'		=> $this->mdtexts->read_field(6,'noimage'),
			'image'			=> 6,
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		$this->load->view("users_interface/vakansii",$pagevar);
	}
	
	public function view_news(){
		
		$news = $this->mdevents->read_field_translit($this->uri->segment(2),'id');
		if(!$news):
			redirect('');
		endif;
		$pagevar = array(
			'title'			=> 'Новости компании | Модное антибактериальное нижнее бесшовное белье, домашние летние яркие коллекции | Белье и одежда на каждый день',
			'description'	=> '',
			'author'		=> '',
			'baseurl' 		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'events'		=> $this->mdevents->read_record($news,array(1)),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		$pagevar['title'] .= $pagevar['events']['title'];
		$pagevar['events']['date'] = $this->operation_dot_date($pagevar['events']['date']);
		$this->load->view("users_interface/view-events",$pagevar);
	}
	
	public function view_stock(){
		
		$stock = $this->mdevents->read_field_translit($this->uri->segment(2),'id');
		if(!$stock):
			redirect('');
		endif;
		$pagevar = array(
			'title'			=> 'Комфорт Лайн | Акции и информация о скидках',
			'description'	=> '',
			'author'		=> '',
			'baseurl' 		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'events'		=> $this->mdevents->read_record($stock,array(2)),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		$pagevar['title'] .= $pagevar['events']['title'];
		$pagevar['events']['date'] = $this->operation_dot_date($pagevar['events']['date']);
		$this->load->view("users_interface/view-events",$pagevar);
	}
	
	public function all_news(){
		
		$from = intval($this->uri->segment(3));
		$pagevar = array(
			'title'			=> 'Новости компании | Модное антибактериальное нижнее бесшовное белье, домашние летние яркие коллекции | Белье и одежда на каждый день',
			'description'	=> '',
			'author'		=> '',
			'baseurl' 		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'events'		=> $this->mdevents->read_records_limit(array(1),5,$from),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		$config['base_url'] 		= $pagevar['baseurl'].'all-news/from/';
		$config['uri_segment'] 		= 3;
		$config['total_rows'] 		= $this->mdevents->count_records(array(1));
		$config['per_page'] 		= 5;
		$config['num_links'] 		= 4;
		$config['first_link']		= 'В начало';
		$config['last_link'] 		= 'В конец';
		$config['next_link'] 		= 'Далее &raquo;';
		$config['prev_link'] 		= '&laquo; Назад';
		$config['cur_tag_open']		= '<span class="actpage">';
		$config['cur_tag_close'] 	= '</span>';
		
		$this->pagination->initialize($config);
		$pagevar['pages'] = $this->pagination->create_links();
		
		for($i=0;$i<count($pagevar['events']);$i++):
			$pagevar['events'][$i]['date'] = $this->operation_dot_date($pagevar['events'][$i]['date']);
			$pagevar['events'][$i]['text'] = strip_tags($pagevar['events'][$i]['text']);
			if(mb_strlen($pagevar['events'][$i]['text'],'UTF-8') > 250):
				$pagevar['events'][$i]['text'] = mb_substr($pagevar['events'][$i]['text'],0,250,'UTF-8');
				$pos = mb_strrpos($pagevar['events'][$i]['text'],' ',0,'UTF-8');
				$pagevar['events'][$i]['text'] = mb_substr($pagevar['events'][$i]['text'],0,$pos,'UTF-8');
				$pagevar['events'][$i]['text'] .= ' ... ';
			endif;
		endfor;
		$this->load->view("users_interface/all-events",$pagevar);
	}
	
	public function all_stock(){
		
		$from = intval($this->uri->segment(3));
		$pagevar = array(
			'title'			=> 'Комфорт Лайн | Все акции компании',
			'description'	=> '',
			'author'		=> '',
			'baseurl' 		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'events'		=> $this->mdevents->read_records_limit(array(2),5,$from),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		$config['base_url'] 		= $pagevar['baseurl'].'all-stock/from/';
		$config['uri_segment'] 		= 3;
		$config['total_rows'] 		= $this->mdevents->count_records(array(2));
		$config['per_page'] 		= 5;
		$config['num_links'] 		= 4;
		$config['first_link']		= 'В начало';
		$config['last_link'] 		= 'В конец';
		$config['next_link'] 		= 'Далее &raquo;';
		$config['prev_link'] 		= '&laquo; Назад';
		$config['cur_tag_open']		= '<span class="actpage">';
		$config['cur_tag_close'] 	= '</span>';
		
		$this->pagination->initialize($config);
		$pagevar['pages'] = $this->pagination->create_links();
		
		for($i=0;$i<count($pagevar['events']);$i++):
			$pagevar['events'][$i]['date'] = $this->operation_dot_date($pagevar['events'][$i]['date']);
			$pagevar['events'][$i]['text'] = strip_tags($pagevar['events'][$i]['text']);
			if(mb_strlen($pagevar['events'][$i]['text'],'UTF-8') > 250):
				$pagevar['events'][$i]['text'] = mb_substr($pagevar['events'][$i]['text'],0,250,'UTF-8');
				$pos = mb_strrpos($pagevar['events'][$i]['text'],' ',0,'UTF-8');
				$pagevar['events'][$i]['text'] = mb_substr($pagevar['events'][$i]['text'],0,$pos,'UTF-8');
				$pagevar['events'][$i]['text'] .= ' ... ';
			endif;
		endfor;
		$this->load->view("users_interface/all-events",$pagevar);
	}
	
	public function clients(){
		
		$pagevar = array(
			'title'			=> 'Информация для клиентов и партнеров | Корректирующее утягивающее белье оптом, домашний трикотаж, пижамы, халаты оптом',
			'description'	=> '',
			'author'		=> '',
			'baseurl' 		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'text'			=> array($this->mdtexts->read_field(3,'text'),$this->mdtexts->read_field(4,'text')),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			$_POST['submit'] = NULL;
			$this->form_validation->set_rules('name',' ','required|trim');
			$this->form_validation->set_rules('email',' ','required|valid_email|trim');
			$this->form_validation->set_rules('phone',' ','required|trim');
			$this->form_validation->set_rules('company',' ','required|trim');
			$this->form_validation->set_rules('comments',' ','required|trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Повторите ввод.');
			else:
				ob_start();
				?>
				<p>Сообщение от <?=$_POST['name'];?></p>
				<p>Компания <?=$_POST['company'];?></p>
				<p>Email <?=$_POST['email'];?></p>
				<p>Контактный телефон <?=$_POST['phone'];?></p>
				<p><?=$_POST['comments'];?></p>
				<?
				$mailtext = ob_get_clean();
				
				$this->email->clear(TRUE);
				$config['smtp_host'] = 'localhost';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
				
				$this->email->initialize($config);
				$this->email->to('sale@comline-group.com');
				$this->email->from($_POST['email'],$_POST['name']);
				$this->email->bcc('');
				$this->email->subject('Форма партнерства Комфорт Лайн');
				$this->email->message($mailtext);	
				$this->email->send();
				$this->session->set_userdata('msgs','Сообщение отправлено');
			endif;
			redirect($this->uri->uri_string());
		endif;
		
		$this->load->view("users_interface/clients",$pagevar);
	}
	
	public function brands(){
		
		$pagevar = array(
			'title'			=> 'Мужское и женское корректирующее моделирующее белье | Модная домашняя одежда из Италии | Нижнее утягивающее антибактериальное бесшовное белье | Экологически чистая одежда',
			'description'	=> '',
			'author'		=> '',
			'baseurl' 		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'brands'		=> $this->mdbrands->read_records(),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		for($i=0;$i<count($pagevar['brands']);$i++):
			$pagevar['brands'][$i]['catalogs'] = $this->mdcatalogs->catalog_exist($pagevar['brands'][$i]['id']);
		endfor;
		
		$this->load->view("users_interface/brands",$pagevar);
	}
	
	public function contacts(){
		
		$pagevar = array(
			'title'			=> 'Комфорт Лайн | Контактная информация | Офис компании и шоу-рум',
			'description'	=> '',
			'author'		=> '',
			'baseurl' 		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'text'			=> array($this->mdtexts->read_field(1,'text'),$this->mdtexts->read_field(2,'text')),
			'storage'		=> $this->mdstorage->read_records(),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			$_POST['submit'] = NULL;
			$this->form_validation->set_rules('name',' ','required|trim');
			$this->form_validation->set_rules('email',' ','required|valid_email|trim');
			$this->form_validation->set_rules('comments',' ','required|trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Повторите ввод.');
			else:
				ob_start();
				?>
				<p>Сообщение от <?=$_POST['name'];?></p>
				<p>Email <?=$_POST['email'];?></p>
				<p><?=$_POST['comments'];?></p>
				<?
				$mailtext = ob_get_clean();
				
				$this->email->clear(TRUE);
				$config['smtp_host'] = 'localhost';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
				
				$this->email->initialize($config);
				$this->email->to('sale@comline-group.com');
				$this->email->from($_POST['email'],$_POST['name']);
				$this->email->bcc('');
				$this->email->subject('Форма обратной связи Комфорт Лайн');
				$this->email->message($mailtext);
				$this->email->send();
				$this->session->set_userdata('msgs','Сообщение отправлено');
			endif;
			redirect($this->uri->uri_string());
		endif;
		
		$this->load->view("users_interface/contacts",$pagevar);
	}
	
	public function catalog(){
	
		$pagevar = array(
			'title'			=> 'Пижамы, мужская и женская одежда для отдыха, моделирующее белье, одежда для беременных, домашняя одежда, нижнее корректирующее бесшовное белье',
			'description'	=> '',
			'author'		=> '',
			'baseurl' 		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'brands'		=> $this->mdbrands->read_records_notext(),
			'category'		=> $this->mdcategory->read_showed_records(),
			'seasons'		=> $this->mdseasons->read_records(),
			'brseasons'		=> $this->mdbrandseasons->read_all_records(),
			'products'		=> array(),
			'product_category'=> array(),
			'pages'			=> array(),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->uri->total_segments() > 1):
			switch ($this->uri->segment(2)):
				case 'category': 	$categoryid = $this->mdcategory->read_field_translit($this->uri->segment(3),'id');
									if(!$categoryid):
										redirect('');
									endif;
									$pagevar['title'] = $this->mdcategory->read_field($categoryid,'page_title');
									$pagevar['description'] = $this->mdcategory->read_field($categoryid,'page_description');
									$pagevar['about_category'] = $this->mdcategory->read_field($categoryid,'page_content');
									$this->session->unset_userdata('bid');
									$this->session->unset_userdata('gender');
									$this->session->set_userdata('cid',$categoryid);
									break;
				case 'brands'	:	$brandid = $this->mdbrands->read_field_translit($this->uri->segment(3),'id');
									if(!$brandid):
										redirect('');
									endif;
									$this->session->unset_userdata('gender');
									$this->session->unset_userdata('cid');
									$this->session->set_userdata('bid',$brandid);
									redirect('catalog');
									break;
				case 'come-back':	$urlparam = preg_split('/-/',$this->uri->segment(3));
									
									$this->session->set_userdata('gender',$urlparam[0]);
									$this->session->set_userdata('bid',$urlparam[1]);
									$this->session->set_userdata('cid',$urlparam[2]);
									redirect('catalog');
									break;
				default				: redirect('');
			endswitch;
		endif;
		if(!$this->session->userdata('cid') && !$this->session->userdata('bid')):
			redirect('');
		endif;
		if($this->session->userdata('cid')):
			for($i=0;$i<count($pagevar['category']);$i++):
				if($pagevar['category'][$i]['id'] == $this->session->userdata('cid')):
					$pagevar['category'][$i]['checked'] = 1;
				else:
					$pagevar['category'][$i]['checked'] = 0;
				endif;
			endfor;
			if(!$this->session->userdata('bid')):
				for($i=0;$i<count($pagevar['brands']);$i++):
					$pagevar['brands'][$i]['checked'] = 1;
				endfor;
			endif;
		endif;
		if($this->session->userdata('bid')):
			if(!$this->session->userdata('cid')):
				for($i=0;$i<count($pagevar['category']);$i++):
					$pagevar['category'][$i]['checked'] = 1;
				endfor;
			endif;
			for($i=0;$i<count($pagevar['brands']);$i++):
				if($pagevar['brands'][$i]['id'] == $this->session->userdata('bid')):
					$pagevar['brands'][$i]['checked'] = 1;
				else:
					$pagevar['brands'][$i]['checked'] = 0;
				endif;
			endfor;
		endif;
		if($this->session->userdata('bid')):
			$brands[0] = $this->session->userdata('bid');
		else:
			for($i=0;$i<count($pagevar['brands']);$i++):
				$brands[$i] = $pagevar['brands'][$i]['id'];
			endfor;
		endif;
		$actcategory = $this->mdunion->read_showed_category(2,$brands);
		if($actcategory):
			for($i=0;$i<count($pagevar['category']);$i++):
				$pagevar['category'][$i]['disable'] = 1;
				for($j=0;$j<count($actcategory);$j++):
					if($pagevar['category'][$i]['id'] == $actcategory[$j]['id']):
						$pagevar['category'][$i]['disable'] = 0;
						continue;
					endif;
				endfor;
			endfor;
		else:
			for($i=0;$i<count($pagevar['category']);$i++):
				$pagevar['category'][$i]['disable'] = 1;
			endfor;
		endif;
		$seasons = array();
		foreach($pagevar['seasons'] AS $key=>$season):
			$seasons[$season['id']]['id'] = $season['id'];
			$seasons[$season['id']]['title'] = $season['title'];
			$seasons[$season['id']]['translit'] = $season['translit'];
		endforeach;
		$pagevar['seasons'] = $seasons;
		
		$category = $brands = $seasons = array();
		for($i=0;$i<count($pagevar['category']);$i++):
			if($pagevar['category'][$i]['checked']):
				$category[] = $pagevar['category'][$i]['id'];
			endif;
		endfor;
		for($i=0;$i<count($pagevar['brands']);$i++):
			if($pagevar['brands'][$i]['checked']):
				$brands[] = $pagevar['brands'][$i]['id'];
			endif;
		endfor;
		foreach($pagevar['seasons'] AS $key=>$season):
			$seasons[] = $season['id'];
		endforeach;
		$count = $this->mdunion->count_products_in_brends(2,$brands,$seasons,$category);
		if($count):
			$from = $this->uri->segment(5);
			if(!$from):
				$from = 0;
			endif;
			$pagevar['product_category'] = $this->mdcategory->read_in_records($category);
			$pagevar['products'] = $this->mdunion->read_products_in_brends(2,$brands,$seasons,$category,12,$from);
			$seasons = $this->mdseasons->read_records();
			$stmp = array();
			foreach($seasons AS $key=>$season):
				$stmp[$season['id']]['title'] = $season['title'];
			endforeach;
			$seasons = $stmp;
			for($i=0;$i<count($pagevar['products']);$i++):
				$pagevar['products'][$i]['stitle'] = $seasons[$pagevar['products'][$i]['season']]['title'];
			endfor;
			
			$config['base_url'] 		= base_url().'catalog/category/'.$this->uri->segment(3).'/page-from/';
			$config['uri_segment'] 		= 5;
			$config['total_rows'] 		= $count;
			$config['per_page'] 		= 12;
			$config['num_links'] 		= 4;
			$config['first_link']		= 'В начало';
			$config['last_link'] 		= 'В конец';
			$config['next_link'] 		= 'Далее &raquo;';
			$config['prev_link'] 		= '&laquo; Назад';
			$config['cur_tag_open']		= '<li class="active"><a href="#">';
			$config['cur_tag_close'] 	= '</a></li>';
			$config['full_tag_open'] 	= '<div class="pagination"><ul>';
			$config['full_tag_close'] 	= '</ul></div>';
			$config['first_tag_open'] 	= '<li>';
			$config['first_tag_close'] 	= '</li>';
			$config['last_tag_open'] 	= '<li>';
			$config['last_tag_close'] 	= '</li>';
			$config['next_tag_open'] 	= '<li>';
			$config['next_tag_close'] 	= '</li>';
			$config['prev_tag_open'] 	= '<li>';
			$config['prev_tag_close'] 	= '</li>';
			$config['num_tag_open'] 	= '<li>';
			$config['num_tag_close'] 	= '</li>';
			
			$this->pagination->initialize($config);
			$pagevar['pages'] = $this->pagination->create_links();
		endif;
		$this->load->view("users_interface/catalog",$pagevar);
	}
	
	public function catalogs(){
		
		$brandid = $this->mdbrands->read_field_translit($this->uri->segment(3),'id');
		if(!$brandid):
			redirect('');
		endif;
		$pagevar = array(
			'title'			=> 'Комфорт Лайн | Каталоги брендов',
			'description'	=> '',
			'author'		=> '',
			'baseurl' 		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'brand'			=> $this->mdbrands->read_record($brandid),
			'catalogs'		=> $this->mdcatalogs->read_records($brandid),
			'catalog'		=> array(),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->uri->total_segments() == 3):
			if(isset($pagevar['catalogs'][0]['id'])):
				redirect('catalogs/brands/'.$this->uri->segment(3).'/catalog/'.$pagevar['catalogs'][0]['translit']);
			endif;
		else:
			$catalogid = $this->mdcatalogs->read_field_translit($this->uri->segment(5),'id',$brandid);
			if(!$catalogid):
				redirect('brands');
			endif;
			$pagevar['catalog'] = $this->mdcatalogs->read_record($catalogid);
			if(!count($pagevar['catalog'])):
				redirect('brands');
			endif;
		endif;
		
		$this->load->view("users_interface/catalogs",$pagevar);
	}
	
	public function catalog_load(){
		
		$per_page = 12;
		$pagevar = array('baseurl'=>base_url(),'category'=>array(),'products'=>array(),'pages'=>0,'page'=>0);
		$gender = $this->input->post('gender');
		$brands = $this->input->post('brands');
		$seasons = $this->input->post('seasons');
		$category = $this->input->post('category');
		$page = $this->input->post('page');
		if(!$gender || !$brands || !$seasons || !$page):
			show_404();
		endif;
		
		$pagevar['page'] = $page;
		if($category):
			$gender = preg_split("/&/",$gender);
			for($i=0;$i<count($gender);$i++):
				$genid = preg_split("/=/",$gender[$i]);
				$gender[$i] = $genid[1];
			endfor;
			if(count($gender) == 2):
				$gender = 2;
			else:
				$gender = $gender[0];
			endif;
			$brands = preg_split("/&/",$brands);
			for($i=0;$i<count($brands);$i++):
				$brid = preg_split("/=/",$brands[$i]);
				$brands[$i] = $brid[1];
			endfor;
			$seasons = preg_split("/&/",$seasons);
			for($i=0;$i<count($seasons);$i++):
				$sid = preg_split("/=/",$seasons[$i]);
				$seasons[$i] = $sid[1];
			endfor;
			$seasons = array_unique($seasons);$i=0;
			foreach($seasons AS $key=>$s):
				$snew[$i] = $s;
				$i++;
			endforeach;
			$seasons = $snew;
			$category = preg_split("/&/",$category);
			for($i=0;$i<count($category);$i++):
				$catid = preg_split("/=/",$category[$i]);
				$category[$i] = $catid[1];
			endfor;
			$count = $this->mdunion->count_products_in_brends($gender,$brands,$seasons,$category);
			if($count):
				$from = ($page-1)*$per_page;
				$pagevar['category'] = $this->mdcategory->read_in_records($category);
				$pagevar['products'] = $this->mdunion->read_products_in_brends($gender,$brands,$seasons,$category,$per_page,$from);
				$seasons = $this->mdseasons->read_records();
				
				$stmp = array();
				foreach($seasons AS $key=>$season):
					$stmp[$season['id']]['title'] = $season['title'];
				endforeach;
				$seasons = $stmp;
				
				for($i=0;$i<count($pagevar['products']);$i++):
					$pagevar['products'][$i]['stitle'] = $seasons[$pagevar['products'][$i]['season']]['title'];
				endfor;
				
				$pagevar['pages'] = ceil($count/$per_page);
				$this->load->view('users_interface/products-list',$pagevar);
			else:
				echo '<span class="no-products">Не нашлось ни одного товара. Измените условия выборки.</span>';
			endif;
		else:
			echo '<span class="no-products">Не нашлось ни одного товара. Измените условия выборки.</span>';
		endif;
	}
	
	public function calegory_list(){
		
		$statusval = array('status'=>TRUE,'category'=>array());
		$gender = $this->input->post('gender');
		$brands = $this->input->post('brands');
		if(!$gender || !$brands):
			show_404();
		endif;
		$gender = preg_split("/&/",$gender);
		for($i=0;$i<count($gender);$i++):
			$genid = preg_split("/=/",$gender[$i]);
			$gender[$i] = $genid[1];
		endfor;
		if(count($gender) == 2):
			$gender = 2;
		else:
			$gender = $gender[0];
		endif;
		$brands = preg_split("/&/",$brands);
		for($i=0;$i<count($brands);$i++):
			$brid = preg_split("/=/",$brands[$i]);
			$brands[$i] = $brid[1];
		endfor;
		$statusval['category'] = $this->mdunion->read_showed_category($gender,$brands);
		if(!$statusval['category']):
			$statusval['status'] = FALSE;
		endif;
		echo json_encode($statusval);
	}
	
	public function product(){
		
		$urlparam = preg_split('/-/',$this->uri->segment(2));
		$product = $urlparam[3];
		if(!$this->mdproductsimages->read_main($product)):
			redirect('');
		endif;
		$pagevar = array(
			'title'			=> 'Комфорт Лайн | ',
			'description'	=> '',
			'author'		=> '',
			'baseurl' 		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'urlparam'		=> $urlparam,
			'product'		=> $this->mdproducts->read_record($product),
			'primages'		=> $this->mdproductsimages->read_records($product),
			'prsizes'		=> $this->mdproductssizes->read_records($product),
			'prcolors'		=> $this->mdproductscolors->read_records($product),
			'brands'		=> $this->mdbrands->read_records_notext(),
			'category'		=> $this->mdcategory->read_showed_records(),
			'prslide'		=> array('prew'=>FALSE,'next'=>FALSE),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		$pagevar['title'] .= $pagevar['product']['title'];
		$products = $this->mdunion->read_products_slider($urlparam[0],$urlparam[1],$urlparam[2]);
		for($i=0;$i<count($products);$i++):
			if($products[$i]['id'] == $product):
				if(isset($products[$i-1]['id'])):
					$pagevar['prslide']['prew'] = $products[$i-1]['translit'];
					$pagevar['prslide']['prewid'] = $products[$i-1]['id'];
				endif;
				if(isset($products[$i+1]['id'])):
					$pagevar['prslide']['next'] = $products[$i+1]['translit'];
					$pagevar['prslide']['nextid'] = $products[$i+1]['id'];
				endif;
			endif;
		endfor;
		$this->load->view("users_interface/product",$pagevar);
		
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
				redirect("admin-panel/actions/events");
			endif;
		endif;
		
		if($this->loginstatus['status']):
			redirect('admin-panel/actions/events');
		endif;
		
		$this->load->view("admin_interface/login",$pagevar);
	}
	
	public function setseason(){
		
		$products = $this->mdproducts->read_records();
		for($i=0;$i<count($products);$i++):
			$this->mdproductsseasons->insert_record($products[$i]['id'],0);
		endfor;
		$seasons = $this->mdproductsseasons->read_all_records();
		print_r($seasons);
	}
	
	/******************************************************** functions ******************************************************/	
	
	public function viewimage(){
		
		$section = $this->uri->segment(1);
		$id = $this->uri->segment(3);
		switch ($section):
			case 'news' 	: $image = $this->mdevents->get_image($id); break;
			case 'stock' 	: $image = $this->mdevents->get_image($id); break;
			case 'brands' 	: $image = $this->mdbrands->get_image($id); break;
			case 'productimage' : $image = $this->mdproductsimages->get_image($id); break;
			case 'baner' 	: $image = $this->mdimages->get_image($id); break;
			case 'text' 	: $image = $this->mdtexts->get_image($id); break;
		endswitch;
		// Output the image
    	header('Content-Type: image/jpeg');
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