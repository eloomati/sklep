
<?php
 require('header.php');

 $session ->updateSession(new user(true));
 header ("Location: index.php");
 
 require ('footer.php')
?>