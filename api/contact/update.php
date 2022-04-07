<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../class/contacts.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new Contact($db);
    
    $data = json_decode(file_get_contents("php://input"));

    if($data->name == null OR $data->name === '')
    {
        http_response_code(400);
        echo json_encode(['required' => 'Name is required']);
        return;
    }

    if($data->last_name == null OR $data->last_name === '')
    {
        http_response_code(400);
        echo json_encode(['required' => 'Lastname is required']);
        return;
    }

    if($data->email == null OR $data->email === '')
    {
        http_response_code(400);
        echo json_encode(['required' => 'Email is required']);
        return;
    }

    if (!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['format' => 'Invalid Email Format']);
        return;
    }
    
    $item->id = $data->id;
    $item->name = $data->name;
    $item->last_name = $data->last_name;
    $item->email = $data->email;
    $item->address = $data->address;
    $item->created_at = date('Y-m-d H:i:s');
    
    if($item->updateContact()){
        http_response_code(200);
        echo json_encode(['message' => 'Contact data updated.']);
    } else{
        http_response_code(500);
        echo json_encode(['message' => 'Contact could not be updated.']);
    }
?>