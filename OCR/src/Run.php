<?php

namespace OCR\PdfToImage;

use OCR\TesseractOCR\TesseractOCR;

// use OCR\TesseractOCR\TesseractOCR;

include_once __DIR__."/Pdf.php";
include_once __DIR__."/TesseractOCR.php";
$filename="/home/saikat/Downloads/cc.txt";
$handle=fopen($filename, "w+");
$pathToPdf="/home/saikat/Downloads/mmm/mmm.pdf";
$pdf = new Pdf($pathToPdf);
$ocr=new TesseractOCR();
$pathToWhereImageShouldBeStored="/home/saikat/Downloads/";
// $pdf->saveImage($pathToWhereImageShouldBeStored);
$pageCount=$pdf->getNumberOfPages();
// for($i=1;$i<$pageCount;$i++){
    // $pdf->setPage($i)->saveImage("/home/saikat/Downloads/Out/page_".$i.".jpg");
    $ocr->image("/home/saikat/Downloads/Out/page_242.jpg"    );
    $data=$ocr->lang("ben")->run();
    fwrite($handle, $data.PHP_EOL);
    print_r($data);
    exit();
// }