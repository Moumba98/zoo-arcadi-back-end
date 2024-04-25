<?php
	// Include config.php file
	include_once 'configDB.php';

	// Create a class role
	class Database extends Config {
	  // Fetch all or a single user from database
	  public function fetch($id = 0) {
	    $sql = 'SELECT * FROM `veterinary_raport`';
	    if ($id != 0) {
	      $sql .= ' veterinary_raport_id = :veterinary_raport';
	    }
        
        
	    $stmt = $this->conn->prepare($sql);
		 
	    $stmt->execute();
		
		
        var_dump($id);
	    $rows = $stmt->fetchAll();
	    return $rows;
	  }

	  // Insert an user in the database
	    public function insert( $date, $detail, $user_id, $animal_id, ) {
	    $sql = 'INSERT INTO `veterinary_raport` ( date, detail, user_id, animal_id) VALUES (  :date, :detail, :user_id, :animal_id)';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute([ 'date' => $date, 'detail' => $detail, 'user_id' => $user_id, 'animal_id' => $animal_id]);
	    return true;
	  }

	  // Update an user in the database
	  public function update( $date, $detail, $user_id, $animal_id) {
	    $sql = 'UPDATE `veterinary_raport` SET veterinary_raport_id = :veterinary_raport_id, date = :date, detail = :detail, user_id = :user_id, animal_id = :animal_id WHERE veterinary_raport_id= :veterinary_raport_id';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute([ 'date' => $date, 'detail' => $detail, 'user_id' => $user_id, 'animal_id' => $animal_id]);
	    return true;
	  }

	  // Delete an user from database
	  public function delete($id) {
	    $sql = 'DELETE FROM `veterinary_raport` WHERE veterinary_raport_id = :veterinary_raport_id';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['veterinary_raport_id' => $id]);
	    return true;
	  }
	}