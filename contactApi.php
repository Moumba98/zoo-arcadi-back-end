<?php

// Include CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, X-Auth-Token, Authorization, Origin');
header('Content-Type: application/json');

// Include Contact class file
include_once 'Contactdb.php';

// Create object of Contact class
$contact = new Contact();

// Create an API variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];

// Get ID from URL
$id = intval($_GET['contact_id'] ?? '');

// Get all or a single contact from database
if ($api == 'GET') {
    if ($id != 0) {
        $data = $contact->getContactById($id);
    } else {
        $data = $contact->fetchAll();
    }
    echo json_encode($data);
}

// Add a new contact into database
if ($api == 'POST') {
    $data = json_decode(file_get_contents('php://input'));
    $nom = $contact->test_input($data->nom);
    $email = $contact->test_input($data->email);
    $sujet = $contact->test_input($data->sujet);
    $message = $contact->test_input($data->message);

    if ($contact->insert($nom, $email, $sujet, $message)) {
        echo $contact->message('Contact added successfully!', false);
    } else {
        echo $contact->message('Failed to add contact!', true);
    }
}

// Update a contact in database
if ($api == 'PUT') {
    $data = $contact->getContactById($id);
    if ($data != null) {
        $data = json_decode(file_get_contents('php://input'));
        $nom = $contact->test_input($data->nom);
        $email = $contact->test_input($data->email);
        $sujet = $contact->test_input($data->sujet);
        $message = $contact->test_input($data->message);

        if ($contact->update($id, $nom, $email, $sujet, $message)) {
            echo $contact->message('Contact updated successfully!', false);
        } else {
            echo $contact->message('Failed to update contact!', true);
        }
    } else {
        echo $contact->message('Contact not found!', true);
    }
}

// Delete a contact from database
if ($api == 'DELETE') {
    $data = $contact->getContactById($id);
    if ($data != null) {
        if ($contact->delete($id)) {
            echo $contact->message('Contact deleted successfully!', false);
        } else {
            echo $contact->message('Failed to delete contact!', true);
        }
    } else {
        echo $contact->message('Contact not found!', true);
    }
}
