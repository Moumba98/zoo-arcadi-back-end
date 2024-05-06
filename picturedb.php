<?php
	// Include config.php file
	include_once 'configDB.php';

	// Create a class role
	class Picture extends Config {
	  // Fetch all or a single user from database


	  public function getPictureById($id) {
	   
	    if ($id != null) {
		  $sql = 'SELECT * FROM picture WHERE picture_id = :id ';
		}
		  $stmt = $this->conn->prepare($sql);
		  $stmt->bindParam(':id', $id);
	      $rows = $stmt->execute();
		  $rows = $stmt->fetch();
	     return $rows;
	  }

	public function fetchAll() {
	      $sql = 'SELECT * FROM picture ;';
	      $stmt = $this->conn->prepare($sql);
		  $stmt->execute();
	      $rows = $stmt->fetchAll();
	    return $rows;
	  }

	  public function insert($picture_name, $picture_date) {
	    $sql = 'INSERT INTO picture(picture_name, picture_date) VALUES (:picture_name, :picture_date);';
	    $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':picture_name', $picture_name);

        $stmt->bindParam(':picture_date', $picture_date);
		
	    $stmt->execute();
	    return true;
	  }

	  // Update an user in the database
	  public function update(   $picture_name, $picture_date, $picture_id) {
	    $sql = 'UPDATE picture SET picture_name = :picture_name, picture_date = :picture_date  WHERE picture_id = :id';
	    $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':picture_name', $picture_name);
		$stmt->bindParam(':picture_date', $picture_date);
		$stmt->bindParam(':id', $picture_id);
		$stmt->execute();
	    return true;
	  }

	  // Delete an user from database
	  public function delete($id) {
	    $sql = 'DELETE FROM picture WHERE picture_id = :id';
	    $stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id', $id);
	    $stmt->execute();
	    return true;
	  }
	}