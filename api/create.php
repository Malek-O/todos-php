<?php

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Allow: POST");
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
       

    return;
}

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Controll-Allow-Methods: POST');

include_once '../db/Database.php';
include_once '../models/Todo.php';

$database = new Database();

$dbConnection = $database->connect();

$todo = new Todo($dbConnection);

$data = json_decode(file_get_contents('php://input'),true);

if(!$data || !isset($data['task'])){
    http_response_code(422);
    echo json_encode(
        ['message' => 'Error missing params task']
    );
    return;
}

$todo->setTask($data['task']);

if($todo->create()){
     echo json_encode(
        ['message' => 'A todo was created']
    );
}else{
     echo json_encode(
        ['message' => 'Error: No Todo item was created']
    );
}
