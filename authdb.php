<?php
// Include configDB.php file
include_once 'configDB.php';

// Create a class for authentication
class Auth extends Config {
    // Authenticate user with hashed password
    public function authenticate($username, $password) {
        // Requête pour récupérer l'utilisateur
        $sql = 'SELECT * FROM users WHERE username = :username';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Vérifier si l'utilisateur existe et comparer les mots de passe
        if ($user && $user['password'] === $password) {  // Simple comparaison
            return $user;
        }
        return false;
    }
    

    /*public function authenticate($username, $password) {
        $sql = 'SELECT * FROM users WHERE username = :username';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Vérifiez si l'utilisateur existe et si le mot de passe correspond
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Succès
        }
        // Échec d'authentification
        return false;
    }*/
    
        
    // Helper to clean input data
    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Generate JSON message
    public function message($message, $error) {
        return json_encode(['message' => $message, 'error' => $error]);
    }
}




/*/ Include config.php file
include_once 'configDB.php';

// Create a class for authentication
class Auth extends Config {
    // Verify user credentials
    public function authenticate($username, $password) {
        $sql = 'SELECT * FROM users WHERE username = :username';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch();

        // Comparaison simple (NON SÉCURISÉ)
    if ($user && $user['password'] === $password) {
        return $user;
    }
    return false;
        // Check if user exists and verify password
       // if ($user && password_verify($password, $user['password'])) {
          //  return $user; // // Authentification réussie, retourne les informations de l'utilisateur
       // }
       // return false;  //// Authentification échouée
    }

    // Generate a success message
    public function message($message, $error) {
        return json_encode(['message' => $message, 'error' => $error]);
    }
}*/
