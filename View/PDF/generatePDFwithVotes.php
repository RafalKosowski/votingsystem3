



<?php
// Include TCPDF library
require_once('../../TCPDF/tcpdf.php');
use Controller\VoteController;

require_once ('../../Database/Database.php');
require_once('../../Controller/VoteController.php'); // Zakładam, że VoteController jest klasą zawierającą logikę związana z głosowaniami
require_once('../../TCPDF/tcpdf.php');

// Your existing code
// ...

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];

    $voteController = new VoteController();
    $data = $voteController->getVotingReport($startDate, $endDate);

    // Create a new PDF instance
    $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Raport glosowan ');
//    $pdf->SetFont('arial', '', 10); // Ustawia czcionkę na 'arial'
    $pdf->SetFont('dejavusans', '', 10); // Ustawia czcionkę na 'dejavusans'

    // Add a page
    $pdf->AddPage();

    // Your existing code for generating content
    ob_end_clean();
    ob_start(); // Capture the HTML output
    require_once("../elements/votesTable.php");
    $content = ob_get_contents();
    ob_end_clean();


    // Set content to PDF
    $pdf->writeHTML($content, true, false, true, false, '');
    $pdf->SetY(0);
    $pdf->SetFont('helvetica', 'I', 8);
    $pdf->Cell(0, 10, 'Raport z okresu: ' .$startDate.'  -  '.$endDate, 0, false, 'C');
    $pdf->SetFont('helvetica', 'I', 8);
    $pdf->Cell(0, 10, 'Wygenerowano: ' . date('Y-m-d H:i:s'), 0, false, 'R');

//    ob_end_clean();
    // Output the PDF as a download
    $pdf->Output('raport_szczegolowy.pdf', 'I');
}

// Your existing HTML form
?>
