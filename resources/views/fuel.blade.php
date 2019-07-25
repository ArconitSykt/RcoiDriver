<?php
// var_dump($data);
// return 0;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Выгрузка по топливу за '.$month.'".xlsx"');
header('Cache-Control: max-age=0');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$inputFileName = 'templates/fuel.xlsx'; //! Файл-шаблон
$inputFileNameDownload = 'fuel.xlsx'; //! Файл на скачивание
$spreadsheet = IOFactory::load($inputFileName);

$sheet = $spreadsheet->getSheet(0);
$all = count($data)-1;
$sheet->setCellValueByColumnAndRow(10, 2, $date);
$sheet->setCellValueByColumnAndRow(4, 1, $month);

foreach ($data as $key => $value) {
if($key != 0) {
    $spreadsheet->getActiveSheet()->insertNewRowBefore(7+$key, 1);
  }
  $sheet->setCellValueByColumnAndRow(1, 7+$key, $value->date);
  $sheet->setCellValueByColumnAndRow(2, 7+$key, $value->start_odd);
  $sheet->setCellValueByColumnAndRow(3, 7+$key, $value->end_odd);
  $sheet->setCellValueByColumnAndRow(4, 7+$key, "=C".(7+$key)."-B".(7+$key));
  $sheet->setCellValueByColumnAndRow(5, 7+$key, "=\$D".(7+$key)."/100*\$F\$".(11+$all).""."+J".(7+$key));
  $sheet->setCellValueByColumnAndRow(6, 7+$key, "=\$D".(7+$key)."/100*\$F\$".(11+$all).""."+J".(7+$key));
  $sheet->setCellValueByColumnAndRow(7, 7+$key, $value->fueling);
  $sheet->setCellValueByColumnAndRow(8, 7+$key, $value->fuel);
  $sheet->setCellValueByColumnAndRow(9, 7+$key, "=H".(7+$key)."+G".(7+$key)."-F".(7+$key));
  $sheet->setCellValueByColumnAndRow(10, 7+$key, "=0.82*".$value->waiting);
  $sheet->setCellValueByColumnAndRow(11, 7+$key, $value->waiting);
}
$sheet->setCellValueByColumnAndRow(4, 8+$all, "=SUM(D7:D".(7+$all).")");
$sheet->setCellValueByColumnAndRow(5, 8+$all, "=SUM(E7:E".(7+$all).")");
$sheet->setCellValueByColumnAndRow(6, 8+$all, "=SUM(F7:F".(7+$all).")");
$sheet->setCellValueByColumnAndRow(7, 8+$all, "=SUM(G7:G".(7+$all).")");
$sheet->setCellValueByColumnAndRow(10, 8+$all, "=SUM(J7:J".(7+$all).")");
$sheet->setCellValueByColumnAndRow(11, 8+$all, "=SUM(K7:K".(7+$all).")");

$sheet->setCellValueByColumnAndRow(3, 14+$all, $date);
$sheet->setCellValueByColumnAndRow(4, 14+$all, "=I".(7+$all));


$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$writer->save($inputFileNameDownload);    
file_force_download($inputFileNameDownload);

function file_force_download($file) {
    if (file_exists($file)) {
      if (ob_get_level()) {
        ob_end_clean();
      }
      readfile($file);
      unlink($file);
      exit;
    }
  }