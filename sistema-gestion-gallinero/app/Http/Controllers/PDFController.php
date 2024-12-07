<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF;

class PDFController extends Controller
{
    public function generatePDF(Request $request)
    {
        $data = $request->all();

        // Procesar los materiales
        if (!empty($data['materiales']) && is_array($data['materiales'])) {
            $data['materiales'] = collect($data['materiales'])->map(function ($material) {
                return [
                    'descripcion' => $material['descripcion'] ?? 'Sin descripción',
                    'cantidad' => $material['cantidad'] ?? '0',
                    'tipo_presentacion' => $material['tipo_presentacion'] ?? 'Sin presentación',
                    'estado' => $material['estado'] ?? 'Estado no definido',
                ];
            })->toArray();
        } else {
            $data['materiales'] = [];
        }

        // Verifica los materiales procesados
        logger($data['materiales']);

        // Generar HTML desde la vista
        $html = view('pdfSample', $data)->render();

        // Obtener la fecha y hora actuales
        $fecha_hora = date('Y-m-d H:i:s');

        // Crear una clase personalizada de TCPDF
        $pdf = new class extends \TCPDF {
            // Encabezado
            public function Header()
            {
                // Ruta de la imagen del encabezado
                $headerImage = public_path('images/pdf-images/header.png');
                //$this->Image($headerImage, 10, 10, 190); // Ajusta las coordenadas y tamaño
                $this->Image($headerImage, 0, 0, 165, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            }

            // Pie de página
            public function Footer()
            {
                // Ruta de la imagen del pie de página
                $footerImage = public_path('images/pdf-images/footer.png');
                //$this->Image($footerImage, 10, -30, 190); // Ajusta las coordenadas y tamaño
                $this->Image($footerImage, 0,  $this->GetY()-28, 210, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

                // Número de página
                $this->SetY(-8);
                $this->SetFont('helvetica', 'I', 8);
                $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
            }
        };

        // Configuración del PDF
        $pdf->SetMargins(10, 25, 10); // Márgenes: Izquierdo, Superior (debajo del header), Derecho
        $pdf->SetAutoPageBreak(true, 40); // Evita encimar contenido con el pie de página
        $pdf->SetTitle('Detalles del Servicio');

        // Agregar página y contenido
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, "");
        // Mostrar la fecha y hora de generación
        $pdf->writeHTMLCell(0, 0, 6.5, 1, '<p style="font-size:6pt; color:#000; font-family:helvetica;"> <b>Fecha y Hora de Generación:</b> ' . htmlspecialchars($fecha_hora) . '</p>', 0, 1, 0, true, 'L', true);

        // Guardar el PDF en el servidor
        $fileName = 'DetallesServicio.pdf'; // Nombre fijo
        $outputPath = public_path('pdfs/' . $fileName);
        $pdf->Output($outputPath, 'F'); // Guardar el archivo

        // Retornar la URL para previsualización
        return response()->json(['url' => asset('pdfs/' . $fileName)]);
    }
}
