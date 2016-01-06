@extends('layout/common')

@section('title', 'CODEung hakgyo > Rooms')

@section('head')
	@parent
	<link rel="stylesheet" href="/styles/room.css" />
@stop

@section('container')
	<?php if(Auth::check()) $user=Auth::user(); ?>
	<div id="content">
		<form method="post" action="{{ url('room/create') }}">
			{!! csrf_field() !!}
			<div class="roomCreate">
				<h3 class="sectionTitle"><i class="xi-windows-add"></i> Create Room</h3>
				
				<div class="formWrap">
					<label>
						<span class="label"><i class="xi-windows"></i> Room name</span>
						<span class="inputWrap"><input type="text" name="name" value="" placeholder="Name of your room" required /></span>
					</label>
					
					<label>
						<span class="label"><i class="xi-folder"></i> Type</span>
						<span class="inputWrap"><input type="text" name="type" value="" placeholder="Type of your room" required /></span>
					</label>
					
					<label>
						<span class="label"><i class="xi-align-justify"></i> Description</span>
						<span class="inputWrap"><input type="text" name="description" value="" placeholder="Short description for your room" /></span>
					</label>
					
					<label>
						<span class="label"><i class="xi-tags"></i> Tags</span>
						<span class="inputWrap"><input type="text" name="tag" value="" placeholder="Separated by ,(commas)" /></span>
					</label>
					
					<label>
						<span class="label"><i class="xi-users"></i> Maximum number of people</span>
						<span class="inputWrap"><input type="number" name="limit" value="" placeholder="No-value or '0' for unlimited number" /></span>
					</label>
					
					<label>
						<span class="label"><i class="xi-lock"></i> Password</span>
						<span class="inputWrap"><input type="password" name="password" value="" placeholder="Type if you need a secret room" /></span>
					</label>
				</div>
				
				<div class="buttonArea">
					<button class="gray"><a href="{{ url('room') }}"><i class="xi-esc"></i> Go Back</a></button>
					<button type="submit"><span><i class="xi-windows-add"></i> Submit</span></button>
				</div>
			</div>
		</form>
	</div>
	
	<div id="sidebar">
		
	</div>
@stop