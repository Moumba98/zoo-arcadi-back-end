<?php
// Include config.php file
include_once 'configDB.php';

// Create a class role
class Habitat extends Config
{
	// Fetch all or a single user from database


	public function getHabitatById($id)
	{

		if ($id != null) {
			$sql = 'SELECT * FROM habitat WHERE habitat_id = :id ';
		}
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id', $id);
		$rows = $stmt->execute();
		$rows = $stmt->fetch();
		return $rows;
	}

	public function fetchAll()
	{
		$sql = 'SELECT * FROM habitat';
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll();
		return $rows;
	}


	// Insert an user in the database
	public function insert($name, $description, $habitat_comment)
	{
		$sql = 'INSERT INTO habitat(name, description, habitat_comment) VALUES ( :name, :description, :habitat_comment);';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':description', $description);
		$stmt->bindParam(':habitat_comment', $habitat_comment);
		$stmt->execute();
		return true;
	}

	// Update an user in the database
	public function update($name, $description, $habitat_comment, $habitat_id)
	{
		$sql = 'UPDATE habitat SET  name = :name,  description = :description , habitat_comment = :habitat_comment  WHERE habitat_id = :id';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id', $habitat_id);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':description', $description);
		$stmt->bindParam(':habitat_comment', $habitat_comment);
		$stmt->execute();
		return true;
	}

	// Delete an user from database
	public function delete($id)
	{
		$sql = 'DELETE FROM habitat WHERE habitat_id = :id';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		return true;
	}
}
