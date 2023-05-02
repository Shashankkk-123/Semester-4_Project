<!DOCTYPE html>
<html>
<style>
    body {
        background-image: url('backgroundPage1.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;
    }
</style>
<head>
	<title>Check In</title>
	<meta charset="utf-8"> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="javascript.js"></script>
		
</head>

<script>
function search(){
	xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET","php/check_in_search.php?search="+document.getElementById("key").value,false);
	xmlhttp.send(null);
	document.getElementById("tbl").innerHTML=xmlhttp.responseText;
}
function checkin(data){
	var d = data.childNodes;
	var a=d[0];
	var isbn=d[1];
	var ci=d[2];
	if (confirm("Are you sure you want to check in "+isbn.innerHTML+"?") == true) {
        xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET","http://localhost:8080/library/php/check_in_book.php?loanid="+parseInt(a.innerHTML)+"&isbn="+isbn.innerHTML+"&cardid="+parseInt(ci.innerHTML),false);
		xmlhttp.send(null);
		alert(xmlhttp.responseText);
	}
}
</script>

<body onload="startTime()">


<nav class="navbar navbar-expand-lg navbar-primary bg-primary">
	  <div class="container-fluid">
		<div class="navbar-header">

		<a class="navbar-brand" href="index.php" style="color: rgb(119, 13, 13);">Library System</a>
		<div id = "clock" onload="currentTime()"></div>
		</div>
		<ul class="nav navbar-nav">
		  <li><a href="search.php" style="color: rgb(255, 255, 255);">Search Books</a>&emsp;</li>
		  <li><a href="checkin.php"style="color: rgb(255, 255, 255);">Check In</a>&emsp;</li>
		  <li><a href="add_borrower.php"style="color: rgb(255, 255, 255);">Add Borrower</a></li>
		</ul>
	  </div>
	</nav>
<div class="container">
	<h1>Check In</h1>
	<input class="form-control" type="text" id="key" name="search" placeholder="Enter the ISBN of the book, or your Card ID number." />
	<br/>
	<center>
	<input type="button" class="btn btn-primary" id="btn" value="Search" onclick="search()"/>
	</center>
	<div id="tbl"></div>
</div>


</body>
</html>
