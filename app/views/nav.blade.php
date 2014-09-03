 <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                {{ HTML::linkAction('home', 'Purdue Food', array(), array('class' => 'navbar-brand')) }}
            </div>

            <div class="collapse navbar-collapse" id="nav-collapse">
                <ul class="nav navbar-nav">
                    <li>{{ HTML::linkAction('home', 'Home') }}</li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Today's Menu <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{action('DiningController@pushData', ['name' => 'Earhart'])}}#{{$data['mealtime']}}">Earhart</a></li>
                            <li><a href="{{action('DiningController@pushData', ['name' => 'Ford'])}}#{{$data['mealtime']}}">Ford</a></li>
                            <li><a href="{{action('DiningController@pushData', ['name' => 'Hillenbrand'])}}#{{$data['mealtime']}}">Hillenbrand</a></li>
                            <li><a href="{{action('DiningController@pushData', ['name' => 'Wiley'])}}#{{$data['mealtime']}}">Wiley</a></li>
                            <li><a href="{{action('DiningController@pushData', ['name' => 'Windsor'])}}#{{$data['mealtime']}}">Windsor</a></li>
                        </ul>
                    </li>
					<li>{{ HTML::linkAction('SearchController@searchMain', 'Search') }}</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li>{{ HTML::linkAction('UsersController@create', 'Register') }}</li>
						<li>{{ HTML::linkAction('UsersController@login', 'Login') }}</li>
					@else
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>{{ HTML::linkAction('UsersController@details', 'Account Details') }}</li>
							<li>{{ HTML::linkAction('UsersController@logout', 'Logout') }}</li>
						</ul>
					@endif
				</ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>