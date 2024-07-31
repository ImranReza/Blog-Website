<?php
require 'config/database.php';

if(isset($_POST['submit'])){
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'],FILTER_SANITIZE_NUMBER_INT);

    $thumbnail = $_FILES['thumbnail'];

    // Set is_featured to 0 if unchecked
    $is_featured = $is_featured == 1 ?: 0;

    // Validate form data
    if(!$title){
        $_SESSION['add-post'] = "Enter post title";
    } elseif(!$category_id){
        $_SESSION['add-post'] = "Select post category";
    } elseif(!$body){
        $_SESSION['add-post'] = "Enter post body";
    } elseif(!$thumbnail['name']){
        $_SESSION['add-post'] = "Choose post thumbnail";
    } else {
        // Work on thumbnail
        $time = time(); // Make each image name unique
        $thumbnail_name = $time . '_' . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        // Make sure file is an image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extention = strtolower(pathinfo($thumbnail_name, PATHINFO_EXTENSION));

        if(in_array($extention, $allowed_files)){
            // Make sure image is not too big (2mb+)
            if($thumbnail['size'] < 2_000_000){
                // Upload thumbnail
                if(move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path)){
                    // Insert post into database
                    $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) VALUES ('$title', '$body', '$thumbnail_name', '$category_id', '$author_id', '$is_featured')";

                    $result = mysqli_query($connection, $query);

                    if($result){
                        $_SESSION['add-post-success'] = "New post added successfully";
                        header('location: '.ROOT_URL.'admin/');
                        exit();
                    } else {
                        $_SESSION['add-post'] = "Error: " . mysqli_error($connection);
                    }
                } else {
                    $_SESSION['add-post'] = "Failed to upload thumbnail";
                }
            } else {
                $_SESSION['add-post'] = "File size too big. Should be less than 2MB";
            }
        } else {
            $_SESSION['add-post'] = "File should be PNG, JPG, or JPEG";
        }
    }

    // Redirect back (with form data) to add-post page if there is any problem
    $_SESSION['add-post-data'] = $_POST;
    header('location: '.ROOT_URL.'admin/add-post.php');
    exit();
}

header('location: '.ROOT_URL.'admin/add-post.php');
exit();
?>
