<?php
class user{
	private $id;
	private $login;
	private $construnct;
	
	public function __construct($anonymous=true){
		if($anonymous ==true){
			$this->id=0;
			$this->login='';
		}
		$this->construct=true;
	}
	 public function setLogin($login){
		 $this->login = $login;
		 
	 }
	 
	 public function getId(){
		 return $this->id;
	 }
	 
	 public function getLogin(){
		 return $this->login;
	 }
	 
	 public function setId($id){
		 $this->id=$id;
	 }
	 public function isAnonymus(){
		 return ($this->id==0);
	 }
	 
	 public function isAdmin($nazwa){
		 global $pdo;
		 
		 $stmt=$pdo->prepare("SELECT admin FROM user WHERE nazwa=:nazwa");
		 $stmt->bindValue(":nazwa", $nazwa, PDO::PARAM_STR);
		 $stmt->execute;
		 
		 $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
		 if($row[0]['admin']=1){
			 echo "<p> JESTES ADMINEM</p>";
			 
		 }
		 else{
			 echo "<p> NIE JESTES ADMINEM</p>";
		 }
	 }
	 
	 public function checkPassword($nazwa, $password){
		 
		global $pdo;
			//$stmt=$pdo->prepare("SELECT * FROM user WHERE nazwa='%s'");
			//$wiersz=$stmt->fetchAll(PDO::FETCH_ASSOC);
			
			 $stmt=$pdo->prepare("SELECT id, nazwa, haslo FROM user WHERE nazwa=:nazwa");
			 $stmt->bindValue(":nazwa", $nazwa, PDO::PARAM_STR);
			 $stmt->execute();
			 
			 if($row=$stmt->fetchAll(PDO::FETCH_ASSOC)){
				 if(password_verify($password, $row[0]['haslo'])){
				$newUser=new user;
				$newUser->setId($row[0]['id']);
				$newUser->login=$row[0]['nazwa'];
			 
				return $newUser;
				}
				else{
					return 0;
				}
			 }
			else{
			 return 0;
			}
			 
		}
	 
}

?>