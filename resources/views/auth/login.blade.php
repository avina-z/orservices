@extends('frontLayout.app')
@section('title')
Login
@stop
@section('content')
	<div class="inner_services login_register">
		@if (Session::has('message'))
		<div class="alert alert-{{(Session::get('status')=='error')?'danger':Session::get('status')}} " alert-dismissable fade in id="sessions-hide">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>{{Session::get('status')}}!</strong> {!! Session::get('message') !!}
		</div>
		@endif
        {{ Form::open(array('url' => route('login'), 'class' => 'form-horizontal form-signin','files' => true)) }}
        {{-- {{$layout->site_name}}! --}}
			{{-- <h3 class="form-signin-heading">Welcome to <br>Please Sign In</h3> --}}
            <p>{!! $layout->login_content !!}</p>
			{!! csrf_field() !!}
			<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
				<div class="col-sm-12">
					{!! Form::text('email', null, ['class' => 'form-control','placeholder '=>'E-mail']) !!}
					{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
			<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
				<div class="col-sm-12">
					{!! Form::password('password', ['class' => 'form-control','placeholder '=>'Password']) !!}
					{!! $errors->first('password', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
			<a class="forget_password pull-right " href="{{url('password/reset')}}">Forgot Password</a>
			<button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Login" type="Submit">Login</button>

			<a class="forget_password" style="margin-top: 15px;display: inline-block;margin-bottom: 0;" href="{{url('register')}}">Register</a>
			@if ($errors->has('global'))
			<span class="help-block danger">
				<strong style="color:red" >{{ $errors->first('global') }}</strong>
			</span>
			@endif
			<div class="form-group" >
				<h5 class="card-title">or Use your social media account:</h5>
			</div>
			<div class="form-group" >
				<div id="spinner"
					style="
						background: #4267b2;
						border-radius: 2px;
						color: white;
						height: 25px;
						text-align: center;
						width: 200px;">
					Loading
					<div 
					class="fb-login-button" 
					data-max-rows="1" 
					data-width="" 
					data-size="medium" 
					data-button-type="continue_with" 
					data-layout="default" 
					data-auto-logout-link="false" 
					data-use-continue-as="true" 
					data-scope="public_profile,email" 
					data-onlogin="checkLoginState();"
					></div>
				</div>		
			</div>
			<div class="form-group" >
				<div id="g_id_onload"
					data-client_id="997108129438-1srdf94oekvaiud0525411ia4ht4q0pb.apps.googleusercontent.com"
					data-callback="handleGoogleToken"
					data-scope="email openid"
					data-auto_select="true"
					data-auto_prompt="false"
					data-_token="{{ csrf_token() }}">
				</div>
				<div class="g_id_signin"
					data-type="standard"
					data-size="large"
					data-theme="outline"
					data-text="sign_in_with"
					data-shape="rectangular"
					data-logo_alignment="left">
				</div>
			</div>
		</form>

	</div>
@endsection

@section('scripts')
@endsection
