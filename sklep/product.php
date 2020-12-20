<?php
require('header.php');
?>
 <div id='top'>
  <div id='TOPlogo'>
  <img class="logo" src="image/LOGO/LogoTR.jpg" alt="LOGOTR">
  <img class="logo" src="image/LOGO/LogoNP.jpg" alt="LOGONP">
  </div>
  <div id='TOPmenu'>
  <?php showMenuTOP(); ?>
  
 </div>
 
</div>

<?php
//funkcja pokazywania produktu
function showProducts($id){
	global $pdo;
	
	$stmt=$pdo->prepare("SELECT * FROM products as p LEFT JOIN people as pl ON p.author_id=pl.author_id WHERE id= :id");
	$stmt->bindValue(':id',$id, PDO::PARAM_INT);
	$stmt->execute();
	
	while($row=$stmt -> fetch(PDO::FETCH_ASSOC)){
			$index= $row['indeks'];
			echo "<div>";
			echo "<h2>".$row['name']."</h2>";
			
			
			foreach(getProductPictures($index)as $image){
				echo "<a href='image/$image' rel='lightbox[$index]'>";
				echo "<img src='image/miniturki/$image'>";
				echo "</a>";
				echo "<br />";
				
			};
			
			echo $row['author_name'];
			echo '<br>';
			echo $row['description'];
			echo '<br /><br />';
			$id=$row['ID'];
			echo "<h3>Cena netto: ".$row['net_price']."</h3>";
			echo "<a href='addToCart.php?id=$id'>Dodaj do koszyka</a>";
			echo "</div>";
		}
}
//koniec funkcji pokazywania produktu

if(isset($_GET['product_id'])){
	showProducts($_GET['product_id']);
}
?>	
		
<?php 
require ('footer.php')
?>