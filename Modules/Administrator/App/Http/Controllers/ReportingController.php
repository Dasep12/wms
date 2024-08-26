<?php

namespace Modules\Administrator\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Administrator\App\Models\Material;
use Modules\Administrator\App\Models\SummaryStock;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;

class ReportingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function inbound()
    {
        return view('administrator::reporting/inbound_form');
    }

    public function outbound()
    {
        return view('administrator::reporting/outbound_form');
    }

    public function jsonSummary(Request $req)
    {
        $response = SummaryStock::jsonSummary($req);
        return response()->json($response);
    }
    public function jsonDetailSummary(Request $req)
    {
        $response = SummaryStock::jsonDetailSummary($req);
        return response()->json($response);
    }

    public function jsonListMaterialSummary(Request $req)
    {
        $res = Material::where('customers_id', $req->customer_id)->get();
        return response()->json($res);
    }


    public function jsonExportExcelInbound(Request $req)
    {
        $sql = "SELECT coalesce(date_format(b.date_trans,'%m/%d/%Y'),'-')dates , a.name_material , a.no_material , a.uniqid, b.no_surat_jalan ,
        a.units , a.packaging  , a.qtyUnits  , a.qtyPackaging 
        FROM vw_tbl_inbound_detail a
        inner join vw_tbl_inbound  b on b.id  = a.headers_id 
        WHERE b.status in ('close') and  date_format(b.date_trans,'%Y-%m-%d') between '$req->startDate' AND '$req->endDate' ";

        if ($req->customer_id != "*") {
            $sql .= " AND b.customer_id='" . $req->customer_id . "'";
        }

        if ($req->material_id != "*") {
            $sql .= " AND a.material_id='" . $req->material_id . "'";
        }
        $data = DB::select($sql);

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set some data in the spreadsheet
        $sheet->setCellValue('A1', 'No');
        $sheet->mergeCells('A1:A2');
        $sheet->setCellValue('B1', 'Surat Jalan');
        $sheet->mergeCells('B1:B2');
        $sheet->setCellValue('C1', 'Date');
        $sheet->mergeCells('C1:C2');
        $sheet->setCellValue('D1', 'Material');
        $sheet->setCellValue('D2', 'Name');
        $sheet->setCellValue('E2', 'Part Number');
        $sheet->setCellValue('F2', 'Unique Id');
        $sheet->mergeCells('D1:F1');
        $sheet->setCellValue('G1', 'Detail');
        $sheet->setCellValue('G2', 'Unit');
        $sheet->setCellValue('H2', 'Packaging');
        $sheet->mergeCells('G1:H1');
        $sheet->setCellValue('I1', 'Detail Qty');
        $sheet->setCellValue('I2', 'Qty/Unit');
        $sheet->setCellValue('J2', 'Qty/Packaging');
        $sheet->mergeCells('I1:J1');

        // Apply borders to a single cell
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
                'inside' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        // Set background color for a range of cells
        $sheet->getStyle('A1:J2')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'f8fc03'], // Magenta background
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // Example: Freeze the first row
        $sheet->freezePane('E3');
        // Auto size columns based on the content
        $this->autoSizeColumns($sheet, range('A', 'J'));

        $start = 3;
        $no = 1;

        if (count($data) > 0) {
            foreach ($data as $d) {
                $sheet->setCellValue('A' . $start, $no++);
                $sheet->setCellValue('B' . $start, $d->no_surat_jalan);
                $sheet->setCellValue('C' . $start, $d->dates);
                $sheet->setCellValue('D' . $start, strtoupper($d->name_material));
                $sheet->setCellValue('E' . $start, $d->no_material);
                $sheet->setCellValue('F' . $start, strtoupper($d->uniqid));
                $sheet->setCellValue('G' . $start, strtoupper($d->units));
                $sheet->setCellValue('H' . $start, strtoupper($d->packaging));
                $sheet->setCellValue('I' . $start, strtoupper($d->qtyUnits));
                $sheet->setCellValue('J' . $start, strtoupper($d->qtyPackaging));
                $start++;
            }
        } else {
            $sheet->setCellValue('A' . $start, "data not found");
            $sheet->mergeCells('A' . $start . ':J' . $start + 1);
        }

        $sheet->getStyle('A1:J' . $start)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:J' . $start)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:J' . $start - 1)->applyFromArray($styleArray);
        $sheet->getStyle('A1:J' . $start)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


        if ($req->act == "xls") {
            // Save the spreadsheet to a file
            $writer = new Xlsx($spreadsheet);
            $tempFile = tempnam(sys_get_temp_dir(), 'php');
            $writer->save($tempFile);

            // Return the file as a response
            return response()->download($tempFile, 'export.xlsx')->deleteFileAfterSend(true);
        } else if ($req->act == "pdf") {
            // Write the file to a stream
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
            $writer = new Mpdf($spreadsheet);

            // Return the file as a response
            return response()->stream(
                function () use ($writer) {
                    $writer->save('php://output');
                },
                200,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="export.pdf"',
                ]
            );
        }
    }


    public function jsonExportExcelOutbound(Request $req)
    {
        $sql = "SELECT coalesce(date_format(b.date_trans,'%m/%d/%Y'),'-')dates , a.name_material , a.no_material , a.uniqid, b.no_surat_jalan ,
        a.units , a.packaging  , a.qtyUnits  , a.qtyPackaging 
        FROM vw_tbl_inbound_detail a
        inner join vw_tbl_outbound  b on b.id  = a.headers_id 
        WHERE b.status in ('close') and  date_format(b.date_trans,'%Y-%m-%d') between '$req->startDate' AND '$req->endDate' ";

        if ($req->customer_id != "*") {
            $sql .= " AND b.customer_id='" . $req->customer_id . "'";
        }

        if ($req->material_id != "*") {
            $sql .= " AND a.material_id='" . $req->material_id . "'";
        }
        $data = DB::select($sql);

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set some data in the spreadsheet
        $sheet->setCellValue('A1', 'No');
        $sheet->mergeCells('A1:A2');
        $sheet->setCellValue('B1', 'Surat Jalan');
        $sheet->mergeCells('B1:B2');
        $sheet->setCellValue('C1', 'Date');
        $sheet->mergeCells('C1:C2');
        $sheet->setCellValue('D1', 'Material');
        $sheet->setCellValue('D2', 'Name');
        $sheet->setCellValue('E2', 'Part Number');
        $sheet->setCellValue('F2', 'Unique Id');
        $sheet->mergeCells('D1:F1');
        $sheet->setCellValue('G1', 'Detail');
        $sheet->setCellValue('G2', 'Unit');
        $sheet->setCellValue('H2', 'Packaging');
        $sheet->mergeCells('G1:H1');
        $sheet->setCellValue('I1', 'Detail Qty');
        $sheet->setCellValue('I2', 'Qty/Unit');
        $sheet->setCellValue('J2', 'Qty/Packaging');
        $sheet->mergeCells('I1:J1');

        // Apply borders to a single cell
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
                'inside' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        // Set background color for a range of cells
        $sheet->getStyle('A1:J2')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'f8fc03'], // Magenta background
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // Example: Freeze the first row
        $sheet->freezePane('E3');
        // Auto size columns based on the content
        $this->autoSizeColumns($sheet, range('A', 'J'));

        $start = 3;
        $no = 1;

        if (count($data) > 0) {
            foreach ($data as $d) {
                $sheet->setCellValue('A' . $start, $no++);
                $sheet->setCellValue('B' . $start, $d->no_surat_jalan);
                $sheet->setCellValue('C' . $start, $d->dates);
                $sheet->setCellValue('D' . $start, strtoupper($d->name_material));
                $sheet->setCellValue('E' . $start, $d->no_material);
                $sheet->setCellValue('F' . $start, strtoupper($d->uniqid));
                $sheet->setCellValue('G' . $start, strtoupper($d->units));
                $sheet->setCellValue('H' . $start, strtoupper($d->packaging));
                $sheet->setCellValue('I' . $start, strtoupper($d->qtyUnits));
                $sheet->setCellValue('J' . $start, strtoupper($d->qtyPackaging));
                $start++;
            }
        } else {
            $sheet->setCellValue('A' . $start, "data not found");
            $sheet->mergeCells('A' . $start . ':J' . $start + 1);
        }

        $sheet->getStyle('A1:J' . $start)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:J' . $start)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:J' . $start - 1)->applyFromArray($styleArray);
        $sheet->getStyle('A1:J' . $start)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


        if ($req->act == "xls") {
            // Save the spreadsheet to a file
            $writer = new Xlsx($spreadsheet);
            $tempFile = tempnam(sys_get_temp_dir(), 'php');
            $writer->save($tempFile);

            // Return the file as a response
            return response()->download($tempFile, 'export.xlsx')->deleteFileAfterSend(true);
        } else if ($req->act == "pdf") {
            // Write the file to a stream
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
            $writer = new Mpdf($spreadsheet);

            // Return the file as a response
            return response()->stream(
                function () use ($writer) {
                    $writer->save('php://output');
                },
                200,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="export.pdf"',
                ]
            );
        }
    }


    private function autoSizeColumns($sheet, array $columns)
    {
        foreach ($columns as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    }

    public function jsonExportPdf(Request $req) {}
}
