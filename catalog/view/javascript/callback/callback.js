$(document).ready(function() {
	$('.show-callback').on('click', function() {
		$('.alert-success, .alert-danger').remove();
		$("#callback-box").modal('show');
	});
	
	$('#button-callback').on('click', function() {
		$.ajax({
			url: 'index.php?route=extension/module/callback',
			type: 'post',
			dataType: 'json',
			data: $("#form-callback").serialize(),
			beforeSend: function() {
				$('#button-callback').button('loading');
			},
			complete: function() {
				$('#button-callback').button('reset');
			},
			success: function(json) {
				$('.alert-success, .alert-danger').remove();
				
				if (json['error']) {
					$('#callback').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
				}

				if (json['success']) {
					$('#callback').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
					$('#form-callback').get(0).reset();

					setTimeout(function () {
						$('#callback-box').modal('hide');
					}, 1500);
				}
			}
		});
	});
	
	$('#button-phone-callback').on('click', function() {
		$.ajax({
			url: 'index.php?route=extension/module/callback',
			type: 'post',
			dataType: 'json',
			data: $("#callback-form-phone").serialize(),
			beforeSend: function() {
				$('#button-add-callback').button('loading');
			},
			complete: function() {
				$('#button-add-callback').button('reset');
			},
			success: function(json) {
				$('.callback-alert').remove();

				if (json['error']) {
					$('#callback-field-alert').html('<div class="text-danger">' + json['error'] + '</div>');
				}

				if (json['success']) {
					$('#callback-field-alert').html('<div class="text-success">' + json['success'] + '</div>');
					$('#callback-form-phone').get(0).reset();
					
					$('#callback-field-alert > div').fadeOut(3000);
				}
			}
		});
	});
});