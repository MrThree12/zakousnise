<?php
session_name("User");
session_start();

$sqlAllArticles = "SELECT * FROM articlesNEW";

$result = mysqli_query($_SESSION['dbconnect'], $sqlAllArticles);

echo '<script language="javascript">alert("ERR0")</script>';

while ($row = mysqli_fetch_assoc($result)) {
    echo '
    <h2 class="articleh"> ' . $row['title'] . '</h2>
    <p class="articlep">' . $row['text'] . '</p>
    <label class="articlelabel">– ' . $row['author'] . ' ' . $row['time'] . '</label>    
    ';
}
?>