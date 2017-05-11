<?php 
	require_once("C:/wamp64/www/proje/LogicLayer/ProductManager.php");
		
	$p_id = $p_name = $quantity = $reg_date = "";
		

	if (isset($_POST["radio_pid"]) && isset($_POST["btn_name_delete"])) {
		$p_id = $_POST["radio_pid"];

		$errorMeesage = "";
		$successMeesage = "";
		$result = ProductManager::deleteProduct($p_id);
		if(!$result) {
			$errorMeesage = "There is a problem deleting product!";
		}else{
			$successMeesage = "Product deleted successfully.";
		}
	} else if (isset($_POST["radio_pid"]) && isset($_POST["btn_name_update"])) {
		$p_id = $_POST["radio_pid"];
		
		$productList = ProductManager::getProduct($p_id);
		//$p_id = $productList[0]->getP_id();
		$p_name = $productList[0]->getP_name();
		$quantity = $productList[0]->getQuantity();
		$reg_date = $productList[0]->getReg_date();
		
	} else if (isset($_POST["p_id"])&& isset($_POST["p_name"]) && isset($_POST["quantity"]) && isset($_POST["reg_date"]) && isset($_POST["btn_name_save"])) {
		
		$p_id = trim($_POST["p_id"]);
		$p_name = trim($_POST["p_name"]);
		$quantity = trim($_POST["quantity"]);
		$reg_date = trim($_POST["reg_date"]);
		
		$errorMeesage = "";
		$successMeesage = "";
		$result = ProductManager::updateProduct($p_id, $p_name, $quantity, $reg_date);
		if(!$result) {
			$errorMeesage = "Yeni ürün kaydı başarısız!";
		}
		else
			$successMessage = "id : ".$p_id.", name : ".$p_name.", quantity : ".$quantity.", registration date : ".$reg_date;
		
	}
	
	
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Store System</title>
		<link href="Css/style.css" rel="stylesheet" type="text/css">
		
	</head>
	<script>
			// JQuery 
		$(document).ready(function() { // when DOM is ready, this will be executed
			
			$("#btnCallSrvc").click(function(e) { // click event for "btnCallSrvc"
				
				var cntrCode = $("#txtCode").val(); // get country code
				if(cntrCode == "") {
					alert("Enter country code!");
					$("#txtCode").focus();
					return;
				}
				
				var retType = $("#radioJson").is(":checked") ? "json" : "xml"; // get reply format
				var count = $("#txtNum").val(); // get desired country count
				
				$.ajax({ // start an ajax POST 
					type	: "post",
					url		: "countries.php",
					data	:  { 
						"code"	: cntrCode, 
						"format": retType, 
						"num"	: count 
					},
					success : function(reply) { // when ajax executed successfully
						console.log(reply);
						if(retType == "json") {
							$("#divCallResult").html( JSON.stringify(reply) );
						}
						else {
							$("#divCallResult").html( new XMLSerializer().serializeToString(reply) );
						}
						
					},
					error   : function(err) { // some unknown error happened
						console.log(err);
						alert(" There is an error! Please try again. " + err); 
					}
				});
				
			});
			
		});
		</script>
	<body>
		<div class="container">
			
			<?php require_once("MasterPage/header.php"); ?>
			<?php require_once("MasterPage/menu.php"); ?>
			
			
			<div class="content">
				<h1>SHOW PRODUCT LIST</h1>
				<form action="<?php $_PHP_SELF ?>" method="POST">
					<div id="left_side" class="left_right">
						<p>
							Product ID: <br/>
							<input type="text" id="tb_pid" value="<?php echo $p_id; ?>" name ="p_id" required> <br/>
						</p>
						<p>
							Product Name: <br/>
							<input type="text" id="tb_pname" value="<?php echo $p_name; ?>" name ="p_name" required> <br/>
						</p>
						<p>
							Quantity: <br/>
							<input type="text" id="tb_quantity" value="<?php echo $quantity; ?>" name ="quantity" required> <br/>
						</p>
						<p>
							Registration Date: <br/>
							<input type="text" id="tb_regdate" value="<?php echo $reg_date; ?>" name ="reg_date" required> <br/>
						</p>
						<p>
							<input type="submit" id="btn_save" value="SAVE PRODUCT" name="btn_name_save">
						</p>
					</div>	
				</form>
				<table id="tblUsers">
					<tbody>
						<form action="<?php $_PHP_SELF ?>" method="POST">
							<tr>
								<th>Select</th>
								<th>Product ID</th>
								<th>Product Name</th>
								<th>Quantity</th>
								<th>Registration Date</th>
							</tr>
							<?php 
								$productList = ProductManager::getAllProducts();
								
								for($i = 0; $i < count($productList); $i++) {
									?>
									<tr>
										<td style="text-align:center">
											<input type="radio" name="radio_pid" value="<?php echo $productList[$i]->getP_id(); ?>" id="radio_select">
										</td>
										<td><?php echo $productList[$i]->getP_id(); ?></td>
										<td><?php echo $productList[$i]->getP_name(); ?></td>
										<td><?php echo $productList[$i]->getQuantity(); ?></td>
										<td><?php echo $productList[$i]->getReg_date(); ?></td>
									</tr>
									<?php
								}
							?>
							<tr>
								<td></td>
								<td><input type="submit" name="btn_name_update" value="UPDATE" id="btn_update"></td>
								<td><input type="submit" name="btn_name_delete" value="DELETE" id="btn_delete"></td>
								
								<?php 
								if(isset($errorMeesage)) {
									echo "<br>" . "<span style='color: red;'>" . $errorMeesage . "</span>";
								}else if(isset($errorMeesage)) {
									echo "<br>" . "<span style='color: green;'>" . $successMeesage . "</span>";
								}
								
								?>
							</tr>
						</form>
						<form action="web_service.php" method="POST">
							
							<tr>
								<td>
									Format : 
								</td>
								<td>
									<input type="radio" name="format" value="json" id="radioJson" checked>
									<label for="radioJson">JSON</label>
									<br>
									<input type="radio" name="format" value="xml" id="radioXml">
									<label for="radioXml">XML</label>
								</td>
							</tr>
							<tr>
								<td></td>
								
								<td><input type="submit" name="btn_name_ws" value="Show Web Service" id="btn_ws"></td>
								
							</tr>
						</form>
					</tbody>
				</table>
				
			</div><!-- end .content -->

			<?php require_once("MasterPage/footer.php"); ?>
		</div><!-- end .container -->
	</body>
</html>
