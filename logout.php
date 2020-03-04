<?php
session_name("User");
session_start();
session_destroy();

header("Refresh:0 url=index.php");
?>