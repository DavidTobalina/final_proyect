<?php
	//sessions.php is called in order to check if the user has loged in.
	require_once 'connection.php';
	require_once './sessions.php';
	check_session();

	$user = $_SESSION['user'];
	$u=getUserCod($_SESSION['user']);

	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST['i']) && isset($_POST['d']) &&  isset($_POST['t'])){
			$today = date("Y-m-d");
			$now = date('H:i');

			$text = $_POST['i'];
			$date = $_POST['d'];
			$time = $_POST['t'];

			if($date>$today || ($date==$today && $time>$now)){
				$task = newTask($text, $date, $time, $u);
			}
			header("./main.php");
		}
		if(isset($_POST['note'])){
			$text = $_POST['note'];

			$task = newNote($text, $u);
			echo '<script>
					function note() {
						var xhttp = new XMLHttpRequest();
						xhttp.onreadystatechange = function() {
						if(this.readyState==4 && this.status==200) {
							document.querySelector("#inside").innerHTML="<div>Create note</div><div><h2>Your notes</h2>"+this.response+"</div>";
							createNote();
						}
						};
						xhttp.open("GET", "./showNotes.php", true);
						xhttp.send();
					}
					function createNote() {
						var not = document.querySelectorAll("#inside > div:last-child > .n > div");
						for(var i=0;i<not.length;i++){
							not[i].addEventListener("click", function(){
							var xhttp = new XMLHttpRequest();
							xhttp.onreadystatechange = function() {
								if(this.readyState==4 && this.status==200) {
								document.querySelector("#inside").innerHTML="<div>Create note</div><div><h2>Your notes</h2>"+this.response+"</div>";
								createNote();
								}
							};
							xhttp.open("GET", "./showNotes.php?text="+this.parentNode.querySelector("p").innerHTML, true);
							xhttp.send();
							});
						}
	  
						document.querySelector("#inside > div:first-child").addEventListener("click", function(){
						var xhttp = new XMLHttpRequest();
						xhttp.onreadystatechange = function() {
							if(this.readyState==4 && this.status==200) {
							document.querySelector("#inside > div:last-child").innerHTML=this.response;
							}
						};
						xhttp.open("GET", "./createNote.php", true);
						xhttp.send();
						});
					}
					note();
				</script>';
		}
		if(isset($_POST['array'])){
			$stringAmounts=$_POST['arrayCant'];
			$arrayAmounts = explode(",", $stringAmounts);
			$arrayProducts=$_POST['array'];

			if(countProducts($u)>0){
				deleteProducts($u);
			}

			$length = count($arrayProducts);
			for($i=0; $i<$length; $i++){
				newProduct($arrayProducts[$i], $u, $arrayAmounts[$i]);
			}

			echo '<script>
					function show(){
						var xhttp = new XMLHttpRequest();
						xhttp.onreadystatechange = function() {
							if(this.readyState==4 && this.status==200) {
								document.querySelector("#inside").innerHTML="<div>Create list</div><div><h2>Your shopping list</h2>"+this.response+"</div>";
								createShop();
							}
						};
						xhttp.open("GET", "./showList.php", true);
						xhttp.send();
					}
					function createShop() {

						var arrayCant = [];
						var count = 0;
					
						var prod = document.querySelectorAll("#inside > div:last-child > .product > div");
						for(var i=0;i<prod.length;i++){
						  prod[i].addEventListener("click", function(){
							this.parentNode.style.color="red";
							this.parentNode.style.textDecoration="line-through";
							var xhttp = new XMLHttpRequest();
							xhttp.open("GET", "../pages/deleteProduct.php?text="+this.parentNode.querySelector("img").alt.toLowerCase(), true);
							xhttp.send();
						  });
						}
				  
						document.querySelector("#inside > div:first-child").addEventListener("click", function(){
						  var xhttp = new XMLHttpRequest();
						  xhttp.onreadystatechange = function() {
							if(this.readyState==4 && this.status==200) {
							  document.querySelector("#inside > div:last-child").innerHTML=this.response;
				  
							  document.getElementById("add").addEventListener("click", function(){
								var text = document.getElementById("product").value;
								if(!text.length==0) {
								  var ele = document.createElement("div");
								  ele.classList.add("product");
								  var img = document.createElement("img");
								  img.src = "../images/shopping-cart.png";
								  img.alt = text.toLowerCase();
								  ele.appendChild(img);
								  var t = document.createElement("span");
								  t.innerHTML=text;
								  ele.appendChild(t);
				  
								  var inp = document.createElement("input");
								  inp.type="hidden";
								  inp.name="array[]";
								  inp.value=text.toLowerCase();
								  document.getElementById("items").appendChild(inp);
				  
								  ele.addEventListener("click", function(){
									if(ele.classList.contains("crossed")){
									  var val = (this.querySelector("img").alt).toLowerCase();
									  var a = document.querySelectorAll("#items > input");
									  for(var i=0;i<a.length;i++){
										if(a[i].value==val){
										  a[i].name="array[]";
										}
									  }
									  ele.classList.add("notCrossed");
									  ele.classList.remove("crossed");
									}else{
									  var val2 = (this.querySelector("img").alt).toLowerCase();
									  var a2 = document.querySelectorAll("#items > input");
									  for(var i=0;i<a2.length;i++){
										if(a2[i].value==val2){
										  a2[i].name="";
										}
									  }
									  ele.classList.add("crossed");
									  ele.classList.remove("notCrossed");
									}
								  });
								  var contProduct = document.createElement("div");
								  contProduct.classList.add("contProduct");
								  contProduct.appendChild(ele);
				  
								  var contCant = document.createElement("div");
								  contCant.classList.add("contCant");
								  var label1 = document.createElement("label");
								  label1.innerHTML="Amount:";
								  var input1 = document.createElement("input");
								  input1.id="id"+count;
								  input1.type="number";
								  input1.min="1";
								  input1.max="99";
								  input1.value="1";
								  input1.size="2";
								  input1.onkeydown=function(){
									return false;
								  };
								  input1.onchange=function(){
									var num = parseInt((this.id).slice(-1));
									arrayCant[num]=parseInt(this.value);
									document.getElementById("arrayCant").value=arrayCant.toString();
								  };
				  
								  contCant.appendChild(label1);
								  contCant.appendChild(input1);
				  
								  arrayCant[count]=1;
								  document.getElementById("arrayCant").value=arrayCant.toString();
								  count++;
				  
								  var contTotal = document.createElement("div");
								  contTotal.classList.add("contTotal");
								  contTotal.appendChild(contProduct);
								  contTotal.appendChild(contCant);
								  document.getElementById("cont").appendChild(contTotal);
								}
								document.getElementById("product").value="";
							  });
				  
							  var products = document.querySelectorAll("#products > div");
							  for(var i=0;i<products.length;i++){
				  
								products[i].addEventListener("click", function(){
								  if(!this.classList.contains("clicked")) {
									var clone = this.cloneNode(true);
				  
									clone.addEventListener("click", function(){
									  if(this.classList.contains("crossed")){
										var val = (this.querySelector("img").alt).toLowerCase();
										var a = document.querySelectorAll("#items > input");
										for(var i=0;i<a.length;i++){
										  if(a[i].value==val){
											a[i].name="array[]";
										  }
										}
										this.classList.add("notCrossed");
										this.classList.remove("crossed");
									  }else{
										var val2 = (this.querySelector("img").alt).toLowerCase();
										var a2 = document.querySelectorAll("#items > input");
										for(var i=0;i<a2.length;i++){
										  if(a2[i].value==val2){
											a2[i].name="";
										  }
										}
										this.classList.add("crossed");
										this.classList.remove("notCrossed");
									  }
									});
									var inp2 = document.createElement("input");
									inp2.type="hidden";
									inp2.name="array[]";
									inp2.value=(this.querySelector("img").alt).toLowerCase();
									document.getElementById("items").appendChild(inp2);
				  
									var contProduct = document.createElement("div");
									contProduct.classList.add("contProduct");
									contProduct.appendChild(clone);
				  
									var contCant = document.createElement("div");
									contCant.classList.add("contCant");
									var label1 = document.createElement("label");
									label1.innerHTML="Amount:";
									var input1 = document.createElement("input");
									input1.id="id"+count;
									input1.type="number";
									input1.min="1";
									input1.max="99";
									input1.value="1";
									input1.size="2";
									input1.onkeydown=function(){
									  return false;
									};
									input1.onchange=function(){
									  var num = parseInt((this.id).slice(-1));
									  arrayCant[num]=parseInt(this.value);
									  document.getElementById("arrayCant").value=arrayCant.toString();
									};
									contCant.appendChild(label1);
									contCant.appendChild(input1);
				  
									arrayCant[count]=1;
									document.getElementById("arrayCant").value=arrayCant.toString();
									count++;
				  
									var contTotal = document.createElement("div");
									contTotal.classList.add("contTotal");
									contTotal.appendChild(contProduct);
									contTotal.appendChild(contCant);
									document.getElementById("cont").appendChild(contTotal);
								  }
								  this.classList.add("clicked");
								});
							  }
							}
						  };
						  xhttp.open("GET", "../pages/createList.php", true);
						  xhttp.send();
						});
					}
				show();
			</script>';
		}
	}
?>
<!DOCTYPE html>
<!-- HTML main page:
	If the login checking is correct we can access this file. This page is meant to be an index to access the application functions.
	From here the user can send a message and see the recieved messages.
 -->
<html>
	<head>
		<title>Main</title>
		<meta charset = "UTF-8">
		<link href="../css/main.css" rel="stylesheet" type="text/css">
		<script src="../js/main.js"></script>
	</head>
	<body>
		<div id="container">
			<div id="menu">
				<ul class="menu">
		    		<li class="menu2">Tasks</li>
		    		<li class="menu2">Notes</li>
					<li class="menu2">Shopping list</li>
					<li class="menu2">Calendar</li>
		        </ul>
			</div>
			<div id="content">
				<?php
					require("./header.php");
					echo "<h1>Welcome ".$_SESSION['user']."</h1>";
				?>
				<input id="hidden" type="hidden" value="<?php $u?>">
				<div id="inside">
					<div>Create task</div>
					<div>
						<h2>Your tasks</h2>
						<?php require_once("./showTasks.php"); ?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>