<?php
//multiple facet

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
addClass(document.getElementById("navSearchad"), "active");
</script>
<?php
// How many adjacent pages should be shown on each side?
$limit = 10; 	
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
//parameters
$title=null;
$creator=null;
$publisher=null;
$type=null;
$language=null;
$bDate=null;
if(isset($_GET['title']) && !empty($_GET['title'])) 
	$title=trim($_GET['title']);  
if(isset($_GET['creator']) && !empty($_GET['creator'])) 
	$creator=trim($_GET['creator']);  
if(isset($_GET['publisher']) && !empty($_GET['publisher'])) 	
	$publisher=trim($_GET['publisher']);  
if(isset($_GET['type']) && !empty($_GET['type'])) 	
	$type=trim($_GET['type']);  
if(isset($_GET['language']) && !empty($_GET['language'])) 	
	$language=trim($_GET['language']);  
if(isset($_GET['bDate']) && !empty($_GET['bDate'])) 	
	$bDate=trim($_GET['bDate']);  

// create a client instance
$client = new Solarium\Client($config);

// get a select query instance
$query = $client->createSelect();

// get the facetset component
$facetSet = $query->getFacetSet();

// create a facet query instance and set options
$facet = $facetSet->createFacetMultiQuery('books');
// at least one facet query
$facet->createQuery('title', 'title:*'.$title.'*');
if ($creator > ' ') $facet->createQuery('creator', 'creator:*'.$creator.'*');
if ($publisher > ' ') $facet->createQuery('publisher', 'publisher:*'.$publisher.'*');
if ($type > ' ') $facet->createQuery('type', 'type:'.$type);
if ($language > ' ') $facet->createQuery('language', 'language:'.$language);
if ($bDate > ' ') $facet->createQuery('date', 'date_s:*'.$bDate.'*');

//$facet->createQuery('nostock_pricecat1', 'inStock:false AND price:[1 TO 300]');


// this executes the query and returns the result
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

$target='?title=' . $title. '&creator=' . $creator. '&publisher=' . $publisher. '&type=' . $type. '&language=' . $language. '&bDate=' . $bDate;
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

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Multiquery facet counts:<br/>';
$facet = $resultset->getFacetSet()->getFacet('books');
foreach($facet as $key => $count) {
    echo $key . ' [' . $count . ']<br/>';
}
echo '<p class="bg-info">Note: <i>Clicked </i><b>[id]</b><i> to view the book; Clicked</i> <b>[source]</b><i> to link to <b>HATHITrust</b></i>.</p>';
echo '<hr style="background:#F87431; border:0; height:7px" />';

echo '<h4>Results found: '.$resultset->getNumFound().' (showing '.($start+1).' to '.($start+$query->getRows()).')</h4>';
	//pagination
	echo '<div class="col-sm-offset-2 col-sm-10">';
	echo $pagination;
	echo '</div>';
	
// show all fields
foreach ($resultset as $document) {

	foreach($document AS $field => $value){
		// this converts multi-value fields to a comma-separated string
		if(is_array($value)) $value = implode(', ', $value);
		//special field
		if ($field=='id')	{
			print '<strong>' . $field . '</strong>: <a href="Search_book.php?id=' . $value . '" class="highlight">'. $value .'</a><br />'; 
		}elseif ($field=='source')	{
			print '<strong>' . $field . '</strong>: <a href="' . $value . '" class="highlight">HATHITrust</a><br />'; 
		}else{
			print '<strong>' . $field . '</strong>: ' . $value . '<br />'; 
		}
	}
	echo '<hr/>';
}
	//pagination
	echo '<div class="col-sm-offset-2 col-sm-10">';
	echo $pagination;
	echo '</div>';
	

htmlFooter();
