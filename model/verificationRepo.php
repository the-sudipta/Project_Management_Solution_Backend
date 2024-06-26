<?php

require_once __DIR__ . '/../model/db_connect.php';


function findAllVerification()
{
    $conn = db_conn();
    $selectQuery = 'SELECT * FROM `verification`';

    try {
        $result = $conn->query($selectQuery);

        // Check if the query was successful
        if (!$result) {
            throw new Exception("Query failed: " . $conn->error);
        }

        $rows = array();

        // Fetch rows one by one
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        // Check for an empty result set
        if (empty($rows)) {
            throw new Exception("No rows found in the 'verification' table.");
        }

        return $rows;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        // Close the database connection
        $conn->close();
    }
}


function findVerificationByID($id)
{
    $conn = db_conn();
    $selectQuery = 'SELECT * FROM `verification` WHERE `id` = ?';

    try {
        $stmt = $conn->prepare($selectQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }

        // Bind the parameter
        $stmt->bind_param("i", $id);

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Fetch the user as an associative array
        $user = $result->fetch_assoc();

        // Check for an empty result set
        if (!$user) {
            throw new Exception("No Customer found with ID: " . $id);
        }

        // Close the statement
        $stmt->close();

        return $user;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        // Close the database connection
        $conn->close();
    }
}


function updateVerification($email, $token, $verification_code, $status, $action, $created_at, $verified_at, $id)
{
    $conn = db_conn();

    // Construct the SQL query
    $updateQuery = "UPDATE `verification` SET 
                    email = ?,
                    token = ?,
                    verification_code = ?,
                    status = ?,
                    action = ?,
                    created_at = ?,
                    verified_at = ?
                    WHERE id = ?";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($updateQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param('sssssssi', $email, $token, $verification_code, $status, $action, $created_at, $verified_at, $id);

        // Execute the query
        $stmt->execute();

        // Return true if the update is successful
        return true;
    } catch (Exception $e) {
        // Handle the exception, you might want to log it or return false
        echo "Error: " . $e->getMessage();
        return false;
    } finally {
        // Close the statement
        $stmt->close();

        // Close the database connection
        $conn->close();
    }
}


function deleteVerification($id) {
    $conn = db_conn();

    // Construct the SQL query
    $updateQuery = "DELETE FROM `verification`
                    WHERE id = ?";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($updateQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }

        // Bind parameter
        $stmt->bind_param('i', $id);

        // Execute the query
        $stmt->execute();

        // Return true if the update is successful
        return true;
    } catch (Exception $e) {
        // Handle the exception, you might want to log it or return false
        echo "Error: " . $e->getMessage();
        return false;
    } finally {
        // Close the statement
        $stmt->close();

        // Close the database connection
        $conn->close();
    }
}


function createVerification($email, $token, $verification_code, $status, $action, $created_at, $verified_at) {
    $conn = db_conn();

    // Construct the SQL query
    $insertQuery = "INSERT INTO `verification` (email, token, verification_code, status, action, created_at, verified_at) VALUES (?, ?, ?, ?, ?, ?, ?)";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($insertQuery);

        // Bind parameters
        $stmt->bind_param('sssssss', $email, $token, $verification_code, $status, $action, $created_at, $verified_at);

        // Execute the query
        $stmt->execute();

        // Return the ID of the newly inserted user
        $newUserId = $stmt->insert_id;

        // Close the statement
        $stmt->close();

        return $newUserId;
    } catch (Exception $e) {
        // Handle the exception, you might want to log it or return false
        echo "Error: " . $e->getMessage();
        return -1;
    } finally {
        // Close the database connection
        $conn->close();
    }
}
