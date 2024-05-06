<?php
// Include config.php file
include_once 'configDB.php';

// Create a class Users
class Raport extends Config
{
	// Fetch all or a single user from database

	public function getRaportById($id)
	{

		if ($id != null) {
			$sql = 'SELECT * FROM veterinary_raport WHERE veterinary_report_id = :id ';
		}
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id', $id);
		$rows = $stmt->execute();
		$rows = $stmt->fetch();
		return $rows;
	}

	public function fetchAll()
	{
		$sql = 'SELECT * FROM veterinary_raport ;';
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll();
		return $rows;
	}

	// Insert an user in the database
	public function insert($date, $detail, $user_id, $animal_id)
	{
		$sql = 'INSERT INTO veterinary_raport (date, detail, user_id, animal_id) VALUES ( :date, :detail, :user_id, :animal_id)';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':date', $date);
		$stmt->bindParam(':detail', $detail);
		$stmt->bindParam(':user_id', $user_id);
		$stmt->bindParam(':animal_id', $animal_id);
		$stmt->execute();
		return true;
	}

	// Update an user in the database
	public function update($date, $detail, $user_id, $animal_id, $veterinary_report_id)
	{
		$sql = 'UPDATE veterinary_raport SET veterinary_report_id = :veterinary_report_id, date = :date, detail = :detail, user_id = :user_id, animal_id = :animal_id  WHERE veterinary_report_id = :veterinary_report_id';
		
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':veterinary_report_id', $veterinary_report_id);
		$stmt->bindParam(':date', $date);	
		$stmt->bindParam(':detail', $detail);
		$stmt->bindParam(':user_id', $user_id);
		$stmt->bindParam(':animal_id', $animal_id);
		$stmt->execute();
		return true;
	}

	// Delete an user from database
	public function delete($id)
	{
		$sql = 'DELETE FROM veterinary_raport WHERE veterinary_report_id = :veterinary_report_id';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':veterinary_report_id', $id);
		$stmt->execute();
		return true;
	}
}
