@extends('layout/common')

@section('title', 'CODEung hakgyo > Rooms')

@section('head')
	@parent
	<link rel="stylesheet" href="/styles/room.css" />
	<script src="/scripts/room.js"></script>
@stop

@section('container')
	<?php if(Auth::check()) $user=Auth::user(); ?>
	
	<div id="roomContent">
		<div class="teacher">
			<div id="video">
				Section: Video
			</div>
			<div id="teacherCode">
				Section: Teacher's code
			</div>
		</div>
		<div class="student">
			<div id="chatting">
				Section: Chat(text)
			</div>
			<div id="studentCode">
				Section: Student's code
			</div>
		</div>
		
	</div>
	
	<div id="userList">
		
	</div>
@stop