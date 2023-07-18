$(document).ready(function() {
	$.ajaxSetup({
	    headers: {
	      	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$("#select-all").click(function () {
        $('.selectone:checkbox').not(this).prop('checked', this.checked);
    });

	$("#create-form").on('submit',function(e){
	    e.preventDefault();
	    var form = $(this);
	    let formData = new FormData(this);
	    var curSubmit = $(this).find("button.add-podcast-btn");
    	// toastr.options.timeOut = 10000;

    	toastr.options ={
           "closeButton" : true,
           "progressBar" : true,
           "disableTimeOut" : true,
       	}

	    $.ajax({
	        type : 'post',
	        url : form.attr('action'),
	        data : formData,
	        dataType: 'json',
	        contentType: false,
	        processData: false,
	        beforeSend : function(){
	            curSubmit.html(`Sending.. <i class="fa fa-spinner fa-spin"></i>`).attr('disabled',true);
	        },
	        success : function(response){
	        	if(response.status==201){	        		
	        		curSubmit.html(`Save`).attr('disabled',false);
	        		toastr.success(response.message);
	        		
	        		setTimeout(function () {
	        		    var url = $('#redirect_url').val();
	        		    if(url !== undefined || url != null){
	        		    	window.location = url;
	        		    } else {
	        		    	location.reload(true);
	        		    }
	        		}, 2000);
	        		return false;
	        	}

	        	if(response.status==200){
	        	    curSubmit.html(`Save`).attr('disabled',false);
	        	    toastr.error(response.message);
	        	    return false;
	        	}
	        },
	        error : function(data){
	            if(data.status==422){
	            	let li_htm = '';
	                $.each(data.responseJSON.errors,function(k,v){
	                    const $input = form.find(`input[name=${k}],select[name=${k}],textarea[name=${k}]`);
	                    if($input.next('small').length){
	                        $input.next('small').html(v);
	                        if(k == 'services' || k == 'membership'){
	                        	$('#myselect').next('small').html(v);
	                        }
	                    }else{
	                        $input.after(`<small class='text-danger'>${v}</small>`);
	                        if(k == 'services' || k == 'membership'){
	                        	$('#myselect').after(`<small class='text-danger'>${v[0]}</small>`);
	                        }
	                    }
	                    li_htm += `<li>${v}</li>`;
	                });
	                curSubmit.html(`Save`).attr('disabled',false);
	                return false;
	            }else{
	                curSubmit.html(`Save`).attr('disabled',false);
	                toastr.error(data.statusText);
	                return false;
	            }
	        }
	    });
	});
	$("#edit-form").on('submit',function(e){
	    e.preventDefault();
	    var form = $(this);
	    let formData = new FormData(this);
	    var curSubmit = $(this).find("button.add-podcast-btn");
    	// toastr.options.timeOut = 10000;

    	toastr.options ={
           "closeButton" : true,
           "progressBar" : true,
           "disableTimeOut" : true,
       	}

	    $.ajax({
	        type : 'post',
	        url : form.attr('action'),
	        data : formData,
	        dataType: 'json',
	        contentType: false,
	        processData: false,
	        beforeSend : function(){
	            curSubmit.html(`Sending.. <i class="fa fa-spinner fa-spin"></i>`).attr('disabled',true);
	        },
	        success : function(response){
	        	if(response.status==201){	        		
	        		curSubmit.html(`Save`).attr('disabled',false);
	        		toastr.success(response.message);
	        		
	        		setTimeout(function () {
	        		    var url = $('#redirect_url').val();
	        		    if(url !== undefined || url != null){
	        		    	window.location = url;
	        		    } else {
	        		    	location.reload(true);
	        		    }
	        		}, 2000);
	        		return false;
	        	}

	        	if(response.status==200){
	        	    curSubmit.html(`Save`).attr('disabled',false);
	        	    toastr.error(response.message);
	        	    return false;
	        	}
	        },
	        error : function(data){
	            if(data.status==422){
	            	let li_htm = '';
	                $.each(data.responseJSON.errors,function(k,v){
	                    const $input = form.find(`input[name=${k}],select[name=${k}],textarea[name=${k}]`);
	                    if($input.next('small').length){
	                        $input.next('small').html(v);
	                        if(k == 'services' || k == 'membership'){
	                        	$('#myselect').next('small').html(v);
	                        }
	                    }else{
	                        $input.after(`<small class='text-danger'>${v}</small>`);
	                        if(k == 'services' || k == 'membership'){
	                        	$('#myselect').after(`<small class='text-danger'>${v[0]}</small>`);
	                        }
	                    }
	                    li_htm += `<li>${v}</li>`;
	                });
	                curSubmit.html(`Save`).attr('disabled',false);
	                return false;
	            }else{
	                curSubmit.html(`Save`).attr('disabled',false);
	                toastr.error(data.statusText);
	                return false;
	            }
	        }
	    });
	});
});

function toggleStatus(ele) {
	$.ajaxSetup({
	    headers: {
	      	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	var url = ele.getAttribute("data-update_url");
	var status = ele.checked ? 1 : 0;
	$.ajax({
		type: 'put',
		url: url,
		data: {
			status: status,
			toggle: true
		},



		success: function(response) {
			if (response.status == 201) {

				toastr.success(response.message);

				setTimeout(function() {
					var url = $('#redirect_url').val();
					if (url !== undefined || url != null) {
						window.location = url;
					} else {
						location.reload(true);
					}
				}, 2000);
				return false;
			}

			if (response.status == 200) {
				// curSubmit.html(`Save`).attr('disabled', false);
				toastr.error(response.message);
				return false;
			}
		},
		error: function(data) {

			// curSubmit.html(`Save`).attr('disabled', false);
			toastr.error(data.statusText);
			return false;

		}
	});
}