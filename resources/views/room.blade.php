<!DOCTYPE html>
<html>
<head>
<script src="./jquery-1.11.3.min.js"></script>
<script src="https://cdn.webrtc-experiment.com/RTCMultiConnection.js"></script>
<script>

window.onload = function() {
	var GET = {};

        document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
                 function decode(s) {
                        return decodeURIComponent(s.split("+").join(" "));
                 }
                 GET[decode(arguments[1])] = decode(arguments[2]);
        });


        // channel-id
        //channel은 방을 구분하기 위해 쓰인다.
        var MODERATOR_CHANNEL_ID = GET['roomToken'];

        //session은 서로 파일을 주고받거나 채팅을 할 때에 쓰인다.
        var MODERATOR_SESSION_ID = GET['roomToken'];    // room-id
        var MODERATOR_ID         = GET['userId'];       // user-id
        var MODERATOR_SESSION    = {           // media-type
                audio: true,
                video: true
        };
        var MODERATOR_EXTRA      = {};       // empty extra-data

        // moderator
        var isMaster = GET["isMaster"];
        if(isMaster == "true") {
                this.disabled = true;

                var moderator = new RTCMultiConnection(MODERATOR_CHANNEL_ID);
                moderator.session = MODERATOR_SESSION;
                moderator.userid = MODERATOR_ID;
                moderator.extra = MODERATOR_EXTRA;
                moderator.open({
                        dontTransmit: true,
                        sessionid: MODERATOR_SESSION_ID
                });
        }
        else if(isMaster == "false") {
                this.disabled = true;
                var participants = new RTCMultiConnection(MODERATOR_CHANNEL_ID);
                participants.join({
                        sessionid: MODERATOR_SESSION_ID,
                        userid: MODERATOR_ID,
                        extra: MODERATOR_EXTRA,
                        session: MODERATOR_SESSION
                });
        }
}
</script>
</head>
<body>
</body>

