<?php
	// Include config.php file
	include_once 'configDB.php';

	// Create a class role
	class Race extends Config {
	  // Fetch all or a single user from database


	  public function getRaceById($id) {
	   
	    if ($id != null) {
		  $sql = 'SELECT * FROM race WHERE race_id = :id ';
		}
		  $stmt = $this->conn->prepare($sql);
		  $stmt->bindParam(':id', $id);
	      $rows = $stmt->execute();
		  $rows = $stmt->fetch();
	     return $rows;
	  }

	public function fetchAll() {
	      $sql = 'SELECT * FROM race ;';
	      $stmt = $this->conn->prepare($sql);
		  $stmt->execute();
	      $rows = $stmt->fetchAll();
	    return $rows;
	  }


	  // Insert an user in the database
	  public function insert( $label) {
	    $sql = 'INSERT INTO race (label) VALUES ( :label);';
	    $stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':label', $label);
	    $stmt->execute();
	    return true;
	  }

	  // Update an user in the database
	  public function update(   $label,$race_id,) {
	    $sql = 'UPDATE race SET label = :label  WHERE race_id = :id';
	    $stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':label', $label);
		$stmt->bindParam(':id', $race_id);
		$stmt->execute();
	    return true;
	  }

	  // Delete an user from database
	  public function delete($id) {
	    $sql = 'DELETE FROM race WHERE race_id = :id';
	    $stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id', $id);
	    $stmt->execute();
	    return true;
	  }
	}