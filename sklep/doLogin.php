
<?php
 require('header.php');

    $login=$_POST['login'];
	$haslo=$_POST['password'];
	
	$login=htmlentities($login, ENT_QUOTES, "UTF-8"); //htmlentities - zabezpieczenie przed wstrzykiwaniem SQL, zamiana na encje html ENT_QUOTES - mowi zebysmy zamieniali na encje takze cudzyslowie i apostrofy
	
 
 
 if($session->getUser()->isAnonymus()){
	 $result=user::checkPassword($login, $haslo);
	 
	 if($result instanceof user){
		 //zalogowany
		 $session->updateSession($result);
		 echo 'zalogowno: '.$session->getUser()->getLogin();
		// $session->getUser()->isAdmin($login);
	 }
	 else{
		 header('Location: admin.php');
	 }
	 
 }
 
  require ('footer.php')
?>