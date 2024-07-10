<?php
require_once 'connect.php';
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
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span> Menu
              </button>
              <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto mr-md-3">
                    <li class="nav-item"><a href="profil.php" class="nav-link">Profil</a></li>
                    <li class="nav-item"><a href="homepage.php" class="nav-link">Product</a></li>
                    <li class="nav-item active"><?php echo ($_SESSION['email'] == 'admin@admin.com') ? '<a href="#" class="nav-link">managing</a>' : ''; ?></li>
                    <li class="nav-item"><a href="cart.php" class="nav-link">Cart</a></li>
                    <li class="dropdown nav-item d-md-flex align-items-center"></li>
                </ul>
              </div>
            </div>
          </nav>
        </div>
        <div class="container">
          <form action="insert_product.php" method="post">
            <h1>Adding Product</h1>
            <table>
              <tr>
                <td><label>Product Name :</label></td>
                <td><input type="text" name="product_name"></td>
              </tr>
              <tr>
                <td><label>Price :</label></td>
                <td><input type="number" name="price"></td>
              </tr>
              <tr>
                <td><label>Stock :</label></td>
                <td><input type="number" name="stock"></td>
              </tr>
              <tr>
                <td><button class="btn btn-primary" type="submit">Submit</button></td>
              </tr>
            </table>
          </form>
          <form method="post">
  <h1>remove product, update pricing or stock</h1>
  <table>
    <?php
              $query = "SELECT * FROM product";
              $result = mysqli_query($connect, $query);
              ?>
              <tr>
                <td>
                  <label>product name :</label>
                </td>
                <td>
                  <select name="product_id">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo "<option value='" . $row['product_id'] . "'>" . $row['product_name'] . "</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td>
                  <label>
                    price :
                  </label>
                </td>
                <td>
                  <input type="number" name="price">
                </td>
              </tr>
              <tr>
                <td>
                  <label>stock :</label>
                </td>
                <td>
                  <input type="number" name="stock">
                </td>
              </tr>
              <tr>
                <td><button class="btn btn-primary" type="submit" name="submit">submit</button></td>
                <td><button class="btn btn-primary" type="submit" name="delete">delete</button></td>
              </tr>
            </table>
          </form>
          
          <?php
          if (isset($_POST['submit'])) {
            $product_id = $_POST['product_id'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];

            if (!empty($price) && !empty($stock)) {
              $query = "UPDATE product SET price = '$price', stock = '$stock' WHERE product_id = '$product_id'";
            } elseif (!empty($price)) {
              $query = "UPDATE product SET price = '$price' WHERE product_id = '$product_id'";
            } elseif (!empty($stock)) {
              $query = "UPDATE product SET stock = '$stock' WHERE product_id = '$product_id'";
            }
            
            mysqli_query($connect, $query);
          }

          if (isset($_POST['delete'])) {
            $product_id = $_POST['product_id'];
            $query = "DELETE FROM product WHERE product_id = '$product_id'";
            mysqli_query($connect, $query);
          }
          ?>
        </div>
    </section>
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

