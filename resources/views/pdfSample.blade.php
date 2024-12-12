<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detalles del Servicio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.4;
            /* justify-content: center; */
        }
        /* .header, .footer {
            text-align: center;
            font-size: 9px;
            color: #666;
        } */
        .content {
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #00264d;
            font-size: 16px;
            margin-bottom: 20px;
        }
        h3 {
            text-align: center;
            color: #00264d;
            margin-bottom: 15px;
            font-size: 12px;
        }
        p {
            margin: 5px 0;
            text-align: center;
        }
        .info-section {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f9f9f9;
        }
        .info-section p {
            margin: 3px 0;
        }
        .materials {
        margin-top: 20px;
        }
        .material-item {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            font-size: 10px; /* Tamaño de fuente ajustado */
        }
        .material-item strong {
            margin: 10px 0; /* Espaciado entre líneas */
        }
        .material-item strong {
            color: #00264d;
        }

        /* Materiales */
        .materials-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .materials-table th, .materials-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .materials-table th {
            background-color: #f4f4f4;
            color: #333;
        }
        .materials-table td {
            color: #555;
        }

        /* Firmas en el PDF */
        .signature-section {
    display: grid; /* Cambiar a Grid Layout */
    grid-template-columns: repeat(3, 1fr); /* Tres columnas de igual ancho */
    gap: 10px; /* Espacio entre las firmas */
    width: 100%; /* Usar el ancho completo */
    margin-top: 20px; /* Espaciado superior */
}

.signature-box {
    text-align: center; /* Centrar contenido */
}

    </style>
</head>
<body>
    <!-- Contenido Principal -->
    <div class="content">
        <h1>Detalles de huevos para las fincas</h1>

        <!-- Información General -->
        <div class="info-section">
        <table class="materials-table">
            <tr>
                <th>No. de Folio</th>
                <td>{{ $folio }}</td>
            </tr>
            <tr>
                <th>Año</th>
                <td>{{ $ano }}</td>
            </tr>
            <tr>
                <th>Mes</th>
                <td>{{ $trimestre }}</td>
            </tr>
            <tr>
                <th>Nombre de la finca</th>
                <td>{{ $tipo_servicio }}</td>
            </tr>
            <tr>
                <th>Fecha de Autorización</th>
                <td>{{ $fecha_autorizacion }}</td>
            </tr>
        </table>

            <p><strong>Autorizado Por:</strong></p>
            <p><strong>Usuario:</strong> <span> {{ $usuario_name }}</span></p>
            <p><strong>Nombre:</strong>
                <span>{{ $usuario_nombre }}</span>
                <span>{{ $usuario_paterno }}</span>
                <span>{{ $usuario_materno }}</span>
            </p>

        </div>

        <!-- Lista de Materiales -->
        <h3>Informacion de los huevos</h3>
        <table class="materials-table">
            <thead>
                <tr>
                    <th>Nombre del Ave</th>
                    <th>Cantidad de Huevos</th>
                    <th>Raza de Ave</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($materiales as $material)
                    <tr>
                        <td>{{ $material['descripcion'] }}</td>
                        <td>{{ $material['cantidad'] }}</td>
                        <td>{{ $material['tipo_presentacion'] }}</td>
                        <td>{{ $material['estado'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Sección de Firmas -->
    <table style="width: 100%; text-align: center; border: none;">
        <tr>
            <td style="width: 45%;">
                ___________________________<br>
                Firma Dueño de la finca
            </td>
            <td style="width: 10%;"></td>
            <td style="width: 45%;">
                ___________________________<br>
                Firma de recibido
            </td>
        </tr>
    </table>

</body>
</html>
