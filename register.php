<?php
    include 'connection.php';
    if(isset($_POST['submit-btn'])) {
        $filter_name = filter_var($_POST['name']);
        $name = mysqli_real_escape_string($conn, $filter_name);

        $filter_address = filter_var($_POST['address']);
        $address = mysqli_real_escape_string($conn, $filter_address);

        $filter_contact = filter_var($_POST['phone']);
        $contact = mysqli_real_escape_string($conn, $filter_contact);

        $filter_email = filter_var($_POST['email']);
        $email = mysqli_real_escape_string($conn, $filter_email);

        $filter_password = filter_var($_POST['password']);
        $password = mysqli_real_escape_string($conn, $filter_password);

        $filter_cpassword = filter_var($_POST['cpassword']);
        $cpassword = mysqli_real_escape_string($conn, $filter_cpassword);

        $query = "SELECT * FROM users WHERE email = '$email'";

        $select_user = mysqli_query($conn, $query) or die('query failed');

        if(mysqli_num_rows($select_user)>0) {
            $message[] = 'user already exist';
        }
        else {
            if($password!=$cpassword) {
                $message[] = 'password did not match';
            }
            else {
                mysqli_query($conn, "INSERT INTO users (name, address, contact, email, password, department_id) VALUES ('$name', '$address', '$contact', '$email', '$password', '101')") or die('query_failed');
                $message[] = 'registered successfully';
                header('location:login.php');
            }
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" rel="stylesheet">
    <title>Register Page</title>
</head>
<style>
    body{
        background-color: #99d6ff;
        display: grid;
        align-items: center;
        justify-items: center;
    }
    form{
        background-color: white;
        display: grid;
        width: 80vh;
        height: 70vh;
        justify-items: center;
        align-content: center;
    }
    .input-field label{
        padding-top: 10px;
        font-size: 3vh;
    }
    input[type=text], input[type=email], input[type=password]{
        width: 30vh;
        height: 30px;
    }
    input[type=submit]{
        margin-top: 10px;
        width: 15vh;
        height: 3vh;
        background-color: lightseagreen;
        border: 1px solid black;
        color: white;
        border-radius: 5px;
    }
</style>
<body>
    <section class="form-container">
        <?php
            if(isset($message)) {
                foreach($message as $message) {
                    echo '
                    <div class="message" style="
                    text-align: center;
                    font-size: 30px;
                    text-transform: capitalize;
                ">
                            <span> '.$message.' </span>
                            <span class="icon" onclick="this.parentElement.remove()"> <i class="fa-regular fa-circle-xmark"></i> </span>
                        </div>
                    ';
                }
            }

        ?>
        <form method="post">
            <h1>Register Now</h1>
            <div class="input-field">
                <label>Name</label><br>
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>
            <div class="input-field">
                <label>Address</label><br>
                <input type="text" name="address" placeholder="Enter your address" required>
            </div>
            <div class="input-field">
                <label>Contact</label><br>
                <input type="text" name="phone" placeholder="Enter your contact" required>
            </div>
            <div class="input-field">
                <label>Email</label><br>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-field">
                <label>Password</label><br>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="input-field">
                <label>Confirm Password</label><br>
                <input type="password" name="cpassword" placeholder="Confirm your password" required>
            </div>
            <input type="submit" name="submit-btn" value="register now" class="btn">
            <p style="
                    font-size: 20px;
                    text-transform: capitalize;
                ">already have an account ? <a href="login.php">login now</a></p>
        </form>
    </section>
</body>
</html>