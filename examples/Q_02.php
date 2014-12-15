<?php

require(__DIR__.'/init.php');
use Solarium\Client;
use Solarium\QueryType\Select\Query\Query as Select;

htmlHeader();

// In most cases using the API or config is advisable, however in some cases it can make sense to extend classes.
// This makes it possible to create 'query inheritance' like in this example
class ProductQuery extends Select
{
    protected function init()
    {
        parent::init();

        // basic params
        $this->setQuery('*:*');
        $this->setStart(2)->setRows(20);
        $this->setFields(array('id','title','creator'));
        $this->addSort('date_s', self::SORT_ASC);

        // create a facet field instance and set options
        $facetSet = $this->getFacetSet();
        $facetSet->createFacetField('title')->setField('title');
    }
}

// This query inherits all of the query params of its parent (using parent::init) and adds some more
// Ofcourse it could also alter or remove settings
class ProductPriceLimitedQuery extends ProductQuery
{
    protected function init()
    {
        parent::init();

        // create a filterquery
        $this->createFilterQuery('maxprice')->setQuery('date_s:[1 TO 2000]');
    }
}

// create a client instance
$client = new Client($config);

// create a query instance
$query = new ProductPriceLimitedQuery;

// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Facet counts for field "title":<br/>';
$facet = $resultset->getFacetSet()->getFacet('title');
foreach ($facet as $value => $count) {
    echo $value . ' [' . $count . ']<br/>';
}

// show documents using the resultset iterator
foreach ($resultset as $document) {

    echo '<hr/><table>';
    echo '<tr><th>id</th><td>' . $document->id . '</td></tr>';
    echo '<tr><th>name</th><td>' . $document->title . '</td></tr>';
    echo '<tr><th>price</th><td>' . $document->creator . '</td></tr>';
    echo '</table>';
}

htmlFooter();
