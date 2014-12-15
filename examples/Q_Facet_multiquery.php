<?php

require('init.php');
htmlHeader();

// create a client instance
$client = new Solarium\Client($config);

// get a select query instance
$query = $client->createSelect();

// get the facetset component
$facetSet = $query->getFacetSet();

// create a facet query instance and set options
$facet = $facetSet->createFacetMultiQuery('books');
$facet->createQuery('books_title', 'title:*librarygdgdghsdghdhxdhh*');
$facet->createQuery('books_creator', 'creator:*Lampros*');

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

// show documents using the resultset iterator
foreach ($resultset as $document) {

    echo '<hr/><table>';
    echo '<tr><th>id</th><td>' . $document->id . '</td></tr>';
    echo '<tr><th>title</th><td>' . $document->title[0] . '</td></tr>';
    echo '<tr><th>creator</th><td>' . $document->creator[0] . '</td></tr>';
	echo '<tr><th>score</th><td>' . $document->score . '</td></tr>';
    echo '</table>';
}

htmlFooter();