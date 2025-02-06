<?php
// Inclure configDB.php
include_once 'configDB.php';

// Créer une classe Picture
class Picture extends Config
{
    // Récupérer une image par son ID
    public function getPictureById($id)
    {
        $sql = 'SELECT * FROM picture WHERE picture_id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row;
    }

    // Récupérer toutes les images
    public function fetchAll()
    {
        $sql = 'SELECT * FROM picture';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }

    // Insérer une nouvelle image dans la base de données
    public function insert($pictureName, $pictureData)
    {
        $sql = 'INSERT INTO picture (picture_name, picture_date) VALUES (:name, :data)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $pictureName);
        $stmt->bindParam(':data', $pictureData, PDO::PARAM_LOB);
        $stmt->execute();
        return true;
    }

    // Supprimer une image par son ID
    public function delete($id)
    {
        $sql = 'DELETE FROM picture WHERE picture_id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return true;
    }
}
