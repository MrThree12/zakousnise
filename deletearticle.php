<?php
    $db = mysqli_connect('innodb.endora.cz', 'takeit', 'Takeit123', 'ropblogdatabase');

    if (mysqli_connect_errno()) {
        echo "Error: " + mysqli_connect_error();
    }

    $id = htmlspecialchars($_GET['id']);

    $sqldeletearticle = "DELETE FROM articles WHERE article_ID='$id'";
    $articleresult = mysqli_query($db, $sqldeletearticle);    

    if ($articleresult) {
        echo "Clanek odstranen";
    } else {
        echo "Nastala chyba pri odstranovani clanku!";
    }    
?>