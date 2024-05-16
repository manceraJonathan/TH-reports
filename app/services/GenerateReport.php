<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\Empleados;
use PhpOffice\PhpSpreadsheet\Style\Fill;

require '../../vendor/autoload.php';
require '../models/Empleados.php';


$spreadsheet = new Spreadsheet();
$activeWorkSheet = $spreadsheet->getActiveSheet();
$activeWorkSheet->setTitle('Personal activo');

$activeWorkSheet->getStyle('A1:I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$activeWorkSheet->getStyle('A1:I1')->getFont()->getColor()->setRGB("FFFFFF");
$activeWorkSheet->getStyle('A1:I1')->getFill()->setFillType(Fill::FILL_SOLID);
$activeWorkSheet->getStyle('A1:I1')->getFill()->getStartColor()->setRGB('FF5733');

$empleados = new Empleados();
$data = $empleados->obtenerEmpleados();


$headers = ['ID', 'NOMBRES', 'APELLIDOS', 'IDENTIFICACION', 'CONTRATO', 'CORREO PERSONAL', 'EMPRESA', 'SEDE', 'CARGO'];
$idx = 0;

for ($char = 'A'; $char <= 'I'; $char++) {
    $activeWorkSheet->getColumnDimension($char)->setAutoSize(true);
    $activeWorkSheet->setCellValue($char . '1', $headers[$idx]);
    $idx += 1;
}


$idx = 2;
foreach ($data as $row) {
    $char = 'A';
    // Recorrer cada uno de los valores de la fila
    foreach ($row as $value) {
        $activeWorkSheet->setCellValue($char . $idx, $value);
        // Se incremente la letra en cada iteración para que se desplace una columna hacia la derecha
        $char++;
    }
    $idx++;
}

$writer = new Xlsx($spreadsheet);
$filename = 'Reporte_personal_th' . '.xlsx';
$path = dirname(dirname(__DIR__)) . '/generated-content/' . $filename;

$writer->save($path);

if (file_exists($path)) {
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($path));
    // Limpiar el buffer para asegurarse de que se envien los headers actuales
    ob_clean();
    flush();
    $file = fopen($path, 'rb');
    fpassthru($file); //  Lee y envía el contenido del archivo directamente al cliente a medida que lo va leyendo del disco. 
    fclose($file);
    exit;
}