@extends('layout')
@section('content')

<div class="row">
	<div class="col-md-10"><h1>{{Auth::user()->firstname}}'s Profile</h1></div>
    <div class="col-md-2"><a href="#" class="pull-right"><img title="profile image" class="img-circle img-responsive" src="https://www.gravatar.com/avatar/{{md5(strtolower(trim(Auth::user()->email)))}}?&r=x&d=identicon&s=100"></a></div>
	<hr/>
</div>
<hr/>
<div class="row">
	<div class="col-md-3">
		<ul class="list-group">
			<li class="list-group-item text-center"><b>User Information</b></li>
			<li class="list-group-item text-right"><span class="pull-left"><strong>Joined</strong></span> {{date("F j, Y", strtotime(Auth::user()->created_at))}}</li>
			<li class="list-group-item text-right"><span class="pull-left"><strong>Email</strong></span> {{Auth::user()->email}}</li>
		</ul> 
	</div>
	<div class="col-md-9">
		<ul id="myTab" class="nav nav-tabs" role="tablist">
			<li class="active"><a href="#reviews" role="tab" data-toggle="tab">Reviews</a></li>
			<li><a href="#favorite" role="tab" data-toggle="tab">Favorite Items</a></li>
		</ul>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane fade in active" id="reviews">
		<br/>
          <table class="table table-striped table-bordered">
              <tr>
                  <th>Food Name</th>
                  <th>Rating</th>
                  <th>Review</th>
              </tr>
          @foreach($data['reviews'] as $review)
              <tr>
          <td>{{$review['food_id']}}</td><td> {{$review['rating']}}</td><td> {{$review['comment']}} </td>
               </tr>
          @endforeach
          </table>
        
      </div>
      <div class="tab-pane fade" id="favorite">
		<br/>
          @foreach($data['favorites'] as $fav)
          {{$fav['food_id']}}<br>
          @endforeach

      </div>
    </div>

	</div>
</div>
<hr/>
<div class="row">
	<div class="col-md-12">
		<?php
		$user = User::find(Auth::id());
		?>
		<h2>Dietary Preferences</h2>
		{{Form::checkbox('non vegetarian items', 'settingToggle_vegetarian', $user->settingToggle_vegetarian)}} Hide non-vegetarian items<br>
		{{Form::checkbox('dairy items', 'settingToggle_dairy', $user->settingToggle_dairy)}} Hide items containing dairy<br>
		{{Form::checkbox('soy idems', 'settingToggle_soy', $user->settingToggle_soy)}} Hide items containing soy<br>
		{{Form::checkbox('egg items', 'settingToggle_egg', $user->settingToggle_egg)}} Hide items containing eggs<br>
		{{Form::checkbox('wheat items', 'settingToggle_wheat', $user->settingToggle_wheat)}} Hide items containing wheat<br>
		{{Form::checkbox('gluten items', 'settingToggle_gluten', $user->settingToggle_gluten)}} Hide items containing gluten<br>

		<div class="alert alert-success" role="alert" id="postUpdateAlert" hidden="true">
			<div id="postUpdateAlertMessage">herp</div>
		</div>
		<input type="hidden" id="user" data-user="{{Auth::id()}}">
	</div>
</div>

<script>

    $(function () {
        $(' [value^="settingToggle_"]:checkbox').change(function()
        {
           console.log(this.value + "|" + this.checked + " userID: "+$('#user').data("user"));
            type = this.name
            hideOrShow = this.checked
            $.post("/user/updateSettingsToggles",
                {
                    user_id:$('#user').data("user"),
                    settingToggle:this.value,
                    value:this.checked

                },
                function(data,status)
                {
                    console.log("Data: " + data + "\nStatus: " + status);
                    $("#postUpdateAlert").prop("hidden", false);
                    if(hideOrShow==true)
                    {
                        $("#postUpdateAlertMessage").text(type+" will be hidden now.");
                    }
                    else
                    {
                        $("#postUpdateAlertMessage").text(type+" will be shown now.");
                    }

                });

        });
    });

</script>
@stop