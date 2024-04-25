<?php
	// Include CORS headers
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('Access-Control-Allow-Headers: X-Requested-With');
	header('Content-Type: application/json');

	// Include action.php file
	include_once 'servicedb.php';
	// Create object of Users class
	$service = new Service();

	// create a api variable to get HTTP method dynamically
	$api = $_SERVER['REQUEST_METHOD'];

	// get id from url
	$id = intval($_GET['service_id'] ?? '');
	

	// Get all or a single user from database
	if ($api == 'GET') {
	  if ($id != 0) {
	    $data = $service->getServiceById($id);
	  } else {
	    $data = $service->fetchAll();
	  }
	  echo json_encode($data);
	}

	// Add a new user into database
	if ($api == 'POST') {
		$data = json_decode(file_get_contents('php://input'));
        $name = $service->test_input($data->name);
        $description = $service->test_input($data->description);
			if ($service->insert($name,  $description)) {
				echo $service->message('service added successfully!',false);
			  } else {
				echo $service->message('Failed to add an service!',true);
			  }
	}

	// Update an user in database
	if ($api == 'PUT') {
		$data = $service->getServiceById($id);
	 if ($data != null) {
	   $data = json_decode(file_get_contents('php://input'));
	   $name = $service->test_input($data->name);
	   $description = $service->test_input($data->description);
	   if ($service->update($name, $description, $id)) {
		   http_response_code(202);
		 echo $service->message('User updated successfully!', false);
	   } else {
		   http_response_code(400);
		 echo $service->message('Failed to update an user!', true);
	   }
	 } else {
	   http_response_code(404);
	   echo $service->message('User not found!', true);
	 }
   }

	// Delete an user from database
	if ($api == 'DELETE') {
		$service->delete($id);	
	  if ($id != null) {
	    if ($service->delete($id)) {
			
	      echo $service->message('service deleted successfully!', false);
	    } else {
	      echo $service->message('Failed to delete an service!', true);
	    }
	  } else {
	    echo $service->message('service not found!', true);
	  }
	}