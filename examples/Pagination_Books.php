<?php
require(__DIR__.'/init.php');

htmlHeader();
?>
<script language="javascript" type="text/javascript">
function hasClass(ele,cls) {
	return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
}
function addClass(ele,cls) {
	if (!this.hasClass(ele,cls)) ele.className += " "+cls;
}
function removeClass(ele,cls) {
	if (hasClass(ele,cls)) {
    	var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
		ele.className=ele.className.replace(reg,' ');
	}
}
//call the functions
addClass(document.getElementById("navSearches"), "active");
</script>
<?php
// How many adjacent pages should be shown on each side?
$limit = 10; 	
$fldName=null;
if(isset($_GET['fldName']) && !empty($_GET['fldName'])) {
	$fldName = $_GET['fldName'];
}
	
// create a client instance
$client = new Solarium\Client($config);

// get a select query instance
$query = $client->createSelect();


$query->setRows($limit);
//$query->addSort('title', $query::SORT_ASC);


// get the facetset component
$facetSet = $query->getFacetSet();

// create a facet field instance and set options
$facetSet->createFacetField($fldName)->setField($fldName);


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
	$query->createFilterQuery($fldName)->setQuery($fldName.':*' .$SearchText.'*' );

}

$resultset = $client->select($query);
//pagination
$limit=10;				//items to show per page
$adjacents = 3;		//adjacent pages should be shown on each side
$start = 0;
if(isset($_GET['start']) && !empty($_GET['start'])) {
	$start = $_GET['start'];
	$query->setStart($start);
}
$totalNum=$resultset->getNumFound();
$laststart=$totalNum-($totalNum % $limit);
$lastpage=ceil($totalNum/$limit);	
$page=intval($start/$limit)+1;
$lpm1 = $lastpage - 1;	

$target='?SearchText=' . $SearchText;
$pagination = "";
if ($totalNum > $limit) {
	$pagination .= "<div class=\"pagination\">";
	if ($start >= $limit) {
		//first
		$pagination.='<a href="'.$target.'&start=0">&laquo; First</a>';
		//previous
		$pagination.='<a href="'.$target.'&start='.($start-$query->getRows()).'" class="highlight">&lt; Previous</a>';
	}else{
		$pagination.= '<span class="disabled">&laquo; First</span>';	
		$pagination.= '<span class="disabled">&lt; Previous</span>';	
	}
	//numbers------------------------
	if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
	{
			for ($counter = 1; $counter <= $lastpage; $counter++){
				if ($counter == $page)
					$pagination.=  '<span class="current">'.$counter.'</span>';
				else
				$pagination.= '<a href="'.$target.'&start='.($counter-1)*$limit.'">'.$counter.'</a>';					
			}
	}
	elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
	{
				//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page){
						$pagination.= '<span class="current">'.$counter.'</span>';
					}else{
					$pagination.= '<a href="'.$target.'&start='.($counter-1)*$limit.'">'.$counter.'</a>';					
					}
				}

				$pagination.= "...";
				$pagination.= '<a href="'.$target.'&start='.($lastpage-2)*$limit.'">'.($lastpage-1).'</a>';
				$pagination.= '<a href="'.$target.'&start='.($lastpage-1)*$limit.'">'.$lastpage.'</a>';		

			}
			//in middle; hide some front and some back
			
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= '<a href="'.$target.'&start=0">1</a>';
				$pagination.= '<a href="'.$target.'&start='.$limit.'">2</a>';
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page){
						$pagination.= '<span class="current">'.$counter.'</span>';
					}else{
					$pagination.= '<a href="'.$target.'&start='.($counter-1)*$limit.'">'.$counter.'</a>';					
					}				
				}
				$pagination.= '...';
				$pagination.= '<a href="'.$target.'&start='.($lastpage-2)*$limit.'">'.($lastpage-1).'</a>';
				$pagination.= '<a href="'.$target.'&start='.($lastpage-1)*$limit.'">'.$lastpage.'</a>';		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= '<a href="'.$target.'&start=0">1</a>';
				$pagination.= '<a href="'.$target.'&start='.$limit.'">2</a>';
				$pagination.= '...';
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page){
						$pagination.= '<span class="current">'.$counter.'</span>';
					}else{
					$pagination.= '<a href="'.$target.'&start='.(($counter-1)*$limit).'">'.$counter.'</a>';					
					}						
				}
			}

	}	//End numbers
	$tmp=$start+$limit;
	//if (intval($tmp) <= intval($totalNum)){
	if (($start+$limit) < $totalNum){
		//next
		$pagination.=' <a href="'.$target.'&start='.($start+$query->getRows()).'" class="highlight">next &gt;</a>';
		//last
		$pagination.='<a href="'.$target.'&start='.$laststart.'">Last &raquo; </a>';
	}else{
		$pagination.= '<span class="disabled">next &gt;</span>';	
		$pagination.= '<span class="disabled">Last &raquo;</span>';	
	}
	
	$pagination.= "</div>\n";
}
//End pagination

?>
<style>

</style>

<h1>Pagination of Books</h1>
<hr/>
	<h3>By <?php echo $fldName; ?> Filter</h3>
<div >
	<?php
	echo '<h4>Results found: '.$resultset->getNumFound().' (showing '.($start+1).' to '.($start+$query->getRows()).')</h4>';
	//pagination
	echo '<div>';
	echo $pagination;
	echo '</div>';
	// resultset is also iterable
	foreach ($resultset AS $doc) {
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
		//pagination
	echo '<div >';
	echo $pagination;
	echo '</div>';
	?>
</div>
<?php		
	htmlFooter();