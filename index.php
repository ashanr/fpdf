<?php
// require('fpdf186/fpdf.php');
require('fpdf186/html2pdf.php');

class PDF extends FPDF_HTML
{

    var $B;
    var $I;
    var $U;

    function __construct($orientation='P', $unit='mm', $size='A4')
    {
        // Call parent constructor
        parent::__construct($orientation, $unit, $size);
        // Initialization of properties
        $this->B = 0;
        $this->I = 0;
        $this->U = 0;
    }


    // Page footer
    function Footer()
    {
        $marginSize = 15; // margin size
        $pageWidth = $this->GetPageWidth(); // Page width
        $contentWidth = $pageWidth - ($marginSize * 2); // Available content width
        $row2_content_padding = 30;
        $row2_content_width = $contentWidth - $row2_content_padding;

        $this->SetXY(($marginSize + ($row2_content_padding / 2)), -25); // Position
        $this->AddFont('RockwellNova_Light','','RockwellNova_Light.php'); // Add font
        $this->SetFont('RockwellNova_Light', '', 7); // Set font
        $this->SetTextColor(65, 64, 66);
        $this->MultiCell($row2_content_width, 3, utf8_decode("*Vàlid durant 1 any, sota la disponibilitat del restaurant i amb reserva prèvia.  El Restaurant l’Ó ofereix servei de migdia de dijous a diumenges, el servei de sopar, és únicament les nits de divendres i dissabte. *Vàlid durant 1 any, sota la disponibilitat del restaurant i amb reserva prèvia.  El Restaurant l’Ó ofereix servei de migdia de dijous a diumenges, el servei de sopar, és únicament les nits de divendres i dissabte. *Vàlid durant 1 any, sota la disponibilitat."), 0, 'L');
    }

}

// Create instance of the PDF class
$pdf = new PDF('P', 'mm', 'A4'); // Portrait, millimeters, A4 size

// Add fonts
$pdf->AddFont('RockwellNova_Light','','RockwellNova_Light.php');
$pdf->AddFont('RockwellNova_Italic','','RockwellNova_Italic.php');
$pdf->AddFont('RockwellNova_Bold','','RockwellNova_Bold.php');
$pdf->AddFont('UniversNextPro_Bold','','UniversNextPro_Bold.php');
$pdf->AddFont('UniversNextPro_Thin','','UniversNextPro_Thin.php');

$pdf->AddPage();

// Set font
$pdf->SetFont('UniversNextPro_Thin', '', 11);

$pageHeight = $pdf->GetPageHeight(); // Page height
$pageWidth = $pdf->GetPageWidth(); // Page width
$marginSize = 15; // margin size

$startY = $marginSize; // Set the starting Y position
$startX = $marginSize; // Set the starting X position

// Calculate available height for the rows
$contentHeight = $pageHeight - ($marginSize * 2);
$row1_height = 0.65 * $contentHeight; // Row 1 height
$row2_height = 0.35 * $contentHeight; // Row 2 height

// Available content width
$contentWidth = $pageWidth - ($marginSize * 2);

// First row with border
$pdf->SetDrawColor(237, 28, 36); // Set border color
$pdf->SetLineWidth(1); // Border width
$pdf->SetXY($startX, $startY); // Positioning first row
$pdf->MultiCell($contentWidth, $row1_height, "", 1, 'L');

// Place the logo
$logoX = $startX - 5; // Move 5 units to the left of the first column
$logoY = $startY - 5; // Move 5 units above the first column
$logoWidth = 60; // Set the width of the logo
$pdf->Image('assets/a5-logo.jpg', $logoX, $logoY, $logoWidth);

// Establishment logo
$estLogoPath = 'assets/est.jpg';
list($estLogoWidth, $estLogoHeight) = getimagesize($estLogoPath); // Get image dimensions
$estLogoSetHeight = 30; // Desired height in mm
$aspectRatio = $estLogoWidth / $estLogoHeight; // Calculate the aspect ratio
$estLogoSCalculatedWidth = $estLogoSetHeight * $aspectRatio; // Calculate the width based on the aspect ratio
$estLogoX = $startX + ($contentWidth - $estLogoSCalculatedWidth) / 2; // Center the image in the first column
$estLogoY = 50; // Image vertical position
$pdf->Image($estLogoPath, $estLogoX, $estLogoY, $estLogoSCalculatedWidth, $estLogoSetHeight); // Place the image with the calculated width and desired height

$row1_content_padding = 30;
$row1_content_width = $contentWidth - $row1_content_padding;

$pdf->SetFont('UniversNextPro_Bold', '', 24); // Set font

// Positioning the first row text after the establishment image
$firstRowContentX = $startX + ($row1_content_padding / 2);
$firstRowContentWidth = $contentWidth - $row1_content_padding;
$pdf->SetXY($firstRowContentX, ($startY + ($estLogoY / 2) + $estLogoSetHeight + 30));
$pdf->MultiCell($firstRowContentWidth, 9, utf8_decode("Experiència gastronòmica restaurant L’Ó."), 0, 'C');

$pdf->SetFont('RockwellNova_Light', '', 14); // Set font

$pdf->Ln(9);
$pdf->SetX($firstRowContentX);
$pdf->MultiCell($firstRowContentWidth, 7, utf8_decode("Dedicatòria personal: Ficto blatus sintiistint. Odipsunt dollabo rumqui sunt rem quam, etur sequi aceptae de lab in pora vendi ut moluptam sit entibea inctus, undit iniae eius. Itatum res ent utectate naturia tusdae. Ut eatus id ea vendebis nobit optatem quid quiam is ut eatiis quissum eum voluptassi."), 0, 'C');

$row2_content_padding = 30;
$row2_content_width = $contentWidth - $row2_content_padding;

$colgap = 10; // Set the col gap
$col1_width = 0.65 * ($row2_content_width - $colgap); // Col 1 width
$col2_width = 0.35 * ($row2_content_width - $colgap); // Col 2 width

$secondRowCol1ContentX = $startX + ($row2_content_padding / 2);
$secondRowColContenty = $startY + $row1_height + 15;

$pdf->SetFont('RockwellNova_Bold', '', 11); // Set font

$pdf->SetXY($secondRowCol1ContentX, $secondRowColContenty); // Positioning second column
$pdf->MultiCell($col1_width, 5, utf8_decode("Regal per a dues persones"), 0, 'L');

$pdf->SetFont('RockwellNova_Italic', '', 11); // Set font

$pdf->SetX($secondRowCol1ContentX);
$pdf->MultiCell($col1_width, 5, utf8_decode("Restaurant galardonat amb una Estrella Michelin"), 0, 'L');

$pdf->SetFont('UniversNextPro_Thin', '', 11); // Set font

$pdf->Ln(3);
$pdf->SetX($secondRowCol1ContentX);
$pdf->MultiCell($col1_width, 4.5, utf8_decode("Una nit en habitació doble i vistes als cingles. Detall de benvinguda a l’habitació Massatge de 40 min per persona.“Pack Piscina” amb Casquet i xancletes “L’Avenc”. Sopar “Tastet dels Cingles” amb beguda inclosa. Esmorzar del Bosc. (Bufet ecològic servit a taula). "), 0, 'L');
$pdf->SetX($secondRowCol1ContentX);
$pdf->MultiCell($col1_width, 4, utf8_decode("Accés a la piscina interior durant tot el dia."), 0, 'L');

$secondRowCol2ContentX = $startX + ($row2_content_padding / 2) + $col1_width + $colgap;
$pdf->SetXY($secondRowCol2ContentX, $secondRowColContenty); // Positioning second column

//Set text color
$pdf->SetTextColor(237, 28, 36);

$pdf->SetX($secondRowCol2ContentX);
$pdf->MultiCell($col2_width, 4, utf8_decode("Codi de reserva:"), 0, 'L');

$pdf->SetFont('UniversNextPro_Bold', '', 11); // Set font

$pdf->SetX($secondRowCol2ContentX);
$pdf->MultiCell($col2_width, 4, utf8_decode("68E836BXLX"), 0, 'L');

$pdf->SetFont('UniversNextPro_Thin', '', 11); // Set font

$pdf->Ln(2);
$pdf->SetX($secondRowCol2ContentX);
$pdf->MultiCell($col2_width, 4, utf8_decode("Vàlid fins el"), 0, 'L');

$pdf->SetFont('UniversNextPro_Bold', '', 11); // Set font

$pdf->SetX($secondRowCol2ContentX);
$pdf->MultiCell($col2_width, 4, utf8_decode("23 d’octubre de 2024"), 0, 'L');

$pdf->SetFont('UniversNextPro_Thin', '', 11); // Set font

$pdf->Ln(2);
$pdf->SetX($secondRowCol2ContentX);
$pdf->MultiCell($col2_width, 4, utf8_decode("Món Sant Benet"), 0, 'L');

$pdf->SetFont('UniversNextPro_Bold', '', 11); // Set font

$pdf->SetX($secondRowCol2ContentX);
$pdf->MultiCell($col2_width, 4, utf8_decode("93 875 94 04"), 0, 'L');

// Output the PDF
$pdf->Output();
// $pdf->Output('F', 'file/testfile.pdf', true);
?>
