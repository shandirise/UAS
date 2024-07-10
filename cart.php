<?php
if (!isset($_SESSION)) {
  session_start();

}
if ($_SESSION['login'] !== 'login') {
  header('Location: index.php');
  exit;
}
?>
<!doctype html>
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
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
            aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="fa fa-bars"></span> Menu
          </button>
          <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto mr-md-3">
              <li class="nav-item"><a href="profil.php" class="nav-link">Profil</a></li>
              <li class="nav-item"><a href="homepage.php" class="nav-link">Product</a></li>
              <li class="nav-item">
                <?php echo ($_SESSION['email'] == 'admin@admin.com') ? '<a href="managing.php" class="nav-link">managing</a>' : ''; ?>
              </li>
              <li class="nav-item active"><a href="cart.php" class="nav-link">Cart</a></li>
              <li class="dropdown nav-item d-md-flex align-items-center"></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </section>
  <div class="container">
    <h2>CART</h2>
    <table class="table table-striped table-responsive">
      <thead>
        <tr>
          <th>Product</th>
          <th>Amount</th>
          <th>Price</th>
          <th>Reduce Order</th>
        </tr>
      </thead>
      <tbody>
        <?php
        require_once 'connect.php';
        $email = $_SESSION['email'];
        $query = "SELECT c.*, p.product_name FROM cart c 
                      INNER JOIN product p ON c.product_id = p.product_id 
                      WHERE c.email = '$email';";
        $result = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_assoc($result)) {
          if ($row['amount'] > 0) { 
            ?>
            <tr>
              <td><?php echo $row['product_name']; ?></td>
              <td><?php echo $row['amount']; ?></td>
              <td><?php echo $row['price']; ?></td>
              <td>
                <form action="reduce_order.php" method="post">
                  <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                  <input type="hidden" name="email" value="<?php echo $email; ?>">
                  <button type="submit" class="btn btn-sm btn-danger">Decrease</button>
                </form>
              </td>
            </tr>
          <?php }
        } ?>
      </tbody>
    </table>
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