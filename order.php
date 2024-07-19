<?php
require('fpdf186/fpdf.php');

class PDF extends FPDF
{
    // Page footer
    function Footer()
    {
        $this->SetXY(14, -20); // Position
        $this->AddFont('RockwellNova_Light','','RockwellNova_Light.php'); // Add font
        $this->SetFont('RockwellNova_Light', '', 7); // Set font
        $this->SetTextColor(65, 64, 66);
        $this->MultiCell(0, 3, utf8_decode("*Vàlid durant 1 any, sota la disponibilitat del restaurant i amb reserva prèvia.  El Restaurant l’Ó ofereix servei de migdia de dijous a diumenges, el servei de sopar, és únicament les nits de divendres i dissabte. *Vàlid durant 1 any, sota la disponibilitat del restaurant i amb reserva prèvia.  El Restaurant l’Ó ofereix servei de migdia de dijous a diumenges, el servei de sopar, és únicament les nits de divendres i dissabte. *Vàlid durant 1 any, sota la disponibilitat."), 0, 'L');
    }
}

// Create instance of the PDF class
$pdf = new PDF('L', 'mm', 'A5'); // Landscape, millimeters, A5 size

// Add fonts
$pdf->AddFont('RockwellNova_Light','','RockwellNova_Light.php');
$pdf->AddFont('RockwellNova_Italic','','RockwellNova_Italic.php');
$pdf->AddFont('RockwellNova_Bold','','RockwellNova_Bold.php');
$pdf->AddFont('UniversNextPro_Bold','','UniversNextPro_Bold.php');
$pdf->AddFont('UniversNextPro_Thin','','UniversNextPro_Thin.php');

$pdf->AddPage();

// Set font
$pdf->SetFont('UniversNextPro_Thin', '', 11);

// Calculate available height for the columns
$pageHeight = $pdf->GetPageHeight();
$pageWidth = $pdf->GetPageWidth();
$marginSize = 15; // margin size
$footerHeight = 10; // footer size
$availableHeight = $pageHeight - ($marginSize * 2) - $footerHeight;
// Calculate column heights
$col_height = $availableHeight; // Equal heights for both columns

$startY = $marginSize; // Set the starting Y position
$startX = $marginSize; // Set the starting X position
$colgap = 5; // Set the col gap

// Calculate column widths
$width = $pageWidth - (($marginSize * 2) + $colgap); // Page width minus margins and gaps
$col1_width = 0.65 * $width; // Col 1 width
$col2_width = 0.35 * $width; // Col 2 width

// First column with border
$pdf->SetDrawColor(237, 28, 36); // Set border color
$pdf->SetLineWidth(1); // Border width
$pdf->SetXY($startX, $startY); // Positioning first column
$pdf->MultiCell($col1_width, $col_height, "", 1, 'L');

// Place the logo
$logoX = $startX - 5; // Move 5 units to the left of the first column
$logoY = $startY - 5; // Move 5 units above the first column
$logoWidth = 40; // Set the width of the logo
$pdf->Image('assets/a5-logo.jpg', $logoX, $logoY, $logoWidth);

// Establishment logo
$estLogoPath = 'assets/est.jpg';
list($estLogoWidth, $estLogoHeight) = getimagesize($estLogoPath); // Get image dimensions
$estLogoSetHeight = 20; // Desired height in mm
$aspectRatio = $estLogoWidth / $estLogoHeight; // Calculate the aspect ratio
$estLogoSCalculatedWidth = $estLogoSetHeight * $aspectRatio; // Calculate the width based on the aspect ratio
$estLogoX = $startX + ($col1_width - $estLogoSCalculatedWidth) / 2; // Center the image in the first column
$estLogoY = 30; // Image vertical position
$pdf->Image($estLogoPath, $estLogoX, $estLogoY, $estLogoSCalculatedWidth, $estLogoSetHeight); // Place the image with the calculated width and desired height

$col1_content_padding = 10;
$col1_content_width = $col1_width - $col1_content_padding;

$pdf->SetFont('UniversNextPro_Bold', '', 18); // Set font

// Positioning the first column text after the establishment image
$firstColContentX = $startX + ($col1_content_padding / 2);
$pdf->SetXY($firstColContentX, ($startY + ($estLogoY / 2) + $estLogoSetHeight + 10));
$pdf->MultiCell($col1_content_width, 7, utf8_decode("Experiència gastronòmica restaurant L’Ó."), 0, 'C');

$pdf->SetFont('RockwellNova_Light', '', 11); // Set font

$pdf->Ln(9);
$pdf->SetX($firstColContentX);
$pdf->MultiCell($col1_content_width, 5, utf8_decode("Dedicatòria personal: Ficto blatus sintiistint. Odipsunt dollabo rumqui sunt rem quam, etur sequi aceptae de lab in pora vendi ut moluptam sit entibea inctus, undit iniae eius. Itatum res ent utectate naturia tusdae. Ut eatus id ea vendebis nobit optatem quid quiam is ut eatiis quissum eum voluptassi."), 0, 'C');

$pdf->SetFont('RockwellNova_Bold', '', 11); // Set font

// Positioning the second column
$secondColX = $startX + $col1_width + $colgap;
$pdf->SetXY($secondColX, $startY); // Positioning second column
$pdf->MultiCell($col2_width, 5, utf8_decode("Regal per a dues persones"), 0, 'L');

$pdf->SetFont('RockwellNova_Italic', '', 11); // Set font

$pdf->SetX($secondColX);
$pdf->MultiCell($col2_width, 5, utf8_decode("Restaurant galardonat amb una Estrella Michelin"), 0, 'L');

$pdf->SetFont('UniversNextPro_Thin', '', 11); // Set font

$pdf->Ln(2);
$pdf->SetX($secondColX);
$pdf->MultiCell($col2_width, 4.5, utf8_decode("Una nit en habitació doble i vistes als cingles. Detall de benvinguda a l’habitació Massatge de 40 min per persona.“Pack Piscina” amb Casquet i xancletes “L’Avenc”. Sopar “Tastet dels Cingles” amb beguda inclosa. Esmorzar del Bosc. (Bufet ecològic servit a taula). "), 0, 'L');
$pdf->SetX($secondColX);
$pdf->MultiCell($col2_width, 4, utf8_decode("Accés a la piscina interior durant tot el dia."), 0, 'L');

//Set text color
$pdf->SetTextColor(237, 28, 36);

$pdf->Ln(3);
$pdf->SetX($secondColX);
$pdf->MultiCell($col2_width, 4, utf8_decode("Codi de reserva:"), 0, 'L');

$pdf->SetFont('UniversNextPro_Bold', '', 11); // Set font

$pdf->SetX($secondColX);
$pdf->MultiCell($col2_width, 4, utf8_decode("68E836BXLX"), 0, 'L');

$pdf->SetFont('UniversNextPro_Thin', '', 11); // Set font

$pdf->Ln(2);
$pdf->SetX($secondColX);
$pdf->MultiCell($col2_width, 4, utf8_decode("Vàlid fins el"), 0, 'L');

$pdf->SetFont('UniversNextPro_Bold', '', 11); // Set font

$pdf->SetX($secondColX);
$pdf->MultiCell($col2_width, 4, utf8_decode("23 d’octubre de 2024"), 0, 'L');

$pdf->SetFont('UniversNextPro_Thin', '', 11); // Set font

$pdf->Ln(2);
$pdf->SetX($secondColX);
$pdf->MultiCell($col2_width, 4, utf8_decode("Món Sant Benet"), 0, 'L');

$pdf->SetFont('UniversNextPro_Bold', '', 11); // Set font

$pdf->SetX($secondColX);
$pdf->MultiCell($col2_width, 4, utf8_decode("93 875 94 04"), 0, 'L');

// Output the PDF
$pdf->Output();
// $pdf->Output('F', 'file/testfile.pdf', true);
?>
