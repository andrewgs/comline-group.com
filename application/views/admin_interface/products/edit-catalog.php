<!DOCTYPE html>
<html lang="en">
<?php $this->load->view("admin_interface/includes/head");?>
<body>
	<?php $this->load->view("admin_interface/includes/header");?>
	<div class="container">
		<div class="row">
			<div class="span9">
				<ul class="breadcrumb">
					<li>
						<?=anchor('',"Бренды",array('class'=>'none backpath'));?><span class="divider">/</span>
					</li>
					<li>
						<?=anchor('admin-panel/actions/brands/brandsid/'.$this->uri->segment(5).'/catalogs',"Каталоги");?><span class="divider">/</span>
					</li>
					<li class="active">
						<?=$brand;?><span class="divider">/</span>Редактирование
					</li>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
				<?php $this->load->view("forms/frmeditcatalog");?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script src="<?=$baseurl;?>js/redactor.min.js"></script>
	<script type="text/javascript" src="<?=$baseurl;?>markitup/jquery.markitup.js"></script>
	<script type="text/javascript" src="<?=$baseurl;?>markitup/sets/html/set.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			myHtmlSettings = {
				nameSpace:       "html", // Useful to prevent multi-instances CSS conflict
				onShiftEnter:    {keepDefault:false, replaceWith:'<br />\n'},
				onCtrlEnter:     {keepDefault:false, openWith:'\n<p>', closeWith:'</p>\n'},
				onTab:           {keepDefault:false, openWith:'     '},
				markupSet:  [
				{name:'Heading 1', key:'1', openWith:'<h1(!( class="[![Class]!]")!)>', closeWith:'</h1>', placeHolder:'Your title here...' },
				{name:'Heading 2', key:'2', openWith:'<h2(!( class="[![Class]!]")!)>', closeWith:'</h2>', placeHolder:'Your title here...' },
				{name:'Heading 3', key:'3', openWith:'<h3(!( class="[![Class]!]")!)>', closeWith:'</h3>', placeHolder:'Your title here...' },
				{name:'Heading 4', key:'4', openWith:'<h4(!( class="[![Class]!]")!)>', closeWith:'</h4>', placeHolder:'Your title here...' },
				{name:'Heading 5', key:'5', openWith:'<h5(!( class="[![Class]!]")!)>', closeWith:'</h5>', placeHolder:'Your title here...' },
				{name:'Heading 6', key:'6', openWith:'<h6(!( class="[![Class]!]")!)>', closeWith:'</h6>', placeHolder:'Your title here...' },
				{name:'Paragraph', openWith:'<p(!( class="[![Class]!]")!)>', closeWith:'</p>'  },
				{separator:'---------------' },
				{name:'Bold', key:'B', openWith:'<strong>', closeWith:'</strong>' },
				{name:'Italic', key:'I', openWith:'<em>', closeWith:'</em>'  },
				{name:'Stroke through', key:'S', openWith:'<del>', closeWith:'</del>' },
				{separator:'---------------' },
				{name:'Ul', openWith:'<ul>\n', closeWith:'</ul>\n' },
				{name:'Ol', openWith:'<ol>\n', closeWith:'</ol>\n' },
				{name:'Li', openWith:'<li>', closeWith:'</li>' },
				{separator:'---------------' },
				{name:'Picture', key:'P', replaceWith:'<img src="[![Source:!:http://]!]" alt="[![Alternative text]!]" />' },
				{name:'Link', key:'L', openWith:'<a href="[![Link:!:http://]!]"(!( title="[![Title]!]")!)>', closeWith:'</a>', placeHolder:'Your text to link...' },
				{separator:'---------------' },
				{name:'Clean', replaceWith:function(h) { return h.selection.replace(/<(.*?)>/g, "") } },
				{name:'Preview', call:'preview', className:'preview' }
				]
			}
			$(".mrkRedactor").markItUp(myHtmlSettings);
			$('.redactor').redactor();
		});
	</script>
</body>
</html>
