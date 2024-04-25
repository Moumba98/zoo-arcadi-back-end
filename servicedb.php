<?php
	// Include config.php file
	include_once 'configDB.php';

	// Create a class role
	class Service extends Config {
	  // Fetch all or a single user from database
	  

	  public function getServiceById($id) {
	   
	    if ($id != null) {
		  $sql = 'SELECT * FROM service WHERE service_id = :id ';
		}
		  $stmt = $this->conn->prepare($sql);
		  $stmt->bindParam(':id', $id);
	      $rows = $stmt->execute();
		  $rows = $stmt->fetch();
	     return $rows;
	  }

	public function fetchAll() {
	      $sql = 'SELECT * FROM service ;';
	      $stmt = $this->conn->prepare($sql);
		  $stmt->execute();
	      $rows = $stmt->fetchAll();
	    return $rows;
	  }


	  // Insert an user in the database
	    public function insert( $name, $descr) {
	    $sql = 'INSERT INTO service(name, description) VALUES ( :name, :description);';
	    $stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':description', $descr);
	    $stmt->execute();
	    return true;
	  }

	  // Update an user in the database
	  public function update(  $name, $description, $service_id) {
	    $sql = 'UPDATE service SET  name = :name,  description = :description  WHERE service_id = :id';
	    $stmt = $this->conn->prepare($sql);

		$stmt->bindParam(':id', $service_id);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':description', $description);
	    $stmt->execute();
	    return true;
	  }

	  // Delete an user from database
	  public function delete($id) {
	    $sql = 'DELETE FROM service WHERE service_id = :id';
	    $stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id', $id);
	    $stmt->execute();
	    return true;
	  }
	}