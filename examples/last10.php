<?php
//multiple facet

require(__DIR__.'/init.php');
htmlHeader();
// How many adjacent pages should be shown on each side?
$limit = 10; 	
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

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Multiquery facet counts:<br/>';


// show documents using the resultset iterator
foreach ($resultset as $document) {
	$value=$document->title ;
	if(is_array($value)) $value = implode(', ', $value);
	echo '<a href="Search_book.php?id=' . $document->id  . '" class="highlight">'. $value  .'</a> <br/>';
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
	if(is_array($value)) $value = implode(', ', $value);
	if ($value>'') echo $value .' <br/>';
echo '<hr/>';
}



htmlFooter();
