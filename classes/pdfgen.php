<?php
		class PDF extends FPDF
		{
			// Load data
			function LoadData($file)
			{
				// Read file lines
				$lines = file($file);
				//replace " in lines with null value
				$lines = str_replace('"', null, $lines);
				$data = array();
				foreach($lines as $line)
					$data[] = explode(',',trim($line));
				return $data;
			}

			// Set header of the table and data
			function SetData($thead, $data, $cellWidth, $cellHeight, $cellBorder)
			{
				//Table Header
				if ($thead != "" && $thead != null)
				{
					foreach($thead as $col)
						$this->Cell($cellWidth, $cellHeight, $col, $cellBorder);
					$this->Ln();
				}
				//Table Data
				foreach($data as $row)
				{
					//echo "-->"; print_r($row); echo "\r\n\r\n"; //exit;
					foreach($row as $col)
					{
						//First Level Heading
						if (substr_count($col,"<tag1>") >= 1 && substr_count($col,"</tag1>") >= 1) 
						{
							 //echo "hak";exit;
							$col = str_replace('<tag1>',null,$col);
							$col = str_replace('</tag1>',null,$col);
							
							$fontsize = 14;
							$cellHeight = 16;
							
							$this->SetTextColor(255,255,255);
							$this->SetFont('Arial','B',$fontsize);
							$this->setFillColor(50,60,70);
							$this->Ln();
							$this->Cell(($cellWidth + (2*$fontsize)), $cellHeight, $col, $cellBorder, 0, 'C', true);
							$this->Ln();
						}
						//Second Level Heading
						else if (substr_count($col,"<tag2>") >= 1 && substr_count($col,"</tag2>") >= 1) 
						{
							 //echo "hak";exit;
							$col = str_replace('<tag2>',null,$col);
							$col = str_replace('</tag2>',null,$col);
							
							$fontsize = 12;
							$cellHeight = 14;
							
							$this->SetTextColor(255,255,255);
							$this->SetFont('Arial','',$fontsize);
							$this->setFillColor(50,60,70);
							
							$this->Cell($cellWidth, $cellHeight, $col, $cellBorder, 0, 'C', true);
						}
						// For aligning text to left
						else if (substr_count($col,"<tag3>") >= 1 && substr_count($col,"</tag3>") >= 1) 
						{
							//echo $col."<br>";
							//echo "hak";exit;	
							$col = str_replace('<tag3>',null,$col);
							$col = str_replace('</tag3>',null,$col);
							
							$fontsize = 10;
							$cellHeight = 12;
							
							$this->SetTextColor(0,0,0);
							$this->SetFont('Arial','',$fontsize);
							
							$this->Cell($cellWidth, $cellHeight, $col, $cellBorder, 0, 'L');
						}
						elseif (substr_count($col,"<tag1a>") >= 1 && substr_count($col,"</tag1a>") >= 1) 
						{
							 //echo "hak";exit;
							$col = str_replace('<tag1a>',null,$col);
							$col = str_replace('</tag1a>',null,$col);
							
							$fontsize = 12;
							$cellHeight = 16;
							
							$this->SetTextColor(0,0,0);
							$this->SetFont('Arial','',$fontsize);
							//$this->setFillColor(50,60,70);
							$this->Ln();
							$this->Cell(($cellWidth + (2*$fontsize)), $cellHeight, $col, $cellBorder, 0, 'L');
							//$this->Ln();
						}
						elseif (substr_count($col,"<tag5>") >= 1 && substr_count($col,"</tag5>") >= 1) 
						{
							 //echo "hak";exit;
							$col = str_replace('<tag5>',null,$col);
							$col = str_replace('</tag5>',null,$col);
							
							$fontsize = 12;
							$cellHeight = 14;
							
							$this->SetTextColor(0,0,0);
							$this->SetFont('Arial','',$fontsize);
							$this->setFillColor(210,200,190);
							$this->Cell(($cellWidth + 30), $cellHeight, $col, $cellBorder, 0, 'L',true);
							$this->Ln();
						}
						//Normal cell 
						else
						{  
							$fontsize = 10;
							$cellHeight = 12;
							
							$this->SetTextColor(0,0,0);
							$this->SetFont('Arial','',$fontsize);
							$this->Cell($cellWidth, $cellHeight, $col, $cellBorder, 0, 'C');//$cellHeight
						}
					}
				  	$this->Ln();
				}
			}
		}
?>