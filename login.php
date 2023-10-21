<?php
    include 'connection.php';
    session_start();

    if(isset($_POST['submit-btn'])) {

        $filter_email = filter_var($_POST['email']);
        $email = mysqli_real_escape_string($conn, $filter_email);

        $filter_password = filter_var($_POST['password']);
        $password = mysqli_real_escape_string($conn, $filter_password);


        $query = "SELECT * FROM users WHERE email = '$email' and password = '$password'";

        $select_user = mysqli_query($conn, $query) or die('query failed');

        if(mysqli_num_rows($select_user)>0) {
            $row = mysqli_fetch_assoc($select_user);
            if($row['department_id'] == '100') {
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_email'] = $row['email'];
                $_SESSION['admin_id'] = $row['id'];
                header('location:admin_dashboard.php');
            }
            else if($row['department_id'] == '101') {
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                header('location:index.php');
            }
        }
        else {
            $message[] = 'incorrect email or password';
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" rel="stylesheet">
    <title>Login Page</title>
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
        height: 50vh;
        justify-items: center;
        align-content: center;
    }
    .input-field label{
        padding-top: 10px;
        font-size: 3vh;
    }
    input[type=email], input[type=password]{
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
            <h1>Login Now</h1>

            <div class="input-field">
                <label>Email</label><br>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-field">
                <label>Password</label><br>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <input type="submit" name="submit-btn" value="login now" class="btn">
            <p style="
                    font-size: 20px;
                    text-transform: capitalize;
                ">Don't have an account ? <a href="register.php">register now</a></p>
        </form>
    </section>
</body>
</html>