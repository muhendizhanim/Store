<?php 
	require_once("C:/wamp64/www/proje/LogicLayer/ProductManager.php");
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["p_id"])) {
			$p_id = $_POST["p_id"];
			
			$productList = ProductManager::getProduct();
			$p_id = $productList[0]->getP_id();
			$p_name = $productList[0]->getP_name();
			$quantity = $productList[0]->getQuantity();
			$reg_date = $productList[0]->getReg_date();
			
		} else {
		$nameErr = "Format is required";
		}
	}
	
	$errorMeesage = "";
	
	if(isset($_POST["p_id"]) && isset($_POST["p_name"]) && isset($_POST["quantity"]) && isset($_POST["reg_date"])) {
		
		$p_id = trim($_POST["p_id"]);
		$p_name = trim($_POST["p_name"]);
		$quantity = trim($_POST["quantity"]);
		$reg_date = trim($_POST["reg_date"]);
		
		$errorMeesage = "";
		$successMeesage = "";
		$result = ProductManager::insertNewProduct($p_id, $p_name, $quantity, $reg_date);
		if(!$result) {
			$errorMeesage = "Yeni ürün kaydı başarısız!";
		}else{
			$successMessage = "id : ".$p_id.", name : ".$p_name.", quantity : ".$quantity.", registration date : ".$reg_date;
		}
	}
	
	
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Store System</title>
		<link href="Css/style.css" rel="stylesheet" type="text/css">
		<!--<script type="text/javascript" src="Scripts/jquery-3.2.1.js"></script>-->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	</head>

	<body>
		<div class="container">
			
			<?php require_once("MasterPage/header.php"); ?>
			<?php require_once("MasterPage/menu.php"); ?>
			
			
			<div class="content">
				<h1>ADD PRODUCT MANUALLY</h1>
				
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
							<input type="date" id="tb_regdate" value="<?php echo $reg_date; ?>" name ="reg_date" required> <br/>
						</p>
						<p>
							<input type="submit" id="btn_submit" value="SAVE PRODUCT" name="btn_save">
							<?php 
								if(isset($errorMeesage)) {
									echo "<br>" . "<span style='color: red;'>" . $errorMeesage . "</span>";
								}else
									echo "<br>" . "<span style='color: green;'>" . $successMeesage . "</span>";
								
							?>
						</p>
					</div>					
				</form>
			</div><!-- end .content -->

			<?php require_once("MasterPage/footer.php"); ?>
		</div><!-- end .container -->
	</body>
</html>
