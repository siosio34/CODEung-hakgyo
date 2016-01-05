<!DOCTYPE html>
<html lang="ko">
	<head>
	@section('head')
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0" />
	
	<link href="https://fonts.googleapis.com/earlyaccess/notosanskr.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="//cdn.jsdelivr.net/xeicon/1.0.4/xeicon.min.css">
	<link rel="stylesheet" href="/styles/common.css" />
	
	<link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico" />
	<link rel="apple-touch-icon" href="/images/apple-touch-icon.png">
	
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="apple-mobile-web-app-title" content="CODEung" />
	
	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script> <!-- IE 8 이하 지원 안 함 -->
	
	<title>@yield('title')</title>
	@show
</head>
<body>

<div id="codeung">
	@yield('container')
</div>
</body>
</html>