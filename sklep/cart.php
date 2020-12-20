<?php

class cart{
	public function __construct(){
		
		
		
	}
	
	public function add($id){
		global $pdo, $session;
		
		$stmt=$pdo->prepare("INSERT INTO sessioncart (id, session_id, product_id, quantity) VALUES (null, :sid, :pid, 1)");
		$stmt->bindValue(':sid',$session->getSessionId(), PDO::PARAM_STR);
		$stmt->bindValue(':pid',$id,PDO::PARAM_INT);
		$stmt->execute();
		
	}
	
	public function remove($id){
		global $pdo, $session;
		
	
		
				$stmt=$pdo->prepare("DELETE FROM sessioncart WHERE id= :id AND session_id=:sid");
				$stmt->bindValue(':id',$id, PDO::PARAM_INT);
				$stmt->bindValue(':sid',$session->getSessionId(), PDO::PARAM_STR);
				$stmt->execute();
		
		
		
		
		
		
		
		
	}
	public function getProducts(){
		global $pdo, $session;
		
		$stmt=$pdo->prepare("SELECT s.id, p.net_price, s.quantity, p.indeks, p.name, p.id as pid FROM sessioncart s LEFT OUTER JOIN products p ON (s.product_id=p.id) WHERE session_id=:sid");
		$stmt->bindValue(':sid',$session->getSessionId(), PDO::PARAM_STR);
		$stmt->execute();
		
		$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
		
	}
	
	public function clear(){
		global $pdo, $session;
		
		$stmt = $pdo->prepare ("DELETE from sessioncart WHERE session_id=:sid");
		$stmt->bindValue(':sid',$session->getSessionId(), PDO::PARAM_STR);
		$stmt->execute();
	}
}


?>