$("#input-1").rating({
	starCaptions: {1: "Very Poor", 2: "Poor", 3: "Ok", 4: "Good", 5: "Very Good"},
	starCaptionClasses: {1: "text-danger", 2: "text-warning", 3: "text-info", 4: "text-primary", 5: "text-success"},
});
$("#input-1").on("rating.change", function(event, value, caption) {
	console.log($(this).data("user") + " voted " + value + " on "+ $(this).data("food"));
	form_data = {
		user_id:$(this).data("user"),
        food_id:$(this).data("food"),
        rating:value
	};
	
	$.ajax({
		type: 'POST',
        url: '/ratings/setStar',
		data: form_data,
		success:function (data) {
			 $("#postRatingAlert").removeClass("alert-success alert-info").addClass("alert-" + data['status']).html(data['text']).fadeIn(500).removeClass("hidden").delay(5000).fadeOut();
			 console.log("Data: " + data['status'] + " " + data['text']);
		},
	}, 'json');
});

$('#submit-comment').submit(function() {
	var token = $("[name=_token]").val();
	form_data = {
		comment: CKEDITOR.instances['comment'].getData(),
		id: $(this).data("id")
	};
	$.ajax({
		type: 'POST',
        url: '/ratings/insertComment',
		dataType: 'json',
		data: {_token: token, form: form_data},
		success:function (data) {
		console.log(data);
			$('#submit-comment').slideUp('slow');
			$('#commentAlert').addClass("alert-" + data['status']).html(data['text']).css('style', 'margin-top:5px').fadeIn(500).removeClass("hidden").delay(5000).fadeOut();
			$('.comments').prepend( "<div class='col-md-6'><div class='well'><img src='http://www.gravatar.com/avatar/" + data['email'] + "' alt='" + data['user'] + "' class='img-responsive' style='float:left;padding-right:10px;'/><h4 style='margin:0px 0px 0px 95px;'>" + data['user'] + "</h4><small>Posted at " + data['time'] +"</small><br/><br/><br/><hr/>" + data['comment'] + "</div></div>" )
		},
	});	
	return false;
});