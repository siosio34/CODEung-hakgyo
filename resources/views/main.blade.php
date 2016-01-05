<!DOCTYPE html>
<html>
<head>
<script src="./jquery-1.11.3.min.js"></script>
<meta name="csrf-token" value="{{ csrf_token() }}">
<script>
$.ajaxSetup({
	headers: { 'X-CSRF-TOKEN' : $('meta[name=csrf_token]').attr('content') }
});

var userId = "1";
function createRoom() {
	var roomName = document.getElementById("roomName").value;
	$.ajax({
		url:"/createRoom",
		type:"GET",
		data: {
			'roomName': roomName,
			'userId': userId
		},
		success:function(data) {
			if(data != 'already exists!')
				enter(data);
		}
	});
}

function enterRoom(roomId) {
	var password = document.getElementById("password");
	$.ajax({
		url:"/enterRoom",
		type:"GET",
		data: {
			'roomId': roomId,
			'userId': userId
		},
		success:function(data) {
			enter(data);
		}
	});	
}

function enter(data) {
	var json = JSON.parse(data);
	var form = document.createElement("form");

	var objs;
	objs = [];
	objs[0] = document.createElement("input");
	objs[0].setAttribute("type", "hidden");
	objs[0].setAttribute("name", "roomToken");
	objs[0].setAttribute("value", json["roomToken"]);
	form.appendChild(objs[0]);
	objs[1] = document.createElement("input");
	objs[1].setAttribute("type", "hidden");
	objs[1].setAttribute("name", "isMaster");
	objs[1].setAttribute("value", json["isMaster"]);
	form.appendChild(objs[1]);
	objs[2] = document.createElement("input");
	objs[2].setAttribute("type", "hidden");
	objs[2].setAttribute("name", "userId");
	objs[2].setAttribute("value", userId);	
	form.appendChild(objs[2]);

	form.setAttribute("method", "GET");
	form.setAttribute("action", "/room");
	document.body.appendChild(form);
	form.submit();
}

</script>
</head>
<body>
<input type="text" id="roomName" />
<button onclick="createRoom()" value="createRoom" />
<button onclick="enterRoom('39')" value="enterRoom" />
</body>
</html>

