<?php
	// Include config.php file
	include_once 'configDB.php';

	// Create a class role
	class Database extends Config {
	  // Fetch all or a single user from database
	  public function fetch($id = 0) {
	    $sql = 'SELECT * FROM `role`';
	    if ($id != 0) {
	      $sql .= ' role_id = :role_id';
	    }
        
        
	    $stmt = $this->conn->prepare($sql);
		 
	    $stmt->execute();
		
		
        var_dump($id);
	    $rows = $stmt->fetchAll();
	    return $rows;
	  }

	  // Insert an user in the database
	    public function insert(  $label, ) {
	    $sql = 'INSERT INTO `role` ( role_id, label) VALUES ( :role_id, :label)';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute([ 'label' => $label]);
	    return true;
	  }

	  // Update an user in the database
	  public function update( $label) {
	    $sql = 'UPDATE `role` SET role_id = :role_id, label = :label,  WHERE role_id = :role_id';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['label' => $label ]);
	    return true;
	  }

	  // Delete an user from database
	  public function delete($id) {
	    $sql = 'DELETE FROM `role` WHERE role_id = :role_id';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['role_id' => $id]);
	    return true;
	  }
	}