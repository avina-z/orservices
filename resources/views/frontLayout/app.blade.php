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
	<script type="text/javascript" src="//connect.facebook.net/en_US/sdk.js"></script>
	<script src="https://accounts.google.com/gsi/client" async defer></script>
	<script src="/js/jwt-decode.js"></script>
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
	<script>
		function checkLoginState() {                   // Called when a person is finished with the Login Button.
			window.location.assign('/login/facebook/redirect');
		}
	</script>
	<script>
		window.fbAsyncInit = function() {
			FB.init({
			appId      : '421771489286104',
			cookie     : true,
			xfbml      : true,
			version    : 'v12.0',
			oauth      : true
			});
			
		var finished_rendering = function() {
			var spinner = document.getElementById("spinner");
			spinner.removeAttribute("style");
			spinner.removeChild(spinner.childNodes[0]);
			}
		FB.Event.subscribe('xfbml.render', finished_rendering);
			
		};
	</script>
	<script>
		function registerWithFacebookToken(response) {             // Called when a person is finished with the Register with Google Button.
			FB.getLoginStatus(function(response) {
				if (response.status === 'connected') {
						FB.api('/me',{ locale: 'tr_TR', fields: 'first_name, last_name, email' }, function(response) {
							var element=document.getElementsByName("first_name");
							element[0].value = response.first_name;
							element=document.getElementsByName("last_name");
							element[0].value = response.last_name;
							element=document.getElementsByName("email");
							element[0].value = response.email;
							element=document.getElementsByName("password");
							element[0].value = "";
							element=document.getElementsByName("password_confirmation");
							element[0].value = "";
							document.getElementsByTagName("form")[0].submit();
					});
				}
			});
		}
	</script>
	<script>
		function handleGoogleToken() {                   // Called when a person is finished with the Login Button.
			window.location.assign('/login/google/redirect');
		}
	</script>
	<script>
		function registerWithGoogleToken(response) {             // Called when a person is finished with the Register with Google Button.
			const responsePayload = jwt_decode(response.credential);
			var element=document.getElementsByName("first_name");
			element[0].value = responsePayload.given_name;
			element=document.getElementsByName("last_name");
			element[0].value = responsePayload.family_name;
			element=document.getElementsByName("email");
			element[0].value = responsePayload.email;
			element=document.getElementsByName("password");
			element[0].value = "";
			element=document.getElementsByName("password_confirmation");
			element[0].value = "";
			document.getElementsByTagName("form")[0].submit();
		}
	</script>
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
