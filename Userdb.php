<?php
	// Include config.php file
	include_once 'configDB.php';

	// Create a class Users
	class User extends Config {
	  // Fetch all or a single user from database

	  public function getUserById($id) {
	   
	    if ($id != null) {
		  $sql = 'SELECT * FROM users WHERE user_id = :id ';
		}
		  $stmt = $this->conn->prepare($sql);
		  $stmt->bindParam(':id', $id);
	      $rows = $stmt->execute();
		  $rows = $stmt->fetch();
	     return $rows;
	  }

	  public function login($email, $pwd) {
	   
	    if ($email != null && $pwd != null) {
		  $sql = 'SELECT * FROM users WHERE email = :email and password = :password';
		}
		  $stmt = $this->conn->prepare($sql);
		  $stmt->bindParam(':email', $email);
		  $stmt->bindParam(':password', $pwd);
	      $rows = $stmt->execute();
		  $rows = $stmt->fetch();
	     return $rows;
	  }

	  public function fetchAll() {
	      $sql = 'SELECT * FROM users ;';
	      $stmt = $this->conn->prepare($sql);
		  $stmt->execute();
	      $rows = $stmt->fetchAll();
	    return $rows;
	  }




	  // Insert an user in the database
	  public function insert($username, $password, $name, $first_name, $role_id) {
		// Hasher le mot de passe avant de l'ajouter dans la base
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
	
		// SQL pour insérer l'utilisateur avec le mot de passe hashé
		$sql = 'INSERT INTO users (username, password, name, first_name, role_id)
				VALUES (:username, :password, :name, :first_name, :role_id)';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':password', $password); // Ne pas hasher ici
		//$stmt->bindParam(':password', $hashedPassword);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':first_name', $first_name);
		$stmt->bindParam(':role_id', $role_id);
		$stmt->execute();
		return true;
	}


	   // public function insert( $username, $password, $name, $first_name, $role_id) {

		//$sql = 'INSERT INTO users (username, password, name, first_name, role_id)
		// VALUES ( :username, :password, :name, :first_name,:role_id)';
	   // $stmt = $this->conn->prepare($sql);
		//$stmt->bindParam(':username', $username);
		//$stmt->bindParam(':password', $password);
		//$stmt->bindParam(':name', $name);
		//$stmt->bindParam(':first_name', $first_name);
		//$stmt->bindParam(':role_id', $role_id);
	   // $stmt->execute();
	  //  return true;
	 // }

	  // Update an user in the database
	  public function update($username, $password, $name, $first_name, $role_id, $user_id) {
	    $sql = 'UPDATE users SET user_id = :user_id, username = :username,
		 password = :password, name = :name, first_name = :first_name, 
		 role_id = :role_id WHERE user_id = :user_id';
	    $stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':user_id', $user_id);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':password', $password);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':first_name', $first_name);
		$stmt->bindParam(':role_id', $role_id);
	    $stmt->execute();
	    return true;
	  }

	  // Delete an user from database
	  public function delete($id) {
	    $sql = 'DELETE FROM users WHERE user_id = :user_id';
	    $stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':user_id', $id);
	    $stmt->execute();
	    return true;
	  }
	}