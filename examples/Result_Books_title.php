<?php

require(__DIR__.'/init.php');
htmlHeader();

//parameters
$SearchText=trim($_GET['SearchText']);  

// create a client instance
$client = new Solarium\Client($config);

// get a select query instance
$query = $client->createSelect();

// set a query (all prices starting from 12)
$query->setQuery('title:*'.$SearchText.'*');

// set start and rows param (comparable to SQL limit) using fluent interface
//$query->setStart(2)->setRows(20);

// set fields to fetch (this overrides the default setting 'all fields')
//$query->setFields(array('id','title','crater', 'publisher'));

// sort the results by price ascending
$query->addSort('price', $query::SORT_ASC);

// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display the max score
echo '<br>MaxScore: '.$resultset->getMaxScore();

echo '<p class="bg-info">Note: <i>Clicked </i><b>[id]</b><i> to view the book; Clicked</i> <b>[source]</b><i> to link to <b>HATHITrust</b></i>.</p>';
echo '<hr style="background:#F87431; border:0; height:7px" />';


// show all fields
foreach ($resultset as $document) {

	foreach($document AS $field => $value)
{
    // this converts multi-value fields to a comma-separated string
    if(is_array($value)) $value = implode(', ', $value);
	//special field
	if ($field=='id')	{
		print '<strong>' . $field . '</strong>: <a href="Search_book.php?id=' . $value . '">'. $value .'</a><br />'; 
	}elseif ($field=='source')	{
		print '<strong>' . $field . '</strong>: <a href="' . $value . '">HATHITrust</a><br />'; 
	}else{
	    print '<strong>' . $field . '</strong>: ' . $value . '<br />'; 
	}
}
echo '<hr/>';
}


htmlFooter();
