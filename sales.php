
<?php include 'includes/scripts.php'; ?>


<?php
	include 'includes/session.php';	

		$conn = $pdo->open();	
		$abc='undone';	
		
		try{
			
			 $stmt1 = $conn->prepare("SELECT * FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
			 $stmt1->execute(['user_id'=>$user['id']]);
			$product1 = $stmt1->fetch();
			// print_r($product1);
			 // echo $product1['slug'];
			
		}
		catch(PDOException $e){
			echo "There is some problem in connection: " . $e->getMessage();
		}
		?>
		
		<script> 
		window.onload = easyrecbuy();

function easyrecbuy(){
                           
                            var apikey = "985a6765017d6d7032c260d0f4747b55";
                            var tenantid = "EASYREC_DEMO";
                            var sessionid = "<?php echo session_id(); ?>";
                            var userid = "<?php echo $_SESSION['user'];?>";
                            var itemdescription = "<?php echo $product1['slug']; ?>";
                           
                            var itemid = "<?php echo $product1['product_id']; ?>";
                            var itemurl = "localhost/ecommerce/product.php?product=<?php echo $product1['slug']; ?>";
                            var itemimageurl = "localhost/ecommerce/image/<?php echo $product1['photo']; ?>";
                            
                            var actiontime  = "<?php echo date("d_m_Y_h_m_s"); ?>";
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
                            <?php $abc='done';?>
                        }
                      </script>


<?php
if(isset($_GET['pay'])){
	$payid = $_GET['pay'];
	$date = date('Y-m-d');

		try{
			
			$stmt = $conn->prepare("INSERT INTO sales (user_id, pay_id, sales_date) VALUES (:user_id, :pay_id, :sales_date)");
			$stmt->execute(['user_id'=>$user['id'], 'pay_id'=>$payid, 'sales_date'=>$date]);
			$salesid = $conn->lastInsertId();
			
			try{
				$stmt = $conn->prepare("SELECT * FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
				$stmt->execute(['user_id'=>$user['id']]);

				foreach($stmt as $row){
					$stmt = $conn->prepare("INSERT INTO details (sales_id, product_id, quantity) VALUES (:sales_id, :product_id, :quantity)");
					$stmt->execute(['sales_id'=>$salesid, 'product_id'=>$row['product_id'], 'quantity'=>$row['quantity']]);
				}

				$stmt = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id");
				$stmt->execute(['user_id'=>$user['id']]);

				$_SESSION['success'] = 'Transaction successful. Thank you.';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	?>
	



	


<?php
 sleep();
if($abc=='done'){

header('location: profile.php');
}
?>