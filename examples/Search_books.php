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
if ($opt=="TP") {
			$sQuery='title:*'.$SearchText.'*';
		}elseif ($opt=="AP") {
			$sQuery='creator:*'.$SearchText.'*';
		}else{
			//$sQuery='title:*'.$SearchText.'* AND creator:*'.$SearchText.'*';
			$sQuery='title:'.$SearchText.' AND creator:'.$SearchText;
		}
echo $sQuery.'</br>';


//$facetSet->createFacetQuery('title')->setQuery($sQuery);

// create a facet query instance and set options
$facet = $facetSet->createFacetMultiQuery('books');
$facet->createQuery('books1', $sQuery);
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
