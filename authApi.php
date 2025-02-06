<?php
// Include CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, X-Auth-Token, Authorization, Origin');
header('Content-Type: application/json');

// Include authdb.php file
include_once 'authdb.php';

// Create an object of Auth class
$auth = new Auth();

// Get HTTP method
$api = $_SERVER['REQUEST_METHOD'];

if ($api == 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    $username = $auth->test_input($data->username);
    $password = $auth->test_input($data->password);

    // Authenticate user
    $user = $auth->authenticate($username, $password);
      
   
    if ($user) {
        // Generate a token (e.g., fake token for now)
        $token = bin2hex(random_bytes(16));
        echo json_encode([
            'message' => 'Authentication successful!',
            'error' => false,
            'token' => $token,
            'user' => [
                'user_id' => $user['user_id'],
                'name' => $user['name'],
                'first_name' => $user['first_name'],
                'role_id' => $user['role_id']
            ]
        ]);
    } else {
        echo $auth->message('Invalid username or password!', true);
    }
} else {
    echo $auth->message('Invalid request method!', true);
}


/*/ Include CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, X-Auth-Token, Authorization, Origin');
header('Content-Type: application/json');

// Include authdb.php file
include_once 'authdb.php';

// Create an object of Auth class
$auth = new Auth();

// Get HTTP method
$api = $_SERVER['REQUEST_METHOD'];

if ($api == 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    $username = $auth->test_input($data->username);
    $password = $auth->test_input($data->password);


    // Authenticate user
    $user = $auth->authenticate($username, $password);

    if ($user) {
        // Generate a fake token (you can replace this with a real token mechanism)
        $token = bin2hex(random_bytes(16));
        echo json_encode([
            'message' => 'Authentication successful!',
            'error' => false,
            'token' => $token,
            'user' => [
                'user_id' => $user['user_id'],
                'name' => $user['name'],
                'first_name' => $user['first_name'],
                'role_id' => $user['role_id']
            ]
        ]);
    } else {
        echo $auth->message('Invalid username or password!', true);
    }
} else {
    echo $auth->message('Invalid request method!', true);
}*/
