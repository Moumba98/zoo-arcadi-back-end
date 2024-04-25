<?php
	// Include CORS headers
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('Access-Control-Allow-Headers: X-Requested-With');
	header('Content-Type: application/json');

	// Include action.php file
	include_once 'roledb.php';
	// Create object of Users class
	$user = new Database();

	// create a api variable to get HTTP method dynamically
	$api = $_SERVER['REQUEST_METHOD'];

	// get id from url
	$id = intval($_GET['id'] ?? '');

	// Get all or a single user from database
	if ($api == 'GET') {
	  if ($id != 0) {
	    $data = $user->fetch($id);
	  } else {
	    $data = $user->fetch();
        var_dump($data);
	  }
	  echo json_encode($data);
	}

	// Add a new user into database
	if ($api == 'POST') {

		

			
			
            $label = $user->test_input($_POST['label']);

			if ($user->insert( $label)) {
				echo $user->message('User added successfully!',false);
			  } else {
				echo $user->message('Failed to add an user!',true);
			  }
	  
			
		
		
		
	  
	}

	// Update an user in database
	
	if ($api == 'PUT') {
	  parse_str(file_get_contents('php://input'), $post_input);
      
     
      
      $label = $user->test_input($post_input['label']);

	  if ($id != null) {
	    if ($user->update( $label)) {
	      echo $user->message('role updated successfully!',false);
	    } else {
	      echo $user->message('Failed to update an role!',true);
	    }
	  } else {
	    echo $user->message('role not found!',true);
	  }
	}

	// Delete an user from database
	if ($api == 'DELETE') {
	  if ($id != null) {
	    if ($user->delete($id)) {
	      echo $user->message('role deleted successfully!', false);
	    } else {
	      echo $user->message('Failed to delete an role!', true);
	    }
	  } else {
	    echo $user->message('role not found!', true);
	  }
	}