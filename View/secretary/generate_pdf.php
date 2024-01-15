<?php
header('Content-Type: text/html; charset=utf-8');
use Controller\VoteController;

require_once("../../Controller/VoteController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");
$voteController = new VoteController();

require('../../FPDF/fpdf.php');

// Utwórz instancję klasy FPDF
$pdf = new FPDF('L');

$pdf->AddPage();

// Ustaw czcionkę dla nagłówka tabeli
$pdf->SetFont('Times', 'B', 12);

// Nagłówki tabeli
$headers = array('ID Głosowania', 'Nazwa Głosowania', 'Data Rozpoczęcia', 'Data Zakończenia', 'Liczba Głosujących', 'Liczba Uprawnionych', 'Status Głosowania');
foreach ($headers as $header) {
    $header = utf8_decode($header);
    $pdf->Cell(40, 7, $header, 1);
}
$pdf->Ln();

// Ustaw czcionkę dla danych tabeli
$pdf->SetFont('Arial', '', 12);

// Pobierz dane z formularza
$startDate = $_POST["startDate"];
$endDate = $_POST["endDate"];

// Pobierz dane
$data = $voteController->getVotingReport($startDate, $endDate);

// Dane tabeli
foreach ($data as $row) {
    foreach ($row as $column) {
        $column = utf8_decode($column);
        $pdf->Cell(40, 7, $column, 1);

    }
    $pdf->Ln();
}

$pdf->Output();
