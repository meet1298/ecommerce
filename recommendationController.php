<?php 
extract($_POST);
?>
									<form action="http://localhost:8080/easyrec-web/api/1.1/view" method="GET" id="dateForm">
										<input type="hidden" name="apikey" value="<?php echo $apikey; ?>">
										<input type="hidden" name="tenantid" value="<?php echo $tenantid; ?>">
										<input type="hidden" name="userid" value="<?php echo $userid; ?>">
										<input type="hidden" name="sessionid" value="<?php echo $sessionid; ?>">
										<input type="hidden" name="itemdescription" value="<?php echo $itemdescription; ?>">
										<input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
										<input type="hidden" name="itemurl" value="<?php echo $itemurl; ?>">
										<input type="hidden" name="itemimageurl" value="<?php echo $itemimageurl; ?>">
										<!-- <input type="" name="itemtype" value="<?php echo $product['catname']; ?>"> -->
										<input type="hidden" name="actiontime" value="<?php echo $actiontime; ?>">
										<button type="submit" class="btn btn-primary btn-lg btn-flat"> View </button>
									</form>
<?php
    if (true)
{?>

	<script type="text/javascript">
	    document.getElementById('dateForm').submit(); 
	</script>

<?php 
	}
	else
	{
	  // leave the page alone
	}
?>
<?php
$xml['status'];

// header("location: $itemurl");

?>