<?php
    /*$sqlAllArticles = "SELECT * FROM articlesNEW LIMIT 1";
    $db = mysqli_connect('innodb.endora.cz', 'takeit', 'Takeit123', 'ropblogdatabase');
    echo mysqli_connect_error();
    $result = mysqli_query($db, $sqlAllArticles);
    $row = mysqli_fetch_assoc($result);
    echo $row;
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<script language="javascript">alert("ERR2")</script>';
        echo '<h2 class="articleh"> ' . $row['title'] . '</h2><p class="articlep">' . $row['text'] . '</p><label class="articlelabel">– ' . $row['author'] . ' ' . $row['time'] . '</label>';					
    }
    
    echo '<script language="javascript">alert("ERR3")</script>';*/
    session_name("User");
    session_start();

    $db = /*$_SESSION['dbconnect'];*/mysqli_connect('innodb.endora.cz', 'takeit', 'Takeit123', 'ropblogdatabase');

    if (mysqli_connect_errno()) {
        echo "Error: " + mysqli_connect_error();
    }

    $sqlallarticles = "SELECT * FROM articles ORDER BY article_ID DESC";
    $articleresult = mysqli_query($db, $sqlallarticles);    
    
    while ($rowofarticles = mysqli_fetch_assoc($articleresult)) {
        //echo '<script language="javascript">alert("' . json_decode($rowofarticles) . '")</script>';
        echo "<div class=article>"; //Vypis clanku
        echo "<h3 class=articleh>" . $rowofarticles['title'] . "</h3><br>" . 
             "<p class=artilep>" . $rowofarticles['text'] . "</p>" . 
             "<label class=articlelabel>–" . $rowofarticles['author'] . " " . $rowofarticles['time']. "</label><br></div>";
    }
?>	