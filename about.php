<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <title>Về Chúng Tôi</title>
</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>về chúng tôi</h3>
   <p><a href="index.php">Trang Chủ</a> <span> / Về Chúng Tôi</span></p>
</div>

<!-- about section starts  -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about-img.png" alt="">
      </div>

      <div class="content">
         <h3>Tại sao chọn chúng tôi?</h3>
         <p>
         Với lợi thế có chuỗi sản xuất khép kín 3F từ "Trang trại đến bàn ăn", mọi nỗ lực của chúng tôi đều
         lấy khách hàng làm trọng tâm để thay đổi tư duy và chiến lược chung của công ty nhằm góp phần tạo nên
         những sản phẩm có giá trị cao cho xã hội và tiến đến khẳng định vị thế trên thị trường một thương hiệu
       phát triển bền vững HL-FRAM
         </p>
         <a href="menu.php" class="btn">Xem Sản Phẩm</a>
      </div>

   </div>

</section>

<!-- about section ends -->

<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   grabCursor: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
      slidesPerView: 1,
      },
      700: {
      slidesPerView: 2,
      },
      1024: {
      slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>