<?php
	// Include config.php file
	include_once 'configDB.php';

	// Create a class role
	class Habitatpic extends Config {
	  // Fetch all or a single user from database

	  public function getHabitatpicById($id) {
	   
	    if ($id != null) {
		  $sql = 'SELECT * FROM habitat_picture WHERE habitat_picture_id = :id ';
		}
		  $stmt = $this->conn->prepare($sql);
		  $stmt->bindParam(':id', $id);
	      $rows = $stmt->execute();
		  $rows = $stmt->fetch();
	     return $rows;
	  }

	public function fetchAll() {
	      $sql = 'SELECT * FROM habitat_picture ;';
	      $stmt = $this->conn->prepare($sql);
		  $stmt->execute();
	      $rows = $stmt->fetchAll();
	    return $rows;
	  }


	  // Insert an user in the database
	  public function insert( $habitat_id, $picture_id) {
	    $sql = 'INSERT INTO habitat_picture (habitat_id , picture_id) VALUES ( :habitat_id, :picture_id);';
	    $stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':habitat_id', $habitat_id);
        $stmt->bindParam(':picture_id', $picture_id);
	    $stmt->execute();
	    return true;
	  }

	  // Update an user in the database
	  public function update( $habitat_id ,$picture_id, $habitat_picture_id ) {
	    $sql = 'UPDATE habitat_picture SET habitat_id = :habitat_id, picture_id = :picture_id   WHERE habitat_picture_id = :id';
	    $stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id ', $habitat_picture_id );
        $stmt->bindParam(':habitat_id', $habitat_id);
		$stmt->bindParam(':picture_id', $picture_id);
        $stmt->execute();     
	    return true;
	  }

	  // Delete an user from database
	  public function delete($id) {
	    $sql = 'DELETE FROM habitat_picture WHERE habitat_picture_id = :id';
	    $stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id', $id);
	    $stmt->execute();
	    return true;
	  }
	}