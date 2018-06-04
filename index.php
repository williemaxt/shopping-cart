<?php
include_once 'connection.php';
//starting a session
session_start();
//setting the session id as a unique id (for later use)
$_SESSION['id'] = uniqid();
//our query
$sql = "SELECT * FROM `products`";
$result = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<link rel="stylesheet" href="css/main.css">
  <head>
    <meta charset="utf-8">
    <title>Random Store</title>
  </head>
  <body>
    <nav>
      <li><a href="index.php"><p>Home</p></a></li>
      <li><a href="cart-list.php"><p>My Cart</p></a></li>
    </nav>
    <?php
      if($result->num_rows > 0){

        while ($row = $result->fetch_assoc()) {
          echo '<div class="item">
            <form class="" action="index.php" method="post">
              <p>'.$row["name"].'</p>
              <p>'.$row["price"].'</p>
              <input type="submit" name="add" value="Add To Cart">
              <!--HIDDEN INPUTS TO CAPTURE THE FORM DATA FOR POSTING-->
              <input  type="hidden" name="id"  value="' . $row['id'] . '">
              <input  type="hidden" name="name"  value="' . $row['name'] . '">
              <input  type="hidden" name="image"  value="' . $row['image'] . '">
              <input  type="hidden" name="price"  value="' . $row['price'] . '">
            </form>
          </div>';
        }

      }else{
        echo "we cant seem t pull your info";
      }
      //controlling the form action
      if(isset($_POST["add"])){
        // NAMING THE RETRIEVED DATA AS VARIABLES FOR USE IN A query
        $id = $_POST['id'];
        $name = $_POST['name'];
        $image = $_POST['image'];
        $price = $_POST['price'];
        //QUERY TO ADD ITEM TO CART
        $conn->query("INSERT INTO `cart`(id,name,image,price) VALUES ('$id','$name','$image','$price');");
        //QUERY TO ADD ITEM TO CART
        $conn->query("DELETE FROM `products` WHERE id LIKE '$id';");
        //ECHO A META TAG TO REFRESH THE page
        echo '<meta http-equiv="refresh" content="0">';
      }
    ?>

  </body>
</html>
