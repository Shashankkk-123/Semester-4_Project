<!DOCTYPE html>
<style>
    body {
        background-image: url('backgroundPage1.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;
    }
</style>
<html>
<head>
	<title>Search Books</title>
	<meta charset="utf-8"> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="javascript.js"></script>
		
</head>
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
	<h1>Search Books</h1>
	<input class="form-control" type="text" id="key" name="search" size=35 placeholder="Enter book title or book ISBN here." />
	<br/>
	<center>
	<input type="button" class="btn btn-primary" id="btn" value="Search" onclick="search()"/>
</center>
	<br/>
	<br/>
	<div id="tbl"></div>
</div>
<script>
function search(){
	xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET","php/getAllBooks.php?search="+document.getElementById("key").value,false);
	xmlhttp.send(null);
	document.getElementById("tbl").innerHTML=xmlhttp.responseText;
}
function checkout(data){
	var a = data.childNodes;
	if(a[3].innerHTML=="False"){
		alert("Item Not Available.");
	}
	else{
		var card_id = prompt("Please enter Card ID");

		if (card_id != null) {
			xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET","php/check_out.php?cardid="+parseInt(card_id)+"&isbn="+a[0].innerHTML,false);
			xmlhttp.send(null);
			alert(xmlhttp.responseText);
		}
	}
}
</script>

</body>
</html>
