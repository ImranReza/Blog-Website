<?php 
include 'partials/header.php';

//fetch users from database but not current user
$current_admin_id = $_SESSION['user-id'];
$query = "SELECT * FROM users WHERE NOT id = $current_admin_id";
$users = mysqli_query($connection, $query);
?>


    <!-- ################################ Dashbord ##############################  -->
    
    <section class="dashboard">

    <?php if(isset($_SESSION['add-user-success'])) : ?>
                <div class="alert-message success container"> 
                  <p>
                <?= $_SESSION['add-user-success'];
                unset($_SESSION['add-user-success']); ?>
                </p>
               </div>
    <?php elseif(isset($_SESSION['edit-user-success'])) : ?>
                <div class="alert-message success container"> 
                  <p>
                <?= $_SESSION['edit-user-success'];
                unset($_SESSION['edit-user-success']); ?>
                </p>
               </div>

     <?php elseif(isset($_SESSION['edit-user'])) : ?>
                <div class="alert-message error container"> 
                  <p>
                <?= $_SESSION['edit-user'];
                unset($_SESSION['edit-user']); ?>
                </p>
               </div>

     <?php elseif(isset($_SESSION['delete-user'])) : ?>
                <div class="alert-message error container"> 
                  <p>
                <?= $_SESSION['delete-user'];
                unset($_SESSION['delete-user']); ?>
                </p>
               </div>

      <?php elseif(isset($_SESSION['delete-user-success'])) : ?>
                <div class="alert-message success container"> 
                  <p>
                <?= $_SESSION['delete-user-success'];
                unset($_SESSION['delete-user-success']); ?>
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
                        <a href="./manage-users.php" class="active">
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
                        <a href="./manage-categories.php">
                            <i class="fa-solid fa-pen"></i>
                          <h5>Manage Category</h5>
                        </a>
                    </li>

                    <?php endif ?>
                </ul>
            </aside>

            <main>
                <h2>Manage Users</h2>
                <?php if(mysqli_num_rows($users) > 0) : ?>
                <table>
                    <thead>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Admin</th>
                    </thead>
                    <tbody>
                        <?php while($user = mysqli_fetch_assoc($users)) : ?>
                        <tr>
                            <td><?= "{$user['firstname']} {$user['lastname']}" ?></td>
                            <td><?= $user['username'] ?></td>
                            <td><a href="<?php ROOT_URL ?>edit-user.php?id=<?=$user['id']?>" class="btn sm">Edit</a></td>
                            <td><a href="<?php ROOT_URL ?>delete-user.php?id=<?=$user['id']?>" class="btn sm danger">Delete</a></td>
                            <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                        </tr>

                        <?php endwhile ?>
                    </tbody>
                </table>

                <?php else : ?>
                  <div class="alert-message error "><?= "No user found" ?></div>
                <?php endif ?>
            </main>
        </div>
    </section>


<!-- ################################### footer ##########################################  -->

<?php 
include '../partials/footer.php';
?>
