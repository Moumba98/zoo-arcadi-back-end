<?php
// Include CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Content-Type: application/json');

// Include action.php file
include_once 'Userdb.php';
// Create object of Users class
$user = new User();

// create a api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];

// get id from url
$id = intval($_GET['user_id'] ?? '');

// Get all or a single user from database
if ($api == 'GET') {
	if ($id != 0) {
		$data = $user->getUserById($id);
	} else {
		$data = $user->fetchAll();
	}
	echo json_encode($data);
}

// Add a new user into database
if ($api == 'POST') {
	$data = json_decode(file_get_contents('php://input'));
	$username = $user->test_input($data->username);
	$password = $user->test_input($data->password);
	$name = $user->test_input($data->name);
	$first_name = $user->test_input($data->first_name);
	$role_id = $user->test_input($data->role_id);
	if ($user->insert($username, $password, $name, $first_name, $role_id)) {
		echo $user->message('User added successfully!', false);
	} else {
		echo $user->message('Failed to add an user!', true);
	}
}

// Update an user in database

if ($api == 'PUT') {
	$data = $user->getUserById($id);
	if ($data != null) {
		$data = json_decode(file_get_contents('php://input'));
		$username = $user->test_input($data->username);
		$password = $user->test_input($data->password);
		$name = $user->test_input($data->name);
		$first_name = $user->test_input($data->first_name);
		$role_id = $user->test_input($data->role_id);

		if ($user->update($username, $password, $name, $first_name, $role_id, $id)) {
			echo $user->message('User added successfully!', false);
		} else {
			echo $user->message('Failed to add an user!', true);
		}
	} else {

		echo $user->message('user not found!', true);
	}
}

// Delete an user from database
if ($api == 'DELETE') {
	$data = $user->getUserById($id);
	if ($data != null) {
		if ($user->delete($id)) {
			echo $user->message('User deleted successfully!', false);
		} else {
			echo $user->message('Failed to delete an user!', true);
		}
	} else {
		echo $user->message('User not found!', true);
	}
}
