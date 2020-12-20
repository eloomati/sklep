
<?php
 require('headerLogIn.php');
?>

<h1> PODAJ DANE </h1>
<form action='orderSummaryLogIn.php' method='post'>
<p>Imie i nazwisko: </p>
<input type='text' name='customer'>
<p>E-mail: </p>
<input type='text' name='email'>
<p>Adres:</p>
<textarea name='address'>
</textarea><br>
<input type='submit' value='zamawiam'>

</form>



<?php	
  require ('footer.php')
?>