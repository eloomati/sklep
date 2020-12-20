
<?php
 session_start();
	
	if(!isset($_SESSION['zalogowany'])) //blokuje możliwość wpisania bepośrednio linku do LOR i przejścia tam bez zalogowania. Odslyla do pierwszej strony i nie wykonuje kodu na dole, odciążając w ten sposób serwer
	{
		header('Location: indexLogIn.php');
		exit();
	}
 require('headerLogIn.php');
 
 

//funkcja pokazywania kategorii
function showCategory($category_id=null){
	
	global $pdo;
 
		if($category_id){
			
			$stmt = $pdo ->prepare ("SELECT * FROM products WHERE category_id=:cid ");
			$stmt -> bindValue(':cid',$category_id,PDO::PARAM_INT);
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
}
//koniec funkcji pokazywania kategorii

  
	
	if (isset($_GET['category_id'])){
		$category_id=$_GET['category_id'];
	}
	else{
		$category_id=null;
	}
	
	showCategory($category_id);
	
	require ('footer.php')
	
	
?>

