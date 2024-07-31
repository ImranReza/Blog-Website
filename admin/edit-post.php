<?php 
include 'partials/header.php';
//fetch categories from database
$category_query = "SELECT * FROM categories";
$categories = mysqli_query($connection,$category_query);


//fetch post data from database if id is set

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id='$id'";
    $result = mysqli_query($connection,$query);
    $post = mysqli_fetch_assoc($result);
}else{
    header('location: ' .ROOT_URL . 'admin/');
    die();
}


?>




    <!-- ######################### Edit Post ##########################  -->
    
    <section class="form-section">
    <div class="container form-section-container">
        <h2>Edit Post</h2>

        <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="hidden" name="previous_thumbnail_name" value="<?= $post['thumbnail'] ?>">
            <input type="text" name="title" value="<?= $post['title'] ?>" placeholder="Title">

            <select name="category" id="">
                <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                <option value="<?= $category['id'] ?>"> <?= $category['title'] ?></option>
                <?php endwhile ?>
            </select>


            <textarea placeholder="Body" name="body" rows="10"><?= $post['body'] ?></textarea>

            <div class="form-control inline">
                <input type="checkbox" id="is_featured" name="is_featured" value="1" checked>
                <label for="is_featured">Featured</label>
            </div>

            <div class="form-control">
                <label for="thumbnail">Change Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>


            <button type="submit" name='submit' class="btn">Update Post</button>
        </form>
    </div>
    </section>



<?php 
include '../partials/footer.php';
?>
