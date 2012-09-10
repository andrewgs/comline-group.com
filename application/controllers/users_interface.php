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
		$this->load->model('mdimages');
		$this->load->model('mdcatalogs');
		
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
			'baners'		=> $this->mdimages->read_records(),
			'category'		=> $this->mdcategory->read_showed_records(),
			'brands'		=> $this->mdbrands->read_records_rand_limit(4),
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
	
	public function about(){
		
		$pagevar = array(
			'title'			=> 'Комфорт Лайн :: О компании',
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
	
	public function view_news(){
		
		$news = $this->mdevents->read_field_translit($this->uri->segment(2),'id');
		if(!$news):
			redirect('');
		endif;
		$pagevar = array(
			'title'			=> 'Комфорт Лайн :: ',
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
			'title'			=> 'Комфорт Лайн :: ',
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
			'title'			=> 'Комфорт Лайн :: Новости',
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
			'title'			=> 'Комфорт Лайн :: Акции',
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
			'title'			=> 'Комфорт Лайн :: Клиентам',
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
				$this->email->to('brand@comline-group.com');
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
			'title'			=> 'Комфорт Лайн :: Список брендов',
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
		
		$this->load->view("users_interface/brands",$pagevar);
	}
	
	public function contacts(){
		
		$pagevar = array(
			'title'			=> 'Комфорт Лайн :: Контактная информация',
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
				$this->email->to($pagevar['text'][1]);
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
			'title'			=> 'Комфорт Лайн :: Каталог продукции',
			'description'	=> '',
			'author'		=> '',
			'baseurl' 		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'brands'		=> $this->mdbrands->read_records_notext(),
			'category'		=> $this->mdcategory->read_showed_records(),
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
									break;
				case 'come-back':	$urlparam = preg_split('/-/',$this->uri->segment(3));
									
									$this->session->set_userdata('gender',$urlparam[0]);
									$this->session->set_userdata('bid',$urlparam[1]);
									$this->session->set_userdata('cid',$urlparam[2]);
									break;
				default			: redirect('');
			endswitch;
			redirect('catalog');
		else:
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
		endif;
		$this->load->view("users_interface/catalog",$pagevar);
	}
	
	public function catalogs(){
		
		$brandid = $this->mdbrands->read_field_translit($this->uri->segment(3),'id');
		if(!$brandid):
			redirect('');
		endif;
		$pagevar = array(
			'title'			=> 'Комфорт Лайн :: Каталоги бренда',
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
				redirect('');
			endif;
			$pagevar['catalog'] = $this->mdcatalogs->read_record($catalogid);
		endif;
		
		$this->load->view("users_interface/catalogs",$pagevar);
	}
	
	public function catalog_load(){
		
		$pagevar = array('baseurl'=>base_url(),'category'=>array(),'products'=>array());
		$gender = $this->input->post('gender');
		$brands = $this->input->post('brands');
		$category = $this->input->post('category');
		if(!$gender || !$brands || !$category):
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
		$category = preg_split("/&/",$category);
		for($i=0;$i<count($category);$i++):
			$catid = preg_split("/=/",$category[$i]);
			$category[$i] = $catid[1];
		endfor;
		$pagevar['category'] = $this->mdcategory->read_in_records($category);
		$pagevar['products'] = $this->mdunion->read_products_in_brends($gender,$brands,$category);
//		print_r($pagevar['products']);
		$this->load->view('users_interface/products-list',$pagevar);
	}
	
	public function product(){
		
		$urlparam = preg_split('/-/',$this->uri->segment(2));
		$product = $this->mdproducts->read_field_translit($this->uri->segment(3),'id',$urlparam[0],$urlparam[1],$urlparam[2]);
		if(!$product):
			redirect('');
		endif;
		$pagevar = array(
			'title'			=> 'Комфорт Лайн :: ',
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
		$products = $this->mdproducts->read_slider($urlparam[0],$urlparam[1],$urlparam[2]);
		for($i=0;$i<count($products);$i++):
			if($products[$i]['id'] == $product):
				if(isset($products[$i-1]['id'])):
					$pagevar['prslide']['prew'] = $products[$i-1]['translit'];
				endif;
				if(isset($products[$i+1]['id'])):
					$pagevar['prslide']['next'] = $products[$i+1]['translit'];
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
			case 'productimage' : $image = $this->mdproductsimages->get_image($id); break;
			case 'baner' 	: $image = $this->mdimages->get_image($id); break;
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