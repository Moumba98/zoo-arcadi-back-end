<?php
	// Include config.php file
	include_once 'configDB.php';

	// Create a class role
	class Database extends Config {
	  // Fetch all or a single user from database
	  public function fetch($id = 0) {
	    $sql = 'SELECT * FROM `race`';
	    if ($id != 0) {
	      $sql .= ' race_id = :race_id';
	    }
        
        
	    $stmt = $this->conn->prepare($sql);
		 
	    $stmt->execute();
		
		
        var_dump($id);
	    $rows = $stmt->fetchAll();
	    return $rows;
	  }

	  // Insert an user in the database
	    public function insert( $race_id, $label, ) {
	    $sql = 'INSERT INTO `race` ( race_id, label) VALUES ( :race_id, :label)';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['race_id' => $race_id, 'label' => $label]);
	    return true;
	  }

	  // Update an user in the database
	  public function update( $race_id,$label) {
	    $sql = 'UPDATE `race` SET role_id = :race_id, label = :label,  WHERE race_id = :race_id';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['race_id' => $race_id,'label' => $label ]);
	    return true;
	  }

	  // Delete an user from database
	  public function delete($id) {
	    $sql = 'DELETE FROM `race` WHERE race_id = :race_id';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['race_id' => $id]);
	    return true;
	  }
	}