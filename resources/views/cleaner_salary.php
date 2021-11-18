<?php
use App\Models\Cleaner_review;
use App\Models\Cleaner;
use App\Models\User;
use App\Models\Assigned_cleaner;
use App\Models\Booking;
use App\Models\Price;
use Carbon\Carbon;
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

// add a page
$pdf->AddPage();
$pdf->SetFont('times', 'B', 12);

$pdf->Cell(189,5,'SWEEP CLEANERS SALARY',0,1,'C');

$pdf->SetFont('times', '', 12);

$month = Carbon::now()->month;
$year = Carbon::now()->year;
$pdf->Cell(189,5,"For " .date("F", mktime(0, 0, 0, $month, 1))." " .$year,0,1,'C');



$pdf->Ln(18);

$pdf->SetFont('times','B', 12);
$pdf->Cell(75,5,'NAME',1,0,'C');
$pdf->Cell(30,5,'TOTAL JOB',1,0,'C');
$pdf->Cell(40,5,'TOTAL JOB FEE',1,0,'C');
$pdf->Cell(40,5,'TOTAL SALARY',1,0,'C');

$cleaner = array();
$counter = 0;
$bookingID = Booking::Where('status', 'Completed')->get();
 foreach($bookingID as $key => $value){
    $cleanerID = Assigned_cleaner::Where('booking_id', $value->booking_id)->value('cleaner_id');
    $cleaner[$counter++] = $cleanerID;
 }
    $cleaner = array_unique($cleaner); 
    
foreach($cleaner as $key => $cleaner){
    $totalSalary = 0;
    $price = 0;
    $total = 0;
    $totalJob = 0; 
    $booking = Assigned_cleaner::Where('cleaner_id', $cleaner)->get();
    foreach($booking as $key => $booking){
        $book = Booking::Where('booking_id', $booking->booking_id)->Where('status', 'Completed')->get();
        foreach($book as $key => $book){
        $price = Price::Where('service_id', $book->service_id)->Where('property_type', $book->property_type)->get();
        foreach($price as $key => $price){
            $salary = $price->price / $price->number_of_cleaner;   
            $totalSalary = $totalSalary + ($salary - ($salary * 0.50));
            $total = $total + $salary; 
        }
        $totalJob++;
    }  
}
    $id = Cleaner::Where('cleaner_id', $cleaner)->value('user_id'); 
    $fullname = User::Where('user_id', $id)->value('full_name'); 
                
$pdf->Ln(5.5);
$pdf->SetFont('times', '', 12);
$pdf->Cell(75,5,"$fullname",1,0);
$pdf->Cell(30,5, "$totalJob",1,0,'C');
$pdf->Cell(40,5,number_format((float)$total, 2, '.', '').' php',1,0,'C');
$pdf->Cell(40,5,number_format((float)$totalSalary, 2, '.', '').' php',1,0,'C');

} 

$pdf->Ln(14);
$pdf->SetFont('times','I', 10);
$pdf->Cell(189,5,"This file was generated on ". date('F d, Y', strtotime(Carbon::now())),0,0);

//Close and output PDF document
$pdf->Output('Cleaner_Salary_Report.pdf', 'D');



ob_flush();
exit;
//============================================================+
// END OF FILE
//============================================================+


