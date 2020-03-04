<!DOCTYPE html>
<html lang="cs">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Blog</title>

	<link rel="stylesheet" href="login.css">

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

        $fillAll = " ";
        $wrong_input = " ";
        $wrong_input = " ";
        $somethingWrong = false;

        if ($_POST) {
            if (!isset($_POST['username']) && !isset($_POST['password'])) {
                $fillAll = "Vyplň všechna pole!";
                $somethingWrong = true;
            } else {
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);

                //echo '<script language="javascript">alert("'. $username .'")</script>';

                $sqlFindUser = "SELECT * FROM ROPBlogUsers WHERE username='$username'";
                //echo '<script language="javascript">alert("'. $sqlFindUser .'")</script>';
                
                $result = mysqli_query($_SESSION['dbconnect'], $sqlFindUser);
                $error = mysqli_fetch_assoc($result);
                //echo '<script language="javascript">alert("'. $result .'")</script>';
                
                echo '<script language="javascript">alert("'. $error['username'] .'")</script>';

                if ($error) {
                    if (password_verify($password, $error['password'])) {
                        $_SESSION['Username'] = $error['username'];
                        $_SESSION['UserID'] = $error['user_ID'];
                        $_SESSION['Email'] = $error['email'];
                        $_SESSION['LevelOfAdministration'] = $error['LevelOfAdministration'];
                        $_SESSION['LoggedIn'] = true;

                        header("Refresh:0 url=../index.php");
                    } else {
                        $somethingWrong = true;
                        $wrong_input = "Špatné heslo!";
                    }
                } else {
                    $somethingWrong = true;
                    $wrong_input = "Špatné jméno!";
                }
            }
        }
    ?>
    <script>
        function DoSpinner() {
            document.getElementById('spinnerdiv').innerHTML = '<div class="spinner-border text-muted"></div>';
        }
    </script>
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
									<a class="nav-link" href="logout.php"><span class="fas fa-sign-out"></span> ' . $_SESSION['username'] . '</a>
                                </li>';
							}
						?>

					</ul>
				</div>  
			</nav>		
		</div>
    </div>
    
	<div class="header">
		<div class="container loginform">
            <h1 class="h1">Login</h1>
            
            <form action="" method="post">
                <div class="wrongInput"><?php if($somethingWrong)echo $fillAll . "<br>" . $wrong_input;?></div>
                <div class="form-group">
                    <label for="username">Jméno:</label>
                    <input type="text" class="form-control" id="username" placeholder="Jméno" name="username">
                </div>
                <div class="form-group">
                    <label for="password">Heslo:</label>
                    <input type="password" class="form-control" id="password" placeholder="Heslo" name="password">
                <input type="submit" value="Login" onclick="DoSpinner()">
            </form>
            <div id="spinnerdiv"></div>
		</div>
    </div>
</body>
</html>