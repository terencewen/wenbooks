<?php

require(__DIR__.'/init.php');
htmlHeader();
?>
<style>
.center-block {
  display: block;
  margin-left: auto;
  margin-right: auto;
}


</style>

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
addClass(document.getElementById("navSearchad"), "active");
</script>
 <div class="center-block" style="width:600px;">
 <div class="box" 
<h3>Search Books...</h3>
		<form id="frmBooks" class="form-horizontal" role="form" action="Result_Books.php" method="get">
                        <div class="form-group">
								<label class="col-sm-2 control-label">Title:</label>
								 <div class="col-sm-10">
                                     <input class="form-control" name="title" placeholder="Search for book by title.">
								</div>
                        </div>
                        <div class="form-group">
								<label class="col-sm-2 control-label">Creator:</label>
								<div class="col-sm-10">
                                    <input name="creator"   class="form-control"  placeholder="Search for book by creator.">
								</div>
                         </div>
                         <div class="form-group">
								<label class="col-sm-2 control-label">Publisher:</label>
								<div class="col-sm-10">
									<input name="publisher"  class="form-control"  placeholder="Search for book by publisher.">
								</div>
                         </div>
								
                                <!-- Dropdown menu to prepend search option values -->
                         <div class="form-group">
								<label class="col-sm-2 control-label">Type:</label>
								<div class="col-sm-10">
									<select onchange="" name="type"  class="form-control" >
                                        <option selected="selected" value="">--Select--</option>
										<option value="Text">Text</option>
										<option value="Collection">Collection</option>
										<option value="PDF">PDF</option>
                                    </select>
								</div>
                         </div>
						<div class="form-group">
								<label class="col-sm-2 control-label">Language:</label>
								<div class="col-sm-10">
									<select onchange="" name="language"  class="form-control" >
                                        <option selected="selected" value="">--Select--</option>
										<option value="eng">EnglishGreece</option>
                                        <option value="grc">Greece</option>
										<option value="gre">Greek</option>
										<option value="ita">Italian</option>
                                    </select>
								</div>
                        </div>
						<div class="form-group">
								<label class="col-sm-2 control-label">Date:</label>
								<div class="col-sm-10">
									<input name="bDate" type="text"  class="form-control"  placeholder="Search for book by year.">
								</div>
                         </div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Search" />
							</div>
					    </div>
						
                     </form>
								</br>There are 117,217 books. Book Data from <a href="//www.hathitrust.org/"><img src="images\hathi.png" alt="hathitrust" style="width:100px;"/></a>.

</div>
</div>
<?php
htmlFooter();
