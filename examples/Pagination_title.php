<?php

require(__DIR__.'/init.php');

htmlHeader();

// How many adjacent pages should be shown on each side?
$limit = 10; 	
	
// create a client instance
$client = new Solarium\Client($config);

// get a select query instance
$query = $client->createSelect();


$query->setRows($limit);
//$query->addSort('title', $query::SORT_ASC);


// get the facetset component
$facetSet = $query->getFacetSet();

// create a facet field instance and set options
$facetSet->createFacetField('title')->setField('title');


// handle facet choice by adding the value as a filterquery
$SearchText = null;
if(isset($_GET['SearchText']) && !empty($_GET['SearchText'])) {
	$SearchText = $_GET['SearchText'];
	/*
	$fq = new Solarium_Query_Select_FilterQuery;
	$fq->setKey('countryfilter');
	$fq->setQuery('countrycode:'.Solarium_Escape::term($country));
	$query->addFilterQuery($fq);
	*/
	// create a filterquery
	$query->createFilterQuery('title')->setQuery('title:*' .$SearchText.'*' );

}

// handle paginating
$start = 0;
if(isset($_GET['start']) && !empty($_GET['start'])) {
	$start = $_GET['start'];
	$query->setStart($start);
}

$result = $client->select($query);

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

		<h1>Pagination of Books</h1>
		<hr/>
			<h3>By Title Filter</h3>
		<div >
			<?php
			echo '<h4>Results found: '.$result->getNumFound().' (showing '.($start+1).' to '.($start+$query->getRows()).')</h4>';
			//pagination
			echo '<div class="col-sm-offset-2 col-sm-10">';
			if ($start !== 0) {
				echo '<a href="?SearchText=' . $SearchText. '&start='.($start-$query->getRows()).'" class="highlight">&laquo; previous</a>';
				echo '&nbsp;&nbsp;&nbsp';
			}
			if ($result->getNumFound() > ($start+$query->getRows())) {
				echo ' <a href="?SearchText=' . $SearchText. '&start='.($start+$query->getRows()).'" class="highlight">next &raquo;</a>';
			}
			echo '</div>';
			// resultset is also iterable
			foreach ($result AS $doc) {
				echo '<table style="margin-bottom:20px; text-align:left; border:1px solid black; width:600px">';
				foreach ($doc AS $field => $value) {
					if(is_array($value)) $value = implode(', ', $value);
					echo '<tr><th><strong>'.$field.'</strong></th><td>';
					//.$value.
					if ($field=='id')	{
						echo '<a href="Search_book.php?id=' . $value . '" class="highlight">'. $value .'</a>'; 
					}elseif ($field=='source')	{
						echo '<a href="' . $value . '" class="highlight">HATHITrust</a>'; 
					}else{
						echo $value; 
					}
					echo '</td></tr>';
					
					
					
				}	
			}
			echo '</table>';
			?>
		</div>
<?php		
	htmlFooter();