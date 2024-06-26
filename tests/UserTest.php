<?php

use PHPUnit\Framework\TestCase;

// Include the database connection and the functions
require_once __DIR__ . '/../model/db_connect.php';
require_once __DIR__ . '/../model/UserRepo.php'; // Replace with the correct path if different

class UserTest extends TestCase
{
    protected $conn;

    protected function setUp(): void
    {
        // Initialize the database connection
        $this->conn = db_conn();
    }

    protected function tearDown(): void
    {
        // Close the database connection
        $this->conn->close();
    }

    public function testFindAllUsers()
    {
        $users = findAllUsers();
        $this->assertIsArray($users);
        $this->assertNotEmpty($users);
    }

    public function testFindUserByEmailAndPassword()
    {
        $email = "test1@gmail.com";
        $password = "testPass1@";
        $user = findUserByEmailAndPassword($email, $password);
        $this->assertIsArray($user);
        $this->assertArrayHasKey('email', $user);
    }

    public function testFindUserByUserID()
    {
        $id = 1; // Replace with an existing user ID in your database
        $user = findUserByUserID($id);
        $this->assertIsArray($user);
        $this->assertEquals($id, $user['id']);
    }

    public function testUpdateUser()
    {
        $id = 1; // Replace with an existing user ID in your database
        $email = 'test1@example.com';
        $password = password_hash('testPass1@', PASSWORD_DEFAULT);

        $result = updateUser($email, $password, $id);
        $this->assertTrue($result);
    }

    public function testCreateUser()
    {
        $email = "test1@gmail.com";
        $password = "testPass1@";
        $role = "Customer";
        $created_at = date('Y-m-d H:i:s');
        $newUserId = createUser($email, $password, $created_at, $role);
        $this->assertGreaterThan(0, $newUserId);
    }

    public function testDeleteUser()
    {
        $id = 2; // Replace with an existing user ID in your database
        $result = deleteUser($id);
        $this->assertTrue($result);
    }
}
