    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>        

<?php include 'includes/session.php'; ?>
<?php
	$conn = $pdo->open();

	$slug = $_GET['product'];

	try{
		 		
	    $stmt = $conn->prepare("SELECT *, products.name AS prodname, category.name AS catname, products.id AS prodid FROM products LEFT JOIN category ON category.id=products.category_id WHERE slug = :slug");
	    $stmt->execute(['slug' => $slug]);
	    $product = $stmt->fetch();
		
	}
	catch(PDOException $e){
		echo "There is some problem in connection: " . $e->getMessage();
	}

	//page view
	$now = date('Y-m-d');
	if($product['date_view'] == $now){
		$stmt = $conn->prepare("UPDATE products SET counter=counter+1 WHERE id=:id");
		$stmt->execute(['id'=>$product['prodid']]);
	}
	else{
		$stmt = $conn->prepare("UPDATE products SET counter=1, date_view=:now WHERE id=:id");
		$stmt->execute(['id'=>$product['prodid'], 'now'=>$now]);
	}

?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav" onload="easyrecview()" >
<script>
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12';
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        	<div class="col-sm-9">
	        		<div class="callout" id="callout" style="display:none">
	        			<button type="button" class="close"><span aria-hidden="true">&times;</span></button>
	        			<span class="message"></span>
	        		</div>
		            <div class="row">
		            	<div class="col-sm-6">
		            		<img src="<?php echo (!empty($product['photo'])) ? 'images/'.$product['photo'] : 'images/noimage.jpg'; ?>" width="100%" class="zoom" data-magnify-src="images/large-<?php echo $product['photo']; ?>">
		            		<br><br>

		            		<form class="form-inline" id="productForm">
		            			<div class="form-group">
			            			<div class="input-group col-sm-5">
			            				
			            				<span class="input-group-btn">
			            					<button type="button" id="minus" class="btn btn-default btn-flat btn-lg"><i class="fa fa-minus"></i></button>
			            				</span>
							          	<input type="text" name="quantity" id="quantity" class="form-control input-lg" value="1">
							            <span class="input-group-btn">
							                <button type="button" id="add" class="btn btn-default btn-flat btn-lg"><i class="fa fa-plus"></i>
							                </button>
							            </span>
							            <input type="hidden" value="<?php echo $product['prodid']; ?>" name="id">
							        </div>
			            			<button type="submit" class="btn btn-primary btn-lg btn-flat"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
			            			
			                 		</div>
		            		<!-- </form>
									<form action="recommendationController.php" method="POST">
										<input type="hidden" name="apikey" value="985a6765017d6d7032c260d0f4747b55">
										<input type="hidden" name="tenantid" value="EASYREC_DEMO">
										<input type="hidden" name="userid" value="<?php echo $_SESSION['user']; ?>">
										<input type="hidden" name="sessionid" value="<?php echo session_id(); ?>">
										<input type="hidden" name="itemdescription" value="<?php echo $product['prodname']; ?>">
										<input type="hidden" name="itemid" value="<?php echo $product['prodid']; ?>">
										<input type="hidden" name="itemurl" value="http://localhost/ecommerce/product.php?product=<?php echo $slug; ?>">
										<input type="hidden" name="itemimageurl" value="http://localhost/ecommerce/image/<?php echo $product['photo']; ?>">
										 <input type="" name="itemtype" value="<?php echo $product['catname']; ?>"> 
										<input type="hidden" name="actiontime" value="<?php echo date("d_m_Y_h_m_s") ?>">
										<button type="submit" class="btn btn-primary btn-lg btn-flat" > View </button>
									</form> -->
		            	</div>
		            	<div class="col-sm-6">
		            		<h1 class="page-header"><?php echo $product['prodname']; ?></h1>
		            		<h3><b>&#36; <?php echo number_format($product['price'], 2); ?></b></h3>
		            		<p><b>Category:</b> <a href="category.php?category=<?php echo $product['cat_slug']; ?>"><?php echo $product['catname']; ?></a></p>
		            		<p><b>Description:</b></p>
		            		<p><?php echo $product['description']; ?></p>
		            	</div>
		            </div>
		            <br>
				    <div class="fb-comments" data-href="http://localhost/ecommerce/product.php?product=<?php echo $slug; ?>" data-numposts="10" width="100%"></div> 
	        	</div>
	        	<div class="col-sm-3">
	        		<?php include 'includes/sidebar.php'; ?>
	        	</div>
	        </div>
	      </section>    	  
	    </div>
	  </div>

  	<?php $pdo->close(); ?>
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script> 
	function easyrecvi	ew() {
                           
                             var apikey = "985a6765017d6d7032c260d0f4747b55";
                             var tenantid = "EASYREC_DEMO";
                             var sessionid = "<?php echo session_id(); ?>;";
                             var userid = "<?php echo $_SESSION['user'];?>";
                             var itemdescription = "<?php echo $slug; ?>";
                            //var itemdescription = "abc";
                             var itemid = "<?php echo $product['prodid']; ?>";
                            var itemurl = "localhost/ecommerce/product.php?product=<?php echo $slug; ?>";
                            var itemimageurl = "localhost/ecommerce/image/<?php echo $product['photo']; ?>";
                            // var itemtype = "<?php echo $product['catname']; ?>";
                            var actiontime  =  "<?php echo date("d_m_Y_h_m_s"); ?>";

                            $.ajax({
                            url: 'http://localhost:8080/easyrec-web/api/1.1/view',
                            type: 'GET',
                            data: {apikey:apikey,
                            	   tenantid : tenantid,
                            	   sessionid : sessionid,
                            	   userid : userid,
                            	   itemdescription : itemdescription,
                            	   itemid : itemid,
                            	   itemurl : itemurl,
                            	   itemimageurl : itemimageurl,
                   
                            	   actiontime : actiontime
                            	    },
                            })
                            
                        }
                      </script>
<script>
$(function(){
	$('#add').click(function(e){
		e.preventDefault();
		var quantity = $('#quantity').val();
		quantity++;
		$('#quantity').val(quantity);
	});
	$('#minus').click(function(e){
		e.preventDefault();
		var quantity = $('#quantity').val();
		if(quantity > 1){
			quantity--;
		}
		$('#quantity').val(quantity);
	});

});
</script>




</body>
</html>