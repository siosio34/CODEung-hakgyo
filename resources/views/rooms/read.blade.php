@extends('layout/common')

@section('title', 'CODEung hakgyo > Rooms')

@section('head')
        @parent
        <link rel="stylesheet" href="/styles/room.css" />
        <script src="/scripts/room.js"></script>
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
			var channel = token.replace(/\$/gi,"");
			var MODERATOR_CHANNEL_ID = channel;
			var connection = new RTCMultiConnection(MODERATOR_CHANNEL_ID);			

			var videosContainer = document.getElementById('video');
			connection.onstream = function(e) {
				var buttons = ['mute-audio', 'mute-video', 'record-audio', 'record-video', 'full-screen', 'volume-slider', 'stop'];
				if (connection.session.audio && !connection.session.video) {
					buttons = ['mute-audio', 'full-screen', 'stop'];
				}
				
				var width;
				var height;
				if(e.isScreen == true) {
					width = videosContainer.clientWidth;
					height = videosContainer.clientHeight;
				}
				else if(e.isVideo == true) {
					width = videosContainer.clientWidth/3;
					height = videosContainer.clientHeight/3;
				}
				
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
				videosContainer.insertBefore(mediaElement, videosContainer.firstChild);
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
						//dontTransmit: true,
						sessionid: MODERATOR_SESSION_ID
				});
			}
			else if(isMaster == "false") {
				session.audio = true;
				session.data = true;
				connection.session = session;
				connection.join({
						sessionid: MODERATOR_SESSION_ID,
						userid: MODERATOR_ID,
						extra: MODERATOR_EXTRA
				});
			}
		}
		</script>
@stop

@section('container')
        <?php if(Auth::check()) $user=Auth::user(); ?>
        <div id="roomContent">
                <div class="teacher">
                        <div id="video">
                                <div id="screenContainer">
				</div>
				<div id="videoContainer">
				</div>
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

