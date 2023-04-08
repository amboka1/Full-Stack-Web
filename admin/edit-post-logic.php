<?php 
require '../config/database.php';

// make sure edit post button was clicked
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $provious_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // set is_featured to 0 if it was unchecked
    $is_featured = $is_featured == 1 ?: 0;

    // check and validate input values
    if(!$title) {
        $_SESSION['edit-post'] = "პოსტი ვერ განახლდა! საჭიროა პოსტის სათაური";
    }elseif(!$category_id) {
        $_SESSION['edit-post'] = "პოსტი ვერ განახლდა! საჭიროა პოსტის კატეგორია";
    } elseif(!$body) {
        $_SESSION['edit-post'] = "პოსტი ვერ განახლდა! საჭიროა პოსტის აღწერა";
    } else {
        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../images/' . $provious_thumbnail_name;
            if($previous_thumbnail_path) {
                unlink($previous_thumbnail_path);
            }

            // work on new thumbnail
            // rename image
            $time = time();
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/' . $thumbnail_name;

            // make sure file is an image
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = explode('.', $thumbnail_name);
            $extension = end($extension);
            if(in_array($extension, $allowed_files)) {
                // make sure avatar is not too large (2mp+)
                if($thumbnail['size'] < 2000000) {
                    // upload avatar
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                }else {
                    $_SESSION['edit-post'] = "ფოტოს ზომა არუნდა იყოს 2MB+";
                }
            } else {
                $_SESSION['edit-post'] = "დასაშვებია მხოლოდ png, jpg ან jpeg";
            }
        }
    }

    if($_SESSION['edit-post']) {
        header('location: ' . ROOT_URL . 'admin/');
        die();
    } else {
        if($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        $thumbnail_to_insert = $thumbnail_name ?? $provious_thumbnail_name;

        $query = "UPDATE posts SET title='$title', body='$body', thumbnail='$thumbnail_to_insert', category_id=$category_id, is_featured=$is_featured WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);
    }

    if(!mysqli_errno($connection)) {
        $_SESSION['edit-post-success'] = "პოსტი განახლდა!";
    }
}

header('location: ' . ROOT_URL . 'admin/');
die();