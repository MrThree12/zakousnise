<!DOCTYPE html>
<html lang="cs">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Blog</title>

	<link rel="stylesheet" href="index.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<?php
		session_name("User");
		session_start();		

		$_SESSION['dbconnect'] = mysqli_connect('innodb.endora.cz', 'takeit', 'Takeit123', 'ropblogdatabase');

		if (!$_SESSION['dbconnect']) {
			echo '<script language="javascript">alert("Connection failed!")</script>';
		}
		
		//echo '<script language="javascript">alert("'. $db .'")</script>';
		
		if (!isset($_SESSION['LoggedIn'])) {
			$_SESSION['LoggedIn'] = false;
			$_SESSION['Username'] = "";
		}	
	?>
</head>
<body>
	<script language="javascript">
		function scrollPage() {
			var element = document.getElementById("navbar")
			element.scrollIntoView(true);
		}

		function logout(){
			var xhttp;

			xhttp = new XMLHttpRequest();
			xhttp.open("GET", "logout.php", true);
			xhttp.send();
		}

		//window.onload(loadarticles);

		function loadarticles() {
			var xhttp;

			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
				document.getElementById("content").innerHTML = this.responseText;
				}
			};
			xhttp.open("GET", "loadarticles.php", true);
			xhttp.send();
		}
	</script>
	
	<div class="header">
		<div class="subheader">
			<h1 class="h1">ZAKOUSNI SE</h1>
			<p class="citation">„Manželství je spravedlivé zařízení. Žena musí denně vařit a muž to musí denně jíst.“ </p>
			<p class="citation">– Alberto Sordi</p>
			<button onclick="scrollPage()">Zakousnout se</button>			
		</div>
	</div>	

	<div class="container-fluid">
		<div class="row">

			<nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top w-100" id="navbar">
				<a class="navbar-brand" id="navbrand" href="index.php">Blog</a>

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="collapsibleNavbar">
					<ul class="navbar-nav">
						<!--<li class="nav-item">
							<a class="nav-link" href="#">Rubriky</a>
						</li>-->
						<li class="nav-item">
							<a class="nav-link" href="aboutpage.php">O stránce</a>
						</li>
					</ul>

					<ul class="navbar-nav ml-auto">
						<?php
							if($_SESSION['LoggedIn'] == false){
								echo '
									<li class="nav-item">							
										<a class="nav-link" href="login.php"><span class="fa fa-user"></span> Login</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="register.php"><span class="fa fa-sign-in"></span> Register</a>
									</li>';
							} else {
								echo '
								<li class="nav-item">							
									<a class="nav-link" href="logout.php"><span class="fa fa-sign-out"></span> ' . $_SESSION['Username'] . '</a>
								</li>'; 
							}
						?>

					</ul>
				</div>  
			</nav>

			<div class="col-md-12">

				<div class="content" onload="loadarticles()"></div>

			</div>
			
			<div class="col-md-12">
				<footer>

				</footer>
			</div>
		</div>
	</div>
</body>
</html>