<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente</title>

        <!-- Incluir jwt-decode desde un CDN -->
        <script src="https://cdn.jsdelivr.net/npm/jwt-decode/build/jwt-decode.min.js"></script>

        <!-- Libreria Jquery -->
        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

        <!-- Incluir Toastr -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!-- Libreria Select 2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- Libreria DataTable -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Scripts dependencias-->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const loginToken = localStorage.getItem('login_token');
        const roleToken = localStorage.getItem('role_token');

        if (!loginToken || !roleToken) {
            toastr.error("Por favor, inicia sesión para acceder.");
            window.location.href = '/';
            return;
        }

        try {
            // Intenta decodificar el roleToken
            const decodedRole = jwt_decode(roleToken);
            console.log("Contenido del roleToken decodificado:", decodedRole); // Agrega esto para ver el contenido en consola

            // Verifica que el rol sea "Cliente"
            if (decodedRole.role !== 2) {
                toastr.error("Acceso no autorizado.");
                window.location.href = '/';

                    // Elimina los tokens de localStorage
                    localStorage.removeItem('login_token');
                    localStorage.removeItem('role_token');
                    localStorage.removeItem('status_token');
            }
            else {
                // Remueve la clase "remover-contenido" del div específico
                const contentDiv = document.querySelector('.remover-contenido');
                if (contentDiv) {
                    contentDiv.classList.remove('remover-contenido');
                }
            }
        } catch (error) {
            console.error("Error decodificando el token de rol:", error);
            toastr.error("Error de autenticación. Inicia sesión nuevamente.");
            window.location.href = '/';

                // Elimina los tokens de localStorage
                localStorage.removeItem('login_token');
                localStorage.removeItem('role_token');
                localStorage.removeItem('status_token');
        }
    });
    </script>

    @vite(['resources/js/app.js', 'resources/sass/app.scss'])

</head>
<body class="d-flex flex-column bg-primary homepage">
<img class="background" src="./images/gallo-fondo.jpg" alt="">

    <div class="remover-contenido">
        <div class="container-fluid component-gestion-mantenimiento">
            <div class="row">
                <div class="content-main-usuario">
                    <div class="col-7 perfil-inicio-sesion">
                        <div class="content-perfil">
                            <img src="./images/perfil.png" width="60" alt="">
                            <p class="title">Nombre de usuario: </p>
                            <p class="subtitle" id="usuarionombre"></p>
                        </div>
                    </div>

                    <div class="col-1"></div>

                    <div class="col-4 perfil-cerrar-sesion">
                        <a class="boton-logout btn btn-success" id="logoutButton">Cerrar Sesión <img src="./images/cerrar-sesion.png" width="28" alt=""></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="titulo-bienvenida">
                    <div class="content-title">
                        <img src="./images/cliente.png" width="60" alt="">
                        <h1 class="title">SITIO CLIENTE</h1>
                    </div>
                </div>
            </div>

            <div class="container tabs-main-content">
                <ul class="tab-list nav nav-pills" id="pills-tab" role="tablist">
                    <!-- TABLA MANTENIMIENTO -->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active bg-success" id="insertar-tabla-mantenimiento-tab" data-bs-toggle="pill" href="#insertar-tabla-mantenimiento" role="tab" aria-controls="insertar-tabla-mantenimiento" aria-selected="true"><img src="./images/informacion-servicio.png" width="25" alt=""> Tabla Fincas de Aves </a>
                    </li>

                    <!-- FORMULARIO MANTENIMIENTO -->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bg-success" id="insertar-mantenimiento-tab" data-bs-toggle="pill" href="#insertar-mantenimiento" role="tab" aria-controls="insertar-mantenimiento" aria-selected="false"><img src="./images/servicio.png" width="25" alt=""> Registro Huevos </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- ******************* -->
                    <!-- TABLA MANT. -->
                    <div class="tab-pane fade show active" id="insertar-tabla-mantenimiento" role="tabpanel" aria-labelledby="insertar-tabla-mantenimiento-tab">
                        <div class="contenedor-modal-1-tabla-mantenimiento col-sm-12">
                            <!-- Tabla enlistar servicios con DataTable -->
                            <div class="container">
                                <h2 class="title-component mb-4">Control de Aves</h2>
                                <table id="servicesTable" class="table-data-libreria display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Año</th>
                                            <th>Trimestre</th>
                                            <th>Tipo de Servicio</th>
                                            <th>Usuario Creador</th>
                                            <th>Usuario Editor</th> <!-- Nueva columna para el usuario que realizó la última edición -->
                                            <th>Folio</th> <!-- Nueva columna -->
                                            <th>Fecha de Creación</th> <!-- Nueva columna -->
                                            <th>Ultima Edicion</th> <!-- Nueva columna -->
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($servicios as $servicio)
                                        <tr>
                                            <td>{{ $servicio->ano }}</td>
                                            <td>{{ $servicio->trimestre->descripcion }}</td>
                                            <td>{{ $servicio->tipoServicio->descripcion }}</td>
                                            <td>{{ $servicio->usuario->usuario ?? 'N/A' }}</td>
                                            <td>{{ $servicio->usuarioEditor->usuario ?? 'N/A' }}</td> <!-- Muestra el último usuario editor -->
                                            <td>{{ $servicio->folio }}</td> <!-- Nueva columna para Folio -->
                                            <td>{{ $servicio->created_at ? $servicio->created_at->setTimezone('America/Mazatlan')->format('d/m/Y H:i') : 'Sin fecha' }}</td>
                                            <td>{{ $servicio->updated_at ? $servicio->updated_at->setTimezone('America/Mazatlan')->format('d/m/Y H:i') : 'Sin fecha' }}</td>
                                            <td>
                                                <button class="btn btn-info btn-details" data-id="{{ $servicio->id_servicio }}">Detalles</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- ******************* -->
                    <!-- INSERTAR MANTENIMIENTO -->
                    <div class="tab-pane fade" id="insertar-mantenimiento" role="tabpanel" aria-labelledby="insertar-mantenimiento-tab">
                        <div class="contenedor-modal-2-insertar-mantenimiento col-sm-12">
                            <div class="content-obtener-pdf">
                                <!-- Agregar Mantenimiento lista materiales (formulario) -->
                                <div class="container">
                                    <h2 class="title-component mb-4">Agregar Entrega de Huevos</h2>
                                    <form id="mantenimientoForm">
                                        @csrf
                                        <!-- Contenedor para mostrar los resultados -->
                                        <div id="resultadoBusqueda" class="mt-3"></div>

                                        <div class="mb-3">
                                            <label for="ano" class="form-label">Año:</label>
                                            <select id="ano" name="ano" class="form-select selector-list-ano" required>
                                                <option value="2005">2005</option>
                                                <option value="2006">2006</option>
                                                <option value="2007">2007</option>
                                                <option value="2008">2008</option>
                                                <option value="2009">2009</option>
                                                <option value="2010">2010</option>
                                                <option value="2011">2011</option>
                                                <option value="2012">2012</option>
                                                <option value="2013">2013</option>
                                                <option value="2014">2014</option>
                                                <option value="2015">2015</option>
                                                <option value="2016">2016</option>
                                                <option value="2017">2017</option>
                                                <option value="2018">2018</option>
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                                <option value="2027">2027</option>
                                                <option value="2028">2028</option>
                                                <option value="2029">2029</option>
                                                <option value="2030">2030</option>
                                                <option value="2031">2031</option>
                                                <option value="2032">2032</option>
                                                <option value="2033">2033</option>
                                                <option value="2034">2034</option>
                                                <option value="2035">2035</option>
                                                <option value="2036">2036</option>
                                                <option value="2037">2037</option>
                                                <option value="2038">2038</option>
                                                <option value="2039">2039</option>
                                                <option value="2040">2040</option>
                                                <option value="2041">2041</option>
                                                <option value="2042">2042</option>
                                                <option value="2043">2043</option>
                                                <option value="2044">2044</option>
                                                <option value="2045">2045</option>
                                                <option value="2046">2046</option>
                                                <option value="2047">2047</option>
                                                <option value="2048">2048</option>
                                                <option value="2049">2049</option>
                                                <option value="2050">2050</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="trimestre" class="form-label">Trimestre:</label>
                                            <select id="trimestre" name="trimestre" class="form-select" required>
                                                @foreach($trimestres as $trimestre)
                                                <option value="{{ $trimestre->id_trimestre }}">{{ $trimestre->descripcion }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tipo_servicio" class="form-label">Tipo de Servicio:</label>
                                            <select id="tipo_servicio" class="selector-list-tipo-servicio" name="tipo_servicio" class="form-select" required>
                                                @foreach($tipos_servicios as $tipo_servicio)
                                                <option value="{{ $tipo_servicio->id_servicio }}">{{ $tipo_servicio->descripcion }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="fecha_inicio" class="form-label">Fecha de Autorización:</label> <b><i>(Opcional).</i></b>
                                            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" autocomplete="off">
                                        </div>

                                        <!-- <div class="mb-3">
                                            <label for="fecha_entrega" class="form-label">Fecha de Entrega:</label> <b><i>(Opcional).</i></b>
                                            <input type="date" id="fecha_entrega" name="fecha_entrega" class="form-control" disabled>
                                        </div> -->

                                        <!-- Bloque principal de materiales -->
                                        <div id="materiales-wrapper">
                                            <div class="material-block">
                                                <div class="form-group">
                                                    <label for="material">Material</label>
                                                    <select name="material[]" class="form-control selector-list-materiales">
                                                        @foreach($materiales as $material)
                                                            <option value="{{ $material->id_material }}">{{ $material->descripcion }} - {{ $material->tipoPresentacion->descripcion }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="cantidad">Cantidad de Material</label>
                                                    <input type="number" name="cantidad[]" class="cantidadMantForm form-control" placeholder="¿Cuanto es de material?" id="cantidadMant" min="0.1" step="any" autocomplete="off">
                                                </div>

                                                <!-- Botón para eliminar el bloque -->
                                                <button type="button" class="btn btn-danger remove-material-btn">Eliminar Material</button>
                                                <hr>
                                            </div>
                                        </div>
                                        <!-- Botón para agregar otro material -->
                                        <button type="button" id="add-material-btn" class="btn btn btn-info">Agregar otro material</button>
                                        <button type="submit" id="button-servicio" class="btn btn-success">Enviar</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de confirmación -->
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que deseas eliminar esta finca?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Modal para mostrar los detalles del servicio -->
            <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailsModalLabel">Detalles de huevos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p style="text-align:center; color:#740624;"><strong>INFORMACION DEL SERVICIO</strong></p>
                        <!-- Información de la API (CCT) -->

                        <!-- Información de la (BASE DE DATOS) -->
                        <p><strong>Año:</strong> <span id="modalAno"></span></p>
                        <p><strong>Trimestre:</strong> <span id="modalTrimestre"></span></p>
                        <p><strong>Nombre de finca:</strong> <span id="modalTp"></span></p>
                        <!-- Información de la API (CCT) -->

                        <p><strong>Folio:</strong> <span id="modalFolio"></span></p>
                        <p><strong>Fecha de Autorización:</strong> <span id="modalFechaInicio"></span></p>
                        <!-- <p><strong>Fecha de Entrega:</strong> <span id="modalFechaEntrega"></span></p> -->

                        <!-- Listado de materiales (BASE DE DATOS) -->
                        <p style="text-align:center; color:#740624;"><strong>Huevos</strong></p>
                        <div id="modalMateriales"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="generatePdf">Generar PDF <img src="./images/pdf.png" width="25" alt=""></button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    //Mostrar Nombre de usuario en la pagina.
    document.addEventListener('DOMContentLoaded', function () {
        const usuarioToken = localStorage.getItem('login_token');

        // Decodificar el token para obtener el nombre de usuario
        if (usuarioToken) {
            try {
                const decodedToken = jwt_decode(usuarioToken);
                const nombreUsuario = decodedToken.usuario;

                if (nombreUsuario) {
                    document.getElementById('usuarionombre').textContent = nombreUsuario;
                } else {
                    console.error("Campo 'usuario' no encontrado en el token.");
                }
            } catch (error) {
                console.error("Error al decodificar el token JWT:", error);
            }
        } else {
            console.error("Token 'usuario_token' no encontrado.");
        }
    });

    // Cerrar Sesion
    document.getElementById('logoutButton').addEventListener('click', function () {
        // Eliminar los tokens de localStorage
        localStorage.removeItem('login_token');
        localStorage.removeItem('role_token');
        localStorage.removeItem('status_token');

        // Mostrar mensaje de confirmación
        toastr.success("Has cerrado sesión correctamente.");

        // Redirigir a la página de inicio de sesión
        window.location.href = '/';
    });

    // Inicializar tabla con todos los servicios (DataTables)
    $(document).ready(function() {
        // Inicializar DataTables
        let table = $('#servicesTable').DataTable({
            deferRender: true,
            language: {
                processing: "Procesando...",
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros totales)",
                infoPostFix: "",
                loadingRecords: "Cargando...",
                zeroRecords: "No se encontraron registros coincidentes",
                emptyTable: "No hay datos disponibles en la tabla",
                paginate: {
                    first: "Primero",
                    previous: "<< Anterior",
                    next: "Siguiente >>",
                    last: "Último"
                },
                aria: {
                    sortAscending: ": activar para ordenar la columna ascendente",
                    sortDescending: ": activar para ordenar la columna descendente"
                }
            }
        });

        let deleteId; // Variable para almacenar el ID del servicio a eliminar

        // Mostrar modal de confirmación para eliminar
        $(document).on('click', '.btn-delete', function () {
            deleteId = $(this).data('id'); // Captura el ID del servicio
            $('#confirmDeleteModal').modal('show'); // Muestra el modal
        });

        // Eliminar servicio
        $('#confirmDeleteBtn').click(function () {
            $.ajax({
                url: '/eliminar-servicio/' + deleteId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: deleteId
                },
                success: function (response) {
                    $('#confirmDeleteModal').modal('hide'); // Oculta el modal de confirmación

                    // Elimina la fila de la tabla sin recargar la página
                    table
                        .row($('button[data-id="' + deleteId + '"]').parents('tr')) // Encuentra la fila del botón eliminar
                        .remove() // Remueve la fila
                        .draw(false); // Actualiza la tabla sin recargar

                    toastr.success('Servicio eliminado correctamente.', 'Éxito', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 3000,  // Tiempo antes de que se cierre automáticamente
                        positionClass: 'toast-top-right'
                    });
                },
                error: function (xhr) {
                    toastr.error('Error al intentar eliminar el servicio.');
                }
            });
        });

        // Mostrar modal con los detalles del servicio
        $(document).on('click', '.btn-details', function () {
            var idServicio = $(this).data('id');

            // Limpiar los campos del modal antes de cargar nueva información
            $('#modalAno').text('');
            $('#modalTrimestre').text('');
            $('#modalTp').text('');
            $('#modalMateriales').html('');
            $('#modalFolio').text('');
            $('#modalFechaInicio').text(''); // Limpiar fecha de inicio
            //$('#modalFechaEntrega').text(''); // Limpiar fecha de entrega
            // Realiza una solicitud AJAX para obtener los detalles del servicio
            $.ajax({
                url: '/obtener-detalles-servicio/' + idServicio,
                type: 'GET',
                success: function (response) {
                    console.log(response); // Para revisar la estructura de la respuesta.

                    // Mostrar los datos del servicio (CCT y Año)
                    $('#modalAno').text(response.ano);
                    $('#modalTrimestre').text(response.trimestre);
                    $('#modalTp').text(response.tipoServicio);
                    $('#modalFolio').text(response.folio);

                    // Mostrar fechas o mensaje si son null
                    $('#modalFechaInicio').text(response.fecha_inicio || 'No hay fechas registradas.');
                    // $('#modalFechaEntrega').text(response.fecha_entrega || 'No hay fechas registradas.');

                    var materialesHtml = '';
                    $.each(response.ser_mat_can, function (index, item) {
                        // Verificar si el materialCan y material existen y mostrar los datos correspondientes.
                        if (item.material_can && item.material_can.material) {
                            let descripcionMaterial = item.material_can.material.descripcion || 'Sin descripción';
                            let cantidadMaterial = item.material_can.cantidad || 'Sin cantidad';

                            // Verificar si el tipo de presentación existe antes de acceder a él
                            let tipoPresentacion = item.material_can.material.tipo_presentacion ? item.material_can.material.tipo_presentacion.descripcion : 'Sin presentación';
                            let estadoMaterial = item.material_can.status ? item.material_can.status.status : 'Estado no definido';

                            materialesHtml += `
                                <p>Nombre del Ave: ${descripcionMaterial}</p>
                                <p>Cantidad: ${cantidadMaterial}</p>
                                <p>Tipo de Ave: ${tipoPresentacion}</p>
                                <p>Estado: ${estadoMaterial}</p>
                                <hr>
                            `;
                        } else {
                            materialesHtml += `
                                <p>Material no definido para este ítem</p>
                                <hr>
                            `;
                            console.error('Material no definido para el ítem', item);
                        }
                    });

                    // Agregar los datos al modal
                    $('#modalMateriales').html(materialesHtml);

                    // Mostrar el modal
                    $('#detailsModal').modal('show');
                },
                error: function (xhr) {
                    toastr.error("No se encontraron detalles del servicio.");
                }
            });
        });

        $(document).on('click', '#generatePdf', function () {
            var data = {
                //_token: $('meta[name="csrf-token"]').attr('content'), // Agrega el token CSRF
                ano: $('#modalAno').text(),
                trimestre: $('#modalTrimestre').text(),
                tipo_servicio: $('#modalTp').text(),
                folio: $('#modalFolio').text(),
                fecha_autorizacion: $('#modalFechaInicio').text(),
                materiales: [] // Recopilar materiales del modal
            };

            // Recopilar materiales desde el modal
            $('#modalMateriales').find('hr').each(function () {
                // Encuentra los elementos <p> relacionados al material antes del <hr>
                let materialElement = $(this).prevUntil('hr').toArray().reverse(); // Invierte el orden

                // Verifica que los elementos sean suficientes para un material completo
                if (materialElement.length === 4) {
                    let descripcion = $(materialElement[0]).text().replace('Material: ', '').trim();
                    let cantidad = $(materialElement[1]).text().replace('Cantidad: ', '').trim();
                    let tipoPresentacion = $(materialElement[2]).text().replace('Tipo de Presentación: ', '').trim();
                    let estado = $(materialElement[3]).text().replace('Estado: ', '').trim();

                    // Agregar el material al arreglo
                    data.materiales.push({
                        descripcion: descripcion,
                        cantidad: cantidad,
                        tipo_presentacion: tipoPresentacion,
                        estado: estado
                    });
                } else {
                    console.error('Estructura de materiales incompleta o inválida antes del <hr>.');
                }
            });

            // Verifica que los materiales se recopilen correctamente
            console.log(data.materiales);

            $.ajax({
                url: '/generar-pdf',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data), // Convertir a JSON
                success: function (response) {
                    toastr.success("PDF generado correctamente.");
                    // Abrir el PDF en una nueva pestaña
                    window.open(response.url, '_blank'); // Previsualizar el PDF
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    toastr.error("Error al generar el PDF.");
                }
            });
        });
    });

    //---- Formulario de mantenimiento -----
    $(document).ready(function () {
        $('#mantenimientoForm').submit(function (event) {
            event.preventDefault();

            var formData = $(this).serialize();
            var loginToken = localStorage.getItem('login_token'); // Obtiene el token del localStorage

            if (!loginToken) {
                toastr.error("No hay un token de autenticación. Por favor, inicia sesión.");
                window.location.href = '/'; // Redirige al login si no hay token
                return;
            }

            $.ajax({
                url: "{{ route('api.insertData') }}", // Asegúrate de que esta ruta está definida
                type: 'POST',
                data: formData,
                headers: {
                    'Authorization': 'Bearer ' + loginToken // Incluye el token en el encabezado
                },
                success: function (response) {
                    toastr.success(response.success || 'Datos insertados correctamente.');
                    $('#mantenimientoForm')[0].reset();
                    location.reload(); // Recargar la tabla para ver los cambios
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.error || 'Error al agregar el mantenimiento.');
                }
            });
        });
    });

    document.getElementById('add-material-btn').addEventListener('click', function() {

        // Clonar el bloque de material
        var materialBlock = document.querySelector('.material-block').cloneNode(true);

        // Limpiar los valores de los campos del nuevo bloque clonado
        materialBlock.querySelectorAll('input').forEach(function(input) {
            input.value = '';
        });

        // Agregar el nuevo bloque clonado al contenedor
        document.getElementById('materiales-wrapper').appendChild(materialBlock);

        // Agregar funcionalidad al botón de eliminar del nuevo bloque
        materialBlock.querySelector('.remove-material-btn').addEventListener('click', function() {
            materialBlock.remove();
            toggleRemoveButtons(); // Verificar si se deben mostrar los botones de eliminar
        });

        toggleRemoveButtons(); // Actualizar visibilidad de botones de eliminar

        // Cantidad formulario mantenimiento
        document.querySelectorAll('.cantidadMantForm').forEach(function(input) {
            input.addEventListener('input', function (event) {
                // Verificar si el valor supera los 12 dígitos
                if (input.value.length > 12) {
                    input.value = input.value.slice(0, 12); // Limitar a 12 dígitos
                }

                // Validar que solo tenga hasta 2 decimales
                if (!/^\d+(\.\d{0,1})?$/.test(input.value)) {
                    input.value = input.value.slice(0, -1); // Eliminar último carácter no válido
                }
            });
        });
    });

    // Función para eliminar el bloque de material
    document.querySelectorAll('.remove-material-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            button.parentElement.remove();
            toggleRemoveButtons(); // Verificar si se deben mostrar los botones de eliminar
        });
    });

    // Función para mostrar/ocultar los botones de eliminar
    function toggleRemoveButtons() {
        const materialBlocks = document.querySelectorAll('.material-block');
        const removeButtons = document.querySelectorAll('.remove-material-btn');

        if (materialBlocks.length === 1) {
            // Si solo hay un bloque, ocultar el botón de eliminar
            removeButtons.forEach(button => button.style.display = 'none');
        } else {
            // Si hay más de un bloque, mostrar los botones de eliminar
            removeButtons.forEach(button => button.style.display = 'inline-block');
        }
    }

    // Ejecutar la función al cargar la página para manejar el bloque inicial
    toggleRemoveButtons();

    // Listados con buscador en el select
    //$(document).ready(function() {
        //$('.selector-list-materiales').select2();
    //});

    // Listados con buscador en el select
    $(document).ready(function() {
        $('.selector-list-tipo-servicio').select2();
    });

    // Listados con buscador en el select
    $(document).ready(function() {
        $('.selector-list-ano').select2();
    });

    // ------------ Validaciones del formulario -----------------

    // Cantidad formulario mantenimiento
    document.querySelectorAll('.cantidadMantForm').forEach(function(input) {
        input.addEventListener('input', function (event) {
            // Verificar si el valor supera los 12 dígitos
            if (input.value.length > 12) {
                input.value = input.value.slice(0, 12); // Limitar a 12 dígitos
            }

            // Validar que solo tenga hasta 2 decimales
            if (!/^\d+(\.\d{0,1})?$/.test(input.value)) {
                input.value = input.value.slice(0, -1); // Eliminar último carácter no válido
            }
        });
    });

    </script>
</body>
</html>
