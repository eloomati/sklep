<?php
    session_start();
		
		if(isset($_POST['email']))
			
			{
				//Udana walidacja
				$wszystko_ok=true; //flaga
				
				//Poprawnosc loginu
				$login=$_POST['login'];
				
				//Sprawdzanie dlugosci loginu
				if((strlen($login)<3) || (strlen($login)>20)) //strlen - dlugosc napisu
				{
					$wszystko_ok=false;
					$_SESSION['e_login']="Login musi mieć minimalnie 3 znaki i nie więcej niż 20!";
				}
				
				if(ctype_alnum($login)==false) // sprawdza prawde falsz czy nie ma znakow specjalnych
				{
					$wszystko_ok=false;
					$_SESSION['e_login']="Login może składać się tylko z liter i cyrf (bez polskich znaków)";
				}
				
				//Poprawnosc maila
				$email=$_POST['email'];
				$emailB=filter_var($email, FILTER_SANITIZE_EMAIL); //sanityzacja maila
				
				if((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
				{
					$wszystko_ok=false;
					$_SESSION['e_email']="Podaj poprawny adres e-mail!";
				}
				
				//Poprawnosc hasla
				$haslo1=$_POST['haslo1'];
				$haslo2=$_POST['haslo2'];
				
				if((strlen($haslo1)<8) || (strlen($haslo1)>20))
				{
					$wszystko_ok=false;
					$_SESSION['e_haslo']="Hasło musi składać się z 8 do 20 znaków!";
				}
				
				if($haslo1!=$haslo2)
				{
					$wszystko_ok=false;
					$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
				}
				
				
				$haslo_hash=password_hash($haslo1, PASSWORD_DEFAULT);
				
				//Zaakceptowanie regulaminu
				
				if(!isset($_POST['regulamin']))
				{
					$wszystko_ok=false;
					$_SESSION['e_regulamin']="Potwierdż akceptację regulaminu!";
				}
				
				//Captcha
				$captcha="6Lf2qtMUAAAAAA6SDd3CL2H_AI7SCgdMMB7xZakT";
				
				$sprawdz=file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$captcha.'&response='.$_POST['g-recaptcha-response']);         //pobierz wartosc zmiennej do pliku
				
				$odpowiedz=json_decode($sprawdz);
				
				if($odpowiedz->success==false) //notacja obiektowa
				{
					$wszystko_ok=false;
					$_SESSION['e_captcha']="Potwierdż, że nie jesteś bottem!";
				}
				
				//Tworzenie połączenia i oprogramowanie komunikatów błędów
				
				require_once "connect.php";
				mysqli_report(MYSQLI_REPORT_STRICT); //kurs php odc 3 1:20:00 || sposob raportowania bledow, zamiast bledow chcemy rzucac wyjatki
				
				try
				{
					$polaczenie=new mysqli($host, $db_user, $db_password, $db_name);
					if($polaczenie->connect_errno!=0) //ostatnia podjęta próba połączenia się z bazą zakończyła się sukcesem
					{
					   throw new Exception(mysqli_connect_errno()); //rzuc nowym wyjatkiem
					}
				
				    else
				    {
					//Sprawdzanie istnienia emila
					$rezultat=$polaczenie->query("SELECT id FROM user WHERE mail='$email'");
					
					if(!$rezultat) throw new Exception($polaczenie->error);
					
					$ile_maili=$rezultat->num_rows;
					if($ile_maili>0)
					{
						$wszystko_ok=false;
					    $_SESSION['e_email']="Isnieje już konto przypisane do tego e-maila!";					
					}
					
					//Sprawdzanie istnienia login
					$rezultat=$polaczenie->query("SELECT id FROM user WHERE nazwa='$login'");
					
					if(!$rezultat) throw new Exception($polaczenie->error);
					
					$ile_loginow=$rezultat->num_rows;
					if($ile_loginow>0)
					{
						$wszystko_ok=false;
					    $_SESSION['e_login']="Isnieje już konto z takim loginem!";					
					}
					
					//Wszystko poprawnie
						if($wszystko_ok==true)
					{
						if($polaczenie->query("INSERT INTO user(id,nazwa, haslo,mail) VALUES (NULL,'$login','$haslo_hash','$email')"))
						{
							$_SESSION['udana']=true;
							header('Location: powitanie.php');
						}
						else
						{
							throw new Exception($polaczenie->error);
						}
					}
					
					$polaczenie->close();
				    }
				}
				    catch(Exception $e) //zlap wyjatki, jesli jakies zostaly rzucone
				{
					echo 'Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestracje w innym terminie';
					echo '<br /> Informacja developerska: '.$e;
				}
				
				
				
				
				
			}


	require ('header.php');
?>



 <form method="post">
	
	    Login: <br /> <input type="text" name="login" /><br />
		
		<?php 
		  if (isset($_SESSION['e_login']))
		  {
			  echo '<div class="error">'.$_SESSION['e_login'].'</div>';
			  unset($_SESSION['e_login']);
		  }
		?>
		
		E-mail: <br /> <input type="text" name="email" /><br />
		
		<?php 
		  if (isset($_SESSION['e_email']))
		  {
			  echo '<div class="error">'.$_SESSION['e_email'].'</div>';
			  unset($_SESSION['e_email']);
		  }
		?>
		
		Hasło: <br /> <input type="password" name="haslo1" /><br />
		
		<?php 
		  if (isset($_SESSION['e_haslo']))
		  {
			  echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
			  unset($_SESSION['e_haslo']);
		  }
		?>
		
		Powtórz hasło: <br /> <input type="password" name="haslo2" /><br />
		
		<label>
		  <input type="checkbox" name="regulamin" /> Akceptuje regulamin
		</label>
		
		<?php 
		  if (isset($_SESSION['e_regulamin']))
		  {
			  echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
			  unset($_SESSION['e_regulamin']);
		  }
		?>
	
	    <div class="g-recaptcha" data-sitekey="6Lf2qtMUAAAAAMFIwPGktDUMjCrIjm-nXXQnJpnu"></div>
		<br />
		
		<?php 
		  if (isset($_SESSION['e_captcha']))
		  {
			  echo '<div class="error">'.$_SESSION['e_captcha'].'</div>';
			  unset($_SESSION['e_captcha']);
		  }
		?>
		
		<input type="submit" value="Załóż konto" />
	
	</form>
	
	
	
<?php 
require ('footer.php');
?>