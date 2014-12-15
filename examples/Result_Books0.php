<?php
//per-field-highlighting
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
addClass(document.getElementById("navSearch"), "active");
</script>

<style>

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

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound().'</br>';
echo 'Search keyword(s): <b>'.$SearchText.'</b></br>';
	//pagination
	//echo '<div class="text-center">';
	echo '<div class="col-sm-offset-2 col-sm-10">';
	echo $pagination;
	echo '</div>';
	
// show documents using the resultset iterator
$cnt=0;
foreach ($resultset as $document) {
$cnt++;
    // highlighting results can be fetched by document id (the field defined as uniquekey in this schema)
    $highlightedDoc = $highlighting->getResult($document->id);
    if ($highlightedDoc) {
	 echo '<hr/>';
		echo $cnt.'.<a href="Search_book.php?id='.urlencode($document->id).'" class="highlight"><b>'.  implode(', ', $document->title) .'</b></a><br />'; 
		echo '<i>id</i>:   '.$document->id.'<br />'; 
        foreach ($highlightedDoc as $field => $highlight) {
			echo '<i>'.$field.'</i>: ';
            echo implode(' (...) ', $highlight) . '<br/>';
        }
    }

}
	//pagination
	echo '<div class="col-sm-offset-2 col-sm-10">';
	echo $pagination;
	echo '</div>';
htmlFooter();
