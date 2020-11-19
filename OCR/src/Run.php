<?php
namespace OCR\PdfToImage;

use OCR\TesseractOCR\TesseractOCR;
include_once __DIR__."/Pdf.php";
include_once __DIR__."/TesseractOCR.php";

$filename="/home/saikat/Downloads/cc.txt"; //Text file name 
$handle=fopen($filename, "w+");

$pathToPdf="/home/saikat/Downloads/mmm/mmm.pdf"; //Pdf Path
$pdf = new Pdf($pathToPdf);
$ocr=new TesseractOCR();
$imagepath="/home/saikat/Downloads/Out/"; //Image Loc
$pageCount=$pdf->getNumberOfPages();
for($i=1;$i<$pageCount;$i++){
    $pdf->setPage($i)->saveImage($imagepath."/page_".$i.".jpg");
    $ocr->image($imagepath."/page_".$i.".jpg");
    $data=$ocr->lang("ben","eng")->run();    
    fwrite($handle, $data.PHP_EOL);
}