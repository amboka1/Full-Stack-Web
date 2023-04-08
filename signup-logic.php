<?php

require 'config/database.php';

// get signup form data if signup button was clicked
if(isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'],
     FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], 
    FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], 
    FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'],
    FILTER_SANITIZE_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], 
    FILTER_SANITIZE_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    // validate input values
    if(!$firstname) {
        $_SESSION['signup'] = "გთხოვთ შეიყვანოთ თქვენი სახელი!";
    } elseif(!$lastname) {
        $_SESSION['signup'] = "გთხოვთ შეიყვანოთ თქვენი გვარი!";
    } elseif(!$username) {
        $_SESSION['signup'] = "გთხოვთ შეიყვანოთ თქვენი Username!";
    } elseif(!$email) {
        $_SESSION['signup'] = "გთხოვთ შეიყვანოთ თქვენი ელ-ფოსტის მისამართი!";
    } elseif(strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['signup'] = "პაროლი უნდა იყოს 8+ სიტყვისგან!";
    } elseif(!$avatar['name']) {
        $_SESSION['signup'] = "გთხოვთ დაამატოთ ფოტო!";
    } else {
        //check if passwords don't match
        if($createpassword !== $confirmpassword) {
            $_SESSION['signup'] = "პაროლი არასწორია!";
        } else{
            // hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // check if username or email already exist in database
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['signup'] = 'Username ან ელ-ფოსტა გამოყენებულია!';
            } else {
                //work on avatar 
                //rename avatar
                $time = time();
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'images/' . $avatar_name;

                //make sure file is an image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extention = explode('.', $avatar_name);
                $extention = end($extention);
                if(in_array($extention, $allowed_files)) {
                    // make sure image is not too large (1mb+)
                    if($avatar['size'] < 1000000) {
                        //upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['signup'] = 'ფოტოს ზომა არუნდა იყოს 1MB+';
                    }
                } else {
                    $_SESSION['signup'] = "დასაშვებია მხოლოდ png, jpg ან jpeg";
                }
            }
        }
    }

    //rediret back to signup pag eif there was any problem
    if(isset($_SESSION['signup'])) {
        // pass form data back to signup page
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    } else {
        // insert new user into users tale
        $insert_user_query = "INSERT INTO users SET firstname='$firstname', lastname='$lastname', 
        username='$username', email='$email', password='$hashed_password', avatar='$avatar_name',
         is_admin=0";
         $insert_user_result = mysqli_query($connection, $insert_user_query);

        if (!mysqli_errno($connection)) {
            //redirect to login page with success message
            $_SESSION['signup-success'] = "რეგისტრაცია წარმატებით დასრულდა, გთხოვთ შეხვიდეთ ექაუნთზე";
            header('location: ' . ROOT_URL . 'signin.php');
            die();

        }
    }

} else {
    // if button wasn't clicked, bounce back to signup page
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}