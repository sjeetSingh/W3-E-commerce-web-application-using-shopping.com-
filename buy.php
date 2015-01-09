<html>
<head><title>Buy Products</title></head>
<body>
	<label>Shopping Cart</label><br><br>
	

<?php
		session_start();
if(empty($_SESSION['shopping_tray'])){
    $_SESSION['shopping_tray'] = array();
}
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors','On'); 
$xmlstr = file_get_contents('http://sandbox.api.ebaycommercenetwork.com/publisher/3.0/rest/CategoryTree?apiKey=78b0db8a-0ee1-4939-a2f9-d3cd95ec0fcc&visitorUserAgent&visitorIPAddress&trackingId=7000610&categoryId=72&showAllDescendants=true');
$xml = new SimpleXMLElement($xmlstr);
?>

<?php
$sum=0.0;
	if(isset($_GET['clear'])){
		unset($_SESSION['shopping_tray']);
		/*echo "<pre>";
		print_r($_SESSION);
		echo "</pre>";*/

	}
	if (isset($_GET['delete'])) {
		# code...
		unset($_SESSION['shopping_tray'][$_GET['delete']]);
	}
	if(isset($_GET['id'])){
		//echo "This is the selected item from result set : " . $_GET['id'];
		$val = $_GET['id'];
		$url ='http://sandbox.api.ebaycommercenetwork.com/publisher/3.0/rest/GeneralSearch?apiKey=78b0db8a-0ee1-4939-a2f9-d3cd95ec0fcc&visitorUserAgent&visitorIPAddress&trackingId=7000610&productId=';
		$url = $url . $_GET['id'];				
		$singleObj = file_get_contents($url);
		$singleObjStr = new SimpleXMLElement($singleObj);
		$test=$singleObjStr->categories->category->items->product;
		//$test=$singleObjStr->categories[0]->category[0]->items[0]->product;
		$_SESSION['shopping_tray'][$val]=array(
		"id"=>$val,	
		"minimumprice"=>(string)$test->minPrice, 
		"itemImage"=>(string)$test->images[0]->image[0]->sourceURL, 
		"pname"=>(string)$test->name, 
		"shopurl"=>(string)$test->productOffersURL);//"minimumprice"=>(string)$test->minPrice
		
		echo "<br>";

	}

	if (!empty($_SESSION['shopping_tray'])) {
		# code...
	
		echo "<table border=1>";
		foreach ($_SESSION as $value) 
		{
			foreach ($value as $value2) 
			{
		echo "<tr>";
		echo "<td>";
		echo '<a href="'.$value2['shopurl'].'"> <image src="'.$value2['itemImage'].'"></a >';	//php?id=".$value2['id'].">";
		echo "<td>"; 
		echo "Product name: ".$value2['pname'];
		echo "</td>";
		echo "<td>";
		echo "Price: ".$value2['minimumprice']."$";
		echo "</td>";
		echo "<td>";
		echo '<a href="buy.php?delete='.$value2['id'].'">'."delete"."</a>";
		echo "</td>";
		echo "</tr>";
		//echo "</table>";
		$sum=$sum+$value2['minimumprice'];
			}
		}
		echo "</table>";
	}
echo "Your bill:$".$sum;

?>
<form action="buy.php" method="GET">
<input type="hidden" name="clear" value="1"/>
<input type="submit" value="Empty Basket"/>
</form>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"

<?php
echo "<form action=".$_SERVER["PHP_SELF"];
echo " method='get'>";

echo "<label>Search Keywords: <input type='text' name='input'></label>";
	echo "<select name='dropList'>";
		foreach ($xml->category->categories->category as $a ) 
		{
			$valueStr = $a->name;
			echo "<optgroup label=";
			echo $valueStr;
			foreach ($a->categories->category as $child) 
			{
				echo "<option value=";
				echo $child['id'];
				echo ">";
				echo $child->name;
				echo "</option>"; 
			}
				echo "</optgroup>";
		}						
echo "</select>";
echo "<input type='submit' name='btn1' value='submit'/>";
?>
</form>

<?php
if( isset($_GET['input']) )
{
	$selection = $_GET['dropList'];	
	$keyword_inp = $_GET['input'];

	echo "</br>";
	$cat_list = file_get_contents('http://sandbox.api.shopping.com/publisher/3.0/rest/GeneralSearch?apiKey=78b0db8a-0ee1-4939-a2f9-d3cd95ec0fcc&visitorUserAgent&visitorIPAddress&trackingId=7000610&numItems=20&categoryId='.$selection.'&keyword='.$keyword_inp);
	$ouptutSubmit = new SimpleXMLElement($cat_list);

	echo "<table border =1>";
	foreach ( $ouptutSubmit->categories[0]->category[0]->items[0]->product as $forproduct ) 
	{
		$GLOBALS['varID'] = $forproduct['id'];		//declared  $varID as a global
		
		echo "<tr>";
		echo "<td>";
		echo "<a href=buy.php?id=".$forproduct['id'].">";
		echo "<image src=".$forproduct->images[0]->image[0]->sourceURL;
		echo "/>";
		echo "<td>"; 
		echo "Description: ".$forproduct->fullDescription;
		echo "</td>";
		echo "<td>"; 
		echo "Product name: ".$forproduct->name;
		echo "</td>";
		echo "<td>";
		echo "Price: ".$forproduct->minPrice."$";
		echo "</tr>";		
	}
}
echo "</table>";
?>
</body>
</html>
