@extends('common')

@section('title', 'CODEung hakgyo')

@section('head')
	@parent
	<link rel="stylesheet" href="/styles/index.css" />
	<link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
@stop

@section('content')
	<?php if(Auth::check()) $user=Auth::user(); ?>
	<div id="indexPage">
		<div class="welcome">
			<h2>WELCOME</h2><h3>to CODEUNG HAKGYO</h3>
		</div>	
	</div>
	
	<div id="myPage">
		@if(!Auth::check())
		
            <form id="loginForm" role="form" method="POST" action="{{ url('/login') }}">
                {!! csrf_field() !!}
                
				<div class="login_icon"><i class="xi-user-lock"></i></div>
		
		        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
		            <div class="input_wrap">
		            	<i class="xi-user"></i>
		           		<input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
		            </div>
		
		            @if ($errors->has('email'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('email') }}</strong>
		                </span>
		            @endif
		        </div>
		        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
		            <div class="input_wrap">
		            	<i class="xi-key"></i>
		            	<input type="password" class="form-control" placeholder="Password" name="password">
		            </div>
		
		            @if ($errors->has('password'))
		                <span class="help-block" style="padding-bottom:0">
		                    <strong>{{ $errors->first('password') }}</strong>
		                </span>
		            @endif
		        </div>
		        
		        <div class="checkbox">
		            <label>
		                <input type="checkbox" name="remember"> Remember Me
		            </label>
		        </div>
		
		        <button type="submit"><i class="xi-unlock"></i> Sign in</button>
        
				<div class="loginMenu">
					<a href="{{ url('/password/reset') }}">Forgot Your Password?</a>
				</div>
				
            </form>
		@else
		
			<div class="login_icon"><i class="xi-user"></i></div>
			<div class="user_info">
				<div class="name">{{ $user->name }}</div>
				<div class="email">{{ $user->email }}</div>
				<div class="buttons">
					<a href="{{ url('/logout') }}">Sign out</a>
				</div>
			</div>
		
		@endif
	</div>
@stop