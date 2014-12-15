<?php

require(__DIR__.'/init.php');
htmlHeader();
?>
<script language="javascript" type="text/javascript">
function hasClass(ele,cls) {
	return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
}
function addClass(ele,cls) {
	if (!this.hasClass(ele,cls)) ele.className += " "+cls;
}
function removeClass(ele,cls) {
	if (hasClass(ele,cls)) {
    	var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
		ele.className=ele.className.replace(reg,' ');
	}
}
//call the functions
addClass(document.getElementById("navSearch"), "active");
</script>
<style>
.center-block {
  display: block;
  margin-left: auto;
  margin-right: auto;
}


</style>

 
 <!--div class="center-block"-->
 <div class="center-block" style="width:600px;">
 <div class="box" >
 <div class="gap"></div>
<h3>Search Books...</h3>
<div class="gap"></div>
		<form id="frmBooks" class="form-horizontal" role="form" action="Result_Books0.php" method="get">
			<div class="form-group">


					<input class="form-control" name="SearchText" placeholder="Search for books by any keyword.">


             </div>
			 <div class="form-group">

					<input type="submit" value="Search" />

			</div>
        </form>
		<div class="gap"></div>
		</br>There are 117,217 books. Books Data from <a href="//www.hathitrust.org/"><img src="images\hathi.png" alt="hathitrust" style="width:100px;"/></a>.
</div>
</div>
<?php
htmlFooter();
