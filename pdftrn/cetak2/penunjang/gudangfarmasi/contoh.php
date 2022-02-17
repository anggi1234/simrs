<?php
require_once('../../tcpdf/tcpdf.php');
// Extend the TCPDF class to create custom Header and Footer
    class MYPDF extends TCPDF {

    //Page header
    public function Header() {
      $this->SetTextColor(209,183,49);

      $this->Ln(5);        

    }

    // Page footer
    public function Footer() {
        $this->SetY(-15);

    }
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'UTF-8', false);

$teks = <<<EOD



ghjkhgkj




EOD;
        $pdf->AddPage();
        $pdf->writeHTML($teks, true, 0, true, 0);
		$pdf->Output('buatpdf.pdf','I');
?>