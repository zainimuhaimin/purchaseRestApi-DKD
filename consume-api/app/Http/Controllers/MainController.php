<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class MainController extends Controller
{
    public function index()
    {
        if (!Session::get('isToken')) {
            return  redirect()->to('/');
        }
        $data = [
            'title' => 'Dashboard',
        ];
        return view('dashboard.pages.main', $data);
    }

    public function purchase()
    {
        if (!Session::get('isToken')) {
            return  redirect()->to('/');
        }
        $data = [
            'title' => 'Purchase',
        ];
        return view('dashboard.pages.purchase', $data);
    }

    public function goods()
    {
        if (!Session::get('isToken')) {
            return  redirect()->to('/');
        }
        $data = [
            'title' => 'Goods',
        ];
        return view('dashboard.pages.goods', $data);
    }

    public function excel()
    {
        if (!Session::get('isToken')) {
            return  redirect()->to('/');
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => [
                'bold' => true,
                'size' => 12,
                'type' => 'arial'
            ], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FF4F81BD'
                ]
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'font' => [
                'size' => 12,
                'type' => 'arial'
            ], // Set font nya jadi bold
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ],
        ];
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A9', "No");
        $sheet->setCellValue('B9', "Nama Produk");
        $sheet->setCellValue('C9', "Jumlah Produk");
        $sheet->setCellValue('D9', "Kategori");
        $sheet->setCellValue('E9', "Perusahaan Pembelian");
        $sheet->setCellValue('F9', "Total Pembayaran");
        $sheet->setCellValue('B3', "Data Pembelian");

        /* SET VALUE DI ANGSURAN */
        /* $sheet->setCellValue('C10', "1");
        $sheet->setCellValue('D10', "2");
        $sheet->setCellValue('E10', "3");
        $sheet->setCellValue('F10', "4");
        $sheet->setCellValue('G10', "5"); */

        /* loop data */

        $no = 1;
        $x = 11;
        $purchase = DB::table('purchases')->get();
        foreach ($purchase as $row) {
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $row->goods_name);
            $sheet->setCellValue('C' . $x, $row->qty);
            $sheet->setCellValue('D' . $x, $row->category);
            $sheet->setCellValue('E' . $x, $row->company);
            $sheet->setCellValue('F' . $x, $row->pay_total);
            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $x)->applyFromArray($style_row);
            $sheet->getStyle('B' . $x)->applyFromArray($style_row);
            $sheet->getStyle('C' . $x)->applyFromArray($style_row);
            $sheet->getStyle('D' . $x)->applyFromArray($style_row);
            $sheet->getStyle('E' . $x)->applyFromArray($style_row);
            $sheet->getStyle('F' . $x)->applyFromArray($style_row);
            $x++;
        }

        /* logo */
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();


        $headstyle = [
            'font' => [
                'type' => 'arial',
                'size' => 14,
                'bold' => true
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
        ];
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A9:A10')->applyFromArray($style_col);
        $sheet->getStyle('B9:B10')->applyFromArray($style_col);
        $sheet->getStyle('E9:E10')->applyFromArray($style_col);
        $sheet->getStyle('F9:F10')->applyFromArray($style_col);
        $sheet->getStyle('C9:C10')->applyFromArray($style_col);
        $sheet->getStyle('D9:D10')->applyFromArray($style_col);
        $sheet->getStyle('B3:H3')->applyFromArray($headstyle);
        $sheet->getStyle('B5:H5')->applyFromArray($headstyle);



        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->mergeCells('B3:H3');
        $spreadsheet->getActiveSheet()->mergeCells('B5:H5');
        // $spreadsheet->getActiveSheet()->mergeCells('C9:G9');
        $spreadsheet->getActiveSheet()->mergeCells('A9:A10');
        $spreadsheet->getActiveSheet()->mergeCells('C9:C10');
        $spreadsheet->getActiveSheet()->mergeCells('D9:D10');
        $spreadsheet->getActiveSheet()->mergeCells('B9:B10');
        $spreadsheet->getActiveSheet()->mergeCells('H9:H10');
        $spreadsheet->getActiveSheet()->mergeCells('E9:E10');
        $spreadsheet->getActiveSheet()->mergeCells('F9:F10');
        $spreadsheet->getActiveSheet()->mergeCells('G9:G10');
        $spreadsheet->getActiveSheet()->getStyle('A9:A10')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('D9:D10')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('B9:B10')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('H9:H10')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('I9:I10')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('J9:J10')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('K9:K10')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->setShowGridlines(false);
        $spreadsheet->getActiveSheet()->freezePane('C11');
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(1);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.75);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.75);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(1);
        $writer = new Xlsx($spreadsheet);


        $filename = date('Y-m-d') . '-' . 'Data-Pembelian';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');


        return response([
            'body' => $writer->save('php://output')
        ]);
    }

    public function pdf()
    {
        $data = [
            'purchase' => DB::table('purchases')->get()
        ];
        $generatePurchase = view('dashboard.pages.pdf', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        // instantiate and use the dompdf class
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($generatePurchase);


        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $dompdf->stream('Data Pembelian.pdf');
    }
}
