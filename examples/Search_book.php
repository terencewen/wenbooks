<?php

require(__DIR__.'/init.php');
htmlHeader();
$urlid=trim($_GET['id']);  
$bookid=urldecode($_GET['id']);  

echo '$bookid=';
echo $bookid.'<br/>';
// create a client instance
$client = new Solarium\Client($config);

// get a select query instance
$query = $client->createSelect();

// set a query (all prices starting from 12)
$query->setQuery('id:"'.$bookid.'"');

// set start and rows param (comparable to SQL limit) using fluent interface
//$query->setStart(2)->setRows(20);
$query->setStart(0)->setRows(10);

// set fields to fetch (this overrides the default setting 'all fields')
//$query->setFields(array('id','title','creator'));
$query->setFields('*');

// sort the results by price ascending
//$query->addSort('price', Solarium_Query_Select::SORT_ASC);

// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();
echo '<hr/>';
 echo '<div class="col-md-6">';
// show documents using the resultset iterator
foreach ($resultset as $document) {

    echo '<table>';

    // the documents are also iterable, to get all fields
    foreach($document AS $field => $value)
    {
        // this converts multivalue fields to a comma-separated string
        if(is_array($value)) $value = implode(', ', $value);
        
        echo '<tr><th>' . $field . '</th><td>' . $value . '</td></tr>';
    }

    echo '</table>';
}
echo '</div>';
echo '<div class="col-md-6">';
echo '<h3>Book View on HathiTrust</h3>';
echo '<iframe width="450" height="700" src="http://hdl.handle.net/2027/'.$urlid.'?urlappend=%3Bui=embed"></iframe>';
echo '</div>';


htmlFooter();