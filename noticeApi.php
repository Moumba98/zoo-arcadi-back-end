<?php
	// Include CORS headers
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('Access-Control-Allow-Headers: X-Requested-With');
	header('Content-Type: application/json');

	// Include action.php file
	include_once 'noticedb.php';
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

		

			
			$notice_id = $user->test_input($_POST['notice_id']);
            $pseudo = $user->test_input($_POST['pseudo']);
            $comment  = $user->test_input($_POST['comment']);
            $isvisible = $user->test_input($_POST['comment']);

			if ($user->insert($notice_id, $pseudo, $comment, $isvisible)) {
				echo $user->message('notice added successfully!',false);
			  } else {
				echo $user->message('Failed to add an notice!',true);
			  }
		
		
	  
	}

	// Update an user in database
	
	if ($api == 'PUT') {
	  parse_str(file_get_contents('php://input'), $post_input);
      
     
      $notice_id = $user->test_input($post_input['notice_id']);
      $pseudo = $user->test_input($post_input['pseudo']);
      $comment = $user->test_input($post_input['comment']);
      $isvisible = $user->test_input($post_input['isvisible']);


	  if ($id != null) {
	    if ($user->update($notice_id, $pseudo, $comment,$isvisible)) {
	      echo $user->message('notice updated successfully!',false);
	    } else {
	      echo $user->message('Failed to update an notice!',true);
	    }
	  } else {
	    echo $user->message('notice not found!',true);
	  }
	}

	// Delete an user from database
	if ($api == 'DELETE') {
	  if ($id != null) {
	    if ($user->delete($id)) {
	      echo $user->message('notice deleted successfully!', false);
	    } else {
	      echo $user->message('Failed to delete an notice!', true);
	    }
	  } else {
	    echo $user->message('notice not found!', true);
	  }
	}