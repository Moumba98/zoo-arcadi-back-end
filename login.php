<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
header('Content-Type: application/json, charset=UTF-8');

// Include action.php file
include_once 'Userdb.php';
// Create object of Users class

$user = new User();

// create a api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];




if ($api == 'POST') {
    $data = json_decode(file_get_contents('php://input'));
    if (isset($data) && !empty($data)) {
        $email = $user->test_input($data->username);
        $pwd = $user->test_input($data->password);
        //$name = $user->test_input($data->name);
        //$first_name = $user->test_input($data->first_name);
        $result = $user->login($email, $pwd);
        if ($result) {
            echo json_encode($result);
        } else {
            http_response_code(404);
        }
    }
    /*
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

if(isset($postdata) && !empty($postdata))
{
$pwd = mysqli_real_escape_string($mysqli, trim($request->password));
$email = mysqli_real_escape_string($mysqli, trim($request->username));

$sql = "SELECT * FROM users where email='$email' and password='$pwd'";
if($result = mysqli_query($mysqli,$sql))
{
$rows = array();
while($row = mysqli_fetch_assoc($result))
{
$rows[] = $row;
}
echo json_encode($rows);
}
else
{
http_response_code(404);
}*/
}
