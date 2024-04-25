<?php
	// Include CORS headers
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('Access-Control-Allow-Headers: X-Requested-With');
	header('Content-Type: application/json');

	// Include action.php file
	include_once 'habitatdb.php';
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

		

			
			$habitat_id = $user->test_input($_POST['habitat_id']);
            $name = $user->test_input($_POST['name']);
            $description  = $user->test_input($_POST['description']);
            $habitat_comment = $user->test_input($_POST['habitat_comment']);

			if ($user->insert($habitat_id, $name, $description, $habitat_comment)) {
				echo $user->message('habitat added successfully!',false);
			  } else {
				echo $user->message('Failed to add an habitat!',true);
			  }
	  
			
		
		
		
	  
	}

	// Update an user in database
	
	if ($api == 'PUT') {
	  parse_str(file_get_contents('php://input'), $post_input);
      
     
      $habitat_id = $user->test_input($post_input['habitat_id']);
      $name = $user->test_input($post_input['name']);
      $description = $user->test_input($post_input['description']);
      $habitat_comment = $user->test_input($post_input['habitat_comment']);


	  if ($id != null) {
	    if ($user->update($habitat_id, $name, $description, $habitat_comment)) {
	      echo $user->message('habitat updated successfully!',false);
	    } else {
	      echo $user->message('Failed to update an habitat!',true);
	    }
	  } else {
	    echo $user->message('habitat not found!',true);
	  }
	}

	// Delete an user from database
	if ($api == 'DELETE') {
	  if ($id != null) {
	    if ($user->delete($id)) {
	      echo $user->message('habitat deleted successfully!', false);
	    } else {
	      echo $user->message('Failed to delete an habitat!', true);
	    }
	  } else {
	    echo $user->message('habitat not found!', true);
	  }
	}