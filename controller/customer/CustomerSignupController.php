<?php
// API : http://localhost/Project_Management_Solution_Backend/controller/customer/CustomerSignupController.php

require_once __DIR__ . '/../../model/UserRepo.php';
require_once __DIR__ . '/../../model/CustomerRepo.php';
global $routes, $system_routes, $error_page;
require '../../routes.php';


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
    $role = 'Customer';

    $name = $input['name'] ?? null;
    $gender = $input['gender'] ?? null;
    $phone = $input['phone'] ?? null;
    $profession = $input['profession'] ?? null;
    $university_name = $input['university_name'] ?? null;
    $university_id = $input['university_id'] ?? null;
    $company_name = $input['company_name'] ?? null;
    $created_at = date('Y-m-d H:i:s');
    $user_id = -1;




    $everythingOK = true;
    if ($everythingOK && $everythingOKCounter === 0) {

//        echo '<br>Everything is ok<br>';

//        Check the user in the database
        $user = findUserByEmail($email);
        if($user === null){

            $user_id = createUser($email, $password, $created_at, $role);
            if($user_id >0){
                $customer_id = createCustomer($name, $gender, $phone, $profession, $university_name, $university_id,$company_name, $created_at, $user_id);
                if($customer_id >0){
                    $response['status'] = 'success';
                    echo json_encode($response);
                }else{
                    $response['status'] = 'error';
                    $response['message'] = 'User account has been created but the user profile could not, due to some internal issues or Database issues';
                    echo json_encode($response);
                }

            }else{
                $response['status'] = 'error';
                $response['message'] = 'User account could not be created due to some internal issues or Database issues';
                echo json_encode($response);
            }

        }else{
            $response['status'] = 'error';
            $response['message'] = 'Email already Exists';
            echo json_encode($response);
        }

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
