<!DOCTYPE html>
<style>
    body {
        background-image: url('backgroundPage1.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;
		font-family: system-ui;
  		text-align: center;

    }
</style>
<html>
<head>
	<title>Check In</title>
	<meta charset="utf-8"> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	  <script src="javascript.js"></script> 
		
</head>
<body onload="startTime()">
	<nav class="navbar navbar-expand-lg navbar-primary bg-primary">
	  <div class="container-fluid">
		<div class="navbar-header">
		
		<a class="navbar-brand" href="index.php" style="color: rgb(119, 13, 13);">Library System</a>&nbsp;&nbsp;&nbsp;&nbsp;
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
	  <h3>Library Management System</h3>
	  <p>Please select one of the above options.</p>
	  <p>New users should head to Add Borrowers to create a Card ID for themselves to check out books.</p>
	  <p>Only three books can be checked out to any person at any time.</p>
	  <p>Books can be checked in by entering the Card ID of the borrower, and selecting the ISBN of the book they wish to return.</p>
	</div>
</body>
</html>