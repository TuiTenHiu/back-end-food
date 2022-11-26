<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      if($address == ''){
         $message[] = 'xin vui lòng thêm địa chỉ của bạn!';
      }else{
         
         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $message[] = 'đặt hàng thành công!';
      }
      
   }else{
      $message[] = 'Giỏ hàng của bạn trống trơn';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <title>Thủ tục thanh toán</title>
</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>Thủ tục thanh toán</h3>
   <p><a href="index.php">Trang thủ</a> <span> / Thủ tục thanh toán</span></p>
</div>

<section class="checkout">

   <h1 class="title">Thông tin đơn hàng</h1>

<form action="" method="post">

   <div class="cart-items">
      <h3>các mặt hàng trong giỏ hàng</h3>
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
      <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price"><?= $fetch_cart['price']; ?>đ x <?= $fetch_cart['quantity']; ?></span></p>
      <?php
            }
         }else{
            echo '<p class="empty">Giỏ của bạn trống trơn!</p>';
         }
      ?>
      <p class="grand-total"><span class="name">Tổng cộng :</span><span class="price"><?= $grand_total; ?>đ</span></p>
      <a href="cart.php" class="btn">Xem giỏ hàng</a>
   </div>

   <input type="hidden" name="total_products" value="<?= $total_products; ?>">
   <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
   <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
   <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
   <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
   <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

   <div class="user-info">
      <h3>thông tin của bạn</h3>
      <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
      <a href="update_profile.php" class="btn">sửa thông tin</a>
      <h3>địa chỉ giao hàng</h3>
      <p><i class="fas fa-map-marker-alt"></i><span>
         <?php if($fetch_profile['address'] == ''){
            echo 'vui lòng nhập địa chỉ của bạn';
               }
               else{echo $fetch_profile['address'];
               } 
               ?>
               </span></p>
      <a href="update_address.php" class="btn">sửa địa chỉ</a>
      <select name="method" class="box" required>
         <option value="" disabled selected>Chọn phương thức thanh toán </option>
         <option value="thanh toán khi giao hàng">Thanh toán khi nhận hàng</option>
         <option value="thẻ tín dụng">Thẻ tín dụng</option>
         <option value="Chuyển khoản ngân hàng.">Chuyển khoản ngân hàng.</option>
      </select>
      <input type="submit" value="đặt hàng" class="btn 
         <?php if($fetch_profile['address'] == ''){echo 'disabled';} ?>
         " style="width:100%; background:var(--red); color:var(--white);" name="submit">
   </div>

</form>
   
</section>


<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>