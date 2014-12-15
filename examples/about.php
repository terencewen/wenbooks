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
addClass(document.getElementById("navAbout"), "active");
</script>

    <section id="title" class="emerald">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1>About Website</h1>
                    <p></p>
                </div>
                <div class="col-sm-6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="index.php">Home</a></li>
                        <li class="active">About Us</li>
                    </ul>
                </div>
            </div>
        </div>
    </section><!--/#title-->

    <section id="about-us" class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="center"><h2>What Solr Is</h2></div>
                <p>Solr is highly reliable, scalable and fault tolerant, providing distributed indexing, replication and load-balanced querying, automated failover and recovery, centralized configuration and more. Solr powers the search and navigation features of many of the world's largest internet sites.<a href="http://lucene.apache.org/solr/">(Apache Solr)</a></p>
				 <div class="center"><img class="img-responsive img-thumbnail img-circle" src="images/solr.png" alt="" ></div>
            </div><!--/.col-sm-6-->
            <div class="col-sm-6">
               <div class="center"> <h2>What HATHI TRUST Is</h2></div>
                <p>HathiTrust is a partnership of major research institutions and libraries working to ensure that the cultural record is preserved and accessible long into the future. There are more than 100 partners in HathiTrust, and membership is open to institutions worldwide.<a href="http://www.hathitrust.org/">(HATHI TRUST)</a></p>
				 <div class="center"><img class="img-responsive img-thumbnail img-circle" src="images/solarium.gif" alt="" ></div>
            </div><!--/.col-sm-6-->
        </div><!--/.row-->

        <div class="gap"></div>
		        <div class="row">
            <div class="col-sm-6">
                <div class="center"><h2>What Solarium Is</h2></div>
                <p>Solarium is an opensource Solr client library for PHP applications.By offering an API for common Solr functionality you no longer need to compose complex querystrings and parameters manually, greatly reducing development time and complexity. <a href="http://www.solarium-project.org/">(Solarium)</a></p>
				<div class="center"><img class="img-responsive img-thumbnail img-circle" src="images/htrc.jpg" alt="" ></div>
            </div><!--/.col-sm-6-->
            <div class="col-sm-6">
                <div class="center"><h2>Me</h2></div>
  <p>I am a graduate student at Rutgers University, my program is Master Library Information &amp; Science.<br>
I am a programmer now.<br>
</p>
<div class="center"><img class="img-responsive img-thumbnail img-circle" src="images/me.jpg" alt="" ></div>
            </div><!--/.col-sm-6-->
        </div><!--/.row-->
		



		
                <div >

            </div>

    </section><!--/#about-us-->




<?php
htmlFooter();
