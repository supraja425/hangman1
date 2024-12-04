<?php
// Establish the connection to the database
$link = mysqli_connect("localhost", "root", "", "glob");

// Check if the connection is successful
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, $_POST['password']);

    // Check if the user exists in the database
    $sql = "SELECT * FROM hangman WHERE username = '$username'";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            // Redirect to the game page
            header("Location: index.html");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found with that username.";
    }
}

// Close the database connection
mysqli_close($link);
?>
