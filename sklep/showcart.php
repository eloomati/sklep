
<?php
 require('header.php');
?>
  <div id='top'>
  <div id='TOPlogo'>
  <img class="logo" src="" alt="LOGOTR">
  <img class="logo" src="" alt="LOGONP">
  </div>
  <div id='TOPmenu'>
  <?php showMenuTOP(); ?>
  
 </div>
 
</div>

<h1>ZAWARTOŚĆ KOSZYKA</h1>
<table>
<?php
	$inCart=$cart->getProducts();
	
	echo "<tr><td>Indeks</td><td>Nazwa produktu</td><td>Wartość</td><tr>";
	
	$sum=0;
	foreach($inCart as $product){
		$productCartId=$product['id'];
		$net_price=$product['net_price'];
		$quantity=$product['quantity'];
		$index=$product['indeks'];
		$name=$product['name'];
		$total=$quantity*$net_price;
		$id=$product['pid'];
		$sum+=$total;
		
		$remLink="<a href='remFromCart.php?id=$productCartId'>Usuń</a>";;
		
		//$plus="<a href='addToCart.php?id=$id'>+</a>"; funkcje powiększania i zmniejszania koszyka
		//$minus="<a href='remFromCart.php?id=$productCartId'>-</a>";
		echo "<tr><td>$index</td><td>$name</td><td>$total</td><td>$remLink</td></tr>";
	}	
?>
</table>

<h2>Wartość koszyka <?php echo $sum?> ZŁ</h2>


<a href='order.php'>Złóż zamówienie</a>
<?php	
  require ('footer.php')
?>