
<head>
    <meta charset="utf-8">
    <title> PDF</title>
</head>
<?php
// Include TCPDF library
require_once('../../TCPDF/tcpdf.php');

// Your existing code
// ...

// Check if the PDF button is clicked
if (isset($_POST['generate_pdf'])) {
    // Create a new PDF instance
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Raport szczegółowy');
//    $pdf->SetFont('arial', '', 10); // Ustawia czcionkę na 'arial'
    $pdf->SetFont('dejavusans', '', 10); // Ustawia czcionkę na 'dejavusans'

    // Add a page
    $pdf->AddPage();

    // Your existing code for generating content
    ob_end_clean();
    ob_start(); // Capture the HTML output
    require_once("../elements/voteDetailsForReport.php");
    $content = ob_get_contents();
    ob_end_clean();


    // Set content to PDF
    $pdf->writeHTML($content, true, false, true, false, '');
    $pdf->SetY(0);
    $pdf->SetFont('helvetica', 'I', 8);
    $pdf->Cell(0, 10, 'Wygenerowano: ' . date('Y-m-d H:i:s'), 0, false, 'C');

//    ob_end_clean();
    // Output the PDF as a download
    $pdf->Output('raport_szczegolowy.pdf', 'I');
}

// Your existing HTML form
?>
<!--<form method="post" action="">-->
<!--    <button type="submit" name="generate_pdf">Generate PDF</button>-->
<!--</form>-->

