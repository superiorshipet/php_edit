<?php
// 1. Start a session to manage user authentication state
session_start();

// 2. Database connection configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_data1";
$port = 3307; 

// Create connection to the database
$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

// Check if database connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 3. Process form data after submission
if (isset($_POST['signup_   btn'])) {
    
    // 4. Input Sanitization to prevent SQL Injection for security
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $full_name  = $first_name . " " . $last_name;
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone']);
    $pass       = mysqli_real_escape_string($conn, $_POST['password']);

    // 5. SQL Integration: Insert the new user into the database
    $sql = "INSERT INTO users (full_name, email, password, phone) 
            VALUES ('$full_name', '$email', '$pass', '$phone')";

    if (mysqli_query($conn, $sql)) {
        // 6. Post-registration logic: Automatically log in the user
        
        // Retrieve the auto-generated ID of the newly registered user
        $user_id = mysqli_insert_id($conn); 

        // Store user details in session variables for global access across the site
        $_SESSION['user_id'] = $user_id;   
        $_SESSION['user_name'] = $full_name;
        $_SESSION['user_email'] = $email;

        // 7. Successful Registration: Show confirmation alert and redirect to home page
        echo "<script>
                alert('Account created successfully! Welcome, $full_name'); 
                window.location.href='index.php';
              </script>";
    } else {
        // Error handling in case the query fails
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>