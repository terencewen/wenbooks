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
addClass(document.getElementById("navSearches"), "active");
</script>

<style>
.center-block {
  display: block;
  margin-left: auto;
  margin-right: auto;
}
</style>
 <div class="center-block" style="width:600px;">
 <div class="box" >
 <div class="gap"></div>
<h3>Search Books...</h3>
 <div class="gap"></div>
		<form id="frmBooks" class="form-horizontal" role="form" action="Pagination_Books.php" method="get">
			<div class="form-group">
				<label class="col-sm-2 control-label">Publisher:</label>
				<div class="col-sm-10">
					<input class="form-control" name="SearchText" placeholder="Search for book by publisher.">
					<input type="hidden" name="fldName" value="publisher" />
				</div>
             </div>
			 <div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" value="Search" />
				</div>
			</div>
        </form>
		 <div class="gap"></div>
		</br>There are 117,217 books. Book Data from <a href="//www.hathitrust.org/"><img src="images\hathi.png" alt="hathitrust" style="width:100px;"/></a>.
</div>
</div>
<?php
htmlFooter();
