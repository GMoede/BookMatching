<?php
session_start();
session_destroy();
echo "<script>console.log('made it');</script>"
//header("Location:login.php");
?>
