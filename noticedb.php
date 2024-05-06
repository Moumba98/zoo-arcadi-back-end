<?php
// Include config.php file
include_once 'configDB.php';

// Create a class role
class Notice extends Config
{
	// Fetch all or a single user from database


	public function getNoticeById($id)
	{

		if ($id != null) {
			$sql = 'SELECT * FROM notice WHERE notice_id = :id ';
		}
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id', $id);
		$rows = $stmt->execute();
		$rows = $stmt->fetch();
		return $rows;
	}

	public function fetchAll()
	{
		$sql = 'SELECT * FROM notice';
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll();
		return $rows;
	}


	// Insert an user in the database

	public function insert($pseudo, $comment, $isvisible)
	{
		$sql = 'INSERT INTO notice(pseudo, comment, isvisible) VALUES ( :pseudo, :comment, :isvisible);';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':pseudo', $pseudo);
		$stmt->bindParam(':comment', $comment);
		$stmt->bindParam(':isvisible', $isvisible);
		$stmt->execute();
		return true;
	}

	// Update an user in the database
	public function update($pseudo, $comment, $isvisible, $notice_id)
	{
		$sql = 'UPDATE notice SET  pseudo = :pseudo,  comment = :comment , isvisible = :isvisible  WHERE notice_id = :id';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id', $notice_id);
		$stmt->bindParam(':pseudo', $pseudo);
		$stmt->bindParam(':comment', $comment);
		$stmt->bindParam(':isvisible', $isvisible);
		$stmt->execute();
		return true;
	}

	// Delete an user from database
	public function delete($id)
	{
		$sql = 'DELETE FROM notice WHERE notice_id = :id';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		return true;
	}
}
