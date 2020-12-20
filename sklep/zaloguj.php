<?php
	

    session_start();
	
	if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)) 
	{
		header('Location: indexLogIn.php');
		exit(); // powoduje ze caly kod na dole sie nie wykonuje i dzieki temu nie obciaza serwera
	}
	
	//unset($_SESSION['blad']);
	require('header.php');
?>


 
  
  <form action="zalogujLogic.php" method="post">
  
    Login: <br /> <input type="text" name="login" /> <br />
    Hasło: <br /> <input type="password" name="haslo" /> <br /><br />
    <input type="submit" value="Zaloguj się" />
	
	<p>Nie masz konta? <a href="rejestracja.php">Załóż!</a></p>
  </form>

<?php
    if(isset($_SESSION['blad'])) echo $_SESSION['blad']; //blad o niepoprawnym loginie lub hasle
	
	require ('footer.php')
?>
