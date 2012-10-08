<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_interface extends CI_Controller{

	var $language = 'ru';
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
				else:
					redirect('');
				endif;
			endif;
			
			if($this->session->userdata('logon') != md5($userinfo['login'])):
				$this->loginstatus['status'] = FALSE;
				redirect('');
			endif;
		else:
			redirect('');
		endif;
		
		if($this->session->userdata('language')):
			$this->language = $this->session->userdata('language');
		else:
			$this->language = 'ru';
		endif;
	}
	
	public function admin_panel(){
		
		$pagevar = array(
			'title'			=> 'Панель администрирования',
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
		
		$this->session->set_userdata('backpath',$pagevar['baseurl'].$this->uri->uri_string());
		$this->load->view("admin_interface/admin-panel",$pagevar);
	}
	
	public function profile(){
		
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> 'Панель администрирования | Смена пароля',
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'user'			=> $this->mdadmins->read_record($this->user['uid']),
					'msgs'			=> $this->session->userdata('msgs'),
					'msgr'			=> $this->session->userdata('msgr')
			);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			$_POST['submit'] = NULL;
			$this->form_validation->set_rules('oldpas',' ','trim');
			$this->form_validation->set_rules('password',' ','trim');
			$this->form_validation->set_rules('confpass',' ','trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				redirect($this->uri->uri_string());
			else:
				if(!empty($_POST['oldpas']) && !empty($_POST['password']) && !empty($_POST['confpass'])):
					if(!$this->mdadmins->user_exist('password',md5($_POST['oldpas']))):
						$this->session->set_userdata('msgr',' Не верный старый пароль!');
					elseif($_POST['password']!=$_POST['confpass']):
						$this->session->set_userdata('msgr',' Пароли не совпадают.');
					else:
						$this->mdadmins->update_field($this->user['uid'],'password',md5($_POST['password']));
						$this->mdadmins->update_field($this->user['uid'],'cryptpassword',$this->encrypt->encode($_POST['password']));
						$this->session->set_userdata('msgs',' Пароль успешно изменен');
					endif;
				endif;
				redirect($this->uri->uri_string());
			endif;
		endif;
		$this->load->view("admin_interface/admin-profile",$pagevar);
	}
	
	public function admin_logoff(){
		
		$this->session->sess_destroy();
			redirect('');
	}
	
	/******************************************************* text ************************************************************/
	
	public function admin_edit_text(){
		
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> 'Панель администрирования | Смена пароля',
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'text'			=> array(),
					'text'			=> $this->mdadmins->read_record($this->user['uid']),
					'msgs'			=> $this->session->userdata('msgs'),
					'msgr'			=> $this->session->userdata('msgr')
			);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		switch($this->uri->segment(3)):
			case 'contacts' : 	$pagevar['text']['id'] = $id1 = 1;
								$pagevar['text']['vname1'] = $this->mdtexts->read_field($id1,'text');
								$pagevar['text']['noimage'] = $this->mdtexts->read_field($id1,'noimage');
								$pagevar['text']['lname1'] = 'Адрес';
								$pagevar['text']['fname1'] = 'text1';
								$id2 = 2;
								$pagevar['text']['vname2'] = $this->mdtexts->read_field($id2,'text');
								$pagevar['text']['lname2'] = 'E-mail';
								$pagevar['text']['fname2'] = 'text2';
								break;
			case 'clients' : 	$pagevar['text']['id'] = $id1 = 3;
								$pagevar['text']['vname1'] = $this->mdtexts->read_field($id1,'text');
								$pagevar['text']['noimage'] = $this->mdtexts->read_field($id1,'noimage');
								$pagevar['text']['lname1'] = 'Прелог';
								$pagevar['text']['fname1'] = 'text1';
								$id2 = 4;
								$pagevar['text']['vname2'] = $this->mdtexts->read_field($id2,'text');
								$pagevar['text']['lname2'] = 'Содержание';
								$pagevar['text']['fname2'] = 'text2';
								break;
			case 'about' : 		$pagevar['text']['id'] = $id1 = 5;
								$pagevar['text']['vname1'] = $this->mdtexts->read_field($id1,'text');
								$pagevar['text']['noimage'] = $this->mdtexts->read_field($id1,'noimage');
								$pagevar['text']['lname1'] = 'О компании';
								$pagevar['text']['fname1'] = 'text1';
								$id2 = NULL;
								break;
			case 'vakansii' : 	$pagevar['text']['id'] = $id1 = 6;
								$pagevar['text']['vname1'] = $this->mdtexts->read_field($id1,'text');
								$pagevar['text']['noimage'] = $this->mdtexts->read_field($id1,'noimage');
								$pagevar['text']['lname1'] = 'Вакансии';
								$pagevar['text']['fname1'] = 'text1';
								$id2 = NULL;
								break;
			default : redirect($this->session->userdata('backpath'));
		endswitch;
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$text = array(); $i = 0;
			if(!isset($_POST['noimage'])):
				$_POST['noimage'] = 0;
			endif;
			if($_FILES['image']['error'] != 4):
				$this->mdtexts->update_field($id1,'image',file_get_contents($_FILES['image']['tmp_name']));
			endif;
			$this->mdtexts->update_field($id1,'noimage',$_POST['noimage']);
			$this->mdtexts->update_field($id1,'text',$_POST['text1']);
			if(isset($id2)):
				$this->mdtexts->update_field($id2,'noimage',1);
				$this->mdtexts->update_field($id2,'text',$_POST['text2']);
			endif;
			$this->session->set_userdata('msgs','Текс сохранен успешно.');
			redirect($this->uri->uri_string());
		endif;
		$this->load->view("admin_interface/texts/edit-text",$pagevar);
	}
	
	/******************************************************* events ************************************************************/
	
	public function control_events(){
		
		$from = intval($this->uri->segment(5));
		$pagevar = array(
			'title'			=> 'Панель администрирования | Новости',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'events'		=> $this->mdunion->events_limit(5,$from),
			'pages'			=> array(),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
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
		
		$config['base_url'] 		= $pagevar['baseurl'].'admin-panel/actions/events/from/';
		$config['uri_segment'] 		= 5;
		$config['total_rows'] 		= $this->mdevents->count_records(array(1,2));
		$config['per_page'] 		= 5;
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
		
		$this->session->set_userdata('backpath',$pagevar['baseurl'].$this->uri->uri_string());
		$this->load->view("admin_interface/events/list-events",$pagevar);
	}
	
	public function control_add_events(){
		
		$pagevar = array(
			'title'			=> 'Панель администрирования | Добавление новости или события',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$this->form_validation->set_rules('title',' ','required|trim');
			$this->form_validation->set_rules('text',' ','required|trim');
			$this->form_validation->set_rules('type',' ','required|trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				$this->control_add_events();
				return FALSE;
			else:
				if($_FILES['image']['error'] != 4):
					$_POST['image'] = file_get_contents($_FILES['image']['tmp_name']);
				else:
					$_POST['image'] = FALSE;
				endif;
				$translit = $this->translite($_POST['title']);
				$result = $this->mdevents->insert_record($_POST,$translit);
				if($result):
					$this->session->set_userdata('msgs','Запись создана успешно.');
				endif;
				redirect($this->uri->uri_string());
			endif;
		endif;
		
		$this->load->view("admin_interface/events/add-events",$pagevar);
	}
	
	public function control_edit_events(){
		
		$nid = $this->mdevents->read_field_translit($this->uri->segment(5),'id');
		if(!$nid):
			redirect($this->session->userdata('backpath'));
		endif;
		$pagevar = array(
			'title'			=> 'Панель администрирования | Редактирование новости или события',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'event'			=> $this->mdevents->read_record($nid,array(1,2)),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$this->form_validation->set_rules('title',' ','required|trim');
			$this->form_validation->set_rules('content',' ','trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				$this->control_edit_events();
				return FALSE;
			else:
				if($_FILES['image']['error'] != 4):
					$_POST['image'] = file_get_contents($_FILES['image']['tmp_name']);
				endif;
				if(isset($_POST['noimage'])):
					$noimage = 1;
				else:
					$noimage = 0;
				endif;
				$translit = $this->translite($_POST['title']);
				$result = $this->mdevents->update_record($nid,$_POST,$translit,$noimage);
				if($result):
					$this->session->set_userdata('msgs','Запись сохранена успешно.');
				endif;
				redirect($this->session->userdata('backpath'));
			endif;
		endif;
		
		$this->load->view("admin_interface/events/edit-events",$pagevar);
	}
	
	public function control_delete_events(){
		
		$nid = $this->uri->segment(6);
		if($nid):
			$result = $this->mdevents->delete_record($nid);
			if($result):
				$this->session->set_userdata('msgs','Запись удалена успешно.');
			else:
				$this->session->set_userdata('msgr','Запись не удалена.');
			endif;
			redirect($this->session->userdata('backpath'));
		else:
			show_404();
		endif;
	}
	
	/******************************************************* category ************************************************************/
	
	public function control_category(){
		
		$pagevar = array(
			'title'			=> 'Панель администрирования | Категории продуктов',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'category'		=> $this->mdcategory->read_records(),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		$this->session->set_userdata('backpath',$pagevar['baseurl'].$this->uri->uri_string());
		$this->load->view("admin_interface/products/category",$pagevar);
	}
	
	public function control_add_category(){
		
		$pagevar = array(
			'title'			=> 'Панель администрирования | Добавдение категории',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$this->form_validation->set_rules('title',' ','required|trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				$this->control_add_category();
				return FALSE;
			else:
				if(!isset($_POST['showitem'])):
					$_POST['showitem'] = 0;
				endif;
				$translit = $this->translite($_POST['title']);
				$cid = $this->mdcategory->insert_record($_POST,$translit);
				if($cid):
					$this->session->set_userdata('msgs','Запись создана успешно.');
				endif;
				redirect($this->uri->uri_string());
			endif;
		endif;
		
		$this->load->view("admin_interface/products/add-category",$pagevar);
	}
	
	public function control_edit_category(){
		
		$nid = $this->mdcategory->read_field_translit($this->uri->segment(5),'id');
		if(!$nid):
			redirect($this->session->userdata('backpath'));
		endif;
		$pagevar = array(
			'title'			=> 'Панель администрирования | Редактирование категории товара',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'category'		=> $this->mdcategory->read_record($nid),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$this->form_validation->set_rules('title',' ','required|trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				$this->control_edit_category();
				return FALSE;
			else:
				if(!isset($_POST['showitem'])):
					$_POST['showitem'] = 0;
				endif;
				$translit = $this->translite($_POST['title']);
				$result = $this->mdcategory->update_record($nid,$_POST,$translit);
				if($result):
					$this->session->set_userdata('msgs','Запись сохранена успешно.');
				endif;
				redirect($this->session->userdata('backpath'));
			endif;
		endif;
		
		$this->load->view("admin_interface/products/edit-category",$pagevar);
	}
	
	public function control_delete_category(){
		
		$cid = $this->uri->segment(6);
		if($cid):
			$result = $this->mdcategory->delete_record($cid);
			if($result):
				$this->mdproducts->delete_records_category($cid);
				$this->session->set_userdata('msgs','Категория удалена успешно.');
			else:
				$this->session->set_userdata('msgr','Категория не удалена.');
			endif;
			redirect($this->session->userdata('backpath'));
		else:
			show_404();
		endif;
	}
	
	/******************************************************* brands ************************************************************/
	
	public function control_brands(){
		
		$pagevar = array(
			'title'			=> 'Панель администрирования | Бренды',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'brands'		=> $this->mdbrands->read_records(),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		for($i=0;$i<count($pagevar['brands']);$i++):
			$pagevar['brands'][$i]['text'] = strip_tags($pagevar['brands'][$i]['text']);
			if(mb_strlen($pagevar['brands'][$i]['text'],'UTF-8') > 150):
				$pagevar['brands'][$i]['text'] = mb_substr($pagevar['brands'][$i]['text'],0,150,'UTF-8');
				$pos = mb_strrpos($pagevar['brands'][$i]['text'],' ',0,'UTF-8');
				$pagevar['brands'][$i]['text'] = mb_substr($pagevar['brands'][$i]['text'],0,$pos,'UTF-8');
				$pagevar['brands'][$i]['text'] .= ' ... ';
			endif;
		endfor;
		
		$this->session->set_userdata('backpath',$pagevar['baseurl'].$this->uri->uri_string());
		$this->load->view("admin_interface/products/brands",$pagevar);
	}
	
	public function admin_brands_catalogs(){
		
		$pagevar = array(
			'title'			=> 'Панель администрирования | Каталоги бренда',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'brand'			=> $this->mdbrands->read_field($this->uri->segment(5),'title'),
			'catalogs'		=> $this->mdcatalogs->read_records($this->uri->segment(5)),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		for($i=0;$i<count($pagevar['catalogs']);$i++):
			$pagevar['catalogs'][$i]['text'] = strip_tags($pagevar['catalogs'][$i]['text']);
			if(mb_strlen($pagevar['catalogs'][$i]['text'],'UTF-8') > 150):
				$pagevar['catalogs'][$i]['text'] = mb_substr($pagevar['catalogs'][$i]['text'],0,150,'UTF-8');
				$pos = mb_strrpos($pagevar['catalogs'][$i]['text'],' ',0,'UTF-8');
				$pagevar['catalogs'][$i]['text'] = mb_substr($pagevar['catalogs'][$i]['text'],0,$pos,'UTF-8');
				$pagevar['catalogs'][$i]['text'] .= ' ... ';
			endif;
		endfor;
		
		$this->load->view("admin_interface/products/catalogs",$pagevar);
	}
	
	public function control_add_brand(){
		
		$pagevar = array(
			'title'			=> 'Панель администрирования | Добавдение бренда',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$this->form_validation->set_rules('title',' ','required|trim');
			$this->form_validation->set_rules('status_string',' ','trim');
			$this->form_validation->set_rules('text',' ','trim');
			$this->form_validation->set_rules('sort',' ','trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				$this->control_add_brand();
				return FALSE;
			else:
				if($_FILES['image']['error'] != 4):
					$_POST['image'] = file_get_contents($_FILES['image']['tmp_name']);
				else:
					$_POST['image'] = file_get_contents(base_url().'images/noimages/no_icon.jpg');
				endif;
				$translit = $this->translite($_POST['title']);
				$cid = $this->mdbrands->insert_record($_POST,$translit);
				if($cid):
					$this->session->set_userdata('msgs','Запись создана успешно.');
				endif;
				redirect($this->uri->uri_string());
			endif;
		endif;
		
		$this->load->view("admin_interface/products/add-brand",$pagevar);
	}
	
	public function admin_add_catalogs(){
		
		$pagevar = array(
			'title'			=> 'Панель администрирования | Добавдение каталога',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'brand'			=> $this->mdbrands->read_field($this->uri->segment(5),'title'),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$this->form_validation->set_rules('title',' ','required|trim');
			$this->form_validation->set_rules('text',' ','required|trim');
			$this->form_validation->set_rules('html',' ','required|trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				$this->admin_add_catalogs();
				return FALSE;
			else:
				$translit = $this->translite($_POST['title']);
				$cid = $this->mdcatalogs->insert_record($_POST,$translit,$this->uri->segment(5));
				if($cid):
					$this->session->set_userdata('msgs','Каталог создан успешно.');
				endif;
				redirect('admin-panel/actions/brands/brandsid/'.$this->uri->segment(5).'/catalogs');
			endif;
		endif;
		
		$this->load->view("admin_interface/products/add-catalog",$pagevar);
	}
	
	public function control_edit_brand(){
		
		$bid = $this->mdbrands->read_field_translit($this->uri->segment(5),'id');
		if(!$bid):
			redirect($this->session->userdata('backpath'));
		endif;
		$pagevar = array(
			'title'			=> 'Панель администрирования | Редактирование бренда',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'brand'			=> $this->mdbrands->read_record($bid),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$this->form_validation->set_rules('title',' ','required|trim');
			$this->form_validation->set_rules('status_string',' ','trim');
			$this->form_validation->set_rules('text',' ','trim');
			$this->form_validation->set_rules('sort',' ','trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				$this->control_edit_brand();
				return FALSE;
			else:
				if($_FILES['image']['error'] != 4):
					$_POST['image'] = file_get_contents($_FILES['image']['tmp_name']);
				endif;
				$translit = $this->translite($_POST['title']);
				$result = $this->mdbrands->update_record($bid,$_POST,$translit);
				if($result):
					$this->session->set_userdata('msgs','Запись сохранена успешно.');
				endif;
				redirect($this->session->userdata('backpath'));
			endif;
		endif;
		
		$this->load->view("admin_interface/products/edit-brand",$pagevar);
	}
	
	public function admin_edit_catalogs(){
		
		$cid = $this->uri->segment(8);
		$pagevar = array(
			'title'			=> 'Панель администрирования | Редактирование каталога',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'brand'			=> $this->mdbrands->read_field($this->uri->segment(5),'title'),
			'catalog'		=> $this->mdcatalogs->read_record($cid),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$this->form_validation->set_rules('title',' ','required|trim');
			$this->form_validation->set_rules('text',' ','required|trim');
			$this->form_validation->set_rules('html',' ','required|trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				$this->admin_edit_catalogs();
				return FALSE;
			else:
				$translit = $this->translite($_POST['title']);
				$result = $this->mdcatalogs->update_record($cid,$_POST,$translit,$this->uri->segment(5));
				if($result):
					$this->session->set_userdata('msgs','Каталог сохранен успешно.');
				endif;
				redirect('admin-panel/actions/brands/brandsid/'.$this->uri->segment(5).'/catalogs');
			endif;
		endif;
		
		$this->load->view("admin_interface/products/edit-catalog",$pagevar);
	}
	
	public function control_delete_brand(){
		
		$bid = $this->uri->segment(6);
		if($bid):
			$result = $this->mdbrands->delete_record($bid);
			if($result):
				$this->mdproducts->delete_records_category($bid);
				$this->mdcatalogs->delete_records($bid);
				$this->session->set_userdata('msgs','Бренд удален успешно.');
			else:
				$this->session->set_userdata('msgr','Бренд не удален.');
			endif;
			redirect($this->session->userdata('backpath'));
		else:
			show_404();
		endif;
	}
	
	public function admin_delete_catalogs(){
		
		$cid = $this->uri->segment(8);
		if($cid):
			$result = $this->mdcatalogs->delete_record($cid);
			if($result):
				$this->session->set_userdata('msgs','Каталог удален успешно.');
			else:
				$this->session->set_userdata('msgr','Каталог не удален.');
			endif;
			redirect('admin-panel/actions/brands/brandsid/'.$this->uri->segment(5).'/catalogs');
		else:
			redirect($this->session->userdata('backpath'));
		endif;
	}
	
	/******************************************************* colors ************************************************************/
	
	public function control_colors(){
		
		$pagevar = array(
			'title'			=> 'Панель администрирования | Цвета',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'colors'		=> $this->mdcolors->read_records(),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		$this->session->set_userdata('backpath',$pagevar['baseurl'].$this->uri->uri_string());
		$this->load->view("admin_interface/products/colors",$pagevar);
	}
	
	public function control_add_color(){
		
		$pagevar = array(
			'title'			=> 'Панель администрирования | Добавление цвета',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'colors'		=> $this->mdcolors->read_records(),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$this->form_validation->set_rules('title',' ','required|trim');
			$this->form_validation->set_rules('number',' ','required|trim');
			$this->form_validation->set_rules('code',' ','required|trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				$this->control_add_color();
				return FALSE;
			else:
				$cid = $this->mdcolors->insert_record($_POST);
				if($cid):
					$this->session->set_userdata('msgs','Запись создана успешно.');
				endif;
				redirect($this->uri->uri_string());
			endif;
		endif;
		
		$this->load->view("admin_interface/products/add-colors",$pagevar);
	}
	
	public function control_delete_colors(){
		
		$cid = $this->uri->segment(6);
		if($cid):
			$result = $this->mdcolors->delete_record($cid);
			if($result):
				$this->mdproductscolors->delete_color_records($cid);
				$this->session->set_userdata('msgs','Цвет удален успешно.');
			else:
				$this->session->set_userdata('msgr','Цвет не удален.');
			endif;
			redirect($this->session->userdata('backpath'));
		else:
			show_404();
		endif;
	}
	
	/******************************************************* storage ************************************************************/
	
	public function control_storage(){
		
		$pagevar = array(
			'title'			=> 'Панель администрирования | Склады',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'storage'		=> $this->mdstorage->read_records(),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		$this->session->set_userdata('backpath',$pagevar['baseurl'].$this->uri->uri_string());
		$this->load->view("admin_interface/storage/storage",$pagevar);
	}
	
	public function control_add_storage(){
		
		$pagevar = array(
			'title'			=> 'Панель администрирования | Добавдение склада',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$this->form_validation->set_rules('title',' ','required|trim');
			$this->form_validation->set_rules('address',' ','required|trim');
			$this->form_validation->set_rules('metro',' ','required|trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				$this->control_add_storage();
				return FALSE;
			else:
				$sid = $this->mdstorage->insert_record($_POST);
				if($sid):
					$this->session->set_userdata('msgs','Запись создана успешно.');
				endif;
				redirect($this->uri->uri_string());
			endif;
		endif;
		
		$this->load->view("admin_interface/storage/add-storage",$pagevar);
	}
	
	public function control_edit_storage(){
		
		$sid = $this->uri->segment(6);
		$pagevar = array(
			'title'			=> 'Панель администрирования | Редактирование склада',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'storage'		=> $this->mdstorage->read_record($sid),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$this->form_validation->set_rules('title',' ','required|trim');
			$this->form_validation->set_rules('address',' ','required|trim');
			$this->form_validation->set_rules('metro',' ','required|trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				$this->control_edit_storage();
				return FALSE;
			else:
				$result = $this->mdstorage->update_record($sid,$_POST);
				if($result):
					$this->session->set_userdata('msgs','Запись сохранена успешно.');
				endif;
				redirect($this->session->userdata('backpath'));
			endif;
		endif;
		
		$this->load->view("admin_interface/storage/edit-storage",$pagevar);
	}
	
	public function control_delete_storage(){
		
		$sid = $this->uri->segment(6);
		if($sid):
			$result = $this->mdstorage->delete_record($sid);
			if($result):
				$this->session->set_userdata('msgs','Склад удален успешно.');
			else:
				$this->session->set_userdata('msgr','Склад не удалена.');
			endif;
			redirect($this->session->userdata('backpath'));
		else:
			show_404();
		endif;
	}
	
	/******************************************************* baners ************************************************************/
	
	public function control_baners(){
		
		$pagevar = array(
			'title'			=> 'Панель администрирования | Слайдшоу на главной',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'baners'		=> $this->mdimages->read_records(),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		$this->session->set_userdata('backpath',$pagevar['baseurl'].$this->uri->uri_string());
		$this->load->view("admin_interface/baners/images",$pagevar);
	}
	
	public function control_baners_add(){
		
		$pagevar = array(
			'title'			=> 'Панель администрирования | Слайдшоу на главной | Добавление изображения',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$this->form_validation->set_rules('title',' ','required|trim');
			$this->form_validation->set_rules('link',' ','prep_url|required|trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				$this->control_baners_add();
				return FALSE;
			else:
				if($_FILES['image']['error'] != 4):
					if(!$this->case_image($_FILES['image']['tmp_name'])):
						continue;
					endif;
					$img = getimagesize($_FILES['image']['tmp_name']);
					if(($img[0] > $img[1]) && ($img[0] >= 960)):
						$data['image'] = $this->resize_image($_FILES['image']['tmp_name'],960,410,'width',TRUE);
						$data['title'] = $_POST['title'];
						$data['link'] = $_POST['link'];
						$data['sort'] = $_POST['sort'];
						$this->mdimages->insert_record($data);
						$this->session->set_userdata('msgs','Изображение загруженно успешно');
					else:
						$this->session->set_userdata('msgr','Ошибка. Изображение должно быть не менее 960px по ширене');
					endif;
				endif;
				redirect($this->uri->uri_string());
			endif;
		endif;
		$this->load->view("admin_interface/baners/add-image",$pagevar);
	}
	
	public function control_baners_edit(){
		
		$image = $this->uri->segment(6);
		$pagevar = array(
			'title'			=> 'Панель администрирования | Слайдшоу на главной | Редактирование изображения',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'image'			=> $this->mdimages->read_record($image),
			'userinfo'		=> $this->user,
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$this->form_validation->set_rules('title',' ','required|trim');
			$this->form_validation->set_rules('link',' ','prep_url|required|trim');
			$this->form_validation->set_rules('sort',' ','trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				$this->control_baners_edit();
				return FALSE;
			else:
				if($_FILES['image']['error'] != 4):
					if(!$this->case_image($_FILES['image']['tmp_name'])):
						continue;
					endif;
					$img = getimagesize($_FILES['image']['tmp_name']);
					if(($img[0] > $img[1]) && ($img[0] >= 960)):
						$data['image'] = $this->resize_image($_FILES['image']['tmp_name'],960,410,'width',TRUE);
					else:
						$this->session->set_userdata('msgr','Ошибка. Изображение должно быть не менее 960px по ширене');
					endif;
				endif;
				$data['title'] = $_POST['title'];
				$data['link'] = $_POST['link'];
				$data['sort'] = $_POST['sort'];
				$this->mdimages->update_record($image,$data);
				$this->session->set_userdata('msgs','Данные успешно сохранены');
				redirect('admin-panel/actions/baners');
			endif;
		endif;
		$this->load->view("admin_interface/baners/edit-image",$pagevar);
	}
	
	public function control_baners_delete(){
		
		$imgid = $this->uri->segment(6);
		if($imgid):
			$result = $this->mdimages->delete_record($imgid);
			if($result):
				$this->session->set_userdata('msgs','Изображение удалено успешно.');
			else:
				$this->session->set_userdata('msgr','Изображение не удалено.');
			endif;
			redirect($this->session->userdata('backpath'));
		else:
			redirect($this->session->userdata('backpath'));
		endif;
	}
	
	/******************************************************* products ************************************************************/
	
	public function control_products(){
		
		$from = intval($this->uri->segment(5));
		$pagevar = array(
			'title'			=> 'Панель администрирования | Продукты',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'category'		=> $this->mdcategory->read_records(),
			'brands'		=> $this->mdbrands->read_records(),
			'products'		=> $this->mdproducts->read_admin_limit_records(5,$from),
			'pages'			=> array(),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		for($i=0;$i<count($pagevar['products']);$i++):
			$pagevar['products'][$i]['text'] = strip_tags($pagevar['products'][$i]['text']);
			$pagevar['products'][$i]['imgid'] = $this->mdproductsimages->read_main($pagevar['products'][$i]['id']);
			if(mb_strlen($pagevar['products'][$i]['text'],'UTF-8') > 250):
				$pagevar['products'][$i]['text'] = mb_substr($pagevar['products'][$i]['text'],0,250,'UTF-8');	
				$pos = mb_strrpos($pagevar['products'][$i]['text'],' ',0,'UTF-8');
				$pagevar['products'][$i]['text'] = mb_substr($pagevar['products'][$i]['text'],0,$pos,'UTF-8');
				$pagevar['products'][$i]['text'] .= ' ... ';
			endif;
		endfor;
		
		$config['base_url'] 		= $pagevar['baseurl'].'admin-panel/actions/products/from/';
		$config['uri_segment'] 		= 5;
		$config['total_rows'] 		= $this->mdproducts->count_records();
		$config['per_page'] 		= 5;
		$config['num_links'] 		= 3;
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
		
		$this->session->set_userdata('backpath',$pagevar['baseurl'].$this->uri->uri_string());
		$this->load->view("admin_interface/products/products",$pagevar);
	}
	
	public function control_add_product(){
		
		$pagevar = array(
			'title'			=> 'Панель администрирования | Добавдение продукта',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'category'		=> $this->mdcategory->read_records(),
			'brands'		=> $this->mdbrands->read_records(),
			'colors'		=> $this->mdcolors->read_records(),
			'sizes'			=> $this->get_sizes(),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$this->form_validation->set_rules('title',' ','required|trim');
			$this->form_validation->set_rules('composition',' ','required|trim');
			$this->form_validation->set_rules('art',' ','required|trim');
			$this->form_validation->set_rules('text',' ','required|trim');
			$this->form_validation->set_rules('gender[]',' ','required');
			$this->form_validation->set_rules('sizes[]',' ','required');
			$this->form_validation->set_rules('colors[]',' ','required');
			$this->form_validation->set_rules('category',' ','required');
			$this->form_validation->set_rules('brand',' ','required');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				$this->control_add_product();
				return FALSE;
			else:
				if(count($_POST['gender']) == 2):
					$gender = 2;
				else:
					$gender = $_POST['gender'][0];
				endif;
				if(!isset($_POST['showitem'])):
					$_POST['showitem'] = 0;
				endif;
				$translit = $this->translite($_POST['title']);
				$pid = $this->mdproducts->insert_record($_POST,$gender,$translit);
				if($pid):
					/**************************************************************/
					$colors = array();
					for($i=0;$i<count($pagevar['colors']);$i++):
						$colors[$pagevar['colors'][$i]['id']] = $pagevar['colors'][$i]['code'];
					endfor;
					$colorslist = array();
					for($i=0,$j=0;$i<count($_POST['colors']);$i++):
						$colorslist[$j]['color_id'] = $_POST['colors'][$i];
						$colorslist[$j]['code']= $colors[$_POST['colors'][$i]];
						$j++;
					endfor;
					if(count($colorslist)):
						$this->mdproductscolors->delete_product_records($pid);
						$this->mdproductscolors->group_insert($pid,$colorslist);
					endif;
					/**************************************************************/
					$sizeslist = array();
					for($i=0,$j=0;$i<count($_POST['sizes']);$i++):
						$sizeslist[$j]['sizes_id'] = $_POST['sizes'][$i];
						$sizeslist[$j]['code']= $pagevar['sizes'][$_POST['sizes'][$i]]['code'];
						$j++;
					endfor;
					if(count($sizeslist)):
						$this->mdproductssizes->delete_product_records($pid);
						$this->mdproductssizes->group_insert($pid,$sizeslist);
					endif;
					/**************************************************************/
					$this->session->set_userdata('msgs','Продукт создан успешно.');
				endif;
				redirect($this->uri->uri_string());
			endif;
		endif;
		
		$this->load->view("admin_interface/products/add-product",$pagevar);
	}
	
	public function control_product_images(){
		
		$pid = $this->uri->segment(5);
		$pagevar = array(
			'title'			=> 'Панель администрирования | Рисунки продукта',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'product'		=> $this->mdproducts->read_field($pid,'title'),
			'primages'		=> $this->mdproductsimages->read_records($pid),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		$this->load->view("admin_interface/products/product-images",$pagevar);
	}
	
	public function control_product_images_add(){
		
		$pagevar = array(
			'title'			=> 'Панель администрирования | Добавдение рисунка товара',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'product'		=> $this->mdproducts->read_field($this->uri->segment(5),'title'),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$cnt = 0;
			if(!count($_POST)):
				if(!$this->mdproductsimages->read_main($this->uri->segment(5))):
					$first = 0;
					for($i=0;$i<count($_FILES);$i++):
						if($_FILES['image'.$i]['error'] != 4):
							if(!$this->case_image($_FILES['image'.$i]['tmp_name'])):
								continue;
							endif;
							if(!$first):
								$first = $i;
							endif;
						endif;
					endfor;
					$_POST['image'.$first] = 1;
				endif;
			else:
				$imain = $this->mdproductsimages->read_main($this->uri->segment(5));
				if($imain):
					$this->mdproductsimages->update_field($imain,'main',0);
					$this->session->set_userdata('msgr','Внимание. Смена основного изображения.');
				endif;
			endif;
			for($i=0;$i<count($_FILES);$i++):
				if($_FILES['image'.$i]['error'] != 4):
					if(!$this->case_image($_FILES['image'.$i]['tmp_name'])):
						continue;
					endif;
					$img = getimagesize($_FILES['image'.$i]['tmp_name']);
					if(($img[0] < $img[1]) && ($img[1] > 800)):
						$data['image'] = $this->resize_image($_FILES['image'.$i]['tmp_name'],600,800,'height',TRUE);
					elseif(($img[0] > $img[1]) && ($img[0] > 800)):
						$data['image'] = $this->resize_image($_FILES['image'.$i]['tmp_name'],800,600,'width',TRUE);
					else:
						$data['image'] = file_get_contents($_FILES['image'.$i]['tmp_name']);
					endif;
					$data['main'] = 0;
					if(isset($_POST['image'.$i])):
						$data['main'] = 1;
					endif;
					$this->mdproductsimages->insert_record($data,$this->uri->segment(5));
					$cnt++;
				endif;
			endfor;
			if($cnt):
				$this->session->set_userdata('msgs','Загружено '.$cnt.' изображений!');
			endif;
			redirect('admin-panel/actions/products/productid/'.$this->uri->segment(5).'/images');
		endif;
		
		$this->load->view("admin_interface/products/add-image",$pagevar);
	}
	
	public function control_product_images_delete(){
		
		$imgid = $this->uri->segment(6);
		if($imgid):
			$pid = $this->mdproductsimages->read_field($imgid,'product_id');
			$result = $this->mdproductsimages->delete_record($imgid);
			if($result):
				$this->session->set_userdata('msgs','Изображение удалено успешно.');
			else:
				$this->session->set_userdata('msgr','Изображение не удалено.');
			endif;
			redirect('admin-panel/actions/products/productid/'.$pid.'/images');
		else:
			redirect($this->session->userdata('backpath'));
		endif;
	}
	
	public function control_edit_product(){
		
		$pid = $this->uri->segment(5);
		$pagevar = array(
			'title'			=> 'Панель администрирования | Редактирование продукта',
			'description'	=> '',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'product'		=> $this->mdproducts->read_admin_record($pid),
			'gender'		=> array(),
			'category'		=> $this->mdcategory->read_records(),
			'brands'		=> $this->mdbrands->read_records(),
			'prcolors'		=> $this->mdproductscolors->read_records($pid),
			'colors'		=> $this->mdcolors->read_records(),
			'prsizes'		=> $this->mdproductssizes->read_records($pid),
			'sizes'			=> $this->get_sizes(),
			'msgs'			=> $this->session->userdata('msgs'),
			'msgr'			=> $this->session->userdata('msgr'),
		);
		$this->session->unset_userdata('msgs');
		$this->session->unset_userdata('msgr');
		
		$pagevar['gender'][0]['title'] = 'Женская одежда';
		$pagevar['gender'][0]['checked'] = 0;
		$pagevar['gender'][1]['title'] = 'Мужская одежда';
		$pagevar['gender'][1]['checked'] = 0;
		$gender = $this->mdproducts->read_field($pid,'gender');
		if($gender == 2):
			$pagevar['gender'][0]['checked'] = 1;
			$pagevar['gender'][1]['checked'] = 1;
		else:
			$pagevar['gender'][$gender]['checked'] = 1;
		endif;
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$this->form_validation->set_rules('title',' ','required|trim');
			$this->form_validation->set_rules('composition',' ','required|trim');
			$this->form_validation->set_rules('art',' ','required|trim');
			$this->form_validation->set_rules('text',' ','required|trim');
			$this->form_validation->set_rules('gender[]',' ','required');
			$this->form_validation->set_rules('sizes[]',' ','required');
			$this->form_validation->set_rules('colors[]',' ','required');
			$this->form_validation->set_rules('category',' ','required');
			$this->form_validation->set_rules('brand',' ','required');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				$this->control_edit_product();
				return FALSE;
			else:
				if(count($_POST['gender']) == 2):
					$gender = 2;
				else:
					$gender = $_POST['gender'][0];
				endif;
				$_POST['gender'] = $gender;
				if(!isset($_POST['showitem'])):
					$_POST['showitem'] = 0;
				endif;
				$translit = $this->translite($_POST['title']);
				$this->mdproducts->update_record($pid,$_POST,$translit);
				/**************************************************************/
				$colors = array();
				for($i=0;$i<count($pagevar['colors']);$i++):
					$colors[$pagevar['colors'][$i]['id']] = $pagevar['colors'][$i]['code'];
				endfor;
				$colorslist = array();
				for($i=0,$j=0;$i<count($_POST['colors']);$i++):
					$colorslist[$j]['color_id'] = $_POST['colors'][$i];
					$colorslist[$j]['code']= $colors[$_POST['colors'][$i]];
					$j++;
				endfor;
				if(count($colorslist)):
					$this->mdproductscolors->delete_product_records($pid);
					$this->mdproductscolors->group_insert($pid,$colorslist);
				endif;
				/**************************************************************/
				$sizeslist = array();
				for($i=0,$j=0;$i<count($_POST['sizes']);$i++):
					$sizeslist[$j]['sizes_id'] = $_POST['sizes'][$i];
					$sizeslist[$j]['code']= $pagevar['sizes'][$_POST['sizes'][$i]]['code'];
					$j++;
				endfor;
				if(count($sizeslist)):
					$this->mdproductssizes->delete_product_records($pid);
					$this->mdproductssizes->group_insert($pid,$sizeslist);
				endif;
				/**************************************************************/
				$this->session->set_userdata('msgs','Продукт сохранен успешно.');
				redirect($this->session->userdata('backpath'));
			endif;
		endif;
		
		for($i=0;$i<count($pagevar['colors']);$i++):
			$pagevar['colors'][$i]['checked'] = 0;
			for($j=0;$j<count($pagevar['prcolors']);$j++):
				if($pagevar['prcolors'][$j]['color_id'] == $pagevar['colors'][$i]['id']):
					$pagevar['colors'][$i]['checked'] = 1;
				endif;
			endfor;
		endfor;
		for($i=0;$i<count($pagevar['sizes']);$i++):
			$pagevar['sizes'][$i]['checked'] = 0;
			for($j=0;$j<count($pagevar['prsizes']);$j++):
				if($pagevar['prsizes'][$j]['sizes_id'] == $pagevar['sizes'][$i]['id']):
					$pagevar['sizes'][$i]['checked'] = 1;
				endif;
			endfor;
		endfor;
		$this->load->view("admin_interface/products/edit-product",$pagevar);
	}
	
	public function control_delete_product(){
		
		$pid = $this->uri->segment(6);
		if($pid):
			$result = $this->mdproducts->delete_record($pid);
			if($result):
				$this->mdproductsimages->delete_records($pid);
				$this->mdproductscolors->delete_product_records($pid);
				$this->mdproductssizes->delete_product_records($pid);
				$this->session->set_userdata('msgs','Товар удален успешно.');
			else:
				$this->session->set_userdata('msgr','Товар не удалена.');
			endif;
			redirect($this->session->userdata('backpath'));
		else:
			show_404();
		endif;
	}
	
	/******************************************************** functions ******************************************************/	
	
	function get_sizes(){
	
		$sizes= array();
		for($i=0;$i<21;$i++):
			$sizes[$i]['id'] = $i;
			$sizes[$i]['code'] = '';
		endfor;
		$sizes[0]['code'] = '40(s)';
		$sizes[1]['code'] = '42(M)';
		$sizes[2]['code'] = '44(L)';
		$sizes[3]['code'] = '46(XL)';
		$sizes[4]['code'] = '48(XXL)';
		$sizes[5]['code'] = '50(3XL)';
		$sizes[6]['code'] = '52(4XL)';
		$sizes[7]['code'] = '54(5XL)';
		$sizes[8]['code'] = '56(6XL)';
		$sizes[9]['code'] = '44(s)';
		$sizes[10]['code'] = '48(M)';
		$sizes[11]['code'] = '52(L)';
		$sizes[12]['code'] = '56(XL)';
		$sizes[13]['code'] = '60(XXL)';
		$sizes[14]['code'] = '64(3XL)';
		$sizes[15]['code'] = '68(4XL)';
		$sizes[16]['code'] = '72(5XL)';
		$sizes[17]['code'] = '44-46(s)';
		$sizes[18]['code'] = '48-50(M)';
		$sizes[19]['code'] = '52-54(L)';
		$sizes[20]['code'] = '56-58(XL)';
		$sizes[17]['code'] = '44-46(s)';
		$sizes[18]['code'] = '48-50(M)';
		$sizes[19]['code'] = '52-54(L)';
		$sizes[20]['code'] = '56-58(XL)';
		return $sizes;
	}
	
	function resize_image($tmpName,$wgt,$hgt,$dim,$ratio){
			
		chmod($tmpName,0777);
		$img = getimagesize($tmpName);
		$this->load->library('image_lib');
		$this->image_lib->clear();
		$config['image_library'] 	= 'gd2';
		$config['source_image']		= $tmpName; 
		$config['create_thumb'] 	= FALSE;
		$config['maintain_ratio'] 	= $ratio;
		$config['quality'] 			= 100;
		$config['master_dim'] 		= $dim;
		$config['width'] 			= $wgt;
		$config['height'] 			= $hgt;
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
		
		$image = file_get_contents($tmpName);
		return $image;
	}
	
	function case_image($file){
			
		$info = getimagesize($file);
		switch ($info[2]):
			case 1	: return TRUE;
			case 2	: return TRUE;
			case 3	: return TRUE;
			default	: return FALSE;	
		endswitch;
	}
	
	public function translite($string){
		
		$rus = array("1","2","3","4","5","6","7","8","9","0","ё","й","ю","ь","ч","щ","ц","у","к","е","н","г","ш","з","х","ъ","ф","ы","в","а","п","р","о","л","д","ж","э","я","с","м","и","т","б","Ё","Й","Ю","Ч","Ь","Щ","Ц","У","К","Е","Н","Г","Ш","З","Х","Ъ","Ф","Ы","В","А","П","Р","О","Л","Д","Ж","Э","Я","С","М","И","Т","Б"," ");
		$eng = array("1","2","3","4","5","6","7","8","9","0","yo","iy","yu","","ch","sh","c","u","k","e","n","g","sh","z","h","","f","y","v","a","p","r","o","l","d","j","е","ya","s","m","i","t","b","Yo","Iy","Yu","CH","","SH","C","U","K","E","N","G","SH","Z","H","","F","Y","V","A","P","R","O","L","D","J","E","YA","S","M","I","T","B","-");
		$string = str_replace($rus,$eng,$string);
		if(!empty($string)):
			$string = preg_replace('/[^a-z0-9,-]/','',strtolower($string));
			$string = preg_replace('/[-]+/','-',$string);
			$string = preg_replace('/[\.\?\!\)\(\,\:\;]/','',$string);
			return $string;
		else:
			return FALSE;
		endif;
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
}