<?php
	// Include config.php file
	include_once 'configDB.php';

	// Create a class role
	class Database extends Config {
	  // Fetch all or a single user from database
	  public function fetch($id = 0) {
	    $sql = 'SELECT * FROM `habitat`';
	    if ($id != 0) {
	      $sql .= ' habitat_id = :habitat_id';
	    }
        
        
	    $stmt = $this->conn->prepare($sql);
		 
	    $stmt->execute();
		
		
        var_dump($id);
	    $rows = $stmt->fetchAll();
	    return $rows;
	  }

	  // Insert an user in the database
	    public function insert( $habitat_id, $name, $description, $habitat_comment ) {
	    $sql = 'INSERT INTO `habitat` ( habitat_id, name, description, habitat_comment) VALUES ( :habitat_id, :name, :description, :habitat_comment)';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['habitat_id' => $habitat_id, 'name' => $name, 'description' => $description, 'habitat_comment' => $habitat_comment,]);
	    return true;
	  }

	  // Update an user in the database
	  public function update( $habitat_id, $name, $description, $habitat_comment) {
	    $sql = 'UPDATE `habitat` SET habitat_id = :habitat_id, name = :name, description = :description, habitat_comment = :habitat_comment, WHERE habitat_id = :habitat_id';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['habitat_id' => $habitat_id, 'name' => $name, 'description' => $description, 'habitat_comment' => $habitat_comment,]);
	    return true;
	  }

	  // Delete an user from database
	  public function delete($id) {
	    $sql = 'DELETE FROM `habitat` WHERE habitat_id = :habitat_id';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['habitat_id' => $id]);
	    return true;
	  }
	}