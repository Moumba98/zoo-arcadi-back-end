<?php
	// Include CORS headers
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('Access-Control-Allow-Headers: X-Requested-With');
	header('Content-Type: application/json');

	// Include action.php file
	include_once 'Userdb.php';
	// Create object of Users class
	$user = new Database();

	// create a api variable to get HTTP method dynamically
	$api = $_SERVER['REQUEST_METHOD'];

	// get id from url
	$id = intval($_GET['id'] ?? '');

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

		
		    
			$username = $user->test_input($_POST['username']);
			$password = $user->test_input($_POST['password']);
			$name = $user->test_input($_POST['name']);
			$first_name = $user->test_input($_POST['first_name']);
			$role_id = $user->test_input($_POST['role_id']);

			if ($user->insert(  $username, $password, $name, $first_name, $role_id)) {
				echo $user->message('User added successfully!',false);
			  } else {
				echo $user->message('Failed to add an user!',true);
			  }
	  
			
		
		
		
	  
	}

	// Update an user in database
	
	if ($api == 'PUT') {
	  parse_str(file_get_contents('php://input'), $post_input);
      
      
	  $username = $user->test_input($post_input['username']);
	  $password = $user->test_input($post_input['password']);
	  $name = $user->test_input($post_input['name']);
      $first_name = $user->test_input($post_input['first_name']);
      $role_id = $user->test_input($post_input['role_id']);

	  if ($id != null) {
	    if ($user->update($username, $password, $name, $first_name,$role_id)) {
	      echo $user->message('User updated successfully!',false);
	    } else {
	      echo $user->message('Failed to update an user!',true);
	    }
	  } else {
	    echo $user->message('User not found!',true);
	  }
	}

	// Delete an user from database
	if ($api == 'DELETE') {
	  if ($id != null) {
	    if ($user->delete($id)) {
	      echo $user->message('User deleted successfully!', false);
	    } else {
	      echo $user->message('Failed to delete an user!', true);
	    }
	  } else {
	    echo $user->message('User not found!', true);
	  }
	}
