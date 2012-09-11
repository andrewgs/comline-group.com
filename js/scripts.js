/*  Author: Reality Group
 *  http://realitygroup.ru/
 */
 
function isValidEmailAddress(emailAddress){
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return pattern.test(emailAddress);
};

function isValidPhone(phoneNumber){
	var pattern = new RegExp(/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/i);
	return pattern.test(phoneNumber);
};

function myserialize(objects){
	var data = '';
	$(objects).each(function(i,element){
		if(data === ''){
			data = $(element).attr('name')+"="+$(element).val();
		}else{
			data = data+"&"+$(element).attr('name')+"="+$(element).val();
		}
	});
	return data;
};

function backpath(path){window.location=path;}
(function($){
	var baseurl = "http://comline-group.com/";
	$("#msgeclose").click(function(){$("#msgdealert").fadeOut(1000,function(){$(this).remove();});});
	$("#msgsclose").click(function(){$("#msgdsalert").fadeOut(1000,function(){$(this).remove();});});
	$(".digital").keypress(function(e){if(e.which!=8 && e.which!=46 && e.which!=0 && (e.which<48 || e.which>57)){return false;}});
	$(".none").click(function(event){event.preventDefault();});
	
	$("#send").click(function(event){
		var err = false;$(".control-group").removeClass('error');$(".help-inline").hide();
		$(".input-valid").each(function(i,element){if($(this).val()==''){$(this).parents(".control-group").addClass('error');$(this).siblings(".help-inline").html("Поле не может быть пустым").show();err = true;}});if(err){event.preventDefault();}
	});
	$("#PartnerSend").click(function(event){
		var err = false;
		$(".become-partner fieldset").removeClass("validate");
		$(".become-partner .valid-required").each(function(i,element){if($(this).val()==''){$(this).parents("fieldset").addClass('validate');err = true;}});
		if(err){event.preventDefault();}
		if(!err && !isValidEmailAddress($(".become-partner .valid-email").val())){$(".become-partner .valid-email").parents("fieldset").addClass('validate');err = true; event.preventDefault();}
		if(!err && !isValidPhone($(".become-partner .valid-phone").val())){$(".become-partner .valid-phone").parents("fieldset").addClass('validate');err = true; event.preventDefault();}
		if(!err){var postdata = myserialize($(".become-partner .FieldSend"));
			console.log(postdata);
			$.post(baseurl+"send-mail/partners",{'postdata':postdata},
			function(data){if(data.status){$(".become-partner em").show();$(".become-partner .submit").addClass("submitted");}else{$(".become-partner em").html(data.message).show();}},"json");
		}
		event.preventDefault();
	});
	$("#CallSend").click(function(event){
		var err = false;
		$(".get-call fieldset").removeClass("validate");
		$(".get-call .valid-required").each(function(i,element){if($(this).val()==''){$(this).parents("fieldset").addClass('validate');err = true;}});
		if(err){event.preventDefault();}
		if(!err && !isValidPhone($(".get-call .valid-phone").val())){$(".get-call .valid-phone").parents("fieldset").addClass('validate');err = true; event.preventDefault();}
		if(!err){var postdata = myserialize($(".get-call .FieldSend"));
			$.post(baseurl+"send-mail/call",{'postdata':postdata},
			function(data){if(data.status){$(".get-call em").show();$(".get-call .submit").addClass("submitted");}else{$(".get-call em").html(data.message).show();}},"json");
		}
		event.preventDefault();
	});
	
	$('#action-partner').click(function(e){
		e.preventDefault();
		$('div.popup:not(.become-partner)').hide();
		$('div.become-partner').toggle();
	});
	$('.phone a.dashed').click(function(e){
		e.preventDefault();
		$('div.popup:not(.get-call)').hide();
		$('div.get-call').toggle();
	}); 
	$('#action-shop').click(function(e){
		e.preventDefault();
		$('div.popup').hide();
		$('div.overlay').show();
		setTimeout( function() { $('div.overlay').fadeOut(1000);},3000);
	});
	$(document.body).click(function(e){
		if ( e.target == this ) {
			$('div.popup').hide();
		}
	});
})(window.jQuery);