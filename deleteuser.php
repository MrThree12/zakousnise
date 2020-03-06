<?php
    $db = mysqli_connect('innodb.endora.cz', 'takeit', 'Takeit123', 'ropblogdatabase');

    if (mysqli_connect_errno()) {
        echo "Error: " + mysqli_connect_error();
    }

    $id = htmlspecialchars($_GET['id']);

    $sqldeleteuser = "DELETE FROM ROPBlogUsers WHERE user_ID='$id'";
    $articleresult = mysqli_query($db, $sqldeleteuser);    

    if ($articleresult) {
        echo "Uzivatel odstranen";
    } else {
        echo "Nastala chyba pri odstranovani uzivatele!";
    }    
?>