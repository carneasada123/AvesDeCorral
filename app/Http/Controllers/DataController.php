<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Trimestre;
use App\Models\Inicio;
use App\Models\TipoServicio;
use App\Models\Material;
use App\Models\TipoPresentacion;
use App\Models\Servicio;
use App\Models\SerMatCan;
use App\Models\MaterialCan;
use App\Models\Usuario;
use App\Models\Estado;
use App\Models\MaterialStatus;
use App\Models\EntregaParcialCan;
use App\Models\ParcialMat;

class DataController extends Controller
{
    public function showForm()
    {
        // Obtener los datos para los selects
        $trimestres = Trimestre::all();
        $tipos_servicios = TipoServicio::all();
        $materiales = Material::all();

        // if (request()->routeIs('prueba')) {
        //     return view('prueba', compact('trimestres', 'tipos_servicios', 'materiales'));
        // }

        if (request()->routeIs('cliente')) {
            return view('cliente', compact('trimestres', 'tipos_servicios', 'materiales'));
        }

        if (request()->routeIs('admin')) {
            return view('admin', compact('trimestres', 'tipos_servicios', 'materiales'));
        }

        if (request()->routeIs('almacen')) {
            return view('almacen', compact('trimestres', 'tipos_servicios', 'materiales'));
        }

        // Retornar la vista con los datos
        return view('welcome', compact('trimestres', 'tipos_servicios', 'materiales'));
    }

    public function insertData(Request $request)
    {
        \Log::info("Usuario autenticado:", [auth()->user()]);
        \DB::beginTransaction(); // Iniciar transacción

        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            // Validar los datos del formulario
            $validatedData = $request->validate([
                'cct' => 'nullable|string|max:10',
                'ano' => 'required|integer',
                'trimestre' => 'required|integer',
                'tipo_servicio' => 'required|integer',
                'material.*' => 'required|integer',
                'cantidad.*' => 'required|string|min:0.1',
                'fecha_inicio' => 'nullable|date',
                //'fecha_entrega' => 'nullable|date',
            ]);

            // Obtener el id del estado "Activo"
            $estadoActivo = \DB::table('estados_servicios')->where('descripcion', 'Activo')->first();

            if (!$estadoActivo) {
                throw new \Exception("Estado 'Activo' no encontrado en la base de datos.");
            }

            // Insertar la fecha de inicio en la tabla `inicios` y obtener `id_inicio`
            $inicio = \DB::table('inicios')->insertGetId(
                ['fecha_inicio' => $request->input('fecha_inicio')],
                'id_inicio' // Nombre de la columna de clave primaria
            );

            // Insertar la fecha de entrega en la tabla `entregas` y obtener `id_entrega`
            // $entrega = \DB::table('entregas')->insertGetId(
            //     ['fecha_entrega' => $request->input('fecha_entrega')],
            //     'id_entrega' // Nombre de la columna de clave primaria
            // );

            // Insertar el servicio con el usuario que realizó la acción
            $servicio = Servicio::create([
                'cct' => $request->input('cct'),
                'ano' => $request->input('ano'),
                'fk_trimestre' => $request->input('trimestre'),
                'fk_tipo_servicio' => $request->input('tipo_servicio'),
                'fk_usuario' => auth()->user()->id_usuario,  // Asigna el usuario autenticado
                'fk_usuario_editor' => auth()->user()->id_usuario, // Asigna el usuario autenticado como último editor
                'fk_estado_servicio' => $estadoActivo->id_estado_servicio,
                'fk_inicio' => $inicio,   // Asigna el ID de la fecha de inicio
                //'fk_entrega' => $entrega, // Asigna el ID de la fecha de entrega
            ]);

            // Insertar los materiales asociados
            $materiales = $request->input('material');
            $cantidades = $request->input('cantidad');

            foreach ($materiales as $index => $material) {
                $materialCan = MaterialCan::create([
                    'fk_material' => $material,
                    'cantidad' => $cantidades[$index],
                    'fk_servicio' => $servicio->id_servicio,
                    'fk_ms' => 1, // Estado "No entregado"
                ]);

                // Vincular en ser_mat_can
                SerMatCan::create([
                    'fk_servicio' => $servicio->id_servicio,
                    'fk_mc' => $materialCan->id_mc,
                ]);
            }

            \DB::commit(); // Confirmar transacción si todo fue exitoso
            return response()->json(['success' => 'Datos insertados correctamente.']);

        } catch (\Exception $e) {
            \DB::rollBack(); // Revertir cambios si algo falla
            \Log::error("Error al insertar los datos: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al insertar los datos: ' . $e->getMessage()], 500);
        }
    }

    public function updateService(Request $request, $id)
    {
        //\Log::info("Usuario autenticado update-function:", [auth()->user()]);
        // \DB::beginTransaction(); // Iniciar transacción

        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            \Log::info('Usuario autenticado updated service:', [$user]);

            $validatedData = $request->validate([
                'cct' => 'required|string|max:10',
                'ano' => 'required|integer',
                'trimestre' => 'required|integer',
                'tipo_servicio' => 'required|integer',
                'fecha_inicio' => 'nullable|date',
                //'fecha_entrega' => 'nullable|date',
                'material.*' => 'required|integer',
                'cantidad.*' => 'required|integer',
            ]);

            $servicio = Servicio::findOrFail($id);

            // 1. Eliminar materiales que están en `materiales_eliminados`
            if ($request->has('materiales_eliminados')) {
                $materialesEliminados = json_decode($request->input('materiales_eliminados'), true);
                \Log::info('Materiales a eliminar:', $materialesEliminados);
                if (!empty($materialesEliminados)) {
                    SerMatCan::whereIn('id_smc', $materialesEliminados)->delete(); // Eliminar de `ser_mat_can`
                    //SerMatCan::whereIn('fk_mc', $materialesEliminados)->delete(); // Eliminar de `ser_mat_can`
                    //MaterialCan::whereIn('id_mc', $materialesEliminados)->delete(); // Eliminar de `materiales_can`
                }
            }

            // Actualizar la información del servicio
            $servicio->update([
                'cct' => $validatedData['cct'],
                'ano' => $validatedData['ano'],
                'fk_trimestre' => $validatedData['trimestre'],
                'fk_tipo_servicio' => $validatedData['tipo_servicio'],

                'fk_usuario_editor' => auth()->user()->id_usuario, // Asigna el usuario autenticado como último editor

                'fk_inicio' => $validatedData['fecha_inicio']
                    ? \DB::table('inicios')->insertGetId(['fecha_inicio' => $validatedData['fecha_inicio']], 'id_inicio')
                    : $servicio->fk_inicio,
                // 'fk_entrega' => $validatedData['fecha_entrega']
                //     ? \DB::table('entregas')->insertGetId(['fecha_entrega' => $validatedData['fecha_entrega']], 'id_entrega')
                //     : $servicio->fk_entrega,
            ]);

            // 2. Procesar materiales enviados
            $materialIds = $request->input('material_can_id', []);
            $materialNumberIds = $request->input('material_num', []);
            $materials = $request->input('material');
            $quantities = $request->input('cantidad');

            foreach ($materials as $index => $materialId) {
                $materialCanId = $materialIds[$index] ?? null;
                $materialCanNumber = $materialNumberIds[$index] ?? null;
                $cantidad = $quantities[$index];

                if ($materialCanId) {
                    \Log::info('Actualizando material con ID:', [$materialCanId]); // Verificación de ID
                    \Log::info('Actualizando material number con ID:', [$materialCanNumber]); // Verificación de ID

                    // Actualizar material existente de ser_mat_cat id_smc
                    $materialCan = MaterialCan::find($materialCanId);

                    // Actualizar material existente de materiales_can id_mc
                    $materialCanNumb = MaterialCan::find($materialCanNumber);

                    if ($materialCanNumb) {
                        $materialCanNumb->fk_material = $materialId;
                        $materialCanNumb->cantidad = $cantidad;
                        $resultado = $materialCanNumb->save();

                        \Log::info('Resultado de save():', [$resultado]); // Verifica que sea true
                    }

                } else {
                    // Insertar nuevo material y asociación
                    $materialCan = MaterialCan::create([
                        'fk_material' => $materialId,
                        'cantidad' => $cantidad,
                        'fk_servicio' => $servicio->id_servicio,
                        'fk_ms' => 1, // Estado "No entregado"
                    ]);

                    SerMatCan::create([
                        'fk_servicio' => $servicio->id_servicio,
                        'fk_mc' => $materialCan->id_mc,
                    ]);
                }
            }

            return response()->json(['success' => 'Servicio actualizado correctamente']);

        }   catch (\Exception $e) {
        //     \DB::rollBack(); // Revertir cambios si algo falla
            \Log::error("Error al insertar los datos: " . $e->getMessage());
        //     return response()->json(['error' => 'Ocurrió un error al insertar los datos: ' . $e->getMessage()], 500);
        }
    }

    public function listarServiciosActivos()
    {
        $servicios = Servicio::where('fk_estado_servicio', 1)
        ->with(['trimestre', 'tipoServicio', 'usuario']) // Agrega la relación con usuario
        ->get();

        $trimestres = Trimestre::all(); // Obtiene todos los trimestres
        $tipos_servicios = TipoServicio::all(); // Obtiene todos los tipos de servicio
        $materiales = Material::all(); // Obtiene todos los materiales

        // if (request()->routeIs('prueba')) {
        //     return view('prueba', compact('servicios', 'trimestres', 'tipos_servicios', 'materiales'));
        // }

        if (request()->routeIs('cliente')) {
            return view('cliente', compact('servicios', 'trimestres', 'tipos_servicios', 'materiales'));
        }

        if (request()->routeIs('admin')) {
            return view('admin', compact('servicios', 'trimestres', 'tipos_servicios', 'materiales'));
        }

        if (request()->routeIs('almacen')) {
            return view('almacen', compact('servicios', 'trimestres', 'tipos_servicios', 'materiales'));
        }

        // Pasa las variables a la vista
        return view('welcome', compact('servicios', 'trimestres', 'tipos_servicios', 'materiales'));
    }

    //Listar servicio en formato JSON
    public function listarServiciosJson()
    {
        $servicios = Servicio::where('fk_estado_servicio', 1)
        ->with([
            'trimestre',
            'tipoServicio',
            'usuario',
            'usuario.persona',
            'serMatCan.materialCan.material.tipoPresentacion',
            'serMatCan.materialCan.status',
            'inicio'
        ])
        ->get();

        // Transforma los datos para cada servicio
        $serviciosTransformados = $servicios->map(function ($servicio) {
            return [
                'null' => $servicio->cct,
                'ano' => $servicio->ano,
                'trimestre' => $servicio->trimestre->descripcion ?? 'No disponible', // Maneja relaciones nulas
                'Nombre de finca' => $servicio->tipoServicio->descripcion ?? 'No disponible',
                'ser_mat_can' => $servicio->serMatCan,
                'fecha_inicio' => $servicio->inicio ? $servicio->inicio->fecha_inicio : 'No hay fechas registradas.',
                'folio' => $servicio->folio,
                'obtener_usuario' => $servicio->usuario->usuario ?? 'No disponible',
                'obtener_nombre' => $servicio->usuario->persona->nombre ?? 'No disponible',
                'obtener_apellido_paterno' => $servicio->usuario->persona->apellido_paterno ?? 'No disponible',
                'obtener_apellido_materno' => $servicio->usuario->persona->apellido_materno ?? 'No disponible',
            ];
        });

        return response()->json($serviciosTransformados);
    }

    //--------------------
    // ALMACEN CONTROLLER
    //--------------------

    // Listar Materiales "No entregados" en la tabla almacen
    public function listarMaterialesActivosAlmacen()
    {
        $materiales_almacen = SerMatCan::with(['materialCan', 'materialCan.status'])
            ->whereHas('servicio', function ($query) {
                $query->where('fk_estado_servicio', 1);
            })
            ->whereHas('materialCan', function ($query) {
                $query->where('fk_ms', 1); // Filtrar por material status "No Entregado"
            })
            ->get();

        $materiales_cantidad = MaterialCan::whereHas('serMatCan.servicio', function ($query) {
                $query->where('fk_estado_servicio', 1);
            })
            ->where('fk_ms', 1) // Filtrar por material status "No Entregado"
            ->get();

        $materiales = Material::whereHas('materialesCan.serMatCan.servicio', function ($query) {
                $query->where('fk_estado_servicio', 1);
            })
            ->whereHas('materialesCan', function ($query) {
                $query->where('fk_ms', 1); // Filtrar por material status "No Entregado"
            })
            ->get();

        $materiales_entregados = SerMatCan::with(['materialCan','materialCan.entregasParciales','materialCan.entregasParciales.usuario','materialCan.status'])
            ->whereHas('servicio', function ($query) {
                $query->where('fk_estado_servicio', 1);
            })
            ->whereHas('materialCan', function ($query) {
                $query->where('fk_ms', 2); // Filtrar por material status "Entregado"
            })
            ->get();

        $materiales_entrega_parcial = SerMatCan::with(['materialCan','materialCan.entregasParciales','materialCan.entregasParciales.usuario','materialCan.status'])
            ->whereHas('servicio', function ($query) {
                $query->where('fk_estado_servicio', 1);
            })
            ->whereHas('materialCan', function ($query) {
                $query->where('fk_ms', 3); // Filtrar por material status "Entregado"
            })
            ->get();

        $presentacion_tipos = TipoPresentacion::all();
        $inicios = Inicio::all(); // Obtiene todos los iniciosy
        $trimestres = Trimestre::all(); // Obtiene todos los trimestres
        $tipos_servicios = TipoServicio::all(); // Obtiene todos los tipos de servicio
        $servicios = Servicio::where('fk_estado_servicio', 1)
            ->with(['usuario'])
            ->get();

        if (request()->routeIs('almacen')) {
            return view('almacen', compact('presentacion_tipos', 'materiales_cantidad', 'materiales_almacen', 'inicios', 'servicios', 'trimestres', 'tipos_servicios', 'materiales', 'materiales_entregados', 'materiales_entrega_parcial'));
        }

        // Pasa las variables a la vista
        return view('welcome', compact('servicios', 'trimestres', 'tipos_servicios', 'materiales'));
    }

    // Mostrar "detalles" del modal de la tabla
    public function getMaterialesAlmacenDetails($id)
    {
        $materialCan = MaterialCan::with(['material', 'material.tipoPresentacion', 'entregasParciales'])
            ->findOrFail($id);

        // Extraer las cantidades de las entregas parciales
        $entregasParciales = $materialCan->entregasParciales->map(function ($entrega) {
            return $entrega->cantidad;
        });

        // Extraer los usuarios de las entregas parciales
        $entregasConNombreUsuario = $materialCan->entregasParciales->map(function ($entrega) {
            return $entrega->usuario->usuario;
        });

        // Extraer la fecha y hora de las entregas parciales
        $entregasFechaRegistro = $materialCan->entregasParciales->map(function ($entrega) {
            return $entrega->created_at->setTimezone('America/Mazatlan')->format('d/m/Y H:i');
        });

        // Comentarios de las entregas parciales
        $comentarios = $materialCan->entregasParciales->map(function ($entrega) {
            return $entrega->comentario;
        });

        // Fecha agregada de forma manual por el almacen de las entregas parciales
        $fechaEntrega = $materialCan->entregasParciales->map(function ($entrega) {
            return $entrega->fecha_entrega;
        });

        // Persona que recibe por el almacen de las entregas parciales
        $personaQueRecibe = $materialCan->entregasParciales->map(function ($entrega) {
            return $entrega->recibe;
        });

        return response()->json([
            'cantidad' => $materialCan->cantidad,
            'descripcion' => $materialCan->material->descripcion,
            'tipo_presentacion' => $materialCan->material->tipoPresentacion->descripcion,
            'entrega_parcial_can' => $entregasParciales, // Lista de cantidades parciales
            'entrega_parcial_can_usuario' => $entregasConNombreUsuario,
            'entrega_fecha_registro' => $entregasFechaRegistro,
            'comentarios_entrega' => $comentarios,
            'fecha_entrega_material' => $fechaEntrega,
            'persona_que_recibe' => $personaQueRecibe,
        ]);
    }

    public function guardarEntregaParcial(Request $request)
    {
        $validatedData = $request->validate([
            'id_material_can' => 'required|integer', // ID de materiales_can
            'cantidad_entregada' => 'required|string|min:0.1', // Cantidad entregada
            'comentario' => 'nullable|string|max:255', // Validar comentario como opcional
            'fecha_de_entrega' => 'required|date',     // Fecha entrega manual
            'persona_recibe' => 'nullable|string|max:255', // Persona que recibe
        ]);

        DB::beginTransaction();

        try {
            // Autenticar al usuario mediante JWT
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            \Log::info('ID del usuario autenticado dentro GuardarEntregaParcial:', [$user]);

            // Crear o actualizar el registro en `entrega_parcial_can`
            $entregaParcial = EntregaParcialCan::updateOrCreate(
                ['id_epc' => $validatedData['id_material_can']],
                [
                    'cantidad' => $validatedData['cantidad_entregada'],
                    'fk_usuario' => $user->id_usuario, // Asignar el usuario autenticado
                    'comentario' => $validatedData['comentario'],
                    'fecha_entrega' => $validatedData['fecha_de_entrega'],
                    'recibe' => $validatedData['persona_recibe'],
                ]
            );

            // Debug temporal para verificar el guardado
            \Log::info('Entrega Parcial:', [
                'cantidad' => $entregaParcial->cantidad,
                'fk_usuario' => $entregaParcial->fk_usuario,
            ]);

            // Asociar `entrega_parcial_can` con `materiales_can` a través de `parcial_mat`
            ParcialMat::updateOrCreate(
                ['fk_epc' => $entregaParcial->id_epc, 'fk_mc' => $validatedData['id_material_can']]
            );

            // Obtener el material correspondiente
            $materialCan = MaterialCan::find($validatedData['id_material_can']);

            if ($materialCan) {
                // Verificar la cantidad total entregada
                $totalEntregado = EntregaParcialCan::whereHas('materialesCan', function ($query) use ($materialCan) {
                    $query->where('id_mc', $materialCan->id_mc);
                })->selectRaw('SUM(CAST(cantidad AS DECIMAL)) as total')->value('total');

                // Validar el total entregado en relación con la cantidad requerida
                if ($totalEntregado > $materialCan->cantidad) {
                    // Si el total entregado excede la cantidad requerida, retornar error
                    return response()->json([
                        'success' => false,
                        //'message' => 'Ingrese la cantidad requerida o faltante.',
                    ], 400); // Código de error HTTP 400 (Bad Request)
                } elseif ($totalEntregado == $materialCan->cantidad) {
                    // Si las cantidades coinciden, cambiar el estado a "Entregado"
                    $materialCan->fk_ms = 2; // Asumiendo que 2 es el ID de "Entregado" en `material_status`
                } elseif ($totalEntregado < $materialCan->cantidad) {
                    // Si la cantidad entregada es menor, cambiar el estado a "Entrega Parcial"
                    $materialCan->fk_ms = 3; // Asumiendo que 3 es el ID de "Entrega Parcial" en `material_status`
                }

                $materialCan->save();
            }

            // Obtener el nombre del usuario
            $usuarioNombre = $entregaParcial->usuario->usuario ?? 'Usuario desconocido';

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Cantidad de material entregado guardada exitosamente','usuario' => $user->usuario]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error al guardar la entrega parcial: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al guardar la entrega parcial.'], 500);
        }
    }

    // ------------------------
    // CIERRE ALMACEN
    // ------------------------

    public function eliminarServicio(Request $request)
    {
        try {
            // Buscar el servicio por el ID
            $servicio = Servicio::findOrFail($request->id);

            // Actualizar el estado a 'Inactivo'
            $servicio->fk_estado_servicio = 2; // 2 sería el valor de 'Inactivo'
            $servicio->save();

            return response()->json(['success' => 'Servicio eliminado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al intentar eliminar el servicio.'], 500);
        }
    }

    // Mostrar "detalles" del modal de la tabla
    public function getServiceDetails($id)
    {
        $servicio = Servicio::with(['trimestre', 'tipoServicio', 'usuario', 'serMatCan.materialCan.material.tipoPresentacion', 'serMatCan.materialCan.status', 'inicio'])
            ->findOrFail($id);

        return response()->json([
            'cct' => $servicio->cct,
            'ano' => $servicio->ano,
            'trimestre' => $servicio->trimestre->descripcion,  // Añade trimestre
            'tipoServicio' => $servicio->tipoServicio->descripcion,  // Añade tipo de servicio
            'ser_mat_can' => $servicio->serMatCan,
            'fecha_inicio' => $servicio->inicio ? $servicio->inicio->fecha_inicio : 'No hay fechas registradas.',
            'folio' => $servicio->folio,
            'obtener_usuario' => $servicio->usuario->usuario,
            'obtener_nombre' => $servicio->usuario->persona->nombre,
            'obtener_apellido_paterno' => $servicio->usuario->persona->apellido_paterno,
            'obtener_apellido_materno' => $servicio->usuario->persona->apellido_materno,
            //'fecha_entrega' => $servicio->entrega ? $servicio->entrega->fecha_entrega : 'No hay fechas registradas.',
        ]);
    }

    // Insertar Tipo de servicio
    public function storeTipoServicio(Request $request)
    {
        // Validar la entrada
        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        // Crear un nuevo registro en la tabla tipos_servicios
        $tipoServicio = new TipoServicio();
        $tipoServicio->descripcion = $request->descripcion;
        $tipoServicio->save();

        // Retornar una respuesta JSON de éxito
        return response()->json(['message' => 'Tipo de Servicio agregado correctamente.']);
    }

    // Insertar Material y Tipo de Presentación
    public function storeMaterial(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'material_descripcion' => 'required|string|max:255',
            'tipo_presentacion' => 'required|string|max:255',
        ]);

        // Crear el nuevo Tipo de Presentación
        $tipoPresentacion = new TipoPresentacion();
        $tipoPresentacion->descripcion = $request->input('tipo_presentacion');
        $tipoPresentacion->save();

        // Crear el nuevo Material asociado al Tipo de Presentación
        $material = new Material();
        $material->descripcion = $request->input('material_descripcion');
        $material->fk_tp = $tipoPresentacion->id_tp; // Asociar el ID del nuevo tipo de presentación
        $material->save();

        // Redireccionar con mensaje de éxito
        return redirect()->back()->with('success', 'Material y tipo de presentación agregados correctamente.');
    }

    // Listado de usuarios para su visualizacion
    public function obtenerUsuarios()
    {
        $usuarios = Usuario::with(['persona', 'rol', 'estado'])
            ->get(['id_usuario','usuario', 'fk_persona', 'fk_rol', 'fk_estado']);

        return response()->json($usuarios);
    }

    // Revisar este fragmento de codigo para ver si lo elimino
    public function cambiarEstadoUsuario(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->fk_estado = $request->input('estado');
        $usuario->save();

        return response()->json(['success' => 'Estado actualizado correctamente']);
    }

    public function activarUsuario($id)
    {
        $usuario = Usuario::find($id);
        if ($usuario) {
            $usuario->fk_estado = 1; // Asignar el estado de "Activo"
            $usuario->save();
            return response()->json(['message' => 'Usuario activado correctamente.']);
        } else {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }
    }

    public function desactivarUsuario($id)
    {
        $usuario = Usuario::find($id);
        if ($usuario) {
            $usuario->fk_estado = 2; // Asignar el estado de "Inactivo"
            $usuario->save();
            return response()->json(['message' => 'Usuario desactivado correctamente.']);
        } else {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }
    }

}
