<?php 
require 'config/database.php';

// Get add-user form data if signup button was clicked
if(isset($_POST['submit'])){
    $firstname = filter_var($_POST['firstname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['user-role'],FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];

    // Validate input values
    if(!$firstname){
        $_SESSION['add-user'] = "Please enter your First Name";
    }elseif(!$lastname){
        $_SESSION['add-user'] = "Please enter your Last Name";
    }elseif(!$username){
        $_SESSION['add-user'] = "Please enter your User Name";
    }elseif(!$email){
        $_SESSION['add-user'] = "Please enter a valid email";
    }elseif(strlen($createpassword) < 8 || strlen($confirmpassword) < 8){
        $_SESSION['add-user'] = "Password should be 8+ characters";
    }elseif(!$avatar['name']){
        $_SESSION['add-user'] = "Please add avatar";
    }else{
        if($createpassword !== $confirmpassword){
            $_SESSION['add-user'] = "Passwords do not match";
        }else{
            // Hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // Check if username or email already exists in the database
            $user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);

            // Check if the query was successful and if there are any rows returned
            if($user_check_result !== false && mysqli_num_rows($user_check_result) > 0){
                $_SESSION['add-user'] = "Username or Email already exists";
            }else{
                // Work on avatar
                // Rename avatar
                $time = time(); // Make each image name unique using current timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;

                // Make sure file is an image
                $allowed_files = ['png','jpg','jpeg'];
                $extention = pathinfo($avatar_name, PATHINFO_EXTENSION);

                if(in_array($extention, $allowed_files)){
                    // Make sure image is not too large (1mb+)
                    if($avatar['size'] < 1000000){
                        // Upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    }else{
                        $_SESSION['add-user'] = "File size too big. Should be less than 1mb";
                    }
                }else{
                    $_SESSION['add-user'] = "File should be png, jpg, or jpeg";
                }
            }
        }
    }

    // Redirect back to add user page if there was any problem
    if(isset($_SESSION['add-user'])){
        // Pass form data back to sign page
        $_SESSION['add-user-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-user.php');
        exit();
    }else{
        // Insert new user into users table
        $insert_user_query = "INSERT INTO users(firstname, lastname, username, email, password, avatar, is_admin) VALUES('$firstname','$lastname','$username','$email','$hashed_password','$avatar_name','$is_admin')";
        $insert_user_result = mysqli_query($connection, $insert_user_query);

        if($insert_user_result !== false){
            // Redirect to login page with success message
            $_SESSION['add-user-success'] = "New user $firstname $lastname added successfully";
            header('location: '. ROOT_URL . 'admin/manage-users.php');
            exit();
        }
    }
}else{
    // If button wasn't clicked, bounce back to add-user page
    header('location: '. ROOT_URL . 'admin/add-user.php');
    exit();
}
?>
