<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>REGISTER HEALT PHARMA</title>
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="main">
         <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">REGISTER</h2>
                        <form method="POST" class="register-form" id="register-form">
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
                                $name = strip_tags($_POST['name']);
                                $phone = strip_tags($_POST['phone']);
                                $email = strip_tags($_POST['email']);
                                $password = strip_tags($_POST['password']);
                                $messages = [];

                                if (empty($name) || empty($phone) || empty($email) || empty($password)) {
                                    $messages[] = 'Please fill the form!';
                                } elseif (count((array) mysqli_query($connect, 'SELECT email FROM users WHERE email = "' . $email . '" OR phone = "' . $phone . '"')->fetch_array()) > 1) {
                                    $messages[] = 'Your email or phone number already use!';
                                } else {
                                    $insert = mysqli_query($connect, 'INSERT INTO `users`(`name`, `phone`, `email`, `password`) VALUES("' . $name . '", "' . $phone . '", "' . $email . '", "' . $password . '")');
                                    if ($insert) {
                                        

                                        if (session_status() === PHP_SESSION_NONE) {
                                            session_start();
                                        }

                                        $_SESSION['email'] = $email;
                                        $_SESSION['login'] = 'login';
                                        header('Location: homepage.php');
                                        exit();
                                    } else {
                                        $messages[] = 'Pendaftaran gagal!';
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
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name"/>
                            </div>
                            <div class="form-group">
                                <label for="phone"><i class="zmdi zmdi-phone"></i></label>
                                <input type="text" name="phone" id="phone" placeholder="Your Phone"/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email"/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="pass" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                            </div>
                            <div class="form-group form-button">
                                <button name="submit" type="submit" class="form-submit"> submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/register.png" alt="sing up image"></figure>
                        <a href="index.php" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>