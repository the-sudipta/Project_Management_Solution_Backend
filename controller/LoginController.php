<?php
// API : http://localhost/Project_Management_Solution_Backend/controller/LoginController.php

require_once __DIR__ . '/../model/UserRepo.php';
global $routes, $system_routes, $error_page;
require '../routes.php';
require '../utils/system_functions.php';

// Check if $system_routes['error_500'] is set
$error_message = '';

session_start();

$everythingOKCounter = 0;
$everythingOK = false;

header('Content-Type: application/json');

// Decode JSON input
$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $response = [];
    $email = $input['email'] ?? null;
    $password = $input['password'] ?? null;




    $everythingOK = true;
    if ($everythingOK && $everythingOKCounter === 0) {
        $role = null;
//        echo '<br>Everything is ok<br>';

//        Check the user in the database
        $data = findUserByEmailAndPassword($email, $password);
        if ($data && isset($data["id"])) {
            $_SESSION["data"] = $data;
            $_SESSION["user_id"] = $data["id"];
            $role = $data["role"];


//            echo '<br>ID found = '.isset($data["id"]).' <br>';
        } else {
//            echo '<br>Returning to Login page because ID Password did not match<br>';
            $response['status'] = 'error';
            $response['message'] = 'Email & Password did not match';
            echo json_encode($response);

            exit;
        }


        $response['status'] = 'success';
        $response['role'] = $role;
    } else {
        $response['status'] = 'error';
    }
    echo json_encode($response);
    exit;
}else{
    $response['status'] = 'error';
    $response['message'] = 'Request must be POST type';
    echo json_encode($response);
}
