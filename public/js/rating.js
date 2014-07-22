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