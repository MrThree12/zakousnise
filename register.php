<!DOCTYPE html>
<html lang="cs">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Blog</title>

	<link rel="stylesheet" href="register.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <?php
        session_name("User");
        session_start();	

        $_SESSION['dbconnect'] = mysqli_connect('innodb.endora.cz', 'takeit', 'Takeit123', 'ropblogdatabase');
        //echo '<script language="javascript">alert("'. $db .'")</script>';
        $fillAll = " ";
        $wrong_input = " ";
        $somethingWrong = false;

        if ($_POST) {
            if (!(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['passwordagain']) && $_POST['antispam'])) {
                $fillAll = "Vyplň všechna pole!";
                $somethingWrong = true;
            } else {

				$username = htmlspecialchars($_POST['username']);
				$password = htmlspecialchars($_POST['password']);
				$passwordagain = htmlspecialchars($_POST['passwordagain']);
				$email = htmlspecialchars($_POST['email']);
				$antispam = htmlspecialchars($_POST['antispam']);

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

					if ($password == $passwordagain) {

						if ($antispam == (getdate(date("U")))[year]) {

							$check = "SELECT * FROM ROPBlogUsers WHERE username='$username' OR email='$email' LIMIT 1";
                            $result = mysqli_query($_SESSION['dbconnect'], $check);
							$error = mysqli_fetch_assoc($result);
							
							if ($error) {

								if ($error['username'] === $username) {

									$somethingWrong = true;
									$wrong_input = "Jiz jsi zaregistrovan!";

								} else if($error['email'] === $email) {

									$somethingWrong = true;
									$wrong_input = "Email jiz registrovan!";
								}
							} else {

								$header = 'Od: ';
                                $mail = $email;
                                $subject = 'Nová zpráva z ROP Blogu';
                                $message = 'Byl/a jste úspěšně zaregistrován/a do zakousnise.jednoduse.cz.' . "\n\n" . 
                                           'Jméno: ' . $username . "\n" . 'Heslo: ' . $password;
                                mb_send_mail($mail, $subject, $message);

                                $password = password_hash($password, PASSWORD_DEFAULT);
                                $sql = "INSERT INTO ROPBlogUsers (username, password, email, LevelOfAdministration) 
                                                        VALUES ('$username', '$password', '$email','0')";
								mysqli_query($_SESSION['dbconnect'], $sql);
								
								echo '
								<script language="javascript">document.getElementById(\'registered\').innerHTML = "Uspesne registrovan!"; </script>';
							}
						} else {
							$somethingWrong = true;
							$wrong_input = "Špatny rok!";
						}
					} else {
						$somethingWrong = true;
						$wrong_input = "Špatne heslo!";
					}
				} else {
					$somethingWrong = true;
					$wrong_input = "Špatny email!";
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
            <h1 class="h1">Register</h1>
            
            <form action="" method="post">
                <div class="wrongInput"><?php if($somethingWrong)echo $fillAll; echo $wrong_input;?></div>
				<div class="successfullyRegistered"><p id="registered"></p></div>
                <div class="form-group">
                    <label for="username">Jméno:</label>
                    <input type="text" class="form-control" id="username" placeholder="Jméno" name="username">
                </div>
                <div class="form-group">
                    <label for="password">Heslo:</label>
                    <input type="password" class="form-control" id="password" placeholder="Heslo" name="password">
                </div>
                <div class="form-group">
                    <label for="passwordagain">Heslo znovu:</label>
                    <input type="password" class="form-control" id="passwordagain" placeholder="Heslo znovu" name="passwordagain">
                </div>
				<div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                </div>
                <div class="form-group">
                    <label for="antispam">Letošní rok:</label>
                    <input type="number" class="form-control" id="antispam" placeholder="Letošní rok" name="antispam">
                </div>
                <button type="submit" class="btn btn-dark" onclick="DoSpinner()">Login</button>
            </form>
            <div id="spinnerdiv"></div>
		</div>
    </div>
</body>
</html>