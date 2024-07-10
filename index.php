
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LOG IN HEALT PHARMA</title>
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="main">
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/login.png" alt="login image"></figure>
                        <a href="register.php" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">LOGIN</h2>
                        <form method="POST" class="register-form" id="login-form">
                            <?php

                            require_once 'connect.php';

                            if ($_SESSION['login'] == 'login') {
                                header('Location: index.php');
                                exit;
                            }

                            if ($connect) {
                                echo "Connected to database successfully!<br>";
                            } else {
                                echo "Connection failed: " . mysqli_connect_error();
                                exit();
                            }

                            if (isset($_POST['submit'])) {
                                $email = strip_tags($_POST['email']);
                                $password = strip_tags($_POST['password']);
                                $messages = [];

                                if (empty($email) || empty($password)) {
                                    $messages[] = 'Silahkan isi data yang diperlukan!';
                                } else {
                                    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
                                    $result = mysqli_query($connect, $sql);

                                    if ($result->num_rows > 0) {
                                        $row = mysqli_fetch_assoc($result);
                                        $_SESSION['email'] = $row['email'];
                                        $_SESSION['login'] = 'login';
                                        header('Location: homepage.php');
                                        exit();
                                    } else {
                                        echo "<script>alert('Email atau password Anda salah. Silakan coba lagi!')</script>";
                                    }
                                }
                            }


                            if (!empty($messages)) {
                                foreach ($messages as $message) {
                                    echo '<b>Warning:</b> <span style="color:red;">' . $message . '</span>';
                                }
                            }
                            ?>
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-email"></i></label>
                                <input value="" type="text" name="email" placeholder="email"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input value="" type="password" name="password" placeholder="password"/>
                            </div>
                            <div class="form-group form-button">
                                <button name="submit" type="submit" class="form-submit"> submit</button>
                            </div>
                            <h3 style="color:red;">admin account</h3>   
                            <p style="color:red;">email : admin@admin.com</p>
                            <p style="color:red;">password : admin</p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>