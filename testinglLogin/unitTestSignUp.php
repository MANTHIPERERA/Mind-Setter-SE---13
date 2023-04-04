<?php

use PHPUnit\Framework\TestCase;

class SignupTest extends TestCase
{
    private $mysqli;

    protected function setUp(): void
    {
        $this->mysqli = new mysqli("localhost", "username", "password", "database");
    }

    public function testValidSignup()
    {
        $name = "John Doe";
        $email = "johndoe@example.com";
        $password = "password123";
        $confirmPassword = "password123";

        $postData = [
            "name" => $name,
            "email" => $email,
            "password" => $password,
            "Confirm_Password" => $confirmPassword
        ];

        // Simulate a POST request
        $_POST = $postData;

        // Call the signup script
        ob_start();
        require "../process-singup.php";
        $output = ob_get_clean();

        // Check that the output contains the success message
        $this->assertStringContainsString("signup-success.html", $output);

        // Check that the user was added to the database
        $result = $this->mysqli->query("SELECT * FROM users WHERE email='$email'");
        $this->assertEquals(1, $result->num_rows);

        // Check that the user's name and email match what we provided
        $row = $result->fetch_assoc();
        $this->assertEquals($name, $row["name"]);
        $this->assertEquals($email, $row["email"]);

        // Check that the password hash is valid
        $this->assertTrue(password_verify($password, $row["password_hash"]));
    }

    public function testInvalidEmail()
    {
        $name = "John Doe";
        $email = "johndoe@example";
        $password = "password123";
        $confirmPassword = "password123";

        $postData = [
            "name" => $name,
            "email" => $email,
            "password" => $password,
            "Confirm_Password" => $confirmPassword
        ];

        // Simulate a POST request
        $_POST = $postData;

        // Call the signup script
        ob_start();
        require "signup.php";
        $output = ob_get_clean();

        // Check that the output contains the error message
        $this->assertStringContainsString("Valid email is required", $output);

        // Check that the user was not added to the database
        $result = $this->mysqli->query("SELECT * FROM users WHERE email='$email'");
        $this->assertEquals(0, $result->num_rows);
    }

    // Add more test cases here for other scenarios, such as invalid password, missing name, etc.

    protected function tearDown(): void
    {
        $this->mysqli->close();
    }
}
