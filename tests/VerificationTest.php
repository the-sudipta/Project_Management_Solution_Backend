<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../model/db_connect.php';
require_once __DIR__ . '/../model/VerificationRepo.php'; // Replace with the correct path if different

class VerificationTest extends TestCase
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

    public function testCreateVerification()
    {
        $email = 'test2@gmail.com';
        $token = 'token123';
        $verification_code = 'code123';
        $status = 'pending';
        $action = 'verify_email';
        $created_at = date('Y-m-d H:i:s');
        $verified_at = date('Y-m-d H:i:s');;

        $newVerificationId = createVerification($email, $token, $verification_code, $status, $action, $created_at, $verified_at);
        $this->assertGreaterThan(0, $newVerificationId);

        // Verify the creation
        $verification = findVerificationByID($newVerificationId);
        $this->assertEquals($email, $verification['email']);
        $this->assertEquals($token, $verification['token']);
        $this->assertEquals($verification_code, $verification['verification_code']);
        $this->assertEquals($status, $verification['status']);
        $this->assertEquals($action, $verification['action']);
        $this->assertEquals($created_at, $verification['created_at']);
        $this->assertEquals($verified_at, $verification['verified_at']);
    }

    public function testFindAllVerification()
    {
        $verifications = findAllVerification();
        $this->assertIsArray($verifications);
        $this->assertNotEmpty($verifications);
    }

    public function testUpdateVerification()
    {
        $email = 'test2@gmail.com';
        $token = 'token456';
        $verification_code = 'code456';
        $status = 'verified';
        $action = 'verify_email';
        $created_at = date('Y-m-d H:i:s');
        $verified_at = date('Y-m-d H:i:s');
        $verificationId = 1; // Assuming there's a verification with ID 1

        $result = updateVerification($email, $token, $verification_code, $status, $action, $created_at, $verified_at, $verificationId);
        $this->assertTrue($result);

        // Verify the update
        $verification = findVerificationByID($verificationId);
        $this->assertEquals($email, $verification['email']);
        $this->assertEquals($token, $verification['token']);
        $this->assertEquals($verification_code, $verification['verification_code']);
        $this->assertEquals($status, $verification['status']);
        $this->assertEquals($action, $verification['action']);
        $this->assertEquals($created_at, $verification['created_at']);
        $this->assertEquals($verified_at, $verification['verified_at']);
    }

    public function testFindVerificationByID()
    {
        $verificationId = 1; // Assuming there's a verification with ID 1
        $verification = findVerificationByID($verificationId);
        $this->assertIsArray($verification);
        $this->assertArrayHasKey('id', $verification);
        $this->assertEquals($verificationId, $verification['id']);
    }

    public function testDeleteVerification()
    {
        $verificationId = 1; // Assuming there's a verification with ID 1

        $result = deleteVerification($verificationId);
        $this->assertTrue($result);

        // Verify the deletion
        $verification = findVerificationByID($verificationId);
        $this->assertNull($verification);
    }
}
