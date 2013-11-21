<?php

$graph_title = "Two Week Price History";

// Include WP-Load to use JpGraph class
include_once ( dirname(__FILE__) . '/../../../../' . 'wp-load.php' );

$ydata = array();
$xdata = array();

// Some data
if ($_GET) {
	$ydata = $_GET['price'];
	$xdata = $_GET['price_date'];
}

// Width and height of the graph
$width = 715; $height = 200;
 
// Create a graph instance
$graph = new Graph($width,$height);

// Specify what scale we want to use,
// int = integer scale for the X-axis
// int = integer scale for the Y-axis
$graph->SetScale('intint');
// $graph->SetScale( 'datlin' );
 
// Setup a title for the graph
$graph->title->Set('Two Week Price History');
 
// Setup titles and X-axis labels
$graph->xaxis->title->Set('(Date)');
$graph->xaxis->SetTickLabels($xdata);
$graph->xscale->ticks->Set(7,1);
 
// Setup Y-axis title
$graph->yaxis->title->Set('($ price)');
 
// Create the linear plot
$lineplot=new LinePlot($ydata);
 
// Add the plot to the graph
$graph->Add($lineplot);
 
// Display the graph
$graph->Stroke();
?>