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

    if($data->contact_id == null OR $data->contact_id === '')
    {
        http_response_code(400);
        echo json_encode(['required' => 'Contact id required']);
        return;
    }

    if($data->phone == null OR $data->phone === '')
    {
        http_response_code(400);
        echo json_encode(['required' => 'Phone is required']);
        return;
    }

    if(!validate_number($data->phone))
    {
        http_response_code(400);
        echo json_encode(['format' => 'Phone format is invalid']);
        return;
    }
    
    $item->contact_id = $data->contact_id;
    $item->phone = $data->phone;
    $item->created_at = date('Y-m-d H:i:s');
    
    if($item->createContactDetail()){
        http_response_code(200);
        echo json_encode(['message' => 'Contact Detail data has been created.']);
    } else{
        http_response_code(500);
        echo json_encode(['message' => 'Contact Detail could not be created']);
    }

    

    function validate_number($phone_number){
        if(preg_match('/^[0-9]{10}+$/', $phone_number)) {
            return true;
        }   else{
            return false;
        }
    }
?>