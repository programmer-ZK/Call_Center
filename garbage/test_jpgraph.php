<?php
require_once ('lib/jpgraph/src/jpgraph.php');
require_once ('lib/jpgraph/src/jpgraph_line.php');
//include_once("includes/tools_admin.php");
//$tools_admin = new tools_admin();
?>
<html>
<body>
<table>

<?php
//for ($i=0;$i<5;$i++){
?>

<tr>
<td><?php //$tools_admin->generateGraph(0);?>

	<?php
		$datay1 = array(20,15,23,15);
		//$datay2 = array(12,9,42,8);
		//$datay3 = array(5,17,32,24);
		
		// Setup the graph
		$graph = new Graph(250,200);
		$graph->SetScale("textlin");
		
		$theme_class=new UniversalTheme;
		
		$graph->SetTheme($theme_class);
		$graph->img->SetAntiAliasing(false);
		$graph->title->Set($title);
		$graph->SetBox(false);
		
		$graph->img->SetAntiAliasing();
		
		$graph->yaxis->HideZeroLabel();
		$graph->yaxis->HideLine(false);
		$graph->yaxis->HideTicks(false,false);
		
		$graph->xgrid->Show();
		$graph->xgrid->SetLineStyle("solid");
		$graph->xaxis->SetTickLabels(array('Week 1','Week 2','Week 3','Week 4'));
		$graph->xgrid->SetColor('#E3E3E3');
		
		// Create the first line
		$p1 = new LinePlot($datay1);
		$graph->Add($p1);
		$p1->SetColor("#6495ED");
		$p1->SetLegend('');
		
		// Create the second line
		//$p2 = new LinePlot($datay2);
		//$graph->Add($p2);
		//$p2->SetColor("#B22222");
		//$p2->SetLegend('Line 2');
		
		// Create the third line
		//$p3 = new LinePlot($datay3);
		//$graph->Add($p3);
		//$p3->SetColor("#FF1493");
		//$p3->SetLegend('Line 3');
		
		$graph->legend->SetFrameWeight(1);
		
		// Output line
		ob_end_clean();
		$graph->Stroke("graphs/".$title.".jpeg");
		echo "<img src='graphs/".$title.".jpeg'/>";
	?>
<td>
</tr>

<?php
//}
?>
</table>
</body>
</html>
