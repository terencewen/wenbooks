<?php

require(__DIR__.'/init.php');
htmlHeader();
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
$SearchText = null;
if(isset($_GET['SearchText']) && !empty($_GET['SearchText'])) {
	$SearchText = $_GET['SearchText'];
	$query->setQuery($SearchText);
}


// get highlighting component and apply settings
// highlights are applied to three fields with a different markup for each field
// much more per-field settings are available, see the manual for all options
$hl = $query->getHighlighting();
$hl->setFields('title, creator,publisher,type,language,date');
$hl->setSimplePrefix('<b>');
$hl->setSimplePostfix('</b>');
/*
$hl->getField('title')->setSimplePrefix('<b>')->setSimplePostfix('</b>');
$hl->getField('creator')->setSimplePrefix('<u>')->setSimplePostfix('</u>');
$hl->getField('publisher')->setSimplePrefix('<i>')->setSimplePostfix('</i>');
*/
// this executes the query and returns the result
$resultset = $client->select($query);
$highlighting = $resultset->getHighlighting();
// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound().'</br>';
echo 'Search keyword(s): <b>'.$SearchText.'</b></br>';

// show documents using the resultset iterator
foreach ($resultset as $document) {
    // highlighting results can be fetched by document id (the field defined as uniquekey in this schema)
    $highlightedDoc = $highlighting->getResult($document->id);
    if ($highlightedDoc) {
	 echo '<hr/>';
		echo '<a href="Search_book.php?id='.urlencode($document->id).'" class="highlight"><b>'.  implode(', ', $document->title) .'</b></a><br />'; 
		echo '<i>id</i>:   '.$document->id.'<br />'; 
        foreach ($highlightedDoc as $field => $highlight) {
			echo '<i>'.$field.'</i>: ';
            echo implode(' (...) ', $highlight) . '<br/>';
        }
    }

}

htmlFooter();
