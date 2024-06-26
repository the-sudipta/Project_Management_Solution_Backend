<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../model/db_connect.php';
require_once __DIR__ . '/../model/CustomerRepo.php'; // Replace with the correct path if different

class CustomerTest extends TestCase
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

    public function testFindAllCustomers()
    {
        $customers = findAllCustomers();
        $this->assertIsArray($customers);
        $this->assertNotEmpty($customers);
    }

    public function testFindCustomerByUserID()
    {
        $userId = 1; // Assuming there's a user with ID 1
        $customer = findCustomerByUserID($userId);
        $this->assertIsArray($customer);
        $this->assertArrayHasKey('user_id', $customer);
        $this->assertEquals($userId, $customer['user_id']);
    }

    public function testFindCustomerByID()
    {
        $customerId = 1; // Assuming there's a customer with ID 1
        $customer = findCustomerByID($customerId);
        $this->assertIsArray($customer);
        $this->assertArrayHasKey('id', $customer);
        $this->assertEquals($customerId, $customer['id']);
    }

    public function testCreateCustomer()
    {
        $name = 'Jane Doe';
        $gender = 'Female';
        $phone = '0987654321';
        $profession = 'Engineer';
        $university_name = null;
        $university_id = null;
        $company_name = 'ABC Corp';
        $created_at = date('Y-m-d H:i:s');
        $user_id = 2; // Assuming there's a user with ID 2

        $newCustomerId = createCustomer($name, $gender, $phone, $profession, $university_name, $university_id, $company_name, $created_at, $user_id);
        $this->assertGreaterThan(0, $newCustomerId);

        // Verify the creation
        $customer = findCustomerByID($newCustomerId);
        $this->assertEquals($name, $customer['name']);
        $this->assertEquals($gender, $customer['gender']);
        $this->assertEquals($phone, $customer['phone']);
        $this->assertEquals($profession, $customer['profession']);
        $this->assertEquals($university_name, $customer['university_name']);
        $this->assertEquals($university_id, $customer['university_id']);
        $this->assertEquals($company_name, $customer['company_name']);
        $this->assertEquals($created_at, $customer['created_at']);
        $this->assertEquals($user_id, $customer['user_id']);
    }

    public function testUpdateCustomer()
    {
        $name = 'John Doe';
        $gender = 'Male';
        $phone = '1234567890';
        $customerId = 2; // Assuming there's a customer with ID 2

        $result = updateCustomer($name, $gender, $phone, $customerId);
        $this->assertTrue($result);

        // Verify the update
        $customer = findCustomerByID($customerId);
        $this->assertEquals($name, $customer['name']);
        $this->assertEquals($gender, $customer['gender']);
        $this->assertEquals($phone, $customer['phone']);
    }

    public function testDeleteCustomer()
    {
        $customerId = 2; // Assuming there's a customer with ID 1

        $result = deleteCustomer($customerId);
        $this->assertTrue($result);

        // Verify the deletion
        $customer = findCustomerByID($customerId);
        $this->assertNull($customer);
    }


}
