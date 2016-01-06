@extends('layout/common')

@section('title', 'CODEung hakgyo > Rooms')

@section('head')
        @parent
        <link rel="stylesheet" href="/styles/room.css" />
        <script src="/scripts/room.js"></script>
        <script src="/ace/ace.js" type="text/javascript"></script>
		<script src="//cdn.webrtc-experiment.com/firebase.js"></script>
		<script src="//cdn.webrtc-experiment.com/getMediaElement.min.js"></script>
		<script src="//cdn.webrtc-experiment.com/RTCMultiConnection.js"></script>
        <script>
		window.onload = function() {
			window.postMessage({
				enableScreenCapturing: true,
				domains: ["www.yourdomain.com", "yourdomain.com"]
			}, "*");
			
			var token = "{{ $room->token }}";
			var token = token.replace(/\$/gi,"");
			var channel = token.replace(/\./gi,"");
			var MODERATOR_CHANNEL_ID = channel;
			var connection = new RTCMultiConnection(MODERATOR_CHANNEL_ID);			

			var videoContainer = document.getElementById('video-video');
			var screenContainer = document.getElementById('video-screen');
			connection.onstream = function(e) {
			//	var buttons = ['mute-audio', 'mute-video', 'record-audio', 'record-video', 'full-screen', 'volume-slider', 'stop'];
			//	if (connection.session.audio && !connection.session.video) {
			//		buttons = ['mute-audio', 'full-screen', 'stop'];
			//	}
				var buttons = [];
				
				var width = screenContainer.clientWidth>videoContainer.clientWidth?screenContainer.clientWidth:videoContainer.clientWidth;
				var height = screenContainer.clientHeight>videoContainer.clientHeight?screenContainer.clientHeight:videoContainer.clientHeight;
				
				var mediaElement = getMediaElement(e.mediaElement, {
					width: width,
					height: height,
					title: e.userid,
					buttons: buttons,
					onMuted: function(type) {
						connection.streams[e.streamid].mute({
							audio: type == 'audio',
							video: type == 'video'
						});
					},
					onUnMuted: function(type) {
						connection.streams[e.streamid].unmute({
							audio: type == 'audio',
							video: type == 'video'
						});
					},
					onRecordingStarted: function(type) {
						// www.RTCMultiConnection.org/docs/startRecording/
						connection.streams[e.streamid].startRecording({
							audio: type == 'audio',
							video: type == 'video'
						});
					},
					onRecordingStopped: function(type) {
						// www.RTCMultiConnection.org/docs/stopRecording/
						connection.streams[e.streamid].stopRecording(function(blob) {
							if (blob.audio) connection.saveToDisk(blob.audio);
							else if (blob.video) connection.saveToDisk(blob.video);
							else connection.saveToDisk(blob);
						}, type);
					},
					onStopped: function() {
						connection.peers[e.userid].drop();
					}
				});
				if(e.isScreen == true)
					screenContainer.insertBefore(mediaElement, screenContainer.firstChild);
				else if(e.isVideo == true)
					videoContainer.insertBefore(mediaElement, videoContainer.firstChild);
				if (e.type == 'local') {
					mediaElement.media.muted = true;
					mediaElement.media.volume = 0;
				}
			};

			connection.onstreamended = function(e) {
				if (e.mediaElement.parentNode && e.mediaElement.parentNode.parentNode && e.mediaElement.parentNode.parentNode.parentNode) {
					e.mediaElement.parentNode.parentNode.parentNode.removeChild(e.mediaElement.parentNode.parentNode);
				}
			};
			
			//session은 서로 파일을 주고받거나 채팅을 할 때에 쓰인다.
			var MODERATOR_SESSION_ID = channel;    // room-id
			var MODERATOR_ID         = "{{ Auth::user()->id }}";       // user-id
			var MODERATOR_EXTRA      = {};       // empty extra-data

			connection.userid = MODERATOR_ID;
			connection.extra = MODERATOR_EXTRA;
			
			var isMaster = @if(Auth::user()->id == $room->master_id) "true" @else "false" @endif;
			var session = [];
			if(isMaster == "true") {
				session.video = true;
				session.screen = true;
				session.data = true;
				session.broadcast = true;
				connection.session = session;
				connection.open({
				//		dontTransmit: true,
						sessionid: MODERATOR_SESSION_ID
				});
			}
			else if(isMaster == "false") {
				connection.join({
						sessionid: MODERATOR_SESSION_ID,
						userid: MODERATOR_ID,
						extra: MODERATOR_EXTRA
				});
			}
		}
		// by akakakakakaa
		</script>
		
		<meta name="csrf_token" content="{{ csrf_token() }}" />
		<script>
			$(function(){
				$('#roomContent').height($(window).height());
				
				var teacherEditor = ace.edit("teacherCodeArea");
				teacherEditor.getSession().setMode("ace/mode/c_cpp");
				teacherEditor.setTheme("ace/theme/twilight");
				teacherEditor.setShowPrintMargin(false);
				document.getElementById('teacherCodeArea').style.fontSize='13px';
				
				var studentEditor = ace.edit("studentCodeArea");
				studentEditor.getSession().setMode("ace/mode/c_cpp");
				studentEditor.setTheme("ace/theme/github");
				studentEditor.setShowPrintMargin(false);
				document.getElementById('studentCodeArea').style.fontSize='13px';
				
				@if(Auth::user()->id == $room->master_id)
					setInterval(function(){
						$.ajax({
							url: "/room/code/{{$room->id}}",
							type: "POST",
							beforeSend: function(xhr){
								var token=$('meta[name="csrf_token"]').attr('content');
								
								if(token){
									return xhr.setRequestHeader('X-CSRF-TOKEN', token);
								}
							},
							data: {code:teacherEditor.getValue()}
						});
					}, 1000);
				@else
					setInterval(function(){
						$.get("/room/code/{{$room->id}}", function(data){
							teacherEditor.setValue(data);
						});
					}, 1000);
				@endif
				
				$(window).resize(function(){
					$('#roomContent').height($(window).height());
				});
				$('#video').click(function(){
					$('#video-video').toggleClass('back').toggleClass('front');
					$('#video-screen').toggleClass('back').toggleClass('front');
				});
			});
		// by MANAPIE
		</script>
@stop

@section('container')
        <?php if(Auth::check()) $user=Auth::user(); ?>
        <div id="roomContent">
                <div class="teacher">
                        <div id="video">
                        	<div class="wait">... Wait for loading ...</div>
                        	<div id="video-video" class="front"></div>
                        	<div id="video-screen" class="back"></div>
                        </div>
                        <div id="teacherCode">
                        	<div id="teacherCodeArea">{{ $room->code }}</div>
                        </div>
                </div>
                <div class="student">
                        <div id="chatting">
                                Section: Chat(text)
                        </div>
                        <div id="studentCode">
                        	<div id="studentCodeArea"></div>
                        </div>
                </div>

        </div>

        <div id="userList">

        </div>
@stop

