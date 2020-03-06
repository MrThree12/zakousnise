<?php
    $db = mysqli_connect('innodb.endora.cz', 'takeit', 'Takeit123', 'ropblogdatabase');

    if (mysqli_connect_errno()) {
        echo "Error: " + mysqli_connect_error();
    }

    $title = htmlspecialchars($_GET['t']);
    $text = htmlspecialchars($_GET['x']);
    $author = htmlspecialchars($_GET['a']);

    $sqladdarticle = "INSERT INTO articles (title, text, author) VALUES ('$title', '$text', '$author')";
    $articleresult = mysqli_query($db, $sqladdarticle);    

    if ($articleresult) {
        echo "Clanek pridan";
    } else {
        echo "Nastala chyba pri pridavani clanku!";
    }    
?>