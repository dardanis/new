<?php

require_once "Database.php";

class LoginModel extends Database {

	private $email;
	private $password;

	public function login($email, $password){
		
	    session_start();

	    if(empty($email) || empty($password)){
	        $_SESSION['error'] = "Username and/or Password could not be empty!";
	        header("location: ../index.php"); exit;
	    }

	    $this->email = $email;
	    $this->password = hash('sha256', $password);

	    $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
	    $stmt = $this->connect()->prepare($sql);
	    $stmt->bindParam(':email', $this->email,PDO::PARAM_STR);
	    $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
	    $stmt->execute();
	    $result = $stmt->fetch(PDO::FETCH_ASSOC);

	    if($this->email !== $result['email'] || $this->password !== $result['password']){
	        $_SESSION['error'] = "Incorrect Email or Password!";
	        header("location: ../index.php"); exit;
	    }
	    
    	$_SESSION['user_id'] = $result['id'];
	    $_SESSION['name'] = $result['name'];
	    $_SESSION['email'] = $result['email'];

	    header("location: ../views/dashboard.php"); exit;
	    
	}

	public function logout(){
	    session_start();
	    session_destroy();
	    header("location: ../index.php");
	}
}



?>