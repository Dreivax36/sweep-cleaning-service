<?php
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
// Include the main TCPDF library (search for installation path).
require_once('library/tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF
{
	// Load table data from file
	public function LoadData($file)
	{
		// Read file lines
		$lines = file($file);
		$data = array();
		$data = Salary::where('id', $id);
		foreach ($lines as $line) {
			$data[] = explode(';', chop($line));
		}
		return $data;
	}

	// Colored table
	public function ColoredTable($header, $data)
	{
		// Colors, line width and bold font
		$this->SetFillColor(255, 0, 0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128, 0, 0);
		$this->SetLineWidth(0.3);
		$this->SetFont('', 'B');
		// Header
		$w = array(40, 35, 40, 45);
		$num_headers = count($header);
		for ($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
		}
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = 0;
		foreach ($data as $row) {
			$this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
			$this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
			$this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
			$this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
			$this->Ln();
			$fill = !$fill;
		}
		$this->Cell(array_sum($w), 0, '', 'T');
	}
}

// create new PDF document
ob_clean();
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



// set header and footer fonts
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);


// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);


// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
	require_once(dirname(__FILE__) . '/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
 $request = new Request;
$salary = Salary::where('id', 3)->get();
foreach($salary as $salaries){
// add a page
$pdf->AddPage();
$pdf->SetFont('times', 'B', 12);

$pdf->Cell(189,5,'SWEEP EMPLOYEE PAY SLIP',0,1,'C');

$pdf->SetFont('times', '', 12);

$month = Carbon::now()->month;
$year = Carbon::now()->year;
$pdf->Cell(189,5,"For $salaries->month $year",0,1,'C');

$pdf->Ln(18);

$pdf->SetFont('times','B', 12);
$pdf->Cell(149,5,'Employee Code:',0,0);
$pdf->Cell(30,5,'HR0001',0,0,'R');


$pdf->Ln(7);

$pdf->SetFont('times','', 12);
$pdf->Cell(40,5,'          Full Name:',0,0);
$pdf->Cell(139,5,'Edwin Vinas',0,0);

$pdf->Ln(7);
$pdf->SetFont('times','', 12);
$pdf->Cell(40,5,'          Department:',0,0);
$pdf->Cell(139,5,'Human Resource Department',0,0);

$pdf->Ln(7);
$pdf->SetFont('times','', 12);
$pdf->Cell(40,5,'          Position:',0,0);
$pdf->Cell(139,5,'Manager',0,0);

$pdf->Ln(14);

$pdf->SetFont('times','B', 12);
$pdf->Cell(189,3,'Details:',0,0);

$pdf->Ln(7);
$pdf->SetFont('times','', 12);
$pdf->Cell(149,5,'          Total Days Present:',0,0);
$pdf->Cell(30,5,'20 Days',0,0,'R');

$pdf->Ln(7);
$pdf->SetFont('times','', 12);
$pdf->Cell(149,5,'          Total Hours Present:',0,0);
$pdf->Cell(30,5,'160 Hours',0,0,'R');



$pdf->Ln(14);

$pdf->SetFont('times','B', 12);
$pdf->Cell(189,3,'Earnings:',0,0);


$pdf->Ln(7);
$pdf->SetFont('times','', 12);
$pdf->Cell(149,5,'          Total Salary:',0,0);
$pdf->Cell(30,5,'42,700 Php',0,0,'R');




$pdf->Ln(14);

$pdf->SetFont('times','B', 12);
$pdf->Cell(179,5,'Deductions:',0,0);

$pdf->Ln(7);
$pdf->SetFont('times','', 12);
$pdf->Cell(149,5,'          Income Tax:',0,0);
$pdf->Cell(30,5,'2,700 Php',0,0,'R');


$pdf->Ln(14);

$pdf->SetFont('times','B', 12);
$pdf->Cell(149,5,'NET SALARY:',0,0);
$pdf->Cell(30,5,'40,000 Php',0,0,'R');
}

//Close and output PDF document
$pdf->Output('Payslip.pdf', 'I');



ob_flush();
exit;
//============================================================+
// END OF FILE
//============================================================+


