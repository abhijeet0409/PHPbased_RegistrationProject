<?php
if(isset($_POST['filename']) && isset($_POST['data'])) {
    $filename = $_POST['filename'];
    $data = json_decode($_POST['data'], true);

    // Include PHPExcel library
    require 'PHPExcel/Classes/PHPExcel.php';

    // Create a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);

    // Populate Excel with the table data
    $row = 1;
    foreach ($data as $rowData) {
        $col = 0;
        foreach ($rowData as $value) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
            $col++;
        }
        $row++;
    }

    // Set headers for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    // Save Excel file to output
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
}
?>
