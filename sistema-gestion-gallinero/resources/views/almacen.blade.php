<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almacen</title>

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

            // Verifica que el rol sea "Almacen"
            if (decodedRole.role !== 3) {
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
                        <img src="./images/almacen.png" width="60" alt="">
                        <h1 class="title">SITIO ENTREGAS HUEVOS</h1>
                    </div>
                </div>
            </div>

            <div class="container tabs-main-content">
                <ul class="tab-list nav nav-pills" id="pills-tab" role="tablist">
                    <!-- TABLA MATERIALES NO ENTREGADOS -->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active bg-success" id="mat-no-entregados-tab" data-bs-toggle="pill" href="#mat-no-entregados" role="tab" aria-controls="mat-no-entregados" aria-selected="true"><img src="./images/no-entregado.png" width="25" alt=""> No entregado </a>
                    </li>

                    <!-- TABLA MATERIALES ENTREGADOS -->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bg-success" id="mat-entregados-tab" data-bs-toggle="pill" href="#mat-entregados" role="tab" aria-controls="mat-entregados" aria-selected="false"><img src="./images/entregado.png" width="25" alt=""> Huevos Entregados </a>
                    </li>

                    <!-- TABLA MATERIALES ENTREGA PARCIAL -->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bg-success" id="mat-entrega-parcial-tab" data-bs-toggle="pill" href="#mat-entrega-parcial" role="tab" aria-controls="mat-entrega-parcial" aria-selected="false"><img src="./images/entrega-parcial.png" width="25" alt=""> Material Entrega Parcial </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- ******************* -->
                    <!-- Material NO entregado -->
                    <div class="tab-pane fade show active" id="mat-no-entregados" role="tabpanel" aria-labelledby="mat-no-entregados-tab">
                        <div class="contenedor-modal-1-tabla-no-entregado col-sm-12">
                            <!-- Tabla enlistar servicios con DataTable -->
                            <div class="container">
                                <h2 class="title-component mb-4">Entregas Pendientes</h2>
                                <table id="tableNoEntregado" class="table-data-libreria display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Nombre de el ave</th>
                                            <th>Cantidad</th>
                                            <th>Tipo de ave</th>
                                            <th>Nombre de la finca</th>
                                            <th>Fecha Autorizacion</th>
                                            <th>Autorizado por</th>
                                            <th>Estado de la entrega</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($materiales_almacen as $material)
                                        <tr>
                                            <td>{{ $material->servicio->folio }}</td>
                                            <td>{{ $material->MaterialCan->Material->descripcion }}</td>
                                            <td>{{ $material->MaterialCan->cantidad }}</td>
                                            <td>{{ $material->MaterialCan->Material->TipoPresentacion->descripcion }}</td>
                                            <td>{{ $material->servicio->tipoServicio->descripcion }}</td>
                                            <td>{{ $material->servicio->inicio->fecha_inicio }}</td>
                                            <td>{{ $material->servicio->usuario->usuario ?? 'N/A' }}</td>
                                            <td>{{ $material->materialCan->status->status ?? 'No disponible' }}</td> <!-- Mostrar estado del material -->
                                            <td>
                                                <button class="btn btn-info btn-details-no-entregado" data-id="{{ $material->MaterialCan->id_mc }}">Detalles</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- ******************* -->
                    <!-- Huveos entregados -->
                    <div class="tab-pane fade" id="mat-entregados" role="tabpanel" aria-labelledby="mat-entregados-tab">
                        <div class="contenedor-modal-2-mat-entregados col-sm-12">
                            <!-- Tabla enlistar servicios con DataTable -->
                            <div class="container">
                                <h2 class="title-component mb-4">Materiales Entregados</h2>
                                <table id="tableEntregado" class="table-data-libreria display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>CCT</th>
                                            <th>Material</th>
                                            <th>Cantidad</th>
                                            <th>Presentación</th>
                                            <th>Tipo de Servicio</th>
                                            <th>Fecha Autorización</th>
                                            <th>Autorizado por</th>

                                            <!-- Nombre del usuario almacen y fecha entrega -->
                                            <th>Entregado por</th>
                                            <th>Fecha de entrega</th>

                                            <th>Estado del Material</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($materiales_entregados as $material)
                                        <tr>
                                            <td>{{ $material->servicio->folio }}</td>
                                            <td>{{ $material->servicio->cct}}</td>
                                            <td>{{ $material->MaterialCan->Material->descripcion }}</td>
                                            <td>{{ $material->MaterialCan->cantidad }}</td>
                                            <td>{{ $material->MaterialCan->Material->TipoPresentacion->descripcion }}</td>
                                            <td>{{ $material->servicio->tipoServicio->descripcion }}</td>
                                            <td>{{ $material->servicio->inicio->fecha_inicio }}</td>
                                            <td>{{ $material->servicio->usuario->usuario ?? 'N/A' }}</td>

                                            <!-- Nombre del usuario almacen y fecha de entrega -->
                                            <td>
                                                @if ($material->MaterialCan->entregasParciales->isNotEmpty())
                                                    @foreach ($material->MaterialCan->entregasParciales as $entregaParcial)
                                                        <p>•{{ $entregaParcial->usuario->usuario ?? 'Usuario no encontrado' }}<br></p>
                                                    @endforeach
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($material->MaterialCan->entregasParciales->isNotEmpty())
                                                    @foreach ($material->MaterialCan->entregasParciales as $entregaParcial)
                                                        <p>•{{ $entregaParcial->fecha_entrega ?? 'Fecha no registrada' }}<br></p>
                                                    @endforeach
                                                @else
                                                    N/A
                                                @endif
                                            </td>

                                            <td>{{ $material->materialCan->status->status ?? 'No disponible' }}</td>
                                            <td>
                                                <button class="btn btn-info btn-details-entregado" data-id="{{ $material->MaterialCan->id_mc }}">Detalles</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- ******************* -->
                    <!-- Material entrega parcial -->
                    <div class="tab-pane fade" id="mat-entrega-parcial" role="tabpanel" aria-labelledby="mat-entrega-parcial-tab">
                        <div class="contenedor-modal-2-mat-entrega-parcial col-sm-12">
                            <!-- Tabla enlistar servicios con DataTable -->
                            <div class="container">
                                <h2 class="title-component mb-4">Materiales en entregas parciales</h2>
                                <table id="tableEntregadaParcial" class="table-data-libreria display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>CCT</th>
                                            <th>Material</th>
                                            <th>Cantidad</th>
                                            <th>Presentación</th>
                                            <th>Tipo de Servicio</th>
                                            <th>Fecha Autorización</th>
                                            <th>Autorizado por</th>

                                            <!-- Nombre del usuario almacen y fecha entrega -->
                                            <th>Entregado por</th>
                                            <th>Fecha de entrega</th>

                                            <th>Estado del Material</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($materiales_entrega_parcial as $material)
                                        <tr>
                                            <td>{{ $material->servicio->folio }}</td>
                                            <td>{{ $material->servicio->cct}}</td>
                                            <td>{{ $material->MaterialCan->Material->descripcion }}</td>
                                            <td>{{ $material->MaterialCan->cantidad }}</td>
                                            <td>{{ $material->MaterialCan->Material->TipoPresentacion->descripcion }}</td>
                                            <td>{{ $material->servicio->tipoServicio->descripcion }}</td>
                                            <td>{{ $material->servicio->inicio->fecha_inicio }}</td>
                                            <td>{{ $material->servicio->usuario->usuario ?? 'N/A' }}</td>

                                            <!-- Nombre del usuario almacen y fecha de entrega -->
                                            <td>
                                                @if ($material->MaterialCan->entregasParciales->isNotEmpty())
                                                    @foreach ($material->MaterialCan->entregasParciales as $entregaParcial)
                                                        <p>•{{ $entregaParcial->usuario->usuario ?? 'Usuario no encontrado' }}<br></p>
                                                    @endforeach
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($material->MaterialCan->entregasParciales->isNotEmpty())
                                                    @foreach ($material->MaterialCan->entregasParciales as $entregaParcial)
                                                        <p>•{{ $entregaParcial->fecha_entrega ?? 'Fecha no registrada' }}<br></p>
                                                    @endforeach
                                                @else
                                                    N/A
                                                @endif
                                            </td>

                                            <td>{{ $material->materialCan->status->status ?? 'No disponible' }}</td>
                                            <td>
                                                <button class="btn btn-info btn-details-parcial" data-id="{{ $material->MaterialCan->id_mc }}">Detalles</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Modal para mostrar detalles del material NO ENTREGADO -->
            <div class="modal fade" id="detailsModalNoEntregado" tabindex="-1" aria-labelledby="detailsModalNoEntregadoLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailsModalNoEntregadoLabel">No entregado</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Cantidad:</strong> <span id="modalCantidad"></span></p>
                            <p><strong>Nombre de la gallina:</strong> <span id="modalDescripcion"></span></p>
                            <p><strong>Tipo de Ave:</strong> <span id="modalTipoPresentacion"></span></p>
                            <!-- <p><strong>Registrado por:</strong> <span id="usuarioEntrega"></span></p> -->

                            <!-- Formulario para guardar la cantidad entregada -->
                            <form id="formGuardarNoEntregado">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"> <!-- Token CSRF -->
                                <input type="hidden" id="idMaterialCan" name="id_material_can">
                                <div class="form-group">
                                    <label for="inputCantidadEntregada">Huevos Entregados</label>
                                    <input type="number" class="form-control" id="inputCantidadEntregada" name="cantidad_entregada" min="0.1" step="any" required autocomplete="off">

                                    <label for="comentario">Comentario</label>
                                    <textarea class="form-control" id="comentarioEnt" maxlength="80" name="comentario" rows="3" placeholder="Escribe un comentario..."></textarea>

                                    <label for="personaRecibido">Persona que recibio</label>
                                    <input type="text" class="form-control" id="recibidoEnt" maxlength="80" name="persona_recibe" placeholder="Recibido por..." required autocomplete="off"></input>

                                    <label for="inputFechaEntregaEnt">Fecha de Entrega:</label>
                                    <input type="date" class="form-control" id="inputFechaEntregaEnt" name="fecha_de_entrega" autocomplete="off" required>
                                </div>
                                <button type="submit" class="btn btn-info">Guardar Entrega</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal para mostrar detalles del huevos ENTREGADOS -->
            <div class="modal fade" id="detailsModalEntregado" tabindex="-1" aria-labelledby="detailsModalEntregadoLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailsModalEntregadoLabel">Huevos Entregados</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Cantidad:</strong> <span id="modalCantidadEnt"></span></p>
                            <p><strong>Nombre de la gallina:</strong> <span id="modalDescripcionEnt"></span></p>
                            <p><strong>Tipo de Ave:</strong> <span id="modalTipoPresentacionEnt"></span></p>

                            <p><strong>Detalles de las Entregas:</strong></p>
                            <div id="modalEntregaMaterialEnt"></div>

                            <p><strong>Total Entregado:</strong> <span id="modalEntregaTotalEnt"></span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal para mostrar detalles del material ENTREGA PARCIAL -->
            <div class="modal fade" id="detailsModalParcial" tabindex="-1" aria-labelledby="detailsModalParcialLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailsModalParcialLabel">Entrega Parcial</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Nombre de la gallina:</strong> <span id="modalDescripcionPar"></span></p>
                            <p><strong>Tipo de Ave:</strong> <span id="modalTipoPresentacionPar"></span></p>
                            <p><strong>Cantidad:</strong> <span id="modalCantidadPar"></span></p>
                            <p><strong>Detalles de las Entregas:</strong></p>
                            <div id="modalEntregaMaterialPar"></div>

                            <p><strong>Total Entregado:</strong> <span id="modalEntregaTotalPar"></span></p>
                            <p><strong>Cantidad Faltante:</strong> <span id="modalEntregaRequeridaPar"></span></p>

                            <!-- Formulario para guardar la cantidad entregada -->
                            <form id="formGuardarEntregaParcial">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"> <!-- Token CSRF -->
                                <input type="hidden" id="idMaterialCanPar" name="id_material_can">
                                <div class="form-group">
                                    <label for="inputCantidadEntregadaPar">Huevos Entregados</label>
                                    <input type="number" class="form-control" id="inputCantidadEntregadaPar" name="cantidad_entregada" min="0.1" step="any" required autocomplete="off">

                                    <label for="comentario">Comentario</label>
                                    <textarea class="form-control" id="comentarioPar" maxlength="80" name="comentario" rows="3" placeholder="Escribe un comentario..." autocomplete="off"></textarea>

                                    <label for="personaRecibido">Persona que recibio</label>
                                    <input type="text" class="form-control" id="recibidoPar" maxlength="80" name="persona_recibe" placeholder="Recibido por..." required autocomplete="off"></input>

                                    <label for="inputFechaEntregaPar">Fecha de Entrega:</label>
                                    <input type="date" class="form-control" id="inputFechaEntregaPar" name="fecha_de_entrega" autocomplete="off" required>
                                </div>
                                <button type="submit" class="btn btn-info">Guardar Entrega</button>
                            </form>
                        </div>
                        <div class="modal-footer">
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

    //------------------------------------------------------------------------------------------------
    // MATERIAL NO ENTREGADO
    //------------------------------------------------------------------------------------------------
    $(document).ready(function() {
        // Inicializar DataTables
        let table = $('#tableNoEntregado').DataTable({
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

        // Mostrar modal con los detalles del servicio
        $(document).on('click', '.btn-details-no-entregado', function () {
            var idMaterial = $(this).data('id');

            // Limpiar los campos del modal antes de cargar nueva información
            $('#modalCantidad').text('');
            $('#modalDescripcion').text('');
            $('#modalTipoPresentacion').text('');
            $('#inputCantidadEntregada').val('');

            // Realiza una solicitud AJAX para obtener los detalles del material
            $.ajax({
                url: '/obtener-detalles-materiales-almacen/' + idMaterial,
                type: 'GET',
                success: function (response) {
                    console.log(response); // Para revisar la estructura de la respuesta.

                    // Mostrar los datos en el modal
                    $('#modalCantidad').text(response.cantidad);
                    $('#modalDescripcion').text(response.descripcion);
                    $('#modalTipoPresentacion').text(response.tipo_presentacion);
                    $('#idMaterialCan').val(idMaterial); // Establece el ID de material_can para el guardado

                    // Mostrar el modal
                    $('#detailsModalNoEntregado').modal('show');
                },
                error: function (xhr) {
                    toastr.error("No se encontraron detalles del material.");
                }
            });
        });

        // Guardar la cantidad entregada cuando se envía el formulario en el modal
        $('#formGuardarNoEntregado').on('submit', function(e) {
            e.preventDefault();
            var loginToken = localStorage.getItem('login_token'); // Obtiene el token del localStorage

            if (!loginToken) {
                toastr.error("No hay un token de autenticación. Por favor, inicia sesión.");
                window.location.href = '/'; // Redirige al login si no hay token
                return;
            }

            $.ajax({
                url: '{{ route("guardar.entrega.parcial") }}',
                type: 'POST',
                data: {
                    id_material_can: $('#idMaterialCan').val(),
                    cantidad_entregada: $('#inputCantidadEntregada').val(),
                    comentario: $('#comentarioEnt').val(),
                    fecha_de_entrega: $('#inputFechaEntregaEnt').val(),
                    persona_recibe: $('#recibidoEnt').val(),
                    _token: '{{ csrf_token() }}'
                },
                headers: {
                    'Authorization': 'Bearer ' + loginToken // Incluye el token en el encabezado
                },
                success: function(response) {
                    toastr.success(response.message);
                    //$('#usuarioEntrega').text(response.usuario); // Mostrar el nombre del usuario en el modal
                    $('#detailsModal').modal('hide'); // Cerrar el modal
                    location.reload(); // Recargar la tabla para ver los cambios
                },
                error: function(xhr) {
                    toastr.error("Ingrese la cantidad requerida o faltante.");
                }
            });
        });
    });

    //------------------------------------------------------------------------------------------------
    // HUEVOS ENTREGADOS
    //------------------------------------------------------------------------------------------------
    $(document).ready(function() {
        // Inicializar DataTables
        let table = $('#tableEntregado').DataTable({
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

        // Mostrar modal con los detalles del servicio
        $(document).on('click', '.btn-details-entregado', function () {
            var idMaterial = $(this).data('id');

            // Limpiar los campos del modal antes de cargar nueva información
            $('#modalCantidadEnt').text('');
            $('#modalDescripcionEnt').text('');
            $('#modalTipoPresentacionEnt').text('');
            $('#modalEntregaMaterialEnt').html(''); // Limpiar el contenido del elemento

            // Total de las cantidades
            $('#modalEntregaTotalEnt').html('');

            // Realiza una solicitud AJAX para obtener los detalles del material
            $.ajax({
                url: '/obtener-detalles-materiales-almacen/' + idMaterial,
                type: 'GET',
                success: function (response) {
                    console.log(response); // Para revisar la estructura de la respuesta.

                    // Mostrar los datos generales en el modal
                    $('#modalCantidadEnt').text(response.cantidad);
                    $('#modalDescripcionEnt').text(response.descripcion);
                    $('#modalTipoPresentacionEnt').text(response.tipo_presentacion);

                    // Mostrar cada entrega parcial en un formato más claro
                    if (response.entrega_parcial_can.length > 0) {
                        let entregasHTML = '<ul>';
                        response.entrega_parcial_can.forEach((cantidad, index) => {
                            let usuario = response.entrega_parcial_can_usuario[index] || 'Usuario desconocido';
                            let fechaEntregado = response.fecha_entrega_material[index] || 'Fecha no registrada';
                            let comentario = response.comentarios_entrega[index] || 'Sin comentarios';
                            let personaReceptora = response.persona_que_recibe[index] || 'no hay informacion';
                            let fechaRegistro = response.entrega_fecha_registro[index] || 'sin registro';

                            entregasHTML += `
                                <li>
                                    <strong>Entregado por:</strong> ${usuario}<br>
                                    <strong>Fecha hora de entrega:</strong> ${fechaEntregado}<br>
                                    <strong>Huevos Entregados:</strong> ${cantidad}<br>
                                    <strong>Recibido por:</strong> ${personaReceptora}<br>
                                    <strong>Comentarios:</strong> ${comentario}<br>
                                    <strong>Fecha de registro:</strong> ${fechaRegistro}<br>
                                </li>
                                <hr>
                            `;
                        });
                        entregasHTML += '</ul>';
                        $('#modalEntregaMaterialEnt').html(entregasHTML);

                        //Total de todas las entregas
                        let totalEntrega = 0;
                        response.entrega_parcial_can.forEach(function (cantidad) {
                            totalEntrega += parseFloat(cantidad); // Sumar directamente la cantidad
                        });
                        $('#modalEntregaTotalEnt').html(totalEntrega);
                    } else {
                        $('#modalEntregaMaterialEnt').html('<em>No hay entregas parciales registradas.</em>');
                    }

                    // Mostrar el modal
                    $('#detailsModalEntregado').modal('show');
                },
                error: function (xhr) {
                    toastr.error("No se encontraron detalles del material.");
                }
            });
        });
    });

    //------------------------------------------------------------------------------------------------
    // MATERIAL ENTREGA PARCIAL
    //------------------------------------------------------------------------------------------------
    $(document).ready(function() {
        // Inicializar DataTables
        let table = $('#tableEntregadaParcial').DataTable({
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

        // Mostrar modal con los detalles del servicio
        $(document).on('click', '.btn-details-parcial', function () {
            var idMaterial = $(this).data('id');

            // Limpiar los campos del modal antes de cargar nueva información
            $('#modalCantidadPar').text('');
            $('#modalDescripcionPar').text('');
            $('#modalTipoPresentacionPar').text('');
            $('#modalEntregaMaterialPar').html('');

            $('#modalEntregaTotalPar').html('');

            //Cantidad Faltante
            $('#modalEntregaRequeridaPar').html('');

            // Realiza una solicitud AJAX para obtener los detalles del material
            $.ajax({
                url: '/obtener-detalles-materiales-almacen/' + idMaterial,
                type: 'GET',
                success: function (response) {
                    console.log(response); // Para revisar la estructura de la respuesta.

                    // Mostrar los datos en el modal
                    $('#modalCantidadPar').text(response.cantidad);
                    $('#modalDescripcionPar').text(response.descripcion);
                    $('#modalTipoPresentacionPar').text(response.tipo_presentacion);
                    $('#idMaterialCanPar').val(idMaterial); // Establece el ID de material_can para el guardado

                    let cantidadInicial = response.cantidad;

                    // Mostrar las entregas parciales como una lista
                    if (response.entrega_parcial_can.length > 0) {
                        let entregasHTML = '<ul>';
                        response.entrega_parcial_can.forEach((cantidad, index) => {
                            let usuario = response.entrega_parcial_can_usuario[index] || 'Usuario desconocido';
                            let fechaEntregado = response.fecha_entrega_material[index] || 'No hay fecha guardada';
                            let fechaRegistro = response.entrega_fecha_registro[index] || 'Fecha no registrada';
                            let comentario = response.comentarios_entrega[index] || 'Sin comentarios';
                            let personaReceptora = response.persona_que_recibe[index] || 'No hay informacion';

                            entregasHTML += `
                                <li>
                                    <strong>Entregado por:</strong> ${usuario}<br>
                                    <strong>Fecha de entrega:</strong> ${fechaEntregado}<br>
                                    <strong>Huevos Entregados:</strong> ${cantidad}<br>
                                    <strong>Recibido por:</strong> ${personaReceptora}<br>
                                    <strong>Comentarios:</strong> ${comentario}<br>
                                    <strong>Fecha de registro:</strong> ${fechaRegistro}<br>
                                </li>
                                <hr>
                            `;
                        });
                        entregasHTML += '</ul>';
                        $('#modalEntregaMaterialPar').html(entregasHTML);

                        let totalEntrega = 0;
                        response.entrega_parcial_can.forEach(function (cantidad) {
                            totalEntrega += parseFloat(cantidad); // Sumar directamente la cantidad
                        });
                        $('#modalEntregaTotalPar').html(totalEntrega);

                        let cantidadreq = cantidadInicial - totalEntrega;
                        var cantidadreqparse = parseFloat(cantidadreq).toFixed(1);
                        $('#modalEntregaRequeridaPar').html(cantidadreqparse);
                    } else {
                        $('#modalEntregaMaterialPar').html('<em>No hay entregas parciales registradas.</em>');
                    }

                    // Mostrar el modal
                    $('#detailsModalParcial').modal('show');
                },
                error: function (xhr) {
                    toastr.error("No se encontraron detalles del material.");
                }
            });
        });

        // Guardar la cantidad entregada cuando se envía el formulario en el modal
        $('#formGuardarEntregaParcial').on('submit', function(e) {
            e.preventDefault();

            var loginToken = localStorage.getItem('login_token'); // Obtiene el token del localStorage
            if (!loginToken) {
                toastr.error("No hay un token de autenticación. Por favor, inicia sesión.");
                window.location.href = '/'; // Redirige al login si no hay token
                return;
            }

            $.ajax({
                url: '{{ route("guardar.entrega.parcial") }}',
                type: 'POST',
                data: {
                    id_material_can: $('#idMaterialCanPar').val(),
                    cantidad_entregada: $('#inputCantidadEntregadaPar').val(),
                    comentario: $('#comentarioPar').val(),
                    fecha_de_entrega: $('#inputFechaEntregaPar').val(),
                    persona_recibe: $('#recibidoPar').val(),
                    _token: '{{ csrf_token() }}'
                },
                headers: {
                    'Authorization': 'Bearer ' + loginToken // Incluye el token en el encabezado
                },
                success: function(response) {
                    toastr.success(response.message);
                    $('#detailsModalParcial').modal('hide'); // Cerrar el modal
                    location.reload(); // Recargar la tabla para ver los cambios
                },
                error: function(xhr) {
                    toastr.error("Ingrese la cantidad faltante.");
                }
            });
        });
    });

    //------------------------------------------------------------------------------------------------
    // VALIDACION DE INPUTS
    //------------------------------------------------------------------------------------------------
    document.getElementById('inputCantidadEntregada').addEventListener('input', function (e) {
        let value = e.target.value;

        // Verificar si el valor supera los 12 dígitos
        // if (input.value.length > 12) {
        //     input.value = input.value.slice(0, 12); // Limitar a 12 dígitos
        // }

        // Permitir solo hasta 2 decimales
        if (!/^\d+(\.\d{0,1})?$/.test(value)) {
            e.target.value = value.slice(0, -1); // Elimina el último carácter no válido
        }
    });

    document.getElementById('inputCantidadEntregadaPar').addEventListener('input', function (e) {
        let value = e.target.value;

        // Verificar si el valor supera los 12 dígitos
        // if (input.value.length > 12) {
        //     input.value = input.value.slice(0, 12); // Limitar a 12 dígitos
        // }

        // Permitir solo hasta 2 decimales
        if (!/^\d+(\.\d{0,1})?$/.test(value)) {
            e.target.value = value.slice(0, -1); // Elimina el último carácter no válido
        }
    });
    </script>
</body>
</html>
