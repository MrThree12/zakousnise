<!DOCTYPE html>
<html lang="cs">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Blog</title>

	<link rel="stylesheet" href="aboutPage.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<?php
		session_name("User");
		session_start();		
	?>
</head>
<body>
    
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
							<a class="nav-link" href="aboutPage.php">O stránce</a>
						</li>
						<?php
							if($_SESSION['LoggedIn'] == true){
								echo '
									<li class="nav-item">
										<a class="nav-link" href="administration.php">Administrace</a>
									</li>';
							}
						?>
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
									<a class="nav-link" href="#">' . $_SESSION['Username'] . '</a>
								</li>
								';
								echo '
								<li class="nav-item">							
									<a class="nav-link" href="logout.php"><span class="fa fa-sign-out"></span>Odhlasit</a>
								</li>';
							}
						?>

					</ul>
				</div>  
			</nav>

			<div class="col-md-12">

				<div class="content" id="content">
					<h1 class="h1Content">O blogu</h1>
                    <p class="textContent">Blog "Zakousni se" je vytvořený pro účely závěrečné ročníkové práce. Web je tvořen pomocí HTML5, CSS3, JavaScriptu a PHP. Responzivita je zajištěna pomocí technologie Bootstrap 4. </p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>