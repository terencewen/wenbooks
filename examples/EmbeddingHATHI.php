<?php

require(__DIR__.'/init.php');

htmlHeader();
$bookid=trim($_GET['id']);  
echo '<h3>Scroll view</h3>';
echo '<iframe width="450" height="700" src="http://hdl.handle.net/2027/'.$bookid.'?urlappend=%3Bui=embed"></iframe>';

//echo '<h3>Flip view</h3>';
//echo '<iframe width="700" height="450" src="http://hdl.handle.net/2027/mdp.39015068550774?urlappend=%3Bui=embed"></iframe>';


htmlFooter();
