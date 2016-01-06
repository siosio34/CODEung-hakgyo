var express = require('express');
#var http = require('http');
var app = express().createServer();
#var server = app.listen(3000);

app.get('/', function (req, res) # ge 요청이 들어왔때  코드를 작성하는 메인 페이지를 보여줌
{
	res.sendfile("./Codeindex.html");
});


app.listen(3000); # 3000 번 포트는 항상 열어둠
