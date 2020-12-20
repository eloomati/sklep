
<?php
 require('headerLogIn.php');
?>


<?php
	// zapisz informacje o zamowieniu do DB
	$stmt=$pdo->prepare("INSERT INTO orders (id, customer, address, email) VALUES (null, :customer, :address, :email )");
	$stmt->bindValue(':customer', $_POST['customer'], PDO::PARAM_STR);
	$stmt-> bindValue(':email', $_POST['email'], PDO::PARAM_STR);
	$stmt->bindValue(':address',$_POST['address'], PDO::PARAM_STR);
	$stmt->execute();
	
	$orderId= $pdo->lastInsertID();
	
	$orderedProducts=$cart->getProducts();
	
	foreach($orderedProducts as $product){
		$pid=$product['pid'];
		$qty=$product['quantity'];
		
		$stmt=$pdo->prepare("INSERT INTO ordersproducts (id, order_id, product_id, quantity) VALUES (null, :orderId, :pid, :qty)");
		$stmt->bindValue(':orderId', $orderId, PDO::PARAM_INT);
		$stmt->bindValue(':pid', $pid, PDO::PARAM_INT);
		$stmt->bindValue(':qty',$qty, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	$cart->clear();
?>	
	<h1>Dziękuje za złożenie zamówienia</h1>
	
	
<?php	
	//wyslij maila potwierdzajacego
	mail($_POST['address'], "Zamówienie numer $orderId", "Potwierdzamy zamównie");
?>


<?php	
  require ('footer.php')
?>