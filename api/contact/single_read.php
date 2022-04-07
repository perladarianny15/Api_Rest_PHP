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

    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $item->getContactById();

    if($item->name != null){

        $contact_arr = array(
            "id" => $item->id,
            "name" => $item->name,
            "last_name" => $item->last_name,
            "email" => $item->email,
            "address" => $item->address,
            "created_at" => $item->created_at,
        );
      
        http_response_code(200);
        echo json_encode($contact_arr);
    }
    else{
        http_response_code(404);
        echo json_encode(['message', 'Contact not found.']);
    }
?>