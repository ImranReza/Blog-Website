<?php

require 'config/database.php';

session_start(); // Ensure session is started

// Check if form is submitted
if(isset($_POST['submit'])) {
    // Retrieve form data
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    // Validate input values
    if(!$firstname || !$lastname || !$username || !$email || strlen($createpassword) < 8 || strlen($confirmpassword) < 8 || !$avatar['name']) {
        $_SESSION['signup'] = "Please fill out all fields correctly.";
    } else {
        if($createpassword !== $confirmpassword) {
            $_SESSION['signup'] = "Passwords do not match.";
        } else {
            // Hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // Check if username or email already exists in database
            $user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);

            if(mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['signup'] = "Username or email already exists.";
            } else {
                // Work on avatar
                $avatar_name = time() . '_' . $avatar['name'];
                $avatar_destination_path = './images/' . $avatar_name;

                // Upload avatar
                if(move_uploaded_file($avatar['tmp_name'], $avatar_destination_path)) {
                    // Insert new user into users table
                    $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', 0)";
                    $insert_user_result = mysqli_query($connection, $insert_user_query);

                    if($insert_user_result) {
                        $_SESSION['signup-success'] = "Registration successful. Please log in.";
                        header('location: '. ROOT_URL . 'signin.php');
                        exit();
                    } else {
                        $_SESSION['signup'] = "Error: " . mysqli_error($connection);
                    }
                } else {
                    $_SESSION['signup'] = "Failed to upload avatar.";
                }
            }
        }
    }

    // Redirect back to signup page if there was any problem
    $_SESSION['signup-data'] = $_POST;
    header('location: ' . ROOT_URL . 'signup.php');
    exit();
} else {
    // Redirect back to signup page if form was not submitted
    header('location: ' . ROOT_URL . 'signup.php');
    exit();
}

?>
