//////////// Event ///////////////////////////
$(document).ready(function(){


});




//////////// Script Main /////////////////////
window.browse_img_preview = function(name) {
	//Show ภาพ
	$(document).on('change','input.img', function(event) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
		$(name).fadeIn("fast").attr('src',tmppath);
		$(name).css('display','block');
		$(name).css('margin-bottom','5px');
	});
}


window.back = function(url) {
	$(document).on('click','button#back',function(e){
		e.preventDefault();
		window.location.href = url;
	});
}

window.validate_step = function(name) {
	var form = $(name).show();
	form.steps({
		headerTag: "h3",
		bodyTag: "fieldset",
		transitionEffect: "slide",
		stepsOrientation: "vertical",
		autoFocus: true,
		labels: {
			current: "current step:",
			pagination: "Pagination",
			finish: "บันทึกข้อมูล",
			next: "หน้าถัดไป",
			previous: "กลับหน้าก่อน",
			loading: "Loading ..."
		},
		onStepChanging: function(event, currentIndex, newIndex) {
			// Allways allow previous action even if the current form is not valid!
			if (currentIndex > newIndex) {
				return true;
			}
			// // Forbid next action on "Warning" step if the user is to young
			// if (newIndex === 3 && Number($("#age-2").val()) < 18) {
			//     return false;
			// }
			// Needed in some cases if the user went back (clean up)
			if (currentIndex < newIndex) {
				// To remove error styles
				form.find(".body:eq(" + newIndex + ") label.error").remove();
				form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
			}
			form.validate().settings.ignore = ":disabled,:hidden";
			return form.valid();
		},
		onStepChanged: function(event, currentIndex, priorIndex) {
			// // Used to skip the "Warning" step if the user is old enough.
			// if (currentIndex === 2 && Number($("#age-2").val()) >= 18) {
			//     form.steps("next");
			// }
			// // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
			// if (currentIndex === 2 && priorIndex === 3) {
			//     form.steps("previous");
			// }
		},
		onFinishing: function(event, currentIndex) {
			form.validate().settings.ignore = ":disabled";
			return form.valid();
		},
		onFinished: function(event, currentIndex) {
			form.submit();
		}
	}).validate({
		errorPlacement: function errorPlacement(error, element) {
			element.before(error);
		},
		rules: {
			// confirm: {
			//     equalTo: "#password-2"
			// }
		}
	});
}

window.ckeditor = function(token,url,name,width = 500,height = 700) {
	
	var options = {
		filebrowserImageBrowseUrl: url+"laravel-filemanager?type=Images",
		filebrowserImageUploadUrl: url+"laravel-filemanager/upload?type=Images&_token="+token,
		filebrowserBrowseUrl: url+"laravel-filemanager?type=Files",
		filebrowserUploadUrl: url+"laravel-filemanager/upload?type=Files&_token="+token,
		width : width,
		height : height,
		allowedContent : true,
		removeFormatAttributes : '',
		toolbar: [
			{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
			{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
			{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
			{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
			'/',
			{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
			{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
			{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
			{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe','Youtube' ] },
			'/',
			{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
			{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
			{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
			{ name: 'others', items: [ '-' ] },
			{ name: 'about', items: [ 'About' ] }
		],
		toolbarGroups : [
			{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
			{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
			{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
			{ name: 'forms' },
			'/',
			{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
			{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
			{ name: 'links' },
			{ name: 'insert' },
			'/',
			{ name: 'styles' },
			{ name: 'colors' },
			{ name: 'tools' },
			{ name: 'others' },
			{ name: 'about' }
		],
	};

	$(name).ckeditor(options);
}

window.update_sort = function(route,token,table,where,colunm,this_,lvpath) {
    var route = route;
    var token = token;
    var table = table;
    var where = where;
    var id = this_.parents('tr').find('input[name="check_id"]').attr('val_id');
    var colunm = colunm;
    var val = this_.val();
    var _append = this_.parent();
    var mode = 'sort';
    window.ajax_update_record(route,token,table,where,id,colunm,val,_append,mode,lvpath);
}

window.update_active = function(route,token,table,where,colunm,this_,lvpath) {
    var route = route;
    var token = token;
    var table = table;
    var where = where;
    var id = this_.parents('tr').find('input[name="check_id"]').attr('val_id');
    var colunm = colunm;
    var val = '';
    if(this_.html() == 'On') {
        val = 0;
    } else if(this_.html() == 'Off') {
        val = 1;
    }
    var _append = this_;
    var mode = 'active';
    window.ajax_update_record(route,token,table,where,id,colunm,val,_append,mode,lvpath);
}

window.ajax_update_record =  function(route,token,table,where,id,colunm,val,_append,mode,lvpath) {
	
	var status = '';
	$.ajax({
	    url: route,
	    type: "post",
	    data: {
	        'table'  : table,
	        'where'  : where,
	        'id'     : id,
	        'colunm' : colunm,
	        'val'  : val,
	        '_token' : token
	    },
	    dataType: "json",
	    async: false,
	    success: function(data) {
	    	status = data.status;
	    }
	});

	var path = '..';
	if(lvpath) {
		path = lvpath;
    }

	$('div#ajax_status').remove();
	if(status == 'success') {
		if(mode == 'active') {
			var has_class_success = _append.hasClass('btn-success');
			var has_class_danger  = _append.hasClass('btn-danger');
			if(has_class_success) {
				_append.removeClass('btn-success').addClass('btn-danger').html('Off').attr('data-original-title','คลิ๊กเปลี่ยนเป็น On').tooltip('show');
			} else if(has_class_danger) {
				_append.removeClass('btn-danger').addClass('btn-success').html('On').attr('data-original-title','คลิ๊กเปลี่ยนเป็น Off').tooltip('show');
			}
		} else if(mode == 'time') {
			//time
			_append.append("<div id='ajax_status'><img src='/public/backend/images/success.png'></div>");
		} else {
			//mode = sort,
			_append.append("<div id='ajax_status'><img src='/public/backend/images/success.png'></div>");
		}
	} else if(status == 'fail') {
		if(mode == 'active') {
			var has_class_success = _append.hasClass('btn-success');
			var has_class_danger  = _append.hasClass('btn-danger');
			if(has_class_success) {
				_append.removeClass('btn-success').addClass('btn-danger').html('Off').attr('data-original-title','คลิ๊กเปลี่ยนเป็น On').tooltip('show');
			} else if(has_class_danger) {
				_append.removeClass('btn-danger').addClass('btn-success').html('On').attr('data-original-title','คลิ๊กเปลี่ยนเป็น Off').tooltip('show');
			}
		} else if(mode == 'time') {
			//time
			_append.append("<div id='ajax_status'><img src='/public/backend/images/fail.png'></div>");
		} else {
			//mode = sort,
			_append.append("<div id='ajax_status'><img src='/public/backend/images/fail.png'></div>");
		}
		
	}

	if(mode == 'sort' || mode == 'time') {
		setTimeout(function(){
			$('div#ajax_status').hide('slow', function(){ $('div#ajax_status').remove(); });
		},1000);
	}
}