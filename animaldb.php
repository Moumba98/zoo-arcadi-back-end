<?php
	// Include config.php file
	include_once 'configDB.php';

	// Create a class role
	class Database extends Config {
	  // Fetch all or a single user from database
	  public function fetch($id = 0) {
	    $sql = 'SELECT * FROM `animal`';
	    if ($id != 0) {
	      $sql .= ' animal_id = :animal_id';
	    }
        
        
	    $stmt = $this->conn->prepare($sql);
		 
	    $stmt->execute();
		
		
        var_dump($id);
	    $rows = $stmt->fetchAll();
	    return $rows;
	  }

	  // Insert an user in the database
	    public function insert(  $first_name, $etat, $habitat_id, $race_id, ) {
	    $sql = 'INSERT INTO `animal` (  first_name, etat, habitat_id, race_id) VALUES ( :animal_id, :first_name, :etat, :habitat_id, :race_id)';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute([ 'first_name' => $first_name, 'etat' => $etat, 'habitat_id' => $habitat_id, 'race_id' => $race_id]);
	    return true;
	  }

	  // Update an user in the database
	  public function update( $first_name, $etat, $habitat_id, $race_id,) {
	    $sql = 'UPDATE `animal` SET animal_id = :animal_id, first_name = :first_name, etat = :etat, habitat_id = :habitat_id, race_id = :race_id WHERE animal_id = :animal_id';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute([ 'first_name' => $first_name, 'etat' => $etat, 'habitat_id' => $habitat_id, 'race_id' => $race_id]);
	    return true;
	  }

	  // Delete an user from database
	  public function delete($id) {
	    $sql = 'DELETE FROM `animal` WHERE animal_id = :animal_id';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['animal_id' => $id]);
	    return true;
	  }
	}