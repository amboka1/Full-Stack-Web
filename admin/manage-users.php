<?php
    include 'partials/header.php';

    // fetch user from database but not current user
    $current_admin_id = $_SESSION['user-id'];

    $query = "SELECT * FROM users WHERE NOT id=$current_admin_id";
    $users = mysqli_query($connection, $query);
?>



<section class="dashboard">
<?php if(isset($_SESSION['add-user-success'])) : // shows if add user was successeful ?>
           <div class="alert__message success container">
              <p>
                <?= $_SESSION['add-user-success']; 
                unset($_SESSION['add-user-success']);
                ?>
              </p>
            </div>
            <?php elseif(isset($_SESSION['edit-user-success'])): ?>
            <div class="alert__message success container">
            <p>
                <?= $_SESSION['edit-user-success'];
                unset($_SESSION['edit-user-success']); ?>
            </p>
        </div>
            <?php elseif(isset($_SESSION['delete-user-success'])): ?>
            <div class="alert__message success container">
            <p>
                <?= $_SESSION['delete-user-success'];
                unset($_SESSION['delete-user-success']); ?>
            </p>
        </div>
        <?php endif ?>
    <div class="container dashboard__container">
        <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-right-b"></i></button>
        <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-left-b"></i></button>

        <aside>
            <ul>
            <li><a href="add-post.php"><i class="uil uil-pen"></i>
            <h5>პოსტის დამატება</h5>
            </a>
        </li>
        <ul>
            <li><a href="index.php"><i class="uil uil-postcard"></i>
            <h5>პოსტის მართვა</h5>
            </a>
        </li>
        <?php if(isset($_SESSION['user_is_admin'])): ?>
        <ul>
            <li><a href="add-user.php"><i class="uil uil-user-plus"></i>
            <h5>მომხმარებლის დამატება</h5>
            </a>
        </li>
        <ul>
            <li><a href="manage-users.php" class="active"><i class="uil uil-users-alt"></i>
            <h5>მომხმარებლის მართვა</h5>
            </a>
        </li>
        <ul>
            <li><a href="add-category.php"><i class="uil uil-edit"></i>
            <h5>კატეგორიის დამატება</h5>
            </a>
        </li>
        <ul>
            <li><a href="manage-categories.php"><i class="uil uil-list-ul"></i>
            <h5>კატეგორიის მართვა</h5>
            </a>
        </li>
        <?php endif ?>
        </ul>
        </aside>
        <main>
            <h2>მომხმარებლის მართვა</h2>
            <?php if(mysqli_num_rows($users) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>UserName</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Admin</th>
                        <th>Id</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($user = mysqli_fetch_assoc($users)) : ?>
                    <tr>
                        <td><?= "{$user['firstname']} {$user['lastname']}" ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-user.php?id=<?= $user['id'] ?>" class="btn sm">Edit</a></td>
                        <td><a href="<?= ROOT_URL ?>admin/delete-user.php?id=<?= $user['id'] ?>" class="btn sm danger">Delete</a></td>
                        <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                        <td><?= $user['id'] ?></td>
                    </tr>  
                    <?php endwhile ?>
                </tbody>
            </table>
            <?php else : ?>
                <div class="alert__message error"><?= "მომხმარებლების ექაუნთი ვერ მოიძებნა!"?></div>
                <?php endif ?>
        </main>
    </div>
</section>




<?php
    include '../partials/footer.php';
?>