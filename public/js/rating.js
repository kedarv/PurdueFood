$("#input-1").rating({
	starCaptions: {1: "Very Poor", 2: "Poor", 3: "Ok", 4: "Good", 5: "Very Good"},
	starCaptionClasses: {1: "text-danger", 2: "text-warning", 3: "text-info", 4: "text-primary", 5: "text-success"},
});
$("#input-1").on("rating.change", function(event, value, caption) {
	alert("You rated: " + value + " = " + $(caption).text());
	console.log(value);
});