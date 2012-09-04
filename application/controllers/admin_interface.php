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
	
	public function admin_logoff(){
		
		$this->session->sess_destroy();
			redirect('');
	}
	
	public function admin_category(){
		
		
	}
	
	public function admin_events(){
		
		
	}
	
	public function admin_storage(){
		
		
	}
	
	public function admin_baners(){
		
		
	}
	
	public function admin_edit_text(){
		
		
	}
	
	/******************************************************* events ************************************************************/
	
	public function control_events(){
		
		$from = intval($this->uri->segment(5));
		$pagevar = array(
			'title'			=> 'Панель администрирования | Новости',
			'description'	=> 'Игристые вина',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'events'		=> $this->mdunion->events_limit(7,$from),
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
		$config['per_page'] 		= 7;
		$config['num_links'] 		= 4;
		$config['first_link']		= 'В начало';
		$config['last_link'] 		= 'В конец';
		$config['next_link'] 		= 'Далее &raquo;';
		$config['prev_link'] 		= '&laquo; Назад';
		$config['cur_tag_open']		= '<span class="actpage">';
		$config['cur_tag_close'] 	= '</span>';
		
		$this->pagination->initialize($config);
		$pagevar['pages'] = $this->pagination->create_links();
		
		$this->session->set_userdata('backpath',$pagevar['baseurl'].$this->uri->uri_string());
		$this->load->view("admin_interface/events/list-events",$pagevar);
	}
	
	public function control_add_events(){
		
		$pagevar = array(
			'title'			=> 'Панель администрирования | Добавление новости или события',
			'description'	=> 'Игристые вина',
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
					$_POST['image'] = file_get_contents(base_url().'images/noimages/no_events.png');
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
			'description'	=> 'Игристые вина',
			'author'		=> '',
			'baseurl'		=> base_url(),
			'loginstatus'	=> $this->loginstatus,
			'userinfo'		=> $this->user,
			'event'			=> $this->mdevents->read_record($nid),
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
				$translit = $this->translite($_POST['title']);
				$result = $this->mdevents->update_record($nid,$_POST,$translit);
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
			'description'	=> 'Игристые вина',
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
			'description'	=> 'Игристые вина',
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
			'description'	=> 'Игристые вина',
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
//				$this->mdproducts->delete_records_category($cid);
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
		
		$this->session->set_userdata('backpath',$pagevar['baseurl'].$this->uri->uri_string());
		$this->load->view("admin_interface/products/brands",$pagevar);
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
			$this->form_validation->set_rules('text',' ','trim');
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
				if($_FILES['pdf']['error'] != 4):
					
					$_FILES['pdf']['name'] = preg_replace('/.+(.)(\.)+/',$translit."\$2", $_FILES['pdf']['name']);
					$config['upload_path'] 		= getcwd().'/catalogs/';
					$config['allowed_types'] 	= 'pdf';
					$config['remove_spaces'] 	= TRUE;
					$config['overwrite'] 		= TRUE;
					$this->load->library('upload',$config);
					if(!$this->upload->do_upload('pdf')):
						$this->session->set_userdata('msgr','Ошибка при загрузке документа.');
					else:
						$_POST['pdf'] = 'catalogs/'.$_FILES['pdf']['name'];
					endif;
				endif;
				$cid = $this->mdbrands->insert_record($_POST,$translit);
				if($cid):
					$this->session->set_userdata('msgs','Запись создана успешно.');
				endif;
				redirect($this->uri->uri_string());
			endif;
		endif;
		
		$this->load->view("admin_interface/products/add-brand",$pagevar);
	}
	
	public function control_edit_brand(){
		
		$bid = $this->mdbrands->read_field_translit($this->uri->segment(5),'id');
		if(!$bid):
			redirect($this->session->userdata('backpath'));
		endif;
		$pagevar = array(
			'title'			=> 'Панель администрирования | Редактирование категории товара',
			'description'	=> 'Игристые вина',
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
			$this->form_validation->set_rules('text',' ','trim');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msgr','Ошибка. Неверно заполены необходимые поля<br/>');
				$this->control_edit_brand();
				return FALSE;
			else:
				if($_FILES['image']['error'] != 4):
					$_POST['image'] = file_get_contents($_FILES['image']['tmp_name']);
				endif;
				$translit = $this->translite($_POST['title']);
				if($_FILES['pdf']['error'] != 4):
					$_FILES['pdf']['name'] = preg_replace('/.+(.)(\.)+/',$translit."\$2", $_FILES['pdf']['name']);
					$config['upload_path'] 		= getcwd().'/catalogs/';
					$config['allowed_types'] 	= 'pdf';
					$config['remove_spaces'] 	= TRUE;
					$config['overwrite'] 		= TRUE;
					$this->load->library('upload',$config);
					if(file_exists(getcwd().'/'.$pagevar['brand']['pdf'])):
						unlink(getcwd().'/'.$pagevar['brand']['pdf']);
					endif;
					if(!$this->upload->do_upload('pdf')):
						$this->session->set_userdata('msgr','Ошибка при загрузке документа.');
					else:
						$_POST['pdf'] = 'catalogs/'.$_FILES['pdf']['name'];
					endif;
				endif;
				$result = $this->mdbrands->update_record($bid,$_POST,$translit);
				if($result):
					$this->session->set_userdata('msgs','Запись сохранена успешно.');
				endif;
				redirect($this->session->userdata('backpath'));
			endif;
		endif;
		
		$this->load->view("admin_interface/products/edit-brand",$pagevar);
	}
	
	public function control_delete_brand(){
		
		$bid = $this->uri->segment(6);
		if($bid):
			$filepath = getcwd().'/'.$this->mdbrands->read_field($bid,'pdf');
			if(file_exists($filepath)):
				unlink($filepath);
			endif;
			$result = $this->mdbrands->delete_record($bid);
			if($result):
//				$this->mdproducts->delete_records_category($bid);
				$this->session->set_userdata('msgs','Бренд удален успешно.');
			else:
				$this->session->set_userdata('msgr','Бренд не удален.');
			endif;
			redirect($this->session->userdata('backpath'));
		else:
			show_404();
		endif;
	}
	
	
	/******************************************************** functions ******************************************************/	
	
	public function translite($string){
		
		$rus = array("1","2","3","4","5","6","7","8","9","0","ё","й","ю","ь","ч","щ","ц","у","к","е","н","г","ш","з","х","ъ","ф","ы","в","а","п","р","о","л","д","ж","э","я","с","м","и","т","б","Ё","Й","Ю","Ч","Ь","Щ","Ц","У","К","Е","Н","Г","Ш","З","Х","Ъ","Ф","Ы","В","А","П","Р","О","Л","Д","Ж","Э","Я","С","М","И","Т","Б"," ");
		$eng = array("1","2","3","4","5","6","7","8","9","0","yo","iy","yu","","ch","sh","c","u","k","e","n","g","sh","z","h","","f","y","v","a","p","r","o","l","d","j","е","ya","s","m","i","t","b","Yo","Iy","Yu","CH","","SH","C","U","K","E","N","G","SH","Z","H","","F","Y","V","A","P","R","O","L","D","J","E","YA","S","M","I","T","B","-");
		$string = str_replace($rus,$eng,$string);
		if(!empty($string)):
			$string = preg_replace('/[^a-z,-]/','',strtolower($string));
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