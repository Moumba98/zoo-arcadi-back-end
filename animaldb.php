<?php
	// Include config.php file
	include_once 'configDB.php';

	// Create a class Users
	class Animal extends Config {
	  // Fetch all or a single user from database

	  public function getAnimalById($id) {
	   
	    if ($id != null) {
		  $sql = 'SELECT * FROM animal WHERE animal_id = :id ';
		}
		  $stmt = $this->conn->prepare($sql);
		  $stmt->bindParam(':id', $id);
	      $rows = $stmt->execute();
		  $rows = $stmt->fetch();
	     return $rows;
	  }

	  public function fetchAll() {
	      $sql = 'SELECT * FROM animal ;';
	      $stmt = $this->conn->prepare($sql);
		  $stmt->execute();
	      $rows = $stmt->fetchAll();
	    return $rows;
	  }

	  // Insert an user in the database
	    public function insert( $first_name, $etat, $race_id, $habitat_id) {
	    $sql = 'INSERT INTO animal (first_name, etat, race_id, habitat_id) VALUES ( :first_name, :etat, :race_id, :habitat_id)';
	    $stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':first_name', $first_name);
		$stmt->bindParam(':etat', $etat);
		$stmt->bindParam(':race_id', $race_id);
		$stmt->bindParam(':habitat_id', $habitat_id);
	    $stmt->execute();
	    return true;
	  }

	  // Update an user in the database
	  public function update($first_name, $etat, $race_id, $habitat_id, $animal_id) {
	    $sql = 'UPDATE animal SET animal_id = :animal_id, first_name = :first_name, etat = :etat, race_id = :race_id, habitat_id = :habitat_id WHERE animal_id = :animal_id';
	    $stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':animal_id', $animal_id);
		$stmt->bindParam(':first_name', $first_name);
		$stmt->bindParam(':etat', $etat);
		$stmt->bindParam(':race_id', $race_id);
		$stmt->bindParam(':habitat_id', $habitat_id);
	    $stmt->execute();
	    return true;
	  }

	  // Delete an user from database
	  public function delete($id) {
	    $sql = 'DELETE FROM animal WHERE animal_id = :animal_id';
	    $stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':animal_id', $id);
	    $stmt->execute();
	    return true;
	  }
	}