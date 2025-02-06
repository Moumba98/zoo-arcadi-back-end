<?php
/*
// Inclure la configuration de la base de données
include_once 'configDB.php';
$con = new Config();

// Sélectionner tous les utilisateurs dans la base de données
$sql = 'SELECT user_id, password FROM users';
$stmt = $conn->con->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll();

// Pour chaque utilisateur, hasher le mot de passe
foreach ($users as $user) {
    // Hasher le mot de passe avec password_hash
    $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);

    // Mettre à jour le mot de passe hashé dans la base de données
    $updateSql = 'UPDATE users SET password = :hashedPassword WHERE user_id = :user_id';
    $updateStmt = $conn->con->prepare($updateSql);
    $updateStmt->bindParam(':hashedPassword', $hashedPassword);
    $updateStmt->bindParam(':user_id', $user['user_id']);
    $updateStmt->execute();
}

echo "Tous les mots de passe ont été hashés avec succès !";
?>*/
