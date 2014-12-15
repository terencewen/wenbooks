<?php
//Latest Books for Home page 

// How many adjacent pages should be shown on each side?
$limit = 9; 	
?>
<style>
a.highlight:link {
    color: #FF0000;
	text-decoration: underline;
}
a.highlight:hover {
    background-color: yellow;
}
</style>
<?php

// create a client instance
$client = new Solarium\Client($config);

// get a select query instance
$query = $client->createSelect();

$query->setRows($limit);

// set fields to fetch (this overrides the default setting 'all fields')
$query->setFields(array('id','title','creator', 'subjects','language','date_s','timestamp'));

// sort the results by price ascending
$query->addSort('timestamp', $query::SORT_DESC);

// this executes the query and returns the result
$resultset = $client->select($query);

$counter=0;
// show documents using the resultset iterator
foreach ($resultset as $document) {
$counter++;
    echo '<div class="col-xs-4">';
	//echo '<div class="portfolio-item">';
	echo '<div class="dash-unit portfolio-item">';
	
	echo '<div class="item-inner">';
//echo $counter;
	$value=$document->title ;
	if(is_array($value)) $value = implode(', ', $value);
	echo '<a href="Search_book.php?id=' . $document->id  . '" class="highlight">'.  substr($value,0,100)  .'</a> <br/>';
	$value=$document->creator ;
	if(is_array($value)) $value = implode(', ', $value);
	if ($value>'') echo $value .' <br/>';
	$value=$document->subjects ;
	if(is_array($value)) $value = implode(', ', $value);
	if ($value>'') echo $value .' <br/>';
	$value=$document->language ;
	if(is_array($value)) $value = implode(', ', $value);
	if ($value>'') echo $value .' <br/>';
	$value=$document->date_s ;
	if(is_array($value)) $value = implode(', ', $value);
	if ($value>'') echo $value .' <br/>';
	$value=$document->timestamp ;
	//if(is_array($value)) $value = implode(', ', $value);
	//if ($value>'') echo $value .' <br/>';											
	//if ($value>'') echo date_format($document->timestamp, 'Y-m-d H:i:s') .' <br/>';											
	//if ($value>'') echo date('Y-m-d h:i:sa', $document->timestamp) .' <br/>';		
									
	date_default_timezone_set("America/New_York");									
	$date = date_create($document->timestamp);
	echo date_format($date, 'Y-m-d H:i:s');
	
	if ($counter==3 OR $counter==6 OR $counter==9){
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}else{
		echo '</div>';
		echo '</div>';
		echo '</div> ';
	}
	if ($counter==3 OR $counter==6  OR $counter==6){
		echo '</div><!--/.row-->';
		echo '</div><!--/.item-->';
		echo '<div class="item">';
		echo '<div class="row">';
	
	}


}

echo '</div>';
echo '</div><!--/.item-->';

?>


