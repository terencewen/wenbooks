<?php

require(__DIR__.'/init.php');
htmlHeader();

//parameters
$opt=trim($_GET['opt']);  
$SearchText=trim($_GET['SearchText']);  

// create a client instance
$client = new Solarium\Client($config);

// get a select query instance
$query = $client->createSelect();

// get the facetset component
$facetSet = $query->getFacetSet();

// create a facet query instance and set options
$facetSet->createFacetQuery('title')->setQuery('title:*' .$SearchText.'*');

// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet query count
$count = $resultset->getFacetSet()->getFacet('title')->getValue();
echo '<hr/>Facet query count : ' . $count;
echo '<hr style="background:#F87431; border:0; height:7px" />';

// show documents using the resultset iterator
/*
foreach ($resultset as $document) {

    echo '<hr/><table>';
    echo '<tr><th>id:</th><td>' . $document->id . '</td></tr>';
    echo '<tr><th>Title:</th><td>' . $document->title[0] . '</td></tr>';
    echo '<tr><th>Creator:</th><td>' . $document->creator[0] . '</td></tr>';
    echo '</table>';
}
*/
// show all fields
foreach ($resultset as $document) {

	foreach($document AS $field => $value)
{
    // this converts multi-value fields to a comma-separated string
    if(is_array($value)) $value = implode(', ', $value);
	//special field
	if ($field=='source')
	{
		print '<strong>' . $field . '</strong>: <a href="' . $value . '">HATHITrust</a><br />'; 
	}else{
	    print '<strong>' . $field . '</strong>: ' . $value . '<br />'; 
	}
}
echo '<hr/>';
}

htmlFooter();
