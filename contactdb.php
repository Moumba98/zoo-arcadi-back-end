<?php
// Include config.php file
include_once 'configDB.php';

// Create a class Contact
class Contact extends Config {
  
  // Fetch a single contact by ID
  public function getContactById($id) {
    if ($id != null) {
      $sql = 'SELECT * FROM contact WHERE contact_id = :id';
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':id', $id);
      $stmt->execute();
      $row = $stmt->fetch();
      return $row;
    }
    return null;
  }

  // Fetch all contacts
  public function fetchAll() {
    $sql = 'SELECT * FROM contact';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    return $rows;
  }

  // Insert a contact into the database
  public function insert($nom, $email, $sujet, $message) {
    $sql = 'INSERT INTO contact (nom, email, sujet, message) VALUES (:nom, :email, :sujet, :message)';
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':sujet', $sujet);
    $stmt->bindParam(':message', $message);
    $stmt->execute();
    return true;
  }

  // Update a contact in the database
  public function update($contact_id, $nom, $email, $sujet, $message) {
    $sql = 'UPDATE contact SET nom = :nom, email = :email, sujet = :sujet, message = :message WHERE contact_id = :contact_id';
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':contact_id', $contact_id);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':sujet', $sujet);
    $stmt->bindParam(':message', $message);
    $stmt->execute();
    return true;
  }

  // Delete a contact from the database
  public function delete($id) {
    $sql = 'DELETE FROM contact WHERE contact_id = :contact_id';
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':contact_id', $id);
    $stmt->execute();
    return true;
  }
}
