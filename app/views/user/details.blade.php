@extends('user/layout')
@section('content')
<b>Username:</b> {{Auth::user()->username}}
<br/>
<b>Email:</b> {{Auth::user()->email}}
<hr/>
Account created on {{date("F j Y", strtotime(Auth::user()->created_at))}}
<?php
$user = User::find(Auth::id());
?>
<form action="" method="get">
</form>
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