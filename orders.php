<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location: login.php');
};

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
   <title>Đơn Đặt Hàng</title>
</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>đơn đặt hàng</h3>
   <p><a href="index.php">Trang chủ</a> <span> / Đơn đặt hàng</span></p>
</div>

<section class="orders">

   <h1 class="title">Đơn đặt hàng của bạn</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">Vui lòng đăng nhập để xem đơn đặt hàng của bạn</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>Ngày đặt : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>Tên : <span><?= $fetch_orders['name']; ?></span></p>
      <p>Email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>Số điện thoại : <span><?= $fetch_orders['number']; ?></span></p>
      <p>Địa chỉ : <span><?= $fetch_orders['address']; ?></span></p>
      <p>Phương thức thanh toán : <span><?= $fetch_orders['method']; ?></span></p>
      <p>Đơn đặt hàng của tôi : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>Tổng giá : <span><?= $fetch_orders['total_price']; ?>đ</span></p>
      <p> Tình trạng thanh toán : 
         <span style="color:
         <?php
            if($fetch_orders['payment_status'] == 'pending'){ 
               echo 'red'; 
            }else
               { echo 'green'; }; ?>
               ">
               <?= $fetch_orders['payment_status']; 
         ?>
         </span> </p>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">chưa có đơn đặt hàng nào!</p>';
      }
      }
   ?>

   </div>

</section>



<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->


<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>