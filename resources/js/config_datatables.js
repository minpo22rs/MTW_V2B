/// Datatables : Config
	//ใช้กับ Datatables ทุกตัว Public
	window.lang_dt = {
        sProcessing:   "<img src='../public/backend/images/loading_1.gif'><div><button type=\"submit\" class=\"btn btn-grd-warning\">กรุณารอสักครู่...</button></div>",
        sLengthMenu: "แสดง _MENU_ รายการ",
        sZeroRecords:  "ไม่พบข้อมูล",
        sInfo: "แสดง <b>_START_</b> ถึง <b>_END_</b> รายการ (พบทั้งหมด <b>_TOTAL_</b> รายการ)",
        sInfoEmpty: "แสดง 0 ถึง 0 รายการ",
        sInfoFiltered: "(ค้นหาข้อมูลจาก <b>_MAX_</b> รายการ)",
        sInfoPostFix:  "",
        sSearch: " ",//ค้นหา : ใช้ placeholder
        sUrl:          "",
        oPaginate: {
            sFirst:    "หน้าแรก",
            sPrevious: "ก่อนหน้า",
            sNext:     "ถัดไป",
            sLast:     "หน้าสุดท้าย"
        }
    }
    window.lang_dt_subfolder = {
        sProcessing:   "<img src='../../../public/backend/images/loading_1.gif'><div><button type=\"submit\" class=\"btn btn-grd-warning\">กรุณารอสักครู่...</button></div>",
        sLengthMenu: "แสดง _MENU_ รายการ",
        sZeroRecords:  "ไม่พบข้อมูล",
        sInfo: "แสดง <b>_START_</b> ถึง <b>_END_</b> รายการ (พบทั้งหมด <b>_TOTAL_</b> รายการ)",
        sInfoEmpty: "แสดง 0 ถึง 0 รายการ",
        sInfoFiltered: "(ค้นหาข้อมูลจาก <b>_MAX_</b> รายการ)",
        sInfoPostFix:  "",
        sSearch: " ",//ค้นหา : ใช้ placeholder
        sUrl:          "",
        oPaginate: {
            sFirst:    "หน้าแรก",
            sPrevious: "ก่อนหน้า",
            sNext:     "ถัดไป",
            sLast:     "หน้าสุดท้าย"
        }
    }
    window.select_dt = {
        style:    'os',
        selector: 'td:first-child'
    };

    window.iDisplayLength = 25; //จำนวนแถวโช
    window.aLengthMenu = [[25, 50, 100,200, -1], [25, 50, 100,200, "All"]]; // เลือกโช Record

    //Gen Input Search
    window.dt_gen_input = function(dt, $hide = [], class_input, select = []) {

    	

    	var select_arr = [];
    	var select_arr_op = [];
    	if(select.length == undefined) { //Object = undefined
        	$.each(select, function( index, option ) {
				select_arr.push(parseInt(index, 10)); //Push จะเป็น String ต้องครอบด้วย parseInt
				select_arr_op.push(option);
			});
    	}


    	var x = 0;
    	dt.each( function () {
	        var ind   = $(this).index();
	        var title = $(this).text();
	        var style;

	        var index_search = $hide; //นับจาก Column
	        if(index_search.indexOf(ind) < 0) {
	        	if(select_arr.indexOf(ind) >= 0 && select_arr_op[ind]) { //select 
	        		style = 'style="width:85%; background-color:beige; height:20px;"';
            		$(this).html( '<select class="form-control '+class_input+'" rel_index="'+x+'" placeholder="ค้นหาคอลัมน์นี้" '+style+'>'+select_arr_op[ind]+'</select>' );
	        	} else { //input
		            style = 'style="width:85%; background-color:beige;"';
		            $(this).html( '<input type="search" class="form-control '+class_input+'" rel_index="'+x+'" placeholder="ค้นหาคอลัมน์นี้" '+style+' />' );
		        }
	        }
	        
	        x++;
	    })
    }

    //Key Search
    window.dt_key_search = function(class_input, tbl) {
    	$(document).on('keyup change', '.'+class_input, function(e){
    		var type = e.type;
	        var colIdx = $(this).attr('rel_index');
	        if(this.value.length > 0 || e.keyCode == '8' || type == 'change') { //8 = Backspace
	            tbl
	                .column( colIdx )
	                .search( this.value )
	                .draw();    
	        }
	    });
    }

    // Show Search
    window.dt_show_search = function(oSettings, json, dts) {
    	var cols = oSettings.aoPreSearchCols;
        for (var i = 0; i < cols.length; i++) {
            var value = cols[i].sSearch;
            if (value.length > 0) {
                dts.find('input[rel_index="'+i+'"],select[rel_index="'+i+'"]').val(value);
            }
        }

        //ใส่สีช่อง Input Search Main 
        dts.parents('.dataTables_wrapper').find('.dataTables_filter').find('input[type="search"]').css('background-color', 'beige').attr('placeholder', 'ค้นหาทุกคอลัมน์');
    }

	
	//Clear Search
	window.dt_clear_search = function(clear_id, class_input, tbl, sorting) {
		$(document).on('click','#'+clear_id,function(){
	        $('.'+class_input).each(function(index, el) {
	            $(this).val('');
	        });
	        tbl.search( '' ).columns().search( '' );
	        tbl.state.clear();
	        tbl.draw().order( sorting );
	        tbl.ajax.reload(); //Load table ใหม่เพราะดึงข้อมูลจากหน้านี้
	    });
	}

	//Clear Search
	window.dt_clear_search_no_ajax = function(clear_id, class_input, tbl, sorting) {
		$(document).on('click','#'+clear_id,function(){
	        $('.'+class_input).each(function(index, el) {
	            $(this).val('');
	        });
	        tbl.search( '' ).columns().search( '' );
	        tbl.state.clear();
	        tbl.draw().order( sorting );
	    });
	}


////////////////////////////////////////////////////////// Datatables
$(document).on('click', 'button.add, button.edit', function(){
	
	if($(this).hasClass('edit') && !$(this).attr('href')) {
		alert('กรุณาเลือกรายการที่ต้องการแก้ไขก่อนค่ะ');
		return false;

	}

	window.location.href = $(this).attr('href');
});

$(document).on('click', 'input[name="check_id"]', function(){
	var this_mode = $(this).attr('mode');
	
	if(this_mode) {
		//Get Url
		var href_edit         		   = $('button.edit[mode="'+this_mode+'"]').attr('url');
		var href_delete       		   = $('button.delete[mode="'+this_mode+'"]').attr('url');
	} else {
		//Get Url
		var href_edit         		   = $('button.edit').attr('url');
		var href_delete       		   = $('button.delete').attr('url');
	}

	//Gen Url
	var val_id = $('input[name="check_id"]:checked').attr('val_id');
	if(!val_id) val_id = ''; else val_id = '/'+val_id;


	var url_edit = href_edit+val_id+'/edit';
	var url_delete = href_delete+val_id+'/delete';

	//Mode (หน้า edit/create) | หน้า View จะว่าง
	if(val_id) {
		if(this_mode) {
			$('button.edit[mode="'+this_mode+'"]').attr('href', url_edit); 
			$('button.delete[mode="'+this_mode+'"]').attr('href', url_delete); 
		} else {
			$('button.edit').attr('href', url_edit); 		
			$('button.delete').attr('href', url_delete); 

			$('button.edit').each(function(){
				if($(this).attr('type')) {
					var url_edit = href_edit+val_id+'/'+$(this).attr('type');
					$(this).attr('href', url_edit); 	
				}
			});
				
		}
	} else {
		$('button.edit').removeAttr('href'); 		
		$('button.delete').removeAttr('href'); 
	}

});

$(document).on('click', 'button.delete', function(e){ 
	var url = $(this).attr('href');
	var this_mode = $(this).attr('mode');
    var hasClass_delete = $(this).hasClass('delete');
    e.preventDefault();
    if(this_mode) {
    	var checked = $('input[name="check_id"][mode="'+this_mode+'"]:checked').length;
    } else {
   		var checked = $('input[name="check_id"]:checked').length;
   	}
    if(checked == 0) {
    	var mode = '';
    	if(hasClass_delete) {
    		mode = 'ลบ';
    	} 
        alert('กรุณาเลือกรายการที่ต้องการ'+mode+'ก่อนค่ะ');
    } else {
    	if(hasClass_delete) {
        	var x = confirm("คุณแน่ใจว่าต้องการลบข้อมูล?");
	        if (x) {
	           
	        } else {
	            event.preventDefault();
	            return false;
	        }
	    } 
        window.location.href = url;
    }
});


window.ajax_update_image =  function(route,_append,mode,formData,datatable,lvpath) {
	
	var status = '';
    $.ajax({
        url: route,
        type: "post",
        data: formData,
        processData: false,
        contentType: false,
        async: false,
        dataType: "json",
        success: function(data){
            status = data.status;
            datatable.ajax.reload();
        }
    });

    var path = '..';
	if(lvpath) {
		path = lvpath;
	}

	$('div#ajax_status').remove();
	if(status == 'success') {
		if(mode == 'active') {
			var has_class_success = _append.hasClass('label-success');
			var has_class_danger  = _append.hasClass('label-danger');
			if(has_class_success) {
				_append.removeClass('label-success').addClass('label-danger').html('Off').attr('data-original-title','คลิ๊กเปลี่ยนเป็น On').tooltip('show');
			} else if(has_class_danger) {
				_append.removeClass('label-danger').addClass('label-success').html('On').attr('data-original-title','คลิ๊กเปลี่ยนเป็น Off').tooltip('show');
			}
		} else if(mode == 'time') {
			//time
			_append.append("<div id='ajax_status'><img src='"+path+"/public/backend/images/success.png'></div>");
		} else {
			//mode = sort,
			_append.append("<div id='ajax_status'><img src='"+path+"/public/backend/images/success.png'></div>");
		}
	} else if(status == 'fail') {
		if(mode == 'active') {
			var has_class_success = _append.hasClass('label-success');
			var has_class_danger  = _append.hasClass('label-danger');
			if(has_class_success) {
				_append.removeClass('label-success').addClass('label-danger').html('Off').attr('data-original-title','คลิ๊กเปลี่ยนเป็น On').tooltip('show');
			} else if(has_class_danger) {
				_append.removeClass('label-danger').addClass('label-success').html('On').attr('data-original-title','คลิ๊กเปลี่ยนเป็น Off').tooltip('show');
			}
		} else if(mode == 'time') {
			//time
			_append.append("<div id='ajax_status'><img src='"+path+"/public/backend/images/fail.png'></div>");
		} else {
			//mode = sort,
			_append.append("<div id='ajax_status'><img src='"+path+"/public/backend/images/fail.png'></div>");
		}
		
	}

	//ลบสัญลักษณ์
	if(mode == 'sort' || mode == 'time' || mode == 'cover' || mode == 'album' || mode == 'more' || mode == 'vdo' || mode == 'map' || mode == 'listname' || mode == 'slide_vdo' || mode == 'more_vdo' || mode == 'update_stock') {
		setTimeout(function(){
			$('div#ajax_status').hide('slow', function(){ $('div#ajax_status').remove(); });
		},1000);
	} else if(mode == 'delete_li') {
		_append.hide('slow', function(){ $(this).remove(); });
	}

	//Refresh หน้าจอ
	if(mode == 'cover' || mode == 'slide1' || mode == 'slide2' || mode == 'album' || mode == 'more' || mode == 'vdo' || mode == 'map' || mode == 'listname' || mode == 'slide_vdo' || mode == 'more_vdo') {
		setTimeout(function(){
			window.location.reload();
		},1000);
	}
}
