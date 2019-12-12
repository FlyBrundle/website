$(document).ready(function(){
	var current_images = [];

	// code to change the default image on uplaod
	function readURL(input) {
		if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function(e) {
		  //$('.gallery').attr('src', e.target.result);
		  current_images.push(e.target.result);
		  display_images();
		  
		}
		
		reader.readAsDataURL(input.files[0]);
	  }
	}

	// will display the currently saved images into the gallery
	function display_images(){
		if (current_images.length > 0 ){
		alert(current_images[0]);
		$('.gallery').each(function(index){
				$(this).attr('src', current_images[index]); 
			});
	  }
	}

	$("#imgInp").change(function() {
	  readURL(this);
	  display_images();
	});
	// code section to change color and error messages on different forms
	// login, register, product_listing forms
	var input = $("#list_product input[type='text']");
	
	// prompt invalid values on empty fields or non-regex fields
	$("#list_product input[type='text']").keydown(function(){
		$(this).css('border', '1px solid #BEBEBE');
		var attribute = $(this).attr('name');
		$('.'+attribute+'_error').html('');
	}).blur(function(){
		// run if the user clicks out of the field without
		// entering anything
		var this_var = $(this);
		var attribute = $(this).attr('name');
		var specific_name = $(this).attr('id');
		var regex = /^(?=.*[a-zA-Z])[a-zA-Z0-9]{4,20}$/;
		var email_regex = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/
		var matches = this_var.val().match(regex);
		var email_matches = this_var().match(email_regex);
		
		if (this_var.val() === ''){
			this_var.css('border', '1px solid red');
			// display an error message posting the attribute of the input field
			$('.'+attribute+'_error').html('The ' + attribute +  ' field is required');
		} 
		// password regex: /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$
		// run if the pattern is not found
		if (this_var.attr('name') == 'email'){
			if ( email_matches == null){
				$(this).css('border', '1px solid red');
				// post the attribute's name into our error field if not found
				$('.'+attribute+'_error').html('Please enter a valid ' + specific_name + '. Only letters and numbers are allowed');	
			}
		} else {
			if ( matches == null){
				$(this).css('border', '1px solid red');
				// post the attribute's name into our error field if not found
				$('.'+attribute+'_error').html('Please enter a valid ' + specific_name + '. Only letters and numbers are allowed');	
			}
		}
	});
	
	
	
	// code section to display different content on the login and registration boxes
	  var attr_name = $('.header_link').attr('name');
	  $('#'+attr_name+' li').addClass('active');
	  $('#login_box li').on('click', function(e){
		// changes the li colors when clicked
		$('#login_box li').removeClass('active');
		$(this).addClass('active');
		
		// gets our id from the li elements to choose
		// which content box is displayed
		var log_attr = $(this).attr('id');

		e.preventDefault();
		$('.form_content').hide();
		$('#'+log_attr+"_form_content").show();
	  });
	 
	 
	// ajax code to sort the products on the product pages
	$('#sort').change(function(){
		var selection = $('#sort').val();
		$.ajax({
			url: 'pagination.php',
			type: 'POST',
			data: { filter : filter },
			success: function(response){
				$('#site_container').fadeOut(200);
				$('#site_container').html(response).fadeIn(200);
				
				 // window.location = "<?php echo $_SERVER['HTTP_REFERER']; ?>";
			},
			
			error: function(i){
				$('.register_error').html(i);
			}
		});
		
		e.preventDefault();
	});
	
	var mouse_inside = false;
	$('#prompt').click(function(e){
		$('#opacity_login').css('display', 'block');
		$('#login_box').css('display', 'inline-block');
		$('#login_box').css('opacity', '1');
		e.stopPropogation();
	});
	
	$(document).mousedown(function(e) 
	{
		var container = $("#login_box");

		// if the target of the click isn't the container nor a descendant of the container
		if (!container.is(e.target) && container.has(e.target).length === 0) 
		{
			$('#opacity_login').css('display', 'None');
			$('.log_form').val('');
			container.hide();
		}
	});
	
	/* gallery to display images with each image click
	/* 
	*/
	
	$('.img_small').first().addClass('small_active');
		$('.img_small').click(function(){
			var img_location = $(this).attr('src');
			$('img').removeClass('small_active');
			$(this).addClass('small_active');
			$('#img_main').attr('src', img_location, function(){
				$('#img_main').fadeIn('slow');
			});
		});
	});
});
