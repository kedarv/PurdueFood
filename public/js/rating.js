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

// Process Search Form
$('#search_by_food').submit(function() {
	var token = $("[name=_token]").val();
	$("#results").empty();
	$('#results_container').addClass("hidden");
	 $('#search_loader').removeClass('hidden').fadeIn(100); 
	$.ajax({
		type: 'POST',
        url: '/search/by/food',
		dataType: 'json',
		data: {_token: token, food: $("#insertFood").val()},
		success:function (data) {
			if(data['status'] == "danger") {
				$('#search_by_food_error').html(data['text']).fadeIn(500).removeClass("hidden").delay(5000).fadeOut();
			}
			else {
				$.each(data, function(key, value){
					console.log(key, value);
					$('#results').append("<a href='#' class='list-group-item' style='padding-top:15px;' data-toggle='modal' data-target='#myModal' data-id='" + value + "' data-name='" +  key + "' id='info'><h4 class=\"list-group-item-heading\">" + key + "<span class='glyphicon glyphicon-chevron-right pull-right'></span></h4></a>");
				});
				$('#results_container').fadeIn(500).removeClass("hidden");
			}
		}
	});
	$('#search_loader').slideUp(500).delay(800).fadeOut(400);
	return false;
});

// Display schedule of clicked item
$(document).on('click', '#info', function(){ 
	$("#details_id").empty().addClass("hidden");
	var food_id = $(this).data("id");
	var food_name = $(this).data("name");
	$("#myModalLabel").html("<a href=/dining/food/" + food_id + ">" + food_name + "&raquo;</a>");
	$('#schedule_loader').removeClass('hidden').fadeIn(100); 
	$.ajax({
		type: 'POST',
        url: '/search/schedule',
		dataType: 'json',
		data: {food_id: food_id},
		success:function (data) {
		$.each(data, function(key, value){
				$.each(value, function(key2, value2){
					$('#details_id').append("<tr><td>" + value2['Date'] + "</td>" + "<td>" + value2['Location'] + "</td>" + "<td>" + value2['Meal'] + "</td></tr>");
				});
			});
		$("#details_id").fadeIn(400).removeClass("hidden");
		$('#schedule_loader').slideUp(500).delay(800).fadeOut(400);
		}
	});
	return false;
});

// Vote on Comments
$(document).on('click', '.vote', function(){
	$(this).children("i").removeClass("active").addClass("fa-spin");
	form_data = {
		action: $(this).attr("id"),
        comment_id:$(this).data("comment_id"),
	};
	$.ajax({
		type: 'POST',
        url: '/ratings/insertVote',
		dataType: 'json',
		data: form_data,
		success:function (data) {
			if(data['status'] == "success") {
				$("#" + data['id']).addClass("active");
				$("#" + data['id']).children("i").removeClass("fa-spin fa-arrow-down").addClass("fa-check");
			}
			else {
				$("#" + data['id']).children("i").removeClass("fa-spin fa-arrow-up fa-arrow-down active").addClass("fa-exclamation-triangle");
			}
			console.log(data);
		}
	});	
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
