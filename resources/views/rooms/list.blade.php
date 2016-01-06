@extends('layout/common')

@section('title', 'CODEung hakgyo > Rooms')

@section('head')
	@parent
	<link rel="stylesheet" href="/styles/room.css" />
@stop

@section('container')
	<?php if(Auth::check()) $user=Auth::user(); ?>
	<div id="content">
		<div class="roomList">
			<h3 class="sectionTitle"><i class="xi-windows"></i> Room List</h3>
			<ul id="roomList">
				@if(count($rooms)<=0)
					<li class="no_room">No room</li>
				@else
					@foreach($rooms as $room)
					<li><a href="{{ url('room/'.$room->id) }}">
						<span class="id">{{ $room->id }}</span>
						<span class="info">
							<span class="name"> @if($room->password) <i class="xi-lock"></i> @endif {{ $room->name }}</span>
							<span class="meta">
								<span class="type">{{ $room->type }}</span>
								<span class="description">{{ $room->description }}&nbsp;</span>
								<span class="limit">Unknown / {{ $room->user_limit?$room->user_limit:'Unlimited' }}</span>
								<span class="clear"></span>
							</span>
						</span>
					</a></li>
					@endforeach
				@endif
			</ul>
			
			<div class="buttonArea">
				<button><a href="{{ url('room/create') }}"><i class="xi-windows-add"></i> Create Room</a></button>
			</div>
		</div>
	</div>
	
	<div id="sidebar">
		<div class="tags">
			<?php
				foreach($rooms as $room){
					if($room->tag && !$room->password){
						$tags=explode(',', $room->tag);
						foreach($tags as $tag){
							echo '<a href="'.url('room/'.$room->id).'"><i class="xi-tag"></i> '.$tag.'</a>';
						}
					}
				}
			?>
		</div>
	</div>
@stop