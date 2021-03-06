<!DOCTYPE html>
<html lang="cs">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Blog</title>

	<link rel="stylesheet" href="administration.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://j11y.io/demos/plugins/jQuery/autoresize.jquery.js"></script>
    
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
                <script language="javascript">
                    var levelOfAdministration = <?php echo $_SESSION['LevelOfAdministration']; ?>;
                    
                    <?php                   
                        $db = mysqli_connect('innodb.endora.cz', 'takeit', 'Takeit123', 'ropblogdatabase');
                        $sqlallarticles = "SELECT * FROM articles";
                        $result = mysqli_query($db, $sqlallarticles);  
                        $articles = array();
                        while ($rowofarticles = mysqli_fetch_assoc($result)) {
                            array_push($articles, $rowofarticles);
                        }

                        $sqlallusers = "SELECT * FROM ROPBlogUsers";
                        $result = mysqli_query($db, $sqlallusers);  
                        $users = array();
                        while ($rowofusers = mysqli_fetch_assoc($result)) {
                            array_push($users, $rowofusers);
                        }
                    ?>

                    var articles = <?php echo json_encode($articles); ?>;
                    var author = "<?php echo $_SESSION['Username']; ?>";
                    var users = <?php echo json_encode($users); ?>;
                    
                    //alert(articles[0]['title']);

                    function changearticle() { //need deleting articles!!!!!!!!!!!!!!!!!!!!!!!!!! //done
                        if (levelOfAdministration >= 1) {
                            var defaultNode = document.getElementById("content");
                            var node = document.createElement("div");
                            var child = document.createElement("p").appendChild(document.createTextNode("Klikni na nadpis pro upraveni clanku."));
                            node.appendChild(child);

                            for (let i = 0; i < articles.length; i++) {
                                
                                if (author == articles[i]['author'] || levelOfAdministration >= 1) {

                                    var childh = document.createElement("h3");
                                    childh.classList.add("articleh");
                                    var content = document.createTextNode(articles[i]['title']);
                                    childh.appendChild(content);
                                    childh.onclick = function(){
                                        updatearticle(i, articles)
                                    };

                                    var childp = document.createElement("p");
                                    childp.classList.add("articlep");
                                    content = document.createTextNode(articles[i]['text']);
                                    childp.appendChild(content);

                                    var childl = document.createElement("label");
                                    childl.classList.add("articlelabel");
                                    content = document.createTextNode("–" + articles[i]['author'] + " " + articles[0]['time']);
                                    childl.appendChild(content);

                                    node.appendChild(childh);
                                    node.appendChild(childp);
                                    node.appendChild(childl); 
                                    node.appendChild(document.createElement("br"));                               
                                }
                            } 
                            defaultNode.replaceChild(node, defaultNode.childNodes[0]); 
                        } else {
                            alert("Nemas opavneni!");
                        }
                        
                    }

                    function updatearticle(id, articles) {
                        var defaultNode = document.getElementById("content");
                        var node = document.createElement("form");
                        node.classList.add("form");

                        var childtitle = document.createElement("input");
                        childtitle.setAttribute("type", "text");
                        childtitle.setAttribute("name", "title");
                        childtitle.setAttribute("id", "title");
                        childtitle.classList.add("inputTitle");
                        childtitle.setAttribute("value", articles[id]['title']);

                        var childText = document.createElement("textarea");
                        childText.appendChild(document.createTextNode(articles[id]['text']));
                        childText.setAttribute("name", "text");
                        childText.setAttribute("id", "textarea");
                        childText.setAttribute("autofocus", "autofocus");
                        childText.classList.add("inputText");

                        var childButton = document.createElement("button");
                        childButton.appendChild(document.createTextNode("Upravit"));
                        childButton.classList.add("inputbutton");
                        childButton.onclick = function(){
                            ajaxRequestToUpdateArticles(articles[id]['article_ID']);
                        }

                        var childButton2 = document.createElement("button");
                        childButton2.appendChild(document.createTextNode("Odstranit"));
                        childButton2.setAttribute("class", "btn btn-dark");
                        childButton2.classList.add("inputbutton");
                        childButton2.onclick = function(){
                            ajaxRequestToDeleteArticles(articles[id]['article_ID']);
                        }

                        node.appendChild(childtitle);
                        node.appendChild(document.createElement("br"));
                        node.appendChild(childText);
                        node.appendChild(document.createElement("br"));
                        node.appendChild(childButton);
                        node.appendChild(document.createElement("br"));
                        node.appendChild(childButton2);
                        node.appendChild(document.createElement("br"));
                        defaultNode.replaceChild(node, defaultNode.childNodes[0]);
                        $('textarea').autoResize();
                    }

                    function ajaxRequestToUpdateArticles(id) {                        
                        var title = document.getElementById("title").value;
                        var text = document.getElementById("textarea").innerHTML;

                        var xhttp;

                        xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                alert(this.responseText);
                            }
                        };
                        xhttp.open("GET", "updatearticle.php?t=" + title + "&x=" + text + "&id=" + id, true);
                        xhttp.send();

                        //changearticle();
                    }

                    function ajaxRequestToDeleteArticles(id) {
                        var title = document.getElementById("title").value;
                        var text = document.getElementById("textarea").innerHTML;

                        var xhttp;

                        xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                alert(this.responseText);
                            }
                        };
                        xhttp.open("GET", "deletearticle.php?id=" + id, true);
                        xhttp.send();

                        cleansheet();  
                    }

                    function addarticle(){
                        var defaultNode = document.getElementById("content");
                        var node = document.createElement("form");
                        node.classList.add("form");

                        var childtitle = document.createElement("input");
                        childtitle.setAttribute("type", "text");
                        childtitle.setAttribute("name", "title");
                        childtitle.setAttribute("id", "title");
                        childtitle.classList.add("inputTitle");

                        var childText = document.createElement("textarea");
                        childText.setAttribute("name", "text");
                        childText.setAttribute("id", "textarea");
                        childText.classList.add("inputText");

                        var childButton = document.createElement("button");
                        childButton.appendChild(document.createTextNode("Pridat"));
                        childButton.setAttribute("class", "btn btn-dark");
                        childButton.classList.add("inputbutton");
                        childButton.onclick = function(){
                            ajaxRequestToAddArticles(author);
                        }

                        node.appendChild(childtitle);
                        node.appendChild(document.createElement("br"));
                        node.appendChild(childText);
                        node.appendChild(document.createElement("br"));
                        node.appendChild(childButton);
                        defaultNode.replaceChild(node, defaultNode.childNodes[0]);
                        $('textarea').autoResize();
                    }

                    function ajaxRequestToAddArticles(author) {
                        var title = document.getElementById("title").value;
                        var text = document.getElementById("textarea").innerHTML;

                        var xhttp;

                        xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                alert(this.responseText);
                            }
                        };
                        xhttp.open("GET", "addarticle.php?t=" + title + "&x=" + text + "&a=" + author, true);
                        xhttp.send();

                        cleansheet();  
                    }

                    function deleteuser() {
                        if (levelOfAdministration == 1) {
                            var defaultNode = document.getElementById("content");
                            var node = document.createElement("div");

                            for (let i = 0; i < users.length; i++) {
                                
                                var childtitle = document.createElement("h3");
                                childtitle.classList.add("usertitle");
                                childtitle.appendChild(document.createTextNode(users[i]['username']));

                                var childButton = document.createElement("button");
                                childButton.classList.add("userbutton");
                                childButton.appendChild(document.createTextNode("Odstranit"));
                                childButton.setAttribute("class", "btn btn-dark");
                                childButton.onclick = function(){
                                    ajaxRequestToDeleteUser(users[i]['user_ID']);
                                }
                                
                                node.appendChild(childtitle);
                                node.appendChild(childButton);
                                node.appendChild(document.createElement("br"));
                                defaultNode.replaceChild(node, defaultNode.childNodes[0]);
                            }
                        } else {
                            alert("Nemas opavneni!");
                        }
                    }

                    function ajaxRequestToDeleteUser(id) {
                        var xhttp;

                        xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                alert(this.responseText);
                            }
                        };
                        xhttp.open("GET", "deleteuser.php?id=" + id, true);
                        xhttp.send();

                        cleansheet();                        
                    }

                    function cleansheet() {
                        var defaultNode = document.getElementById("content");
                        var node = document.createElement("div");

                        defaultNode.replaceChild(node, defaultNode.childNodes[0]);
                    }
                    
                </script>
                
                <div class="col-md-12 dropdownbutton">
                    <div class="dropdown">
                        <button class="dropbtn">Co chcete udělat?   <span class="fa fa-caret-down"></span></button>
                        <div class="btncontent">
                            <a href="#" onclick="addarticle()">Přidat článek</a>
                            <a href="#" onclick="changearticle()">Upravit článek</a>
                            <a href="#" onclick="deleteuser()">Odstranit uživatele</a>
                        </div>                    
                    </div>
                </div>

                <div class="col-md-12 content">
                    <div class="">
                        <div id="content">
                            <div class="innerContent"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
	</div>
</body>
</html>
