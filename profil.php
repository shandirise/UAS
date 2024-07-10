<?php
if (!isset($_SESSION)) {
  session_start();

}
if ($_SESSION['login'] !== 'login') {
  header('Location: index.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  	<title>HEALTH PHARMA</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/styleHP.css">

	</head>

<body>
    <section class="ftco-section">
		<div class="container">
			<nav class="navbar navbar-expand-lg ftco_navbar ftco-navbar-light" id="ftco-navbar">
		    <div class="container">
		    	<a class="navbar-brand" href="#">HEALTH PHARMA</a>
		      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
		        <span class="fa fa-bars"></span> Menu
		      </button>
		      <div class="collapse navbar-collapse" id="ftco-nav">
		        <ul class="navbar-nav ml-auto mr-md-3">
              <li class="nav-item active"><a href="profil.php" class="nav-link">Profil</a></li>
              <li class="nav-item"><a href="homepage.php" class="nav-link">Product</a></li>
              <li class="nav-item"><?php echo ($_SESSION['email'] == 'admin@admin.com') ? '<a href="managing.php" class="nav-link">managing</a>' : ''; ?></li>
              <li class="nav-item"><a href="cart.php" class="nav-link">Cart</a></li>
              <li class="dropdown nav-item d-md-flex align-items-center">
		        </ul>
		      </div>
		    </div>
		  </nav>
  		</div>
	</section>
    <div class="main">
        <section class="homepage">
            <div class="container">
                <div class="homepage-content">
                    <h2><?php
                    require_once 'connect.php';
                    
                    $email = $_SESSION['email'];

                    $query = "SELECT name, phone FROM users WHERE email = '$email'";
                    $result = mysqli_query($connect, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "Name: " . $row['name'] . "<br>";
                            echo "Phone: " . $row['phone'] . "<br>";
                            echo "Email: " . $email . "<br>";
                        }
                    } else {
                        echo "No results found";
                    }

                    mysqli_close($connect);
                    ?><a href="logout.php" class="main-btn">Logout</a></h2>

                </div>
            </div>
        </section>
    </div>
    <script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
</body>
	<footer class="ftco-footer ftco-section">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <p>
            <a href="https://www.instagram.com/shandihimawan_" target="_blank">
              <i class="fa fa-instagram"></i>
            </a>
            <a href="https://www.facebook.com/shandi.himawan.714/" target="_blank">
              <i class="fa fa-facebook"></i>
            </a>
            <a href="http://www.linkedin.com/in/shandi-himawan-2b9214288" target="_blank">
              <i class="fa fa-linkedin"></i>
            </a>
          </p>
        </div>
      </div>
    </div>
  </footer>

</html>