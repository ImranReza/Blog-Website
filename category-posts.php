<?php 
include './partials/header.php';


//fetch posts if id is set

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE category_id='$id' ORDER BY date_time DESC";
    $post = mysqli_query($connection,$query);
}else{
    header('location: '.ROOT_URL.'blog.php');
    die();
}




?>




    <!-- ##################################### Category Posts SECTION ####################################### -->
    

<header class="category-title"> 
    <h2>
    <?php
    // Fetch category from categories table using category_id of post
    $category_id = $id;
    $category_query = "SELECT * FROM categories WHERE id='$category_id'";
    $category_result = mysqli_query($connection, $category_query);
    $category = mysqli_fetch_assoc($category_result);
    echo $category['title'];
    ?>
    </h2>
</header>





    <!-- ##################################### POST SECTION ####################################### -->
<?php if(mysqli_num_rows($post)>0) : ?>
    <section class="posts">
    <div class="container posts-container">
        <?php
        // Reset the pointer of $post result set
        mysqli_data_seek($post, 0);
        // Now you can fetch rows from $post result set
        while ($post_row = mysqli_fetch_assoc($post)) :
            ?>
            <article class="post">
                <div class="post-thumbnail">
                    <img src="./images/<?= $post_row['thumbnail'] ?>">
                </div>
                <div class="post-info">
                    
                   
                    <h3 class="post-title"><a href="<?= ROOT_URL ?>post.php?id=<?= $post_row['id'] ?>"><?= $post_row['title'] ?></a></h3>
                    <p class="post-body">
                        <?= substr($post_row['body'], 0, 300) ?>...
                    </p>
                    <div class="post-author">
                        <?php
                        // Fetch author from users table using author_id
                        $author_id = $post_row['author_id'];
                        $author_query = "SELECT * FROM users WHERE id='$author_id'";
                        $author_result = mysqli_query($connection, $author_query);
                        $author = mysqli_fetch_assoc($author_result);
                        ?>
                        <div class="post-author-avatar">
                            <img src="./images/<?= $author['avatar'] ?>" alt="">
                        </div>
                        <div class="post-author-info">
                            <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                            <?= date("M d, Y - H:i", strtotime($post_row['date_time'])) ?>
                        </div>
                    </div>
                </div>
            </article>
        <?php endwhile ?>
    </div>
</section>

<?php else : ?>
    <div class="alert-message error lg">
        <p>NO post found for this cotegory</p>
    </div>
<?php endif ?>




    <!-- ##################################### category buttons ######################  -->

    <section class="category-buttons">
    <div class="container category-buttons-container">
        <?php
        $all_categories_query = "SELECT * FROM categories";
        $all_categories = mysqli_query($connection,$all_categories_query); 
        ?>
        <?php while($category = mysqli_fetch_assoc($all_categories)) : ?>
        <a href="<?=ROOT_URL?>category-posts.php?id=<?=$category['id']?>" class="category-button"><?=$category['title'] ?></a>
        <?php endwhile ?>
    </div>
</section>



<?php 
include './partials/footer.php';
?>