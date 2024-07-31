<?php 
include './partials/header.php';

// Fetch all posts from posts table
$query = "SELECT * FROM posts ORDER BY date_time DESC";
$post = mysqli_query($connection, $query);


?>

  







    <!-- ##################################### Search bar ####################################### -->

    <section class="search-bar">
        <form action="<?=ROOT_URL?>search.php" class="container search-bar-container" method="GET">
            <div>
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" name="search" placeholder="Search">
            </div>
            <button type="submit" name="submit" class="btn">Go</button>
        </form>
    </section>
    




    

    <!-- ##################################### POST SECTION ####################################### -->

    <section class="posts">
    <div class="container posts-container">
        <?php
        // Reset the pointer of $post result set
        mysqli_data_seek($post, 0);
        // Now you can fetch rows from $post result set
        while ($post_row = mysqli_fetch_assoc($post)) :
            ?>
            <article class="post <?= $featured ? '' : 'section-extra-margin' ?>">
                <div class="post-thumbnail">
                    <img src="./images/<?= $post_row['thumbnail'] ?>">
                </div>
                <div class="post-info">
                    <?php
                    // Fetch category from categories table using category_id of post
                    $category_id = $post_row['category_id'];
                    $category_query = "SELECT * FROM categories WHERE id='$category_id'";
                    $category_result = mysqli_query($connection, $category_query);
                    $category = mysqli_fetch_assoc($category_result);
                    $category_title = $category['title'];
                    ?>
                    <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post_row['category_id'] ?>" class="category-button"><?= $category['title'] ?></a>
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