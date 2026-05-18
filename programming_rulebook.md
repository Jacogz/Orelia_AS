# Rulebook de Programación

## Reglas para Controladores

### R01 — Importaciones al inicio del archivo

Toda dependencia debe importarse al comienzo del archivo usando una declaración `use`, sin excepción. No se permiten referencias con namespace completo en línea dentro del cuerpo de métodos o funciones.

### R02 — Sin comentarios redundantes

No se deben escribir comentarios que expliquen lo que el código ya expresa por sí mismo, ya que esto constituye una forma de duplicación. Los comentarios están reservados para explicar el *porqué* de una decisión no obvia, no el *qué* hace una línea de código.

### R03 — Uso universal de bloques try-catch

Toda operación que involucre escritura en la base de datos y pueda fallar debe estar envuelta en un bloque `try-catch`, capturando primero la excepción más específica disponible. El uso de `Exception` como tipo capturado se reserva únicamente como último recurso cuando no existe una excepción más precisa. Evitar el uso de bloques try-catch cuando otros métodos de validación suplan su función, por ejemplo al validar envío de formularios.

### R04 — Validación en el controlador, reglas definidas en el modelo

La validación de las solicitudes HTTP se ejecuta en el controlador invocando el método de validación necesario en el archivo `validateRequest` correspondiente, el cual es responsable de definir y exponer sus propias reglas. El controlador no debe conocer ni duplicar las reglas de validación de ningún modelo o request.

### R05 — Uso universal de arreglos asociativos para comunicación entre módulos

Toda transferencia de datos entre módulos debe realizarse mediante arreglos asociativos con nombre descriptivo y sufijo que identifique al consumidor. Por ejemplo, los datos enviados a una vista deben empaquetarse en `$viewData`, los enviados a un validador en `$validationData`, y así sucesivamente. El envío de estos arreglos debe seguir la sintaxis `return view()->with('viewData', $viewData)`.

### R06 — Uso uniforme de getters y setters para acceder a objetos

Todo acceso o modificación de atributos de un modelo debe realizarse exclusivamente a través de sus métodos getter y setter definidos, excepto para casos de asignación masiva, en los que se debe usar `fill()`.

### R07 — Eager loading para relaciones conocidas

Toda consulta que itere sobre una colección de modelos y acceda a una relación de esos modelos debe cargar dicha relación de forma anticipada usando `with()`. Acceder a relaciones dentro de un ciclo sin eager loading genera una consulta adicional por iteración, degradando el rendimiento de forma silenciosa.

### R08 — Redireccionamiento usando rutas

Toda redirección que se haga a otra url del proyecto debe de seguir el siguiente estándar: `return redirect()->route('nombre.de.ruta')`. Nunca se debe redireccionar referenciando a través de texto quemado la url destino.

---

## Reglas para Rutas

### R09 — Definición de rutas basada en importaciones

Cada controlador referenciado en `web.php` debe estar importado explícitamente al inicio del archivo mediante una declaración `use`. Las rutas se definen usando la sintaxis de arreglo `[ControllerClass::class, 'método']` y deben nombrarse todas con `->name()` siguiendo la convención `recurso.acción`.

---

## Reglas para Vistas

### R10 — Herencia de vistas Blade y uso de layouts

Toda vista Blade debe extender un layout maestro usando `@extends` y definir su contenido dentro de secciones con `@section`/`@endsection`. Ninguna vista puede duplicar estructura HTML (encabezado, navegación, pie de página) que pertenezca al layout.

---

## Reglas para Modelos

### R11 — Uso de `$fillable` para asignación masiva de atributos

Todo modelo debe declarar explícitamente un arreglo `$fillable` que liste los atributos permitidos para asignación masiva. El uso de `$guarded = []` o la ausencia de cualquier declaración de protección están prohibidos.

### R12 — Nomenclatura snake_case en atributos y relaciones

Todos los atributos definidos en un modelo deben nombrarse en snake_case sin excepción. Esto incluye columnas de base de datos y claves foráneas.

### R13 — Nomenclatura camelCase de métodos de modelo

Todos los métodos de modelo deben nombrarse en camelCase sin excepción, incluyendo getters, setters y accesos a relaciones de Eloquent como `getOrderItems()`.

### R14 — Orden de los bloques en modelo

Todos los modelos deben nombrar sus atributos en un comentario al inicio, los atributos deben seguir estrictamente el siguiente orden: atributos primarios -> atributos no primarios (o calculados) -> claves foráneas -> relaciones.

El orden de los métodos del modelo debe adherirse al orden de los atributos, es decir, primero se tienen las definiciones de `fillable` y `validate`, luego los métodos siguen el orden de sus atributos relacionados, sean getters, setters, definición o lectura de relaciones; Al final del modelo se definen los métodos propios del modelo, incluyendo aquellos usados para calcular valores de atributos.

Las secciones ya definidas deben ir separadas por comentarios cortos.