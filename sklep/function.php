<?php
define('SESSION_COOKIE','cookiesklep');
define('SESSION_ID_LENGHT', 40);
define('SESSION_COOKIE_EXPIRE', 3600);

//funkcja zdjec
function getProductPictures($index){
		$images= array();
		
		//M01-1
		for($i=0;$i<9;$i++){
			$filename=$index."-".$i.".jpg";
			$filepath="image/$filename";
			if(file_exists($filepath)){
				$images[]=$filename;
			}
		}
		return ($images);
		
	}
	
	function getPeoplePictures($index){
		$images= array();
		
		//M01-1
		for($i=0;$i<9;$i++){
			$filename=$index."-".$i.".jpg";
			$filepath="image/duzyludzie/$filename";
			if(file_exists($filepath)){
				$images[]=$filename;
			}
		}
		return ($images);
		
	}
//koniec funkcji zdjec

//funkcja menu logout
	function showMenuTOP(){
		
	global $pdo, $session;
	
	
		$stmt = $pdo->prepare("SELECT * FROM categories");
		$stmt -> execute();
		
		echo "<ul> <li> ";
		echo "<a href='index.php'>Strona główna</a></li><li>";
		
	
		while($row=$stmt -> fetch(PDO::FETCH_ASSOC)){
			$name=$row['name'];
			$id=$row['ID'];
			
			echo "<A HREF='index.php?category_id=$id'>$name</A></li><li>   ";
			
		}
			
			echo "<a href='showcart.php'>Koszyk</a></li><li>     ";
			
			
			if(!$session->getUser()->isAnonymus()){
				
				echo "<a href='logout.php'>Wyloguj</a></li>";
			}
			else{
				echo "<a href='admin.php'>Zaloguj</a> </li>  ";
			}
		echo "</ul>";
	echo "</div>";
	
	}
//koniec funkcji menu

//funkcja pokazywania ludzi
    function showPeople(){
		
		global $pdo, $session;
		
		$stmt=$pdo->prepare("SELECT * FROM people");
		$stmt -> execute();
		
		while($row=$stmt -> fetch(PDO::FETCH_ASSOC)){
			$name=$row['author_name'];
			$id=$row['author_id'];
			$kategoria=$row['Kategoria'];
			$opis=$row['description'];
			
			echo "<table><tr>";
			echo "<a href='people.php?author_id=$id'><img src=image/miniludzie/beata.jpg alt='Beata' width='600' height='400'></a> </tr><tr>";
			echo "<p>$name</p> </tr><tr>";
			echo "<p>$kategoria</p></tr>";
			echo "</table>";
		}
	}
	

//koniec funckji pokazywania ludzi
//funkcja menu logout
	function showMenu(){
		
	global $pdo, $session;
	
	
		$stmt = $pdo->prepare("SELECT * FROM categories");
		$stmt -> execute();
		
		echo "<a href='index.php'>Strona główna</a>";
		echo "<br>";
	
		while($row=$stmt -> fetch(PDO::FETCH_ASSOC)){
			$name=$row['name'];
			$id=$row['ID'];
			
			echo "<A HREF='index.php?category_id=$id'>$name</A>";
			echo "<br>";
		}
			echo "<br>";
			echo "<br>";
			echo "<a href='showcart.php'>Koszyk</a>";
			echo "<br>";
			echo "<br>";
			echo "<a href='admin.php'>Zaloguj</a>";
			if(!$session->getUser()->isAnonymus()){
				echo "<br>";
				echo "<a href='logout.php'>Wyloguj</a>";
			}
	echo "</div>";
	
	}
//koniec funkcji menu

//funkcja menu login
	function showMenuLogIn(){
		
	global $pdo;
	
	
		$stmt = $pdo->prepare("SELECT * FROM categories");
		$stmt -> execute();
		
		echo "<a href='indexLogIn.php'>Strona główna</a>";
		echo "<br>";
	
		while($row=$stmt -> fetch(PDO::FETCH_ASSOC)){
			$name=$row['name'];
			$id=$row['ID'];
			
			echo "<A HREF='indexLogIn.php?category_id=$id'>$name</A>";
			echo "<br>";
		}
			echo "<br>";
			echo "<br>";
			echo "<a href='showcartLogIn.php'>Koszyk</a>";
			echo "<br>";
			echo "<br>";
			echo "<a href='logout.php'>Wyloguj</a>";
	echo "</div>";
	
	}
//koniec funkcji menu

function random_session_id(){
	$utime=time();
	$id=random_salt(40-strlen($utime)).$utime;
	return $id;
}
function random_salt($len){
	return randomSalt($len);
}


function randomSalt($len) {
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	$l = strlen($chars) - 1;
	$str = '';
	for ($i = 0; $i < $len; ++$i) {
		$str .= $chars[rand(0, $l)];
 	}
	return $str;
}
?>

<?php
