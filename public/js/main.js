$(document).on('ready', function() {

	var notification = "<div id='notification'></div>";

	var newTask = function(task)
	{
		$.ajax({
			url: '/newTask',
			type: 'post',
			dataType: 'json',
			data: {task: task},
			beforeSend: function() {
				$('#notification').remove();
				$('header').append(notification);
			}
		})
		.done(function(data) {
			$(':text').val('');
			$('ul').append($('<li></li>').html("<input type='checkbox' id='"+data.id+"'/><label for="+data.id+">"+data.task+"</label>"));
			$('#total').text(parseInt($('#total').text()) + 1);

			$('#notification').text(data.msg).addClass('alert alert-'+data.msg_class);
			$('#notification').animate({top: 0}, 600, null).delay(2000).animate({top: -42}, 1000, null, function() {
				$(this).remove();
			});
		})
		.fail(function(jqXHR) {
			$('#notification').text(jqXHR.responseJSON.msg).addClass('alert alert-'+jqXHR.responseJSON.msg_class);
			$('#notification').animate({top: 0}, 600, null).delay(2000).animate({top: -42}, 1000, null, function() {
				$(this).remove();
			});
		})
		.always(function() {
			
		});
		
	}

	var setStatusTask = function(id, status)	
	{
		$.ajax({
			url: '/setStatusTask',
			type: 'post',
			dataType: 'json',
			data: {id: id, status: status},
			beforeSend: function() {
				$('#notification').remove();
				$('header').append(notification);
			}
		})
		.done(function(data) {
			if (status == 1)
				$('label[for='+id+']').addClass('task-checked');
			else 
				$('label[for='+id+']').removeClass('task-checked');

			$('#total-checked').text(data.checked);
			$('#total').text(data.total);

			$('#notification').text(data.msg).addClass('alert alert-'+data.msg_class);
			$('#notification').animate({top: 0}, 600, null).delay(2000).animate({top: -42}, 1000, null, function() {
				$(this).remove();
			});
		})
		.fail(function(jqXHR) {
			$('#notification').text(jqXHR.responseJSON.msg).addClass('alert alert-'+jqXHR.responseJSON.msg_class);
			$('#notification').animate({top: 0}, 600, null).delay(2000).animate({top: -42}, 1000, null, function() {
				$(this).remove();
			});
		})
		.always(function() {
			
		});
	}

	$('form').on('submit', function(e) {
		e.preventDefault();

		newTask($('input[type=text]').val());
	})

	$(document).on('change', ':checkbox', function() {
		setStatusTask($(this).attr('id'), $(this).is(':checked') ? 1 : 0);
	});

});