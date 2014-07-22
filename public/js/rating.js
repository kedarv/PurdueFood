$("#input-1").rating({
	starCaptions: {1: "Very Poor", 2: "Poor", 3: "Ok", 4: "Good", 5: "Very Good"},
	starCaptionClasses: {1: "text-danger", 2: "text-warning", 3: "text-info", 4: "text-primary", 5: "text-success"},
});
$("#input-1").on("rating.change", function(event, value, caption) {
	console.log($(this).data("user") + " voted " + value + " on "+ $(this).data("food"));
    $.post("/ratings/setStar",
        {
            user_id:$(this).data("user"),
            food_id:$(this).data("food"),
            rating:value
        },
        function(data,status){
            console.log("Data: " + data + "\nStatus: " + status);
        });
    $("#postRatingAlert").prop("hidden", false);
});