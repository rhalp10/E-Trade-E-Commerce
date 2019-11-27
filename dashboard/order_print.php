<?php
require('../assets/print/fpdf.php');
include('../dbconfig.php');

class PDF extends FPDF
{
// Page header
		/*******************************************************************************
	* HEADER STYLE                                             						*
	*******************************************************************************/
	//Cell with horizontal scaling if text is too wide
	//Patrick Benny script Fit text to cell
	function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
	{
		//Get string width
		$str_width=$this->GetStringWidth($txt);

		//Calculate ratio to fit cell
		if($w==0)
			$w = $this->w-$this->rMargin-$this->x;
		$ratio = ($w-$this->cMargin*2)/$str_width;

		$fit = ($ratio < 1 || ($ratio > 1 && $force));
		if ($fit)
		{
			if ($scale)
			{
				//Calculate horizontal scaling
				$horiz_scale=$ratio*100.0;
				//Set horizontal scaling
				$this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
			}
			else
			{
				//Calculate character spacing in points
				$char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
				//Set character spacing
				$this->_out(sprintf('BT %.2F Tc ET',$char_space));
			}
			//Override user alignment (since text will fill up cell)
			$align='';
		}

		//Pass on to Cell method
		$this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

		//Reset character spacing/horizontal scaling
		if ($fit)
			$this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
	}

	//Cell with horizontal scaling only if necessary
	function CellFitScale($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
	{
		$this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,false);
	}

	//Cell with horizontal scaling always
	function CellFitScaleForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
	{
		$this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,true);
	}

	//Cell with character spacing only if necessary
	function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
	{
		$this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
	}

	//Cell with character spacing always
	function CellFitSpaceForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
	{
		//Same as calling CellFit directly
		$this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,true);
	}

	//Patch to also work with CJK double-byte text
	function MBGetStringLength($s)
	{
		if($this->CurrentFont['type']=='Type0')
		{
			$len = 0;
			$nbbytes = strlen($s);
			for ($i = 0; $i < $nbbytes; $i++)
			{
				if (ord($s[$i])<128)
					$len++;
				else
				{
					$len++;
					$i++;
				}
			}
			return $len;
		}
		else
			return strlen($s);
	}
function Header()
{
	include('../dbconfig.php');
	$sql = "SELECT * FROM `order` `ord` 
			LEFT JOIN `user`  `u` ON `ord`.user_ID = `u`.user_ID
			LEFT JOIN `order_status` `ors` ON `ord`.`ors_ID` = `ors`.`ors_ID`
			WHERE `ord`.`or_ID` =  '".$_REQUEST["order_ID"]."' 
					LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$user_Fullname  = "";
	$or_Date   = "";
	$user_Address  = "";
	$or_ID   = "";
	while ($row = mysqli_fetch_array($result)) 	
		{

			$or_ID = $row['or_ID'];
			$or_Date = $row['or_Date'];
			$ors_Name = $row['ors_Name'];

			if (!empty($row['user_img'])) {
					
				 $ac_Img = 'data:image/jpeg;base64,'.base64_encode($row['user_img']);
				}
				else{
				  $ac_Img = "../assets/img/uploads/blank.png";
				}
			
			$user_Fullname = $row["user_Fullname"];
			$user_Name= $row["user_Name"];
			$user_Email = $row["user_Email"];
			$user_Address = $row["user_Address"];
		
		}
    // Logo
    $this->Image('../assets/img/logo.png',30,6,20);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'',0,1,'C');
    $this->Cell(80);
    $this->Cell(30,10,'E-Trading',0,1,'C');
    $this->SetFont('Times','',12);
    $this->Cell(80,10,'Customer: '.$user_Fullname,0,0);
    $this->Cell(60,10,'Customer: '.$user_Fullname,0,0);
    $this->Cell(0,10,'Date: '.$or_Date,0,1);
    $this->Cell(0,10,'Address: '.$user_Address,0,1);
    $this->Cell(0,10,'OR #'.$or_ID,0,1);
 $this->SetFont('Times','B',12);
    // Line break
    $this->Ln(10);
     $this->Cell(15,10,'#',1,0);
     $this->Cell(70,10,'Item',1,0);
     $this->Cell(35,10,'Price',1,0);
     $this->Cell(35,10,'Quantity(KG)',1,0);
     $this->Cell(0,10,'Subtotal',1,1);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class


$sql = "SELECT * FROM `order_item` `ordi`
LEFT JOIN `item_details` `itms` ON `ordi`.`item_ID` = `itms`.`item_ID`
where `ordi`.`or_ID`  = '".$_REQUEST["order_ID"]."' ";
$result = mysqli_query($conn, $sql);


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

   
	$Total = 0 ;
while ($row = mysqli_fetch_array($result)) {	
	$Subtotal = $row['ord_Qnty'] * $row['ord_Price'];
 	 $pdf->Cell(15,10,$row['ord_ID'],1,0);
     $pdf->CellFitSpace(70,10,$row['item_Name'],1,0);
     $pdf->CellFitSpace(35,10,$row['ord_Price'],1,0);
     $pdf->CellFitSpace(35,10,$row['ord_Qnty'],1,0);
     $pdf->CellFitSpace(0,10,number_format($Subtotal,2),1,1);

	$Total += $Subtotal ;
	}

     $pdf->Cell(120,10,'',1,0);
  	 $pdf->Cell(35,10,'Total:',0,0);
     $pdf->CellFitSpace(0,10,$Total,0,1);

     $pdf->Cell(120,-10,'',0,0);
  	 $pdf->Cell(0,-10,'',1,1);
$pdf->Output();
?>