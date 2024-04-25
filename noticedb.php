<?php
	// Include config.php file
	include_once 'configDB.php';

	// Create a class role
	class Database extends Config {
	  // Fetch all or a single user from database
	  public function fetch($id = 0) {
	    $sql = 'SELECT * FROM `notice`';
	    if ($id != 0) {
	      $sql .= ' notice_id = :notice_id';
	    }
        
        
	    $stmt = $this->conn->prepare($sql);
		 
	    $stmt->execute();
		
		
        var_dump($id);
	    $rows = $stmt->fetchAll();
	    return $rows;
	  }

	  // Insert an user in the database
	    public function insert( $notice_id, $pseudo, $comment, $isvisible ) {
	    $sql = 'INSERT INTO `notice` ( notice_id, pseudo, comment, isvisible) VALUES ( :notice_id, :pseudo, :comment, :isvisible)';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['notice_id' => $notice_id, 'pseudo' => $pseudo, 'comment' => $comment, 'isvisible' => $isvisible,]);
	    return true;
	  }

	  // Update an user in the database
	  public function update( $notice_id, $pseudo, $comment, $isvisible) {
	    $sql = 'UPDATE `notice` SET notice_id = :notice_id, pseudo = :pseudo, comment = :comment, description = :description, WHERE notice_id = :notice_id';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['notice_id' => $notice_id, 'pseudo' => $pseudo, 'comment' => $comment, 'isvisible' => $isvisible,]);
	    return true;
	  }

	  // Delete an user from database
	  public function delete($id) {
	    $sql = 'DELETE FROM `notice` WHERE notice_id = :notice_id';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['notice_id' => $id]);
	    return true;
	  }
	}