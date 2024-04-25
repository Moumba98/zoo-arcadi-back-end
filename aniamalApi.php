<?php
	// Include CORS headers
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('Access-Control-Allow-Headers: X-Requested-With');
	header('Content-Type: application/json');

	// Include action.php file
	include_once 'animaldb.php';
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

		
			$animal_id = $user->test_input($_POST['animal_id']);
            $first_name = $user->test_input($_POST['first_name']);
            $etat  = $user->test_input($_POST['etat']);
            $habitat_id = $user->test_input($_POST['habitat_id']);
            $race_id = $user->test_input($_POST['race_id']);

			if ($user->insert($first_name, $etat, $habitat_id ,$race_id,)) {
				echo $user->message('animal added successfully!',false);
			  } else {
				echo $user->message('Failed to add an animal!',true);
			  }
	  
			
		
		
		
	  
	}

	// Update an user in database
	
	if ($api == 'PUT') {
	  parse_str(file_get_contents('php://input'), $post_input);
      
     
      
      $first_name = $user->test_input($post_input['first_name']);
      $etat = $user->test_input($post_input['etat']);
      $habitat_id = $user->test_input($post_input['habitat_id']);
      $race_id = $user->test_input($post_input['race_id']);


	  if ($id != null) {
	    if ($user->update( $first_name, $etat, $habitat_id , $race_id)) {
	      echo $user->message('animal updated successfully!',false);
	    } else {
	      echo $user->message('Failed to update an animal!',true);
	    }
	  } else {
	    echo $user->message('animal not found!',true);
	  }
	}

	// Delete an user from database
	if ($api == 'DELETE') {
	  if ($id != null) {
	    if ($user->delete($id)) {
	      echo $user->message('animal deleted successfully!', false);
	    } else {
	      echo $user->message('Failed to delete an animal!', true);
	    }
	  } else {
	    echo $user->message('animal not found!', true);
	  }
	}