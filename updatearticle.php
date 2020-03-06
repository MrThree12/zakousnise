<?php
    $db = mysqli_connect('innodb.endora.cz', 'takeit', 'Takeit123', 'ropblogdatabase');

    if (mysqli_connect_errno()) {
        echo "Error: " + mysqli_connect_error();
    }

    $title = htmlspecialchars($_GET['t']);
    $text = htmlspecialchars($_GET['x']);
    $id = htmlspecialchars($_GET['id']);

    $sqlupdatearticle = "UPDATE articles SET title='$title', text='$text' WHERE article_ID='$id'";
    $articleresult = mysqli_query($db, $sqlupdatearticle);    

    if ($articleresult) {
        echo "Clanek upraven";
    } else {
        echo "Nastala chyba pri upravovani clanku!";
    }    
?>