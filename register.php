<?php
// Establish the connection to the database
$link = mysqli_connect("localhost", "root", "", "glob");

// Check if the connection is successful
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, $_POST['password']);

    // Check if the user already exists in the database
    $sql = "SELECT * FROM hangman WHERE username = '$username'";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "Username already exists. Please choose another.";
    } else {
        // Encrypt the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user into the database
        $sql = "INSERT INTO hangman (username, password) VALUES ('$username', '$hashed_password')";
        if (mysqli_query($link, $sql)) {
            echo "Registration successful. You can now login.";
        } else {
            echo "ERROR: Could not execute $sql. " . mysqli_error($link);
        }
    }
}

// Close the database connection
mysqli_close($link);
?>
