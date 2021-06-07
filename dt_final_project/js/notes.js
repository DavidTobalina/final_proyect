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