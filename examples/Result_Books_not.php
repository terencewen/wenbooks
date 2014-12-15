<?php

require(__DIR__.'/init.php');
htmlHeader();

//parameters
$title=trim($_GET['bTitle']);  
$creator=trim($_GET['bCreator']);  
$publisher=trim($_GET['bPublisher']);  
$type=trim($_GET['bType']);  
$language=trim($_GET['bLanguage']);  
$bDate=trim($_GET['bDate']);  

// create a client instance
$client = new Solarium\Client($config);

// get a select query instance
$query = $client->createSelect();

// get the facetset component
$facetSet = $query->getFacetSet();

// create a facet query instance and set options
$facet = $facetSet->createFacetMultiQuery('books');
if ($title > '') $facet->createQuery('title', '-title:*'.$title.'*');
if ($creator > '') $facet->createQuery('creator', '-creator:*'.$creator.'*');
if ($publisher > '') $facet->createQuery('publisher', '-publisher:*'.$publisher.'*');
if ($type > '') $facet->createQuery('type', '-type:'.$type);
if ($language > '') $facet->createQuery('language', '-language:'.$language);
if ($bDate > '') $facet->createQuery('date', '-date_s:*'.$bDate.'*');

//$facet->createQuery('nostock_pricecat1', 'inStock:false AND price:[1 TO 300]');


// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Multiquery facet counts:<br/>';
$facet = $resultset->getFacetSet()->getFacet('books');

foreach($facet as $key => $count) {
    echo $key . ' [' . $count . ']<br/>';
}
echo '<p class="bg-info">Note: Clicked id to view the book; Clicked source to link to HATHITrust</p>';
echo '<hr style="background:#F87431; border:0; height:7px" />';


// show all fields

foreach ($resultset as $document) {

	foreach($document AS $field => $value)
{
    // this converts multi-value fields to a comma-separated string
    if(is_array($value)) $value = implode(', ', $value);
	//special field
	if ($field=='id')	{
		print '<strong>' . $field . '</strong>: <a href="EmbeddingHATHI.php?id=' . $value . '">'. $value .'</a><br />'; 
	}elseif ($field=='source')	{
		print '<strong>' . $field . '</strong>: <a href="' . $value . '">HATHITrust</a><br />'; 
	}else{
	    print '<strong>' . $field . '</strong>: ' . $value . '<br />'; 
	}
}
echo '<hr/>';
}


htmlFooter();
