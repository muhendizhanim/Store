<?php 
	require_once("C:/wamp64/www/proje/LogicLayer/ProductManager.php");
	
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
		}
		else
			$successMessage = "Successfully registrated..";
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
	<script type="text/javascript">

		$(document).ready(function(){

			var counter = 2;

			$("#addButton").click(function () {

				if(counter>10){
						alert("Only 10 textboxes allow");
						return false;
				}

				var newTextBoxDiv = $(document.createElement('div'))
					 .attr("id", 'TextBoxDiv' + counter);
					 
				newTextBoxDiv.after().html('<p><label>Name #'+ counter + ' : </label>' +
					  '<input type="text" name="tb_name' + counter + '" id="textboxN' + counter + '" value="" >' + 
					  '<label>Value #'+ counter + ' : </label>' +
					  '<input type="text" name="tb_value' + counter + '" id="textboxV' + counter + '" value="" ></p>');

				newTextBoxDiv.appendTo("#TextBoxesGroup");


				counter++;
			});
///////////////// remove kısmı
			$("#removeButton").click(function () {
				if(counter==1){
					  alert("No more textbox to remove");
					  return false;
				}

				counter--;

				$("#TextBoxDiv" + counter).remove();

			});
////////////////////////////////////////

			$("#btn_submit").click(function() { // click event for "btnCallSrvc"
				
				var product_id = $("#tb_pid").val(); // get country code
				var product_name = $("#tb_pname").val(); // get country code
				var product_quantity = $("#tb_quantity").val(); // get country code
				var product_regdate = $("#tb_regdate").val(); // get country code
				/*				
				var product_property = {
					accounting: []
				};

				product_property.accounting.push({ 
						"p_id"    : product_id,
						"p_name"  : product_name,
						"quantity": product_property, 
						"reg_date": product_regdate,
						"tb_count": counter
				});
				
				for(var i = 0; i<counter; i++) {    

					product_property.accounting.push({ 
						"tb_name"+i : $("#tb_name"+i).val();,
						"tb_value"+i : $("#tb_value"+i).val();
					});
				}	
				*/
				$.ajax({ // start an ajax POST 
					type	: "post",
					url		: "add_product_manually.php",
					data	:  { 
						"p_id"    : product_id,
						"p_name"  : product_name,
						"quantity": product_property, 
						"reg_date": product_regdate,
						"tb_count": counter
					},
					success : function(reply) { // when ajax executed successfully
						console.log(reply);
						alert("successfully sended");						
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
				<h1>ADD PRODUCT MANUALLY</h1>
				
				<form action="<?php $_PHP_SELF ?>" method="POST">
					<div id="left_side" class="left_right">
						<p>
							Product ID: <br/>
							<input type="text" id="tb_pid" name ="p_id" required> <br/>
						</p>
						<p>
							Product Name: <br/>
							<input type="text" id="tb_pname" name ="p_name" required> <br/>
						</p>
						<p>
							Quantity: <br/>
							<input type="text" id="tb_quantity" name ="quantity" required> <br/>
						</p>
						<p>
							Registration Date: <br/>
							<input type="date" id="tb_regdate" name ="reg_date" required> <br/>
						</p>
						<p>
							<input type="submit" id="btn_submit" value="SAVE PRODUCT" name="btn_save">
							<?php 
								if(isset($errorMeesage)) {
									echo "<br>" . "<span style='color: red;'>" . $errorMeesage . "</span>";
								}else{
									echo "<br>" . "<span style='color: green;'>" . $successMeesage . "</span>";
								}
								
							?>
						</p>
					</div>
					<div id="right_side" class="left_right">
						<p>
							<input type='button' value='Add Property' id='addButton'>
							<input type='button' value='Remove Property' id='removeButton'>
							<div id='TextBoxesGroup'>
								<div id="TextBoxDiv1">
									<p>
										<label>Name #1 : </label><input type='textbox' id='textboxN1' name='tb_name1'><label> Value #1 : </label><input type='textbox' id='textboxV1' name='tb_value1'>
									</p>
								</div>
							</div>
						</p>
					</div>
					
				</form>
			</div><!-- end .content -->

			<?php require_once("MasterPage/footer.php"); ?>
		</div><!-- end .container -->
	</body>
</html>
