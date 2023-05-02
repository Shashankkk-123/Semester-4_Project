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
		<title>Add Borrower</title>
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
			<h1>Add Borrower</h1>
			<form action="php/addBorrower.php" method="post">
				<input type="text" class="form-control" name="ssn" size="35" placeholder="Enter desired Card ID (max 3 digits)" required /><br/>
				<input type="text" class="form-control" name="fname" size="35"placeholder="Enter First Name" required /><br/>
				<input type="text" class="form-control" name="lname" size="35"placeholder="Enter Last Name" required /><br/>
				<center>
				<input type="submit" class="btn btn-primary btn-block" value="Submit" required />
				</center>
			</form>
		</div>
	</body>
</html>