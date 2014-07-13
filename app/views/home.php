<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Purdue Food</title>
	<link rel="stylesheet" href="<?php echo asset('css/bootstrap.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('css/cover.css')?>" type="text/css"> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="<?php echo asset('js/bootstrap.min.js')?>"></script>
</head>
<body>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Sign Up to Purdue Food</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="register">
                    <div class="form-group">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="@purdue.edu Email Address" required>
                    </div>
                    <hr/>
                    <a class="btn btn-primary" id="asubmit">Submit &raquo;</a>
                </form>
                <div id="message"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

</div>
<!-- /.modal -->
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
                <div class="masthead clearfix">
                    <div class="inner">
                        <h3 class="masthead-brand">Purdue Food</h3>
                        <ul class="nav masthead-nav">
                            <li class="active"><a href="#">Home</a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dining Court Menus <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="./dining/Earhart">Earhart</a>
                            </li>
                            <li><a href="./dining/Ford">Ford</a>
                            </li>
                            <li><a href="./dining/Hillenbrand">Hillenbrand</a>
                            </li>
                            <li><a href="./dining/Wiley">Wiley</a>
                            </li>
                            <li><a href="./dining/Windsor">Windsor</a>
                            </li>
                        </ul>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="inner cover">
                    <h1 class="cover-heading">Purdue Food Court Menu</h1>
                    <p class="lead">Discover Menus. Rate Entrees and Courts. Share what you eat.</p>
                    <p class="lead">
                        <a data-toggle="modal" href="#myModal" class="btn btn-lg btn-default">Sign Up &raquo;</a>
                    </p>
                </div>

                <div class="mastfoot">
                    <div class="inner">
                        <p>&copy; 2014 Kedar V</p>
                    </div>
                </div>

            </div>

        </div>
	</div>
</body>
</html>
