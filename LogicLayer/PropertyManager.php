<?php 
	require_once("C:/wamp64/www/proje/DataLayer/DB.php");
	require_once("Property.php");
	
	class PropertyManager {
		
		public static function getAllProperties ($product_id = null) {
			$db = new DB();
			$result = $db->getDataTable("select * from product_property pp, properties pr where pp.p_id = $product_id and pr.pr_id = pp.pr_id order by pr_id");
			
			$allProperties = array();
			
			while($row = $result->fetch_assoc()) {
				$propertyObj = new Property($row["pr_name"], $row["pr_value"]);
				array_push($allProperties, $propertyObj);
			}
			
			return $allProperties;
		}
		
		public static function insertNewProperty($pr_name, $pr_value) {
			$db = new DB();
			$success = $db->executeQuery("INSERT INTO properties(pr_name, pr_value) VALUES ('$pr_name', '$pr_value')");
			return $success;
		}
		
		public static function findExistingProperty($pr_name, $pr_value){
			$db = new DB();
			$result = $db->getDataTable("select * from properties pr where pr.pr_name = $pr_name and pr.pr_value = $pr_value");
			
			$allProperties = array();
			
			while($row = $result->fetch_assoc()) {
				$propertyObj = new Property($row["pr_name"], $row["pr_value"]);
				array_push($allProperties, $propertyObj);
			}
			
			return $allProperties;
		}
		
	}
?>