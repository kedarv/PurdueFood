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
                            <li>{{ HTML::linkAction('DiningController@pushData', 'Earhart', ['name' => 'Earhart']) }}</li>
                            <li>{{ HTML::linkAction('DiningController@pushData', 'Ford', ['name' => 'Ford']) }}</li>
                            <li>{{ HTML::linkAction('DiningController@pushData', 'Hillenbrand', ['name' => 'Hillenbrand']) }}</li>
                            <li>{{ HTML::linkAction('DiningController@pushData', 'Wiley', ['name' => 'Wiley']) }}</li>
                            <li>{{ HTML::linkAction('DiningController@pushData', 'Windsor', ['name' => 'Windsor']) }}</li>
                        </ul>
                    </li>
					<li>{{ HTML::linkAction('SearchController@searchMain', 'Search') }}</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li>{{ HTML::linkAction('UserController@create', 'Register') }}</li>
						<li>{{ HTML::linkAction('UserController@login', 'Login') }}</li>
					@else
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>{{ HTML::linkAction('UserController@details', 'Account Details') }}</li>
							<li>{{ HTML::linkAction('UserController@logout', 'Logout') }}</li>
						</ul>
					@endif
				</ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>