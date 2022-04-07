<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../class/contact_details.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new ContactDetail($db);
    
    $data = json_decode(file_get_contents("php://input"));
    

    if($data->id == null OR $data->id === '')
    {
        http_response_code(400);
        echo json_encode(['required' => 'Id is required']);
        return;
    }

    $item->id = $data->id;
    
    if($item->deleteContactDetail()){
        http_response_code(200);
        echo json_encode(['message' => 'Contact Detail deleted succesfully']);
    } else{
        http_response_code(500);
        echo json_encode(['message' => 'Contact Detail coult not deleted']);

    }
?>