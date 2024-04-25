<?php
	// Include CORS headers
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('Access-Control-Allow-Headers: X-Requested-With');
	header('Content-Type: application/json');

	// Include action.php file
	include_once 'veterinary_raportdb.php';
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

		

			
            
            $date = $user->test_input($_POST['date']);
            $detail  = $user->test_input($_POST['detail']);
            $user_id  = $user->test_input($_POST['user_id']);
            $animal_id = $user->test_input($_POST['animal_id']);

			if ($user->insert(  $date, $detail, $user_id, $animal_id )) {
				echo $user->message('veterinary added successfully!',false);
			  } else {
				echo $user->message('Failed to add an veterinary!',true);
			  }	
		
		
	  
	}

	// Update an user in database
	
	if ($api == 'PUT') {
	  parse_str(file_get_contents('php://input'), $post_input);
      
     
      
      $date = $user->test_input($post_input['date']);
      $detail = $user->test_input($post_input['detail']);
      $user_id = $user->test_input($post_input['user_id']);
      $animal_id  = $user->test_input($post_input['animal_id']);


	  if ($id != null) {
	    if ($user->update(  $date, $detail, $user_id, $animal_id )) {
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