<?php 
    include 'partials/header.php';

    // get back form data if invalid 
    $title = $_SESSION['add-category-data']['title'] ?? null;
    $description = $_SESSION['add-category-data']['description'] ?? null;

    unset($_SESSION['add-category-data']);
?>


<section class="form__section">
    <div class="container form__section-container">
        <h2 class="fonts">კატეგორიის დამატება</h2>
        <?php if(isset($_SESSION['add-category'])) { ?>
            <div class="alert__message error">
            <p>
                <?= $_SESSION['add-category'];
                unset($_SESSION['add-category']); ?>
            </p>
        </div>
        <?php } ?>
        <form action="<?= ROOT_URL ?>admin/add-category-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="title" value="<?= $title ?>" placeholder="Title">
            <textarea rows="4" name="description" placeholder="Description"><?= $description ?></textarea>
          <button type="submit" name="submit" class="btn">დამატება</button>
        </form>
    </div>
</section>


    <!-- ========================= END OF ADD CATEGORY ==========================  -->



<?php 
    include '../partials/footer.php';
?>
