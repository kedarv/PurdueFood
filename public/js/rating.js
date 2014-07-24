$("#input-1").rating({
	starCaptions: {1: "Very Poor", 2: "Poor", 3: "Ok", 4: "Good", 5: "Very Good"},
	starCaptionClasses: {1: "text-danger", 2: "text-warning", 3: "text-info", 4: "text-primary", 5: "text-success"},
});
$("#input-1").on("rating.change", function(event, value, caption) {
	console.log($('#id_data').data("user") + " voted " + value + " on "+ $('#id_data').data("food"));
	form_data = {
		user_id:$('#id_data').data("user"),
        food_id:$('#id_data').data("food"),
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
			if(data['status'] == "success") {
				$('#submit-comment').slideUp('slow');
				$('#commentAlert').removeClass("alert-danger").addClass("alert-" + data['status']).html(data['text']).css('style', 'margin-top:5px').fadeIn(500).removeClass("hidden").delay(5000).fadeOut();
				$('.comments').prepend( "<div class='row'><div class='col-md-12'><div class='well'><img src='http://www.gravatar.com/avatar/" + data['email'] + "?&r=x&d=identicon' alt='" + data['user'] + "' class='img-responsive' style='float:left;padding-right:10px;'/><h4 style='margin:0px 0px 0px 95px;'>" + data['user'] + "</h4><small>Posted at " + data['time'] +"</small><br/><br/><br/><hr/>" + data['comment'] + "</div></div></div>" )
				$('#commentArea').addClass("hidden");
			}
			else {
				$('#commentAlert').addClass("alert-" + data['status']).html(data['text']).fadeIn(500).removeClass("hidden").delay(5000).fadeOut();
			}
		}
	});
	return false;
});


$( document ).ready(function() {
    console.log($('textarea', "#commentArea").val()=="");
    if($('textarea', "#commentArea").val()!="")
    {
        //comment written
        $('#commentArea').addClass("hidden");
        $('#updateCommentButton').removeClass("hidden");
        $('#updateCommentButton').click(function(){
            console.log("her");
            $('#commentArea').removeClass("hidden");
            $('#updateCommentButton').addClass("hidden");
        });
    }

});



$(function () {
    $(' [value^="foodToggle_"]:checkbox').change(function()
    {
        console.log(this.value + "|" + this.checked + " userID: " + $('#id_data').data("user") + " foodID: "+ $('#id_data').data("food"));
        favoriteOrNot = this.checked

        form_data = {
            user_id:$('#id_data').data("user"),
            food_id:$('#id_data').data("food"),
            foodToggle:this.value,
            value:favoriteOrNot
        };

        $.ajax(
         {
            type: 'POST',
            url: '/favorites/update',
            data: form_data,
            success:function (data)
            {
                $("#postFavoriteAlert").removeClass("alert-success alert-info").addClass("alert-" + data['status']).html(data['text']).fadeIn(500).removeClass("hidden").delay(5000).fadeOut();
                console.log("Data: " + data['status'] + " " + data['text']);
            }
        }, 'json');

    });
});
