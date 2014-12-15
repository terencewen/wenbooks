<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

require __DIR__.'/../vendor/autoload.php';

//require __DIR__.'/../solarium/library/Solarium/Autoloader.php';
//require '../solarium/library/Solarium/Autoloader.php';
//require('../library/Solarium/Autoloader.php');
//new Solarium_Client();

//define("SITE_ROOT", "/var/www/html");
//require(SITE_ROOT.'/solarium/library/Solarium/Autoloader.php');
//require('../../solarium/library/Solarium/Autoloader.php');




if (file_exists('config.php')) {
    require('config.php');
} else {
    require('config.dist.php');
}


function htmlHeader()
{
    //echo '<html><head><title>Solarium examples</title></head><body>';
	
	echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<meta name="description" content="">';
    echo '<meta name="author" content="">';
    echo '<title>Wen | Books Theme</title>';
    echo '<link href="css/bootstrap.min.css" rel="stylesheet">';
    echo '<link href="css/font-awesome.min.css" rel="stylesheet">';
    echo '<link href="css/prettyPhoto.css" rel="stylesheet">';
    echo '<link href="css/animate.css" rel="stylesheet">';
    echo '<link href="css/main.css" rel="stylesheet">';
	
	echo '<link href="css/style.css" rel="stylesheet">';
	
    echo '<!--[if lt IE 9]>';
    echo '<script src="js/html5shiv.js"></script>';
    echo '<script src="js/respond.min.js"></script>';
    echo '<![endif]-->       ';
    echo '<link rel="shortcut icon" href="images/ico/favicon.ico">';
    echo '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">';
    echo '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">';
    echo '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">';
    echo '<link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">';
echo '</head><!--/head-->';
echo '<body>';
    echo '<header class="navbar navbar-inverse navbar-fixed-top wet-asphalt" role="banner">';
        echo '<div class="container">';
            echo '<div class="navbar-header">';
                echo '<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">';
                    echo '<span class="sr-only">Toggle navigation</span>';
                    echo '<span class="icon-bar"></span>';
                    echo '<span class="icon-bar"></span>';
                    echo '<span class="icon-bar"></span>';
                echo '</button>';
                echo '<a class="navbar-brand" href="index.html"><img src="images/logo.png" alt="logo"></a>';
            echo '</div>';
            echo '<div class="collapse navbar-collapse">';
                echo '<ul class="nav navbar-nav navbar-right">';
                    echo '<li id="navHome"  class=""><a href="index.php">Home</a></li>';
					echo '<li id="navSearch"  class=""><a href="Form_Search.php">Search</a></li>';
                    echo '<li id="navSearchad"  class=""><a href="Form_Search_ad.php">Advanced Search</a></li>';
                    echo '<li  id="navSearches" class="dropdown">';
                        echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Searches <i class="icon-angle-down"></i></a>';
                        echo '<ul class="dropdown-menu">';
                            echo '<li><a href="Form_Search_title.php">Title</a></li>';
                            echo '<li><a href="Form_Search_creator.php">Creator</a></li>';
							echo '<li><a href="Form_Search_publisher.php">Publisher</a></li>';
                            echo '<li class="divider"></li>';
                            echo '<li><a href="Form_Search_type.php">Type</a></li>';
                            echo '<li><a href="Form_Search_language.php">Language</a></li>';
                        echo '</ul>';
                    echo '</li>';
					echo '<li id="navSolr" class="dropdown">';
                        echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Solr <i class="icon-angle-down"></i></a>';
                        echo '<ul class="dropdown-menu">';
                            echo '<li><a href="http://54.186.36.7:8983/solr/#/"  target="_blank">Admin</a></li>';
                            echo '<li><a href="http://54.186.36.7:8983/solr/#/collection1/documents" target="_blank">Update</a></li>';
							echo '<li><a href="http://54.186.36.7:8983/solr/#/collection1/query" target="_blank">Query</a></li>';
                            echo '<li class="divider"></li>';
                            echo '<li><a href="http://54.186.36.7:8983/solr/collection1/schema?wt=schema.xml" target="_blank">Schema</a></li>';
                            echo '<li><a href="http://54.186.36.7:8983/solr/collection1/schema?wt=schema.xml" target="_blank">Solr Config</a></li>';
							echo '<li class="divider"></li>';
							echo '<li><a href="http://54.186.36.7/solarium/examples/index_solarium.html" target="_blank">Solarium examples</a></li>';
                        echo '</ul>';
                    echo '</li>';
                    echo '<li id="navContact" ><a href="contact.php">Contact</a></li>';
					echo '<li id="navAbout" ><a href="about.php">About</a></li>';
                echo '</ul>';
            echo '</div>';
        echo '</div>';
    echo '</header><!--/header-->';
                    echo '<div class="container">';
                        echo '<div class="row">';
	
	
}

function htmlFooter()
{
                        echo '</div><!-- End Row -->';
					echo '</div><!-- End container -->';
echo '    <footer>';
echo '    <hr/>';
echo '        <div class="container">';
echo '            <div class="row">';
echo '                <div class="col-lg-12 text-center">';
echo '                    <p>Copyright &copy; MLIS 552 Wen Term Project</p>';
echo '                </div>';
echo '            </div>';
echo '        </div>';
echo '    </footer>';
					
echo '<script src="js/jquery.js"></script>';
echo '<script src="js/bootstrap.min.js"></script>';
echo '<script src="js/jquery.prettyPhoto.js"></script>';
echo '<script src="js/main.js"></script>	';
echo '</body></html>';
}
