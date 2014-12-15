<?php

require(__DIR__.'/init.php');

htmlHeader();

// create a client instance
$client = new Solarium\Client($config);

// get a select query instance
$query = $client->createSelect();


$query->setRows(10);
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
 
		<h1>Pagination of Books</h1>
		<hr/>
		<div style="float:left;">
			<h3>By Title Filter</h3>
			<?php if($SearchText!== null) { ?>
				<a href="?">Reset Filter</a>
			<?php }	?>
			<ul>
			<?php

			// facet field is iterable
			//foreach ($result->getFacet('title') AS $value => $count) {
			/*
			foreach ($result->getFacet('title') AS $value => $count) {
			    echo '<li><a href="?title=' . $value . '">' . $value . ' (' . $count . ')</a></li>';
			}
			*/
			?>
			
			</ul>
		</div>
		<div style="float:left;margin-left:30px;">
			<?php
			echo '<h3>Results found: '.$result->getNumFound().' (showing '.($start+1).' to '.($start+$query->getRows()).')</h3>';
			
			if ($start !== 0) {
				echo '<a href="?SearchText=' . $SearchText. '&start='.($start-$query->getRows()).'">&laquo; previous</a>';
				echo '&nbsp;&nbsp;&nbsp';
			}
			
			
			
			
			if ($result->getNumFound() > ($start+$query->getRows())) {
				echo ' <a href="?SearchText=' . $SearchText. '&start='.($start+$query->getRows()).'">next &raquo;</a>';
			}
			
			// resultset is also iterable
			foreach ($result AS $doc) {
				echo '<table style="margin-bottom:20px; text-align:left; border:1px solid black; width:600px">';
				foreach ($doc AS $field => $value) {
					if(is_array($value)) $value = implode(', ', $value);
					echo '<tr><th>'.$field.'</th><td>'.$value.'</td></tr>';
				}	
			}
			echo '</table>';
			?>
		</div>
<?php		
	htmlFooter();