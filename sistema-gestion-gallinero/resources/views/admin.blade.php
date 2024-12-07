<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>

        <!-- Incluir jwt-decode desde un CDN -->
        <script src="https://cdn.jsdelivr.net/npm/jwt-decode/build/jwt-decode.min.js"></script>

        <!-- Librería Jquery -->
        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

        <!-- Incluir Toastr -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!-- Librería Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- Estilos de DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

        <!-- Generar Archivo de Excel  -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

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
            if (decodedRole.role !== 1) {
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

                // Elimina los tokens de localStorage
                localStorage.removeItem('login_token');
                localStorage.removeItem('role_token');
                localStorage.removeItem('status_token');

            window.location.href = '/';
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
                        <img src="./images/administrador.png" width="60" alt="">
                        <h1 class="title">SITIO ADMINISTRADOR HUEVOS</h1>
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
                        <a class="nav-link bg-success" id="insertar-mantenimiento-tab" data-bs-toggle="pill" href="#insertar-mantenimiento" role="tab" aria-controls="insertar-mantenimiento" aria-selected="false"><img src="./images/servicio.png" width="25" alt=""> Registro huevos </a>
                    </li>

                    <!-- TABLA USUARIOS -->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bg-success" id="insertar-tabla-usuarios-tab" data-bs-toggle="pill" href="#insertar-tabla-usuarios" role="tab" aria-controls="insertar-tabla-usuarios" aria-selected="false"><img src="./images/usuarios.png" width="25" alt=""> Usuarios </a>
                    </li>

                    <!-- FORMULARIO REGISTRO -->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bg-success" id="insertar-registro-tab" data-bs-toggle="pill" href="#insertar-registro" role="tab" aria-controls="insertar-registro" aria-selected="false"><img src="./images/registros.png" width="25" alt=""> Registro Usuarios </a>
                    </li>

                    <!-- FORMULARIO INSERTAR SERVICIO -->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bg-success" id="insertar-servicio-tab" data-bs-toggle="pill" href="#insertar-servicio" role="tab" aria-controls="insertar-servicio" aria-selected="false"><img src="./images/Agregar.png" width="25" alt=""> Agregar Finca </a>
                    </li>

                    <!-- FORMULARIO INSERTAR MATERIAL -->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bg-success" id="insertar-material-tab" data-bs-toggle="pill" href="#insertar-material" role="tab" aria-controls="insertar-material" aria-selected="false"><img src="./images/material.png" width="25" alt=""> Agregar Ave Ponedora </a>
                    </li>

                    <!-- OBTENER ARCHIVO JSON -->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bg-success" id="insertar-json-tab" data-bs-toggle="pill" href="#insertar-json" role="tab" aria-controls="insertar-json" aria-selected="false"><img src="./images/archivo-json.png" width="25" alt=""> Obtener JSON </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- ******************* -->
                    <!-- TABLA MANT. -->
                    <div class="tab-pane fade show active" id="insertar-tabla-mantenimiento" role="tabpanel" aria-labelledby="insertar-tabla-mantenimiento-tab">
                        <div class="contenedor-modal-1-tabla-mantenimiento col-sm-12">
                            <!-- Lista de servicios con DataTable -->
                            <div class="container">
                                <h2 class="title-component mb-4">Control de Aves</h2>
                                <table id="servicesTable" class="table-data-libreria display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Año</th>
                                            <th>Mes</th>
                                            <th>Finca de aves</th>
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
                                                <button class="btn btn-warning btn-edit" data-id="{{ $servicio->id_servicio }}">Editar</button>
                                                <button class="btn btn-danger btn-delete" data-id="{{ $servicio->id_servicio }}">Eliminar</button>
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
                                    <h2 class="title-component mb-4">Agregar entrega de huevos</h2>
                                    <form id="mantenimientoForm">
                                        @csrf

                                        <!-- Contenedor para mostrar los resultados -->
                                        <div id="resultadoBusqueda" class="mt-3"></div>

                                        <div class="mb-3">
                                            <label for="ano" class="form-label">Año:</label>
                                            <select id="ano" name="ano" class="form-select selector-list-ano" required >
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
                                            <label for="trimestre" class="form-label">Mes:</label>
                                            <select id="trimestre" name="trimestre" class="form-select" required>
                                                @foreach($trimestres as $trimestre)
                                                <option value="{{ $trimestre->id_trimestre }}">{{ $trimestre->descripcion }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tipo_servicio" class="form-label">Nombre finca:</label>
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
                                                    <label for="material">Ave</label>
                                                    <select name="material[]" class="form-control">
                                                        @foreach($materiales as $material)
                                                            <option value="{{ $material->id_material }}">{{ $material->descripcion }} - {{ $material->tipoPresentacion->descripcion }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="cantidad">Cantidad de huevos</label>
                                                    <input type="number" name="cantidad[]" class="cantidadMantForm form-control" placeholder="¿Cuanto es de material?" id="cantidadMant" min="0.1" step="any" autocomplete="off">
                                                </div>

                                                <!-- Botón para eliminar el bloque -->
                                                <button type="button" class="btn btn-danger remove-material-btn">Eliminar datos</button>
                                                <hr>
                                            </div>
                                        </div>
                                        <!-- Botón para agregar otro material -->
                                        <button type="button" id="add-material-btn" class="btn btn-info">Agregar otro material</button>
                                        <button type="submit" id="button-servicio" class="btn btn-success" >Enviar</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ******************* -->
                    <!-- TABLA USUARIOS -->
                    <div class="tab-pane fade" id="insertar-tabla-usuarios" role="tabpanel" aria-labelledby="insertar-tabla-usuarios-tab">
                        <div class="contenedor-modal-3-tabla-usuarios col-sm-12">
                            <div class="content-obtener-pdf">
                                <!-- Tabla listar usuarios (activar y desactivar) -->
                                <div class="container">
                                    <h2 class="title-component mb-4">Usuarios</h2>
                                    <table id="usuariosTable" class="table-data-libreria display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Usuario</th>
                                                <th>Nombre</th>
                                                <th>Apellido Paterno</th>
                                                <th>Apellido Materno</th>
                                                <th>Rol</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ******************* -->
                    <!-- REGISTRO -->
                    <div class="tab-pane fade" id="insertar-registro" role="tabpanel" aria-labelledby="insertar-registro-tab">
                        <div class="contenedor-modal-4-insertar-registro col-sm-12">
                            <div class="content-obtener-pdf">
                                <!-- Registro de Usuario (formulario) -->
                                <div class="container">
                                    <h2 class="title-component mb-4">Registro de Usuario</h2>
                                    <form id="registerForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="register_usuario" class="form-label">Usuario</label> <b><i>(Verifica que el nombre de usuario no se encuentre ya registrado).</i></b>
                                            <input type="text" id="register_usuario" name="usuario" class="form-control" placeholder="Ingresa nombre de usuario" required maxlength="15" autocomplete="off">
                                        </div>
                                        <div class="mb-3">
                                            <label for="register_clave" class="form-label">Contraseña</label> <b><i>(Minimo 6 caracteres).</i></b>
                                            <input type="password" id="register_clave" name="clave" class="form-control" placeholder="Minimo 6 digitos" required maxlength="20" autocomplete="off">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingresa nombre" required maxlength="30" autocomplete="off">
                                        </div>
                                        <div class="mb-3">
                                            <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
                                            <input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control" placeholder="Ingresa Apellido Paterno" required maxlength="20" autocomplete="off">
                                        </div>
                                        <div class="mb-3">
                                            <label for="apellido_materno" class="form-label">Apellido Materno</label> <b><i>(Opcional).</i></b>
                                            <input type="text" id="apellido_materno" name="apellido_materno" class="form-control" placeholder="Ingresa Apellido Materno" maxlength="20" autocomplete="off">
                                        </div>
                                        <div class="mb-3">
                                            <label for="fk_rol" class="form-label">Rol</label> <b><i>(Otorga los permisos que obtendra el usuario).</i></b>
                                            <select id="fk_rol" name="fk_rol" class="form-select">
                                                <option value="1">Administrador</option>
                                                <option value="2">Cliente</option>
                                                <option value="3">Almacen</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fk_estado" class="form-label">Estado</label> <b><i>(Añade si el usuario estara habilitado para iniciar sesion o no).</i></b>
                                            <select id="fk_estado" name="fk_estado" class="form-select">
                                                <option value="1">Activo</option>
                                                <option value="2">Inactivo</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-success">Registrar</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ******************* -->
                    <!-- INSERTAR SERVICIO -->
                    <div class="tab-pane fade" id="insertar-servicio" role="tabpanel" aria-labelledby="insertar-servicio-tab">
                        <div class="contenedor-modal-5-insertar-servicio col-sm-12">
                            <div class="content-obtener-pdf">
                                <!-- Insertar Tipo de servicio (formulario) -->
                                <div class="container">
                                    <h2 class="title-component mb-4">Agregar Finca</h2>
                                    <form id="tipoServicioForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="descripcion" class="form-label">Nombre de la finca:</label>
                                            <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Plomeria, Impermeabilización, Sustitucion de sanitarios etc." required maxlength="50" autocomplete="off">
                                        </div>
                                        <button type="submit" class="btn btn-info">Agregar Finca</button>
                                    </form>
                                    <div id="message" class="mt-3"></div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ******************* -->
                    <!-- INSERTAR MATERIAL -->
                    <div class="tab-pane fade" id="insertar-material" role="tabpanel" aria-labelledby="insertar-material-tab">
                        <div class="contenedor-modal-6-insertar-material col-sm-12">
                            <div class="content-obtener-pdf">
                                <!-- Insertar Material y tipo de presentacion (formulario) -->
                                <div class="container">
                                    <h2 class="title-component mb-4">Agregar Ave Ponedora</h2>
                                    <form id="materialForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="material_descripcion" class="form-label">Nombre del ave: </label> <b></b>
                                            <input type="text" class="form-control" id="material_descripcion" name="material_descripcion" placeholder="Cemento, Pintura, Varillas, Pegapiso, etc." required maxlength="50" autocomplete="off">
                                        </div>

                                        <div class="mb-3">
                                            <label for="tipo_presentacion" class="form-label">Raza de ave: </label> <b></b>
                                            <input type="text" class="form-control" id="tipo_presentacion" name="tipo_presentacion" placeholder="Piezas, Kilos, Cajas, Litros etc." required maxlength="30" autocomplete="off">
                                        </div>

                                        <button type="submit" class="btn btn-info">Agregar Ave</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ******************* -->
                    <!-- OBTENER JSON -->
                    <div class="tab-pane fade" id="insertar-json" role="tabpanel" aria-labelledby="insertar-json-tab">
                        <div class="contenedor-modal-7-insertar-json col-sm-12">
                            <div class="content-obtener-pdf">
                                <!-- Generar un archivo json con los datos filtrados trimestre y año -->
                                <div class="container">
                                    <h2 class="title-component mb-4">Obtener cifras en formato JSON</h2>
                                    <div class="content-select-buttons">
                                        <div class="uno-trimestre">
                                            <label for="trimestreFilter">Filtrar por trimestre:</label>
                                            <select id="trimestreFilter" class="form-select">
                                                <option value="">Todos los trimestres</option>
                                                <option value="Enero - Febrero - Marzo">Enero - Febrero - Marzo</option>
                                                <option value="Abril - Mayo - Junio">Abril - Mayo - Junio</option>
                                                <option value="Julio - Agosto - Septiembre">Julio - Agosto - Septiembre</option>
                                                <option value="Octubre - Noviembre - Diciembre">Octubre - Noviembre - Diciembre</option>
                                            </select>
                                        </div>

                                        <div class="dos-ano">
                                            <label for="yearFilter">Filtrar por año:</label>
                                            <select id="yearFilter" class="form-select">
                                                <option value="">Todos los años</option>
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

                                        <div class="tres-botones">
                                            @csrf
                                            <button id="mostrarJson" class="btn btn-success mostrar-datos-json"><img src="./images/mostrar-json.png" width="28" alt=""> Mostrar JSON</button>
                                            <button id="descargarJson" class="btn btn-success descargar-datos-json"><img src="./images/descargar.png" width="28" alt=""> Descargar JSON</button>
                                            <button id="descargarExcel" class="btn btn-success descargar-datos-excel"><img src="./images/excel.png" width="28" alt="">Descargar Excel</button>
                                        </div>
                                    </div>
                                    <pre id="jsonOutput" class="container-datos-json"></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- Aquí termina el tab content -->
            </div><!--Aqui termina el container -->

            <!-- Modal de confirmación -->
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que deseas eliminar este servicio?
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
                        <h5 class="modal-title" id="detailsModalLabel">Detalles de los huevos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p style="text-align:center; color:#740624;"><strong>INFORMACION DE LOS HUEVOS EN LA FINCA</strong></p>
                        <p><strong>Folio:</strong> <span id="modalFolio"></span></p>
                        <p><strong>Nombre de la finca:</strong> <span id="modalTp"></span></p>
                        <p><strong>Año:</strong> <span id="modalAno"></span></p>
                        <p><strong>Mes:</strong> <span id="modalTrimestre"></span></p>

                        <u><strong>Autorizado Por:</strong>
                            <ol>
                                <p><strong>Usuario:</strong> <span id="modalUsuarioAutoriza"></span></p>
                            </ol>
                            <ol>
                                <p><strong>Nombre:</strong>
                                    <span id="modalNombreAutoriza"></span>
                                    <span id="modalPaternoAutoriza"></span>
                                    <span id="modalMaternoAutoriza"></span>
                                </p>
                            </ol>
                        </u>

                        <p><strong>Fecha de Autorización:</strong> <span id="modalFechaInicio"></span></p>
                        <!-- <p><strong>Fecha de Entrega:</strong> <span id="modalFechaEntrega"></span></p> -->

                        <!-- Listado de materiales (BASE DE DATOS) -->
                        <p style="text-align:center; color:#740624;"><strong>Huevos por Ave</strong></p>
                        <div id="modalMateriales"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="generatePdf">Generar PDF <img src="./images/pdf.png" width="25" alt=""></button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Modal para editar el servicio -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Editar Servicio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm">
                                @csrf
                                <input type="hidden" id="editIdServicio">

                                <div class="mb-3">
                                    <label for="editAno" class="form-label">Año:</label>
                                    <select id="editAno" name="ano" class="form-select" required>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="editTrimestre" class="form-label">Trimestre:</label>
                                    <select id="editTrimestre" name="trimestre" class="form-select" required>
                                        @foreach($trimestres as $trimestre)
                                            <option value="{{ $trimestre->id_trimestre }}">{{ $trimestre->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="editTipoServicio" class="form-label">Tipo de Servicio:</label>
                                    <select id="editTipoServicio" name="tipo_servicio" class="form-select" required>
                                        @foreach($tipos_servicios as $tipo_servicio)
                                            <option value="{{ $tipo_servicio->id_servicio }}">{{ $tipo_servicio->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="editFechaInicio" class="form-label">Fecha de Inicio:</label>
                                    <input type="date" id="editFechaInicio" name="fecha_inicio" class="form-control" autocomplete="off">
                                </div>

                                <!-- <div class="mb-3">
                                    <label for="editFechaEntrega" class="form-label">Fecha de Entrega:</label>
                                    <input type="date" id="editFechaEntrega" name="fecha_entrega" class="form-control">
                                </div> -->

                                <!-- Sección para editar materiales -->
                                <div id="editMaterialesWrapper">
                                    <!-- Aquí se cargarán los materiales existentes con JavaScript -->
                                </div>

                                <!-- Botón para agregar otro material en el modal de edición -->
                                <button type="button" id="addEditMaterialBtn" class="btn btn-info">Agregar otro material</button>

                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        //Listar los servicios en formato JSON
        let serviciosFiltrados = []; // Variable global para almacenar los datos filtrados
        document.getElementById('mostrarJson').addEventListener('click', function () {
            const selectedYear = document.getElementById('yearFilter').value;
            const selectedTrimestre = document.getElementById('trimestreFilter').value;

            axios.get('{{ route('listar.servicios.json') }}')
                .then(function (response) {
                    let servicios = response.data;

                    // Filtrar por año si se seleccionó uno
                    if (selectedYear) {
                        servicios = servicios.filter(servicio => servicio.ano == selectedYear);
                    }

                    // Filtrar por trimestre si se seleccionó uno
                    if (selectedTrimestre) {
                        servicios = servicios.filter(servicio => servicio.trimestre === selectedTrimestre);
                    }

                    // Actualizar la variable global con los datos filtrados
                    serviciosFiltrados = servicios;

                    // Mostrar JSON en el elemento <pre>
                    document.getElementById('jsonOutput').textContent = JSON.stringify(servicios, null, 2);
                    toastr.success('Busqueda realizada.', 'Éxito', {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 3000,  // Tiempo antes de que se cierre automáticamente
                            positionClass: 'toast-top-right'
                    });
                })
                .catch(function (error) {
                    toastr.error("No se obtuvieron los datos esperados.");
                    console.error('Error al obtener los datos:', error);
                });
        });

        //Funcion para DESCARGAR en JSON
        document.getElementById('descargarJson').addEventListener('click', function () {
            if (serviciosFiltrados.length === 0) {
                toastr.error("No hay datos filtrados para descargar.");
                return;
            }

            // Crear un archivo JSON para descargar
            const jsonBlob = new Blob([JSON.stringify(serviciosFiltrados, null, 2)], { type: 'application/json' });
            const downloadLink = document.createElement('a');
            downloadLink.href = URL.createObjectURL(jsonBlob);
            downloadLink.download = 'Datos_de_servicios.json'; // Nombre del archivo
            downloadLink.click(); // Activa la descarga
        });

        //Funcion para DESCARGAR en Excel
        document.getElementById('descargarExcel').addEventListener('click', function () {
            if (serviciosFiltrados.length === 0) {
                toastr.error("No hay datos filtrados para descargar.");
                return;
            }

            // Convierte los datos filtrados en un formato adecuado para Excel
            const worksheet = XLSX.utils.json_to_sheet(serviciosFiltrados);
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Servicios Filtrados');

            // Genera el archivo Excel y lo descarga
            XLSX.writeFile(workbook, 'servicios_filtrados.xlsx');
        });

        //Validar que el cct sea correcto desde el formulario de mantenimiento
        $(document).ready(function() {
            // Deshabilitar los campos al cargar la página
            disableFields();

            // Detectar cambios en el input CCT
            // Función para realizar la búsqueda de CCT
            function realizarBusqueda(cctValue) {
                $.ajax({
                    url: 'https://estadistica2.sepen.gob.mx/ws_f911/index.php/F911s/getCCT',
                    type: 'POST',
                    data: {
                        cct: cctValue
                    },
                    success: function(response) {
                        if (response.error) {
                            $('#resultadoBusqueda').html('<p class="text-danger">Error: ' + response.mensaje + '</p>');
                            disableFields(); // Deshabilitar campos si hay error
                        } else {
                            // Generar el HTML para mostrar los datos
                            var resultadoHtml = `
                                <ul class="list-group">

                                    <li class="list-group-item"><strong>Nombre:</strong> ${response.data[0].C_NOMBRE}</li>
                                    <li class="list-group-item"><strong>Tipo:</strong> ${response.data[0].C_TIPO}</li>
                                    <li class="list-group-item"><strong>Administrativa:</strong> ${response.data[0].C_ADMINISTRATIVA}</li>
                                    <li class="list-group-item"><strong>Estatus:</strong> ${response.data[0].C_ESTATUS}</li>
                                    <li class="list-group-item"><strong>Municipio:</strong> ${response.data[0].INMUEBLE_C_NOM_MUN}</li>
                                </ul>
                            `;
                            $('#resultadoBusqueda').html(resultadoHtml);

                            // Habilitar campos si el CCT es válido
                            enableFields();
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#resultadoBusqueda').html('<p class="text-danger">Error al realizar la búsqueda. Por favor, inténtelo de nuevo.</p>');
                        disableFields(); // Deshabilitar campos en caso de error
                    }
                });
            }
        });

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

        //Cerrar Sesion
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
                $('#modalFechaInicio').text('');

                // Datos de quien autoriza
                $('#modalUsuarioAutoriza').text('');
                $('#modalNombreAutoriza').text('');
                $('#modalPaternoAutoriza').text('');
                $('#modalMaternoAutoriza').text('');

                //$('#modalFechaEntrega').text(''); // Limpiar fecha de entrega
               // $('#modalNombreCCT').text('Cargando...');
                //$('#modalVialidadPrincipal').text('Cargando...');
                //$('#modalMunicipio').text('Cargando...');
                //$('#modalLocalidad').text('Cargando...');

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

                        // Datos de quien autoriza
                        $('#modalUsuarioAutoriza').text(response.obtener_usuario);
                        $('#modalNombreAutoriza').text(response.obtener_nombre);
                        $('#modalPaternoAutoriza').text(response.obtener_apellido_paterno);
                        $('#modalMaternoAutoriza').text(response.obtener_apellido_materno);

                        // Mostrar fechas o mensaje si son null
                        $('#modalFechaInicio').text(response.fecha_inicio || 'No hay fechas registradas.');
                        //$('#modalFechaEntrega').text(response.fecha_entrega || 'No hay fechas registradas.');

                        // Mostrar materiales asociados
                        var materialesHtml = '';
                        $.each(response.ser_mat_can, function (index, item) {
                            if (item.material_can && item.material_can.material) {
                                let descripcionMaterial = item.material_can.material.descripcion || 'Sin descripción';
                                let cantidadMaterial = item.material_can.cantidad || 'Sin cantidad';
                                let tipoPresentacion = item.material_can.material.tipo_presentacion ? item.material_can.material.tipo_presentacion.descripcion : 'Sin presentación';
                                let estadoMaterial = item.material_can.status ? item.material_can.status.status : 'Estado no definido';

                                materialesHtml += `
                                    <p>Material: ${descripcionMaterial}</p>
                                    <p>Cantidad: ${cantidadMaterial}</p>
                                    <p>Tipo de Presentación: ${tipoPresentacion}</p>
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

                        // Nueva solicitud POST a la API externa
                        $.ajax({
                            url: 'https://estadistica2.sepen.gob.mx/ws_f911/index.php/F911s/getCCT',
                            type: 'POST',
                            data: {
                                cct: response.cct // Enviando el valor de CCT
                            },
                            success: function(apiResponse) {
                                console.log(apiResponse); // Verificar la respuesta de la API

                                if (!apiResponse.error && apiResponse.data && apiResponse.data.length > 0) {
                                    var data = apiResponse.data[0];
                                    //$('#modalNombreCCT').text(data.C_NOMBRE || 'No disponible');
                                    //$('#modalVialidadPrincipal').text(data.INMUEBLE_C_VIALIDAD_PRINCIPAL || 'No disponible');
                                    //$('#modalMunicipio').text(data.INMUEBLE_C_NOM_MUN || 'No disponible');
                                    //$('#modalLocalidad').text(data.INMUEBLE_C_NOM_LOC || 'No disponible');
                                } else {
                                    //$('#modalNombreCCT').text('No disponible');
                                    //$('#modalVialidadPrincipal').text('No disponible');
                                    //$('#modalMunicipio').text('No disponible');
                                    //$('#modalLocalidad').text('No disponible');
                                    console.error('Error en la respuesta de la API', apiResponse);
                                }
                            },
                            error: function (xhr) {
                                //$('#modalNombreCCT').text('No disponible');
                                //$('#modalVialidadPrincipal').text('No disponible');
                                //$('#modalMunicipio').text('No disponible');
                                //$('#modalLocalidad').text('No disponible');
                                console.error('Error al consultar la API externa');
                            }
                        });
                    },
                    error: function (xhr) {
                        toastr.error("No se encontraron detalles del servicio.");
                    }
                });
            });

            $(document).on('click', '#generatePdf', function () {
                var data = {
                    //_token: $('meta[name="csrf-token"]').attr('content'), // Agrega el token CSRF
                    //nombre_escuela: $('#modalNombreCCT').text(),
                    ano: $('#modalAno').text(),
                    trimestre: $('#modalTrimestre').text(),
                    tipo_servicio: $('#modalTp').text(),
                    //vialidad_principal: $('#modalVialidadPrincipal').text(),
                    //municipio: $('#modalMunicipio').text(),
                    //localidad: $('#modalLocalidad').text(),
                    folio: $('#modalFolio').text(),
                    fecha_autorizacion: $('#modalFechaInicio').text(),

                    usuario_name :$('#modalUsuarioAutoriza').text(),
                    usuario_nombre: $('#modalNombreAutoriza').text(),
                    usuario_paterno: $('#modalPaternoAutoriza').text(),
                    usuario_materno: $('#modalMaternoAutoriza').text(),

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

        // Listado de usuarios en en tabla (DataTable)
        $('#usuariosTable').DataTable({
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
            },
            ajax: {
                url: '/obtener-usuarios',
                type: 'GET',
                dataSrc: function(json) {
                    console.log(json); // Check if the JSON data is correct
                    return json;
                }
            },
            columns: [
                { data: 'usuario', name: 'usuario' },
                { data: 'persona.nombre', name: 'persona.nombre' },
                { data: 'persona.apellido_paterno', name: 'persona.apellido_paterno' },
                { data: 'persona.apellido_materno', name: 'persona.apellido_materno' },
                { data: 'rol.descripcion', name: 'rol.descripcion' },
                { data: 'estado.estado', name: 'estado.estado' },
                {
                    data: 'id_usuario', // This is where the user ID will come from.
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        // Check the user's status and render buttons accordingly
                        let activarButton = '';
                        let desactivarButton = '';

                        if (row.estado.estado === 'Inactivo') {
                            activarButton = `<button class="btn btn-info btn-activar" data-id="${row.id_usuario}">Activar</button>`;
                        }

                        if (row.estado.estado === 'Activo') {
                            desactivarButton = `<button class="btn btn-info btn-desactivar" data-id="${row.id_usuario}">Desactivar</button>`;
                        }

                        return `${activarButton} ${desactivarButton}`;
                    }

                }
            ]
        });

        // Cambiar estado ACTIVO en Listado de usuarios en en tabla (DataTable)
        $(document).on('click', '.btn-activar', function() {
            const userId = $(this).data('id');
            $.ajax({
                url: '/activar-usuario/' + userId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    toastr.success(response.message);
                    // Recargar la tabla o actualizar el estado del usuario
                    $('#usuariosTable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    toastr.error('Error al activar el usuario.');
                }
            });
        });

        // Cambiar estado INACTIVO en Listado de usuarios en en tabla (DataTable)
        $(document).on('click', '.btn-desactivar', function() {
            const userId = $(this).data('id');
            $.ajax({
                url: '/desactivar-usuario/' + userId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    toastr.success(response.message);
                    // Recargar la tabla o actualizar el estado del usuario
                    $('#usuariosTable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    toastr.error('Error al desactivar el usuario.');
                }
            });
        });

    //Formulario de registro
    document.getElementById('registerForm').addEventListener('submit', async function(event) {
        event.preventDefault(); // Prevenir que se recargue la página

        const usuario = document.getElementById('register_usuario').value;
        const clave = document.getElementById('register_clave').value;
        const nombre = document.getElementById('nombre').value;
        const apellido_paterno = document.getElementById('apellido_paterno').value;
        const apellido_materno = document.getElementById('apellido_materno').value;
        const fk_rol = document.getElementById('fk_rol').value;
        const fk_estado = document.getElementById('fk_estado').value;

        try {
            const response = await fetch('/api/register', {  // Asegurarse de usar '/api/register'
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    usuario, clave, nombre, apellido_paterno, apellido_materno, fk_rol, fk_estado
                })
            });

            const data = await response.json();

            if (response.ok) {
                toastr.success('Usuario registrado exitosamente');
                document.getElementById('registerForm').reset(); // Resetea el formulario
                location.reload(); // Recargar la tabla para ver los cambios
            } else {
                toastr.error(data.error || 'Error desconocido al registrar');
            }
        } catch (error) {
            console.error('Error en la solicitud:', error);
            toastr.error('Hubo un error en el servidor.');
        }
    });

    //Formulario de mantenimiento
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

        //Insertar tipo de servicio (formulario)
        $(document).ready(function () {
            $('#tipoServicioForm').submit(function (event) {
                event.preventDefault(); // Evitar el envío estándar del formulario

                // Obtener los datos del formulario
                var formData = {
                    descripcion: $('#descripcion').val(),
                    _token: $('input[name=_token]').val()
                };

                // Realizar la solicitud AJAX para insertar el tipo de servicio
                $.ajax({
                    url: '/tipos-servicios',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        // Mostrar mensaje de éxito
                        //$('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                        toastr.success(response.message);

                        // Limpiar el formulario
                        $('#tipoServicioForm')[0].reset();
                    },
                    error: function (xhr) {
                        // Manejar los errores y mostrar el mensaje
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = 'Error: ' + (errors.descripcion ? errors.descripcion[0] : 'Error desconocido.');
                        $('#message').html('<div class="alert alert-danger">' + errorMessage + '</div>');
                        toastr.error(errorMessage);
                    }
                });
            });
        });

        //Insertar Material y tipo de presentación (formulario)
        $(document).ready(function() {
            $('#materialForm').on('submit', function(event) {
                event.preventDefault(); // Evita el comportamiento por defecto de recargar la página.

                // Capturar los datos del formulario
                let formData = {
                    material_descripcion: $('#material_descripcion').val(),
                    tipo_presentacion: $('#tipo_presentacion').val(),
                    _token: $('input[name="_token"]').val() // Añadir el token CSRF
                };

                // Realizar la solicitud AJAX
                $.ajax({
                    url: "{{ route('material.store') }}", // La URL de la ruta de almacenamiento
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // Mostrar el mensaje de éxito usando Toastr
                        toastr.success('Material y tipo de presentación agregados correctamente.');

                        // Limpiar el formulario (opcional)
                        $('#materialForm')[0].reset();
                    },
                    error: function(xhr) {
                        // Mostrar un mensaje de error si algo sale mal
                        toastr.error('Hubo un error al agregar el material.');
                    }
                });
            });
        });

        //-------------- Editar cifras del mantenimiento -----------------------
        $(document).ready(function() {
            var materialesEliminados = [];

            // Función para actualizar la visibilidad del botón "Eliminar Material"
            function toggleRemoveButtonsEdit() {
                // Solo muestra el botón "Eliminar Material" si hay más de un .material-block
                if ($('.material-block-edit').length > 1) {
                    $('.remove-material-btn-edit').show();
                } else {
                    $('.remove-material-btn-edit').hide();
                }
                console.log('prueba toggle button');
            }

            // Abrir modal de edición
            $('.btn-edit').on('click', function() {
                var idServicio = $(this).data('id');
                $('#editMaterialesWrapper').html('');
                materialesEliminados = [];
                toggleRemoveButtonsEdit(); // Llama a esta función después de cargar todos los bloques

                // Obtener datos del servicio a editar
                $.ajax({
                    url: '/obtener-detalles-servicio/' + idServicio,
                    type: 'GET',
                    success: function(response) {
                        $('#editIdServicio').val(idServicio);
                        $('#editCct').val(response.cct);
                        $('#editAno').val(response.ano);
                        $('#editTrimestre').val(response.trimestre_id);
                        $('#editTipoServicio').val(response.tipo_servicio_id);
                        $('#editFechaInicio').val(response.fecha_inicio || '');
                        //$('#editFechaEntrega').val(response.fecha_entrega || '');

                        // Cargar materiales en el modal
                        response.ser_mat_can.forEach(function(item) {
                            addEditMaterialRow(item.material_can.fk_material, item.cantidad, item.id_smc, item.material_can.id_mc);
                        });

                        // Mostrar el modal de edición
                        $('#editModal').modal('show');
                        toggleRemoveButtonsEdit(); // Configurar visibilidad de los botones de eliminación al abrir
                    },
                    error: function(xhr) {
                        toastr.error("Error al obtener los detalles del servicio.");
                    }
                });
            });

            // Función para agregar un bloque de material en el modal de edición
            function addEditMaterialRow(materialId = '', cantidad = '', materialCanId = '', materialNum = '') {
                var materialRow = `
                    <div class="material-block-edit">
                        <input type="hidden" name="material_can_id[]" value="${materialCanId || ''}">
                        <input type="hidden" name="material_num[]" value="${materialNum || ''}">
                        <div class="form-group">
                            <label for="material">Material</label>
                            <select name="material[]" class="form-control">
                                @foreach($materiales as $material)
                                    <option value="{{ $material->id_material }}" ${materialId == '{{ $material->id_material }}' ? 'selected' : ''}>
                                        {{ $material->descripcion }} - {{ $material->tipoPresentacion->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="cantidad">Cantidad de Material</label>
                            <input type="number" name="cantidad[]" class="cantidadMaterialEdit form-control" value="${cantidad}" placeholder="¿Cuanto es de material?" required>
                        </div>

                        <!-- Botón para eliminar el bloque -->
                        <button type="button" class="btn btn-danger remove-material-btn-edit" data-id="${materialCanId}">Eliminar Material</button>
                        <hr>
                    </div>
                `;
                $('#editMaterialesWrapper').append(materialRow);

                // Actualizar visibilidad de los botones de eliminación
                toggleRemoveButtonsEdit();

                // Cantidad formulario mantenimiento ---EDIT---
                document.querySelectorAll('.cantidadMaterialEdit').forEach(function(input) {
                    input.addEventListener('input', function (event) {
                        // Verificar si el valor supera los 12 dígitos
                        if (input.value.length > 12) {
                            input.value = input.value.slice(0, 12); // Limitar a 12 dígitos
                        }
                    });
                });
            }

            // Evento para agregar un nuevo material cuando se hace clic en "Agregar otro material"
            $('#addEditMaterialBtn').on('click', function() {
                addEditMaterialRow(); // Agregar un bloque de material vacío
            });

            // Manejar la eliminación de un bloque de material en el modal de edición
            $(document).on('click', '.remove-material-btn-edit', function() {
                var materialCanId = $(this).data('id');

                // Si el material ya existe en la base de datos, agregar su ID a la lista de eliminados
                if (materialCanId && !materialesEliminados.includes(materialCanId)) {
                    materialesEliminados.push(materialCanId);
                }

                // Eliminar el bloque de material del DOM
                $(this).closest('.material-block-edit').remove();
                console.log("Materiales eliminados actuales:", materialesEliminados);

                // Actualizar visibilidad de los botones de eliminación
                toggleRemoveButtonsEdit();
            });

            // Enviar la actualización del servicio
            $('#editForm').on('submit', function(e) {
                e.preventDefault();

                var idServicio = $('#editIdServicio').val();
                var formData = $(this).serialize();

                 var loginToken = localStorage.getItem('login_token'); // Obtiene el token del localStorage

                if (!loginToken) {
                    toastr.error("No hay un token de autenticación. Por favor, inicia sesión.");
                    window.location.href = '/'; // Redirige al login si no hay token
                    return;
                }

                // Añadir los materiales eliminados al formulario
                formData += '&materiales_eliminados=' + JSON.stringify(materialesEliminados);
                console.log("Materiales eliminados:", JSON.stringify(materialesEliminados));

                $.ajax({
                    url: '/actualizar-servicio/' + idServicio,
                    type: 'PUT',
                    data: formData,
                    headers: {
                        'Authorization': 'Bearer ' + loginToken // Incluye el token en el encabezado
                    },
                    success: function(response) {
                        $('#editModal').modal('hide');
                        toastr.success("Servicio actualizado correctamente");
                        location.reload(); // Recargar la tabla para ver los cambios
                    },
                    error: function(xhr) {
                        toastr.error("Error al actualizar el servicio.");
                    }
                });
            });
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

        // Nombre formulario registro
        document.getElementById('nombre').addEventListener('input', function (event) {
            const input = event.target;
            // Remover cualquier número del valor ingresado
            input.value = input.value.replace(/[0-9]/g, '');
        });

        // Apellido Paterno formulario registro
        document.getElementById('apellido_paterno').addEventListener('input', function (event) {
            const input = event.target;
            // Remover cualquier número del valor ingresado
            input.value = input.value.replace(/[0-9]/g, '');
        });

        // Apellido Paterno formulario registro
        document.getElementById('apellido_materno').addEventListener('input', function (event) {
            const input = event.target;
            // Remover cualquier número del valor ingresado
            input.value = input.value.replace(/[0-9]/g, '');
        });
    </script>
</body>
</html>
