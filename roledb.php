<?php
	// Include config.php file
	include_once 'configDB.php';

	// Create a class role
	class Role extends Config {
	  // Fetch all or a single user from database


	  public function getRoleById($id) {
	   
	    if ($id != null) {
		  $sql = 'SELECT * FROM role WHERE role_id = :id ';
		}
		  $stmt = $this->conn->prepare($sql);
		  $stmt->bindParam(':id', $id);
	      $rows = $stmt->execute();
		  $rows = $stmt->fetch();
	     return $rows;
	  }

	public function fetchAll() {
	      $sql = 'SELECT * FROM role ;';
	      $stmt = $this->conn->prepare($sql);
		  $stmt->execute();
	      $rows = $stmt->fetchAll();
	    return $rows;
	  }


	  // Insert an user in the database
	  public function insert( $label) {
	    $sql = 'INSERT INTO role(label) VALUES ( :label);';
	    $stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':label', $label);
	    $stmt->execute();
	    return true;
	  }

	  // Update an user in the database
	  public function update(   $label,$role_id,) {
	    $sql = 'UPDATE role SET label = :label  WHERE role_id = :id';
	    $stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':label', $label);
		$stmt->bindParam(':id', $role_id);
		$stmt->execute();
	    return true;
	  }

	  // Delete an user from database
	  public function delete($id) {
	    $sql = 'DELETE FROM role WHERE role_id = :id';
	    $stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id', $id);
	    $stmt->execute();
	    return true;
	  }
	}