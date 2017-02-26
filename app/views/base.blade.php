<!doctype html>
<html lang="en">
<head>
	@yield('title')
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="res/16.png">
	
	<style>
		body{
			min-height: 2000px;
		}
		.h{ {{-- Center heading (h1,h2 etc.) --}}
			text-align:center; 
			font-family: "Avenir";
			src: url("res/fonts/avenir_roman.otf");
		}
		#R_logo_image{
			background-image: url("res/sanco_logo.png");
			background-position: 15px 4px;
			background-repeat: no-repeat;
			background-size: 32px auto;
			text-align: right;
			width: 200px;
		}
		@yield('style')
		
	</style>
	<link href="res/sanco.css" rel="stylesheet"/>
	<?php //Bootstrap  ?>
	{{ HTML::style('res/bootstrap/css/bootstrap.min.css') }}
	{{ HTML::style('res/jquery-ui/css/smoothness/jquery-ui-1.10.4.custom.css') }}
	{{ HTML::style('res/jquery-ui/css/bootstrap/jquery.ui.theme.css') }}
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	{{ HTML::script('res/bootstrap/js/bootstrap.min.js') }}
	{{ HTML::script('res/jquery-ui/js/jquery-1.10.2.js') }}
	{{-- HTML::script('res/jquery-ui/js/jquery-ui-1.10.4.custom.js') --}}

	
	@yield('head')
	
	
	
</head>
<body>	
	<!-- NAVBAR -->
	<div role="navigation" class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="{{ URL::to('/') }}" class="navbar-brand" id="R_logo_image">Sanco Shipping</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="{{ Request::is('insert') ? 'active' : '' }}"><a href="{{ URL::to('insert') }}">Insert Data</a></li>
			<li class="{{ Request::is('tables') ? 'active' : '' }}"><a href="{{ URL::to('tables') }}">TM-Tables</a></li>
			<li class="{{ Request::is('overview') ? 'active' : '' }}"><a href="{{ URL::to('overview') }}">Due Overview</a></li>   
          </ul>
			<form class="navbar-form navbar-right" role="search">
			  <div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
			  </div>
			  <button type="submit" class="btn btn-default">Submit</button>
			</form>

        </div>
	
      </div>
    </div>
	<!-- NAVBAR END -->
	<div style="margin-top:50px;">
	@yield('content')
	</div>
</body>
</html>
