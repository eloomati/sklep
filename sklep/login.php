 <div id='top'>
  <div id='TOPlogo'>
  <br><br>
  <img class="logo" src="image/LOGO/LogoTR.jpg" alt="LOGOTR">
  <img class="logo" src="image/LOGO/LogoNP.jpg" alt="LOGONP">
  </div>
  <div id='TOPmenu'>
  <?php showMenuTOP(); ?>
  
 </div>
 
</div>


<form action='doLogin.php' method='post'>
Login: <input type='text' name='login'><br>
Hasło: <input type='password' name='password'><br>
<input type='submit' value='zaloguj'>
<p>Nie masz konta? <a href="rejestracja.php">Załóż!</a></p>
</form>