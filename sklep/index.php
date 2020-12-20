
<?php
 require('header.php');
?>
 <div id='top'>
  <div id='TOPlogo'>
  <br><br><br>
  <img class="logo" src="" alt="LOGOTR">
  <img class="logo" src="" alt="LOGONP">
  </div>
  <div id='TOPmenu'>
  <?php showMenuTOP(); ?>
  
 </div>
 
</div>
<div id='people'>
<div class='artist'>
<?php
showPeople();
?>
</div>
<div class='artist'>
<?php
showPeople();
?>
</div>
<div class='artist'>
<?php
showPeople();
?>
</div>
</div>
<div id='products'>


<?php

  
	
	if (isset($_GET['category_id'])){
		$category_id=$_GET['category_id'];
	}
	else{
		$category_id=null;
	}
	
	
	showCategory($category_id);
	
	require ('footer.php')
	
	
?>
<?php
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
	echo "</div>";
}
//koniec funkcji pokazywania kategorii
?>


<script type="text/javascript" language="JavaScript">
function HideContent(d)
{
  if (d.length < 1)
    return;

  document.getElementById(d).style.display = "none";
}

function ShowContent(d)
{
  if (d.length < 1)
    return;
  document.getElementById(d).style.display = "block";
}

function ReverseContent(d)
{
  if (d.length < 1)
    return;

  if (document.getElementById(d).style.display == "none")
  {
    document.getElementById(d).style.display = "block";
  }
  else
  {
    document.getElementById(d).style.display = "none";
  }
}
</script>
