<?php
require('header.php');
?>
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

<?php
//funkcja pokazywania pelnego czlowieka
function showFullMan($author_id){
	global $pdo;
	
	$stmt=$pdo->prepare("SELECT * FROM people WHERE author_id= :id");
	$stmt->bindValue(':id',$author_id, PDO::PARAM_INT);
	$stmt->execute();
	
	while($row=$stmt -> fetch(PDO::FETCH_ASSOC)){
			$index= $row['author_indeks'];
			echo "<div>";
			echo "<h2>".$row['author_name']."</h2>";
			
			
			foreach(getPeoplePictures($index)as $image){
				echo "<a href='image/ludzie/$image' rel='lightbox[$index]'>";
				echo "<img src='image/duzyludzie/$image'>";
				echo "</a>";
				echo "<br />";
				
			};
			
			
			echo $row['description'];
			
		}
}
//koniec funkcji pelnego czlowieka

//funkcja pokazywania kategorii
function showMadeProduct($author_id=null){
	
	global $pdo;
 
		if($author_id){
			
			$stmt = $pdo ->prepare ("SELECT * FROM products WHERE author_id=:aid ");
			$stmt -> bindValue(':aid',$author_id,PDO::PARAM_INT);
			$stmt -> execute();
		}
		
		else {
			
			$stmt = $pdo ->prepare ("SELECT * FROM products");
			$stmt -> execute();
		}
	
	echo "<table>";
		while($row=$stmt -> fetch(PDO::FETCH_ASSOC)){
			echo "<tr><td>";
			$index= $row['indeks'];
			$id=$row['ID'];
			$images= getProductPictures($index);
			if(!empty($images)){
				$image=$images[0];
			}
			else{
				$image='no-photo.jpg';
			}
			echo "<img src='image/mini/$image'>";
			echo "</td><td>";
			//nazwa
			echo "<a href='product.php?product_id=$id'>";
			echo $row['name'];
			echo "</a>";
			echo "</td><td>";
			//cena
		
			echo $row['net_price']." zł";
			echo "</td></tr>";
			
			
		}
	echo "</table>";
	echo "</div>";
}
//koniec funkcji pokazywania kategorii


if(isset($_GET['author_id'])){
	showFullMan($_GET['author_id']);
	showMadeProduct($_GET['author_id']);
}
?>	
		
<?php 
require ('footer.php')
?>