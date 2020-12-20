<?php

class session{
	private $id;
	private $ip;
	private $browser;
	private $time;
	private $user;
	private $salt;
	
	public function __construct(){
		global $pdo, $request;
		
		if(!isset($_COOKIE[SESSION_COOKIE])){
			$_COOKIE[SESSION_COOKIE]='';
			
		}
		else{
			if(strlen($_COOKIE[SESSION_COOKIE])!=SESSION_ID_LENGHT){
			$this->newSession();
			}
		}
		
		$stmt=$pdo->prepare('SELECT session_id, updated_at, salt_token, user_id, uniq_info, ip, browser, ip FROM sessionns WHERE session_id= :sid AND uniq_info=:info AND updated_at> :updated AND ip=:ip AND browser=:browser  ');
		
		$stmt->bindValue(':sid',$_COOKIE[SESSION_COOKIE], PDO::PARAM_STR);
		$stmt->bindValue(':updated', time()-SESSION_COOKIE_EXPIRE, PDO::PARAM_INT);
		$stmt->bindValue(':info', $request->getInfo(), PDO::PARAM_STR);
		$stmt->bindValue(':ip',$request->getIp(), PDO::PARAM_STR);
		$stmt->bindValue(':browser', $request->getBrowser(), PDO::PARAM_STR);
		$stmt->execute();
		
		if($session=$stmt->fetch(PDO::FETCH_ASSOC)){
			$stmt->closeCursor();
			$this->id=$_COOKIE[SESSION_COOKIE];
			$this->salt=$session['salt_token'];
			$this->ip=$session['ip'];
			$this->browser=$session['browser'];
			$this->time=$session['updated_at'];
			
			setCookie(SESSION_COOKIE, $this->id, time()+SESSION_COOKIE_EXPIRE);
			
			$stmt=$pdo->prepare('UPDATE sessionns SET updated_at=:time WHERE session_id=:sid');
			$stmt->bindValue(':sid', $_COOKIE[SESSION_COOKIE], PDO::PARAM_STR);
			$stmt->bindValue(':time', time(),PDO::PARAM_INT);
			$stmt->execute();
			
			if($session['user_id']!=0){
				$stmt = $pdo->prepare("SELECT nazwa FROM user WHERE id=:uid");
				$stmt->bindValue(":uid", $session['user_id'], PDO::PARAM_INT);
				$stmt->execute();
				
				$row=$stmt->fetchAll(PDO::FETCH_ASSOC);
				$this->user=new user;
				$this->user->setLogin($row[0]['nazwa']);
				$this->user->setId($session['user_id']);
			}
			else{
				$this->user=new user(true);
			}
		}
		else{
			$stmt->closeCursor();
			$this->newSession();
		}
	}
	
	function newSession(){
		global $pdo,  $request;
		
		$this->id=random_session_id();
		$this->salt=random_salt(10);
		setcookie(SESSION_COOKIE, $this->id, time()+SESSION_COOKIE_EXPIRE);
		
		$stmt=$pdo->prepare('INSERT INTO sessionns (session_id, updated_at, salt_token, user_id, uniq_info, browser, ip) 
		                                    VALUES (:session_id, :time, :salt, :user_id, :info, :browser, :ip)');
		
		$stmt->bindValue(':session_id', $this->id, PDO::PARAM_STR);
		$stmt->bindValue(':time', time(), PDO::PARAM_INT);
		$stmt->bindValue(':salt', $this->salt, PDO::PARAM_STR);
		$stmt->bindValue(':user_id',0,PDO::PARAM_INT);
		$stmt->bindValue(':info',$request->getInfo(), PDO::PARAM_STR);
		$stmt->bindValue(':browser',$request->getBrowser(), PDO::PARAM_STR);
		$stmt->bindValue(':ip',$request->getIp(), PDO::PARAM_STR);
		$stmt->execute();
		$this->user=new user(true);
	}
	
	
	public function updateSession(user $user){
		global $pdo, $request;
		
		$newId=random_session_id();
		$newSalt=random_salt(10);
		setcookie(SESSION_COOKIE, $newId, time()+SESSION_COOKIE_EXPIRE);
		
		$stmt=$pdo->prepare("UPDATE sessionns SET salt_token=:salt, updated_at= :time, session_id=:newId, user_id=:uid WHERE session_id=:sid");
		$stmt->bindValue(':salt', $newSalt, PDO::PARAM_STR);
		$stmt->bindValue(':time', time(), PDO::PARAM_INT);
		$stmt->bindValue(':newId', $newId, PDO::PARAM_STR);
		$stmt->bindValue(':uid', $user->getId(),PDO::PARAM_INT);
		$stmt->bindValue(':sid', $this->id, PDO::PARAM_STR);
		$stmt->execute();
		
		$this->id=$newId;
		$this->user=$user;
	}
	public function getSessionId(){
		return $this->id;
	}
	
	public function getUser(){
		return $this->user;
	}
}