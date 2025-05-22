<?php 
session_start();
error_reporting(1);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:login.php');
}
else{
	if (isset($_POST['submit'])) {

		mysqli_query($con,"update orders set 	paymentMethod='".$_POST['paymethod']."',u_email='".$_SESSION['login']."' where userId='".$_SESSION['id']."' and paymentMethod is null ");
		
		ini_set("SMTP","ssl://smtp.gmail.com");
		ini_set("smtp_port","587");	
		unset($_SESSION['cart']);
		header('location:order-history.php');
		
      // echo '<pre>'.print_r($_POST, true).'</pre>'; die;
   $email = "darshanapansare3@gmail.com"; // change with your email
    $email_to = $_SESSION['login']; // change with your email

  $query=mysqli_query($con,"select orders.u_email as uEmail,products.productImage1 as pimg1,products.productDescription as pdesc ,products.productName as pname,products.id as proid,orders.productId as opid ,orders.quantity as qty,products.productPrice as pprice,products.shippingCharge as shippingcharge,orders.paymentMethod as paym,orders.userId as uId,orders.orderDate as odate,orders.id as orderid from orders join products on orders.productId=products.id where orders.userId='".$_SESSION['id']."' and orders.paymentMethod is not null");

while($row=mysqli_fetch_array($query))
{
$uEmail = $row['uEmail'];
$odate = $row['odate'];	
$qty=$row['qty']; 
$uId=$row['uId']; 
$shippcharge=$row['shippingcharge']; 
$order_id= $row['orderid'];
$productId= $row['proid'];
$productPrice= $row['productPrice'];
$productName= $row['pname'];
$productPrice= $row['pprice'];
$productImage= $row['pimg1'];
$pdesc = $row['pdesc'];
$pay_method = $row['paym'];
	}
	    
	$total = $productPrice + $shippcharge;
	$message_to_user = "<div  style='background:gray; color:white;width:800px; padding:50px;height:1200px;list-style:none;font-size: 16px;'>
	<h3>Thank You for your Order . we will deliver your order soon.</h3>
	<p>Hi  $uEmail , <p>
	<p>We have delighted you that you have found something you like!As soon as your package is on its way , you will recieve a delivery confirmation from us by mail.</p>	
	<h2>Your Order Details:</h2>
	<div>
			<div style='align:left;'>
			Product Id : $productId <br>
			Product NAME : $productName<br>
			Product Image : $productImage<br>
			Product Description : $pdesc<br> 
			</div>
			 
			<div style='align:right;'>Order Id : $order_id<br>
			Order Date: : $odate<br>Product Price: $productPrice<br></div>
	        </div>
	<hr>
	Payment Method : $pay_method<br>
	Product Price: $productPrice<br>
	Shipping charge : $shippcharge<br>
	Total :$total<br>
	<a href='http://localhost/online-Shopping-Portal-project/shopping/track-orders.php' style='background-color: #4CAF50;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;list-style:none;font-size: 16px;'>
    <button style='text-align:center;'>Track Order</button>
    </a>
	</div>";

	
    $message_to_admin = "<div  style='background:gray; color:white;width:800px; padding:50px;height:1200px;list-style:none;font-size: 16px;'>
	<h3>User has purchased order.</h3>
	User id : $uId<br>
	order id : $order_id<br>
	Product Id : $productId <br>
	Product Price: $productPrice<br>
	Product NAME : $productName<br>
    shipping charge : $shippcharge<br>
	Product Image : $productImage<br>
	Product Description : $pdesc<br>
		</div>	
		
			<div>
			<div style='align:left;'>
			Product Id : $productId <br>
			Product NAME : $productName<br>
			Product Image : $productImage<br>
			Product Description : $pdesc<br> 
			</div>
			 
			<div style='align:right;'>Order Id : $order_id<br>
			Order Date: : $odate<br>Product Price: $productPrice<br></div>
	        </div>
	<hr>
	Payment Method : $pay_method<br>
	Product Price: $productPrice<br>
	Shipping charge : $shippcharge<br>
	Total :$total<br>
	<a href='http://localhost/Online-Shopping-Portal-project/Online-Shopping-Portal-project/shopping/admin' style='background-color: #4CAF50;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;list-style:none;font-size: 16px;'>
    <button style='text-align:center;'>Go to Admin</button>
    </a>
	</div>";

	$subject = "ordered product $productName";
    $headers  = "From: $email\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html\r\n";
	if($_SESSION['cart'] != 0){
		mail($email_to, $subject, $message_to_user, $headers);	
		mail($email, $subject, $message_to_admin, $headers);
	}
	
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="">
		<meta name="author" content="">
	    <meta name="keywords" content="MediaCenter, Template, eCommerce">
	    <meta name="robots" content="all">

	    <title>Shopping Portal | Payment Method</title>
	    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
	    <link rel="stylesheet" href="assets/css/main.css">
	    <link rel="stylesheet" href="assets/css/green.css">
	    <link rel="stylesheet" href="assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
		<!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
		<link href="assets/css/lightbox.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/animate.min.css">
		<link rel="stylesheet" href="assets/css/rateit.css">
		<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
		<link rel="stylesheet" href="assets/css/config.css">
		<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
		<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
		<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
		<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
		<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="assets/images/favicon.ico">
	</head>
    <body class="cnt-home">
	
		
<header class="header-style-1">
<?php include('includes/top-header.php');?>
<?php include('includes/main-header.php');?>
<?php include('includes/menu-bar.php');?>
</header>
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="home.html">Home</a></li>
				<li class='active'>Payment Method</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content outer-top-bd">
	<div class="container">
		<div class="checkout-box faq-page inner-bottom-sm">
			<div class="row">
				<div class="col-md-12">
					<h2>Choose Payment Method</h2>
					<div class="panel-group checkout-steps" id="accordion">
						<!-- checkout-step-01  -->
<div class="panel panel-default checkout-step-01">

	<!-- panel-heading -->
		<div class="panel-heading">
    	<h4 class="unicase-checkout-title">
	        <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
	         Select your Payment Method
	        </a>
	     </h4>
    </div>
    <!-- panel-heading -->

	<div id="collapseOne" class="panel-collapse collapse in">

		<!-- panel-body  -->
	    <div class="panel-body">
	    <form name="payment" method="post">
	    <input type="radio" name="paymethod" value="COD" checked="checked"> COD
	     <input type="radio" name="paymethod" value="Internet Banking" class="internet-banking"> Internet Banking
	     <input type="radio" name="paymethod" value="Debit / Credit card"> Debit / Credit card <br /><br />
	     <input type="submit" value="submit" name="submit" class="btn btn-primary">
	    	

	    </form>		
		</div>
		<!-- panel-body  -->

	</div><!-- row -->
</div>
<!-- checkout-step-01  -->
					  
					  	
					</div><!-- /.checkout-steps -->
				</div>
			</div><!-- /.row -->
		</div><!-- /.checkout-box -->
		<!-- ============================================== BRANDS CAROUSEL ============================================== -->
<?php echo include('includes/brands-slider.php');?>
<!-- ============================================== BRANDS CAROUSEL : END ============================================== -->	</div><!-- /.container -->
</div><!-- /.body-content -->
<?php include('includes/footer.php');?>
	<script src="assets/js/jquery-1.11.1.min.js"></script>
	
	<script src="assets/js/bootstrap.min.js"></script>
	
	<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
	
	<script src="assets/js/echo.min.js"></script>
	<script src="assets/js/jquery.easing-1.3.min.js"></script>
	<script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/jquery.rateit.min.js"></script>
    <script type="text/javascript" src="assets/js/lightbox.min.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
	<script src="assets/js/scripts.js"></script>

	<!-- For demo purposes – can be removed on production -->
	
	<script src="switchstylesheet/switchstylesheet.js"></script>
	
	<script>
		$(document).ready(function(){ 
			$(".changecolor").switchstylesheet( { seperator:"color"} );
			$('.show-theme-options').click(function(){
				$(this).parent().toggleClass('open');
				return false;
			});
		});
		$('input:radio[name="paymethod"]').change(function() {
       
                alert('type A');
        
       
    });

		$(window).bind("load", function() {
		   $('.show-theme-options').delay(2000).trigger('click');
		});
	</script>
	<!-- For demo purposes – can be removed on production : End -->

	

</body>
</html>
<?php } ?>