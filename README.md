//Descripcion//

Sitio web intuitivo adaptado a móvil donde el cliente tenga la url que la redireccione a la página con su respectivo login por seguridad. Una vez ingresada ella podrá acceder a todos los registros, como también eliminar, editar o agregar una nueva ave.

//Marco Teorico//

Una señora (amante de las aves) cuenta con un corral grande con diferentes tipos de aves, en donde se les da alimento y hay familiares que apoyan con su cuidado. Mi tía quiere llevar un control de cuantas aves, especies, alimentos, cuidadores hay, como también cada cuando se les da de comer y donde están ubicadas las aves dentro del corral.

//Lenguajes//

Desarrollo en lenguaje JAVA + Springboot

//Patron de diseño//

Patrón de diseño: MVC (Model-View-Controller)
Este patrón es ideal para aplicaciones de gestión como la que mencionas porque:
Angular (Frontend - View): Maneja la capa de presentación, mostrando datos y permitiendo interacciones con los usuarios.
SpringBoot (Backend - Controller y Model): Actúa como intermediario entre el frontend y la base de datos (PostgreSQL), gestionando la lógica del negocio y las operaciones sobre los datos.
PostgreSQL (Base de datos): Provee la persistencia de los datos, organizada de manera estructurada.
Este enfoque separa las responsabilidades claramente, facilitando el mantenimiento, la escalabilidad y el trabajo en equipo.

//Servicios Web de Terceros//

Servicio: OpenWeatherMap (Gratis para nivel básico)
Es un servicio gratuito (con opciones de pago para funciones avanzadas) que proporciona:
Datos meteorológicos actuales, históricos y pronósticos.
API REST fácil de integrar con Angular y SpringBoot.
Útil si tu aplicación requiere mostrar el clima en las ubicaciones donde se encuentran las aves o condiciones ambientales relevantes.
El plan gratuito permite un número limitado de solicitudes diarias, suficiente para proyectos pequeños o en desarrollo. Perfecto si buscas un servicio confiable y sin costo inicial.

//Servicio Web Propio//

Funcionalidades del servicio web propio:
Gestión de aves:

CRUD (Crear, Leer, Actualizar, Eliminar) para aves.
Registro de especies, características, hábitats y estado de conservación.

Control de ubicaciones:
Registrar las ubicaciones geográficas de las aves.
Integración con coordenadas geográficas usando sistemas como Mapbox o Google Maps.

Seguimiento de actividades:
Registro de actividades como migraciones, salud, y alimentación.
Gestión de reportes o historiales.

Autenticación y roles de usuario:
Permitir que diferentes usuarios (administradores, investigadores, público general) accedan según su rol.

Reportes dinámicos:
Generar informes en tiempo real (JSON o CSV) sobre los datos gestionados.