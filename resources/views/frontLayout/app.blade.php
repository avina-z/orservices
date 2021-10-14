<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="Join the best company in the world!" />
    <meta property="og:url" content="http://www.sharethis.com" />
    <meta property="og:image" content="http://sharethis.com/images/logo.jpg" />
    <meta property="og:description" content="ShareThis is its people. It's imperative that we hire smart,innovative people who can work intelligently as we continue to disrupt the very category we created. Come join us!" />
    <meta property="og:site_name" content="ShareThis" />
	<title>@yield('title')</title>
	<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.5/flatly/bootstrap.min.css" rel="stylesheet">
	<link href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
	<link href="/css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/responsive.css">
	<script type='text/javascript' src='{{ env('SHARETHIS_ACTIVATE')}}' async='async'></script>
	<style>
		body {
			padding-top: 70px;
        }
        .navbar-default  {
            background:{{ $layout->secondary_color }};

        }
        .forget_password ,.form-signin-heading{
            color:{{ $layout->secondary_color }};
        }
        .form-signin{
            border-color:{{ $layout->secondary_color }};
        }
        .btn-primary {
            background: {{ $layout->secondary_color }};
        }
	</style>
	@yield('style')
</head>
<body>
	<div id="fb-root"></div>
	<script>
		function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
			console.log('statusChangeCallback');
			console.log(response);                   // The current login status of the person.
			if (response.status === 'connected') {   // Logged into your webpage and Facebook.
			testAPI();  
			} else {                                 // Not logged into your webpage or we are unable to tell.
			document.getElementById('status').innerHTML = 'Please log ' +
				'into this webpage.';
			}
		}


		function checkLoginState() {               // Called when a person is finished with the Login Button.
			FB.getLoginStatus(function(response) {   // See the onlogin handler
			statusChangeCallback(response);
			});
		}


		window.fbAsyncInit = function() {
			FB.init({
			appId      : '{app-id}',
			cookie     : true,                     // Enable cookies to allow the server to access the session.
			xfbml      : true,                     // Parse social plugins on this webpage.
			version    : '{api-version}'           // Use this Graph API version for this call.
			});


			FB.getLoginStatus(function(response) {   // Called after the JS SDK has been initialized.
			statusChangeCallback(response);        // Returns the login status.
			});
		};
		
		function testAPI() {                      // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
			console.log('Welcome!  Fetching your information.... ');
			FB.api('/me', function(response) {
			console.log('Successful login for: ' + response.name);
			document.getElementById('status').innerHTML =
				'Thanks for logging in, ' + response.name + '!';
			});
		}
	</script>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v12.0&appId=421771489286104&autoLogAppEvents=1" nonce="6fBT6oR6"></script>
	<script src="https://accounts.google.com/gsi/client" async defer></script>
	<nav class="navbar navbar-default navbar-fixed-top">
	    <div class="container">
	        <!-- Brand and toggle get grouped for better mobile display -->
	        <div class="navbar-header">
	            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
	                <span class="sr-only">Toggle navigation</span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	            </button>
	            <a class="navbar-brand" href="{{url('/')}}">{{$layout->site_name}}</a>
	        </div>

			<div class="collapse navbar-collapse" id="navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right login_register_nav">

                    @if (Auth::guest())
                        @if (Request::segment(1) != 'login' && Request::segment(1) != 'register')
						<li><a href="{{ url('login') }}">Login</a></li>
						<li><a href="{{ url('register') }}">Register</a></li>
                        @endif
					@else
						<li><a href="#">{{ Auth::user()->name }}</a></li>
						<li><a href="{{ url('logout') }}">Logout</a></li>
					@endif
				</ul>
			</div>

	    </div><!-- /.container-fluid -->
	</nav>

	<div class="container">
		@yield('content')
	</div>

	<hr/>

	<footer class="site-footer" style="padding-left: 40px;">
    	<div class="site-footer-legal">{!! $layout->footer !!}</div>

  	</footer>

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
	<!-- <script src="{{asset('js/markerclusterer.js')}}"></script> -->
	@yield('scripts')
</body>
</html>
