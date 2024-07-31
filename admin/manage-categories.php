<?php 
include 'partials/header.php';

$query = "SELECT * FROM categories ORDER BY title";
$categories = mysqli_query($connection,$query)
?>



    <!-- ################################ Dashbord ##############################  -->
    
    <section class="dashboard">

    <?php if(isset($_SESSION['add-category-success'])) : ?>
                <div class="alert-message success container"> 
                  <p>
                <?= $_SESSION['add-category-success'];
                unset($_SESSION['add-category-success']); ?>
                </p>
               </div>

    <?php elseif(isset($_SESSION['add-category'])) : ?>
                <div class="alert-message error container"> 
                  <p>
                <?= $_SESSION['add-category'];
                unset($_SESSION['add-category']); ?>
                </p>
               </div>
        <?php elseif(isset($_SESSION['edit-category'])) : ?>
                <div class="alert-message error container"> 
                  <p>
                <?= $_SESSION['edit-category'];
                unset($_SESSION['edit-category']); ?>
                </p>
               </div>

        <?php elseif(isset($_SESSION['edit-category-success'])) : ?>
                <div class="alert-message success container"> 
                  <p>
                <?= $_SESSION['edit-category-success'];
                unset($_SESSION['edit-category-success']); ?>
                </p>
               </div>

        <?php elseif(isset($_SESSION['delete-category-success'])) : ?>
                <div class="alert-message success container"> 
                  <p>
                <?= $_SESSION['delete-category-success'];
                unset($_SESSION['delete-category-success']); ?>
                </p>
               </div>
        
    <?php endif ?>
        <div class="container dashboard-container">
            <button id="show-sidebar-btn" class="sidebar-toggle"><i class="fa-solid fa-angle-right"></i></button>
            <button id="hide-sidebar-btn" class="sidebar-toggle"><i class="fa-solid fa-angle-left"></i></button>
            <aside>
                <ul>
                    <li>
                     <a href="./add-post.php">
                       <i class="fa-regular fa-newspaper"></i>
                       <h5>Add post</h5>
                     </a>
                    </li>


                    <li>
                        <a href="./index.php">
                        <i class="fa-regular fa-pen-to-square"></i>
                          <h5>Manage post</h5>
                        </a>
                    </li>

                    <?php if(isset($_SESSION['user_is_admin'])) : ?>


                    <li>
                        <a href="./add-user.php">
                          <i class="fa-solid fa-user"></i>
                          <h5>Add User</h5>
                        </a>
                    </li>

                    <li>
                        <a href="./manage-users.php">
                        <i class="fa-solid fa-user-pen"></i>
                          <h5>Manage User</h5>
                        </a>
                    </li>


                    <li>
                        <a href="./add-category.php">
                          <i class="fa-solid fa-layer-group"></i>
                          <h5>Add Category</h5>
                        </a>
                    </li>

                    <li>
                        <a href="./manage-categories.php" class="active">
                            <i class="fa-solid fa-pen"></i>
                          <h5>Manage Category</h5>
                        </a>
                    </li>

                <?php endif ?>

                </ul>
            </aside>

            <main>
                <h2>Manage Categories</h2>
                <?php if(mysqli_num_rows($categories) > 0) : ?>
                <table>
                    <thead>
                        <th>Title</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                        <tr>
                            <td><?= $category['title'] ?></td>
                            <td><a href="<?= ROOT_URL ?>admin/edit-category.php?id=<?= $category['id'] ?>" class="btn sm">Edit</a></td>
                            <td><a href="<?=ROOT_URL?>admin/delete-category.php?id=<?= $category['id'] ?>" class="btn sm danger">Delete</a></td>
                        </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
                <?php else : ?>
                    <div class="alert-message error"><?= "No categories found" ?></div>
                <?php endif ?>
            </main>
        </div>
    </section>


<!-- ################################### footer ##########################################  -->

<?php 
include '../partials/footer.php';
?>
