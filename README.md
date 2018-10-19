# Slim Framework API Template

#### Dependencias de composer:
* ORM:  illuminate/database
* JWT:  tuupola/slim-jwt-auth

Instalar con
    
    composer install

#### Estructura del projecto:

* public
    * css/
    * js/
    * index.php
* src
    * controllers/
    * middleware/
    * models/
    * controllers.php.
    * middleware.php
    * models.php
    * routes.php
    * settings.php
 * views
    * index.html
    
    
 #### Agregar un controlador:
 
 1. Crear la clase del controlador en la carpeta **_/src/controllers_** con le nombre del controlador.
 La clase debe pertenecer al namespace **_AppController_** o cualquiera que deseemos. El la clase puede o no recibir
 el contenedor de la aplicación o cualquier otro parámetro. Se recomienda que se incluya el contenedor **_($container)_** para acceder a los demás componentes y controladores
 de la aplicación.
 
    * Archivo EjemploController.php:
     ``` php
    <?php
    namespace AppController;
        
        use \Slim\Http\Response;
        use \Slim\Http\Request;
        
        class EjemploController
        {
            protected  $container;
        
            public function __construct($container)
            {
                $this->container = $container;
            }
        }
     ```
 
 2. Se debe agregar la sentencia **_require_** en el archivo **_/src/controllers.php_** para que este disponible para los demás archivos.
 
        require  __DIR__ . '/../src/controllers/EjemploController.php';
    
 3. Se debe agregar la dependencia al contenedor en el archivo **_/src/dependencies.php_** para que el controlador se pueda utilizar en el ruter o en otros controladores.
 
    * Archivo dependencies.php:
    
    ```php
    /*
     *  AGREGAR AQUI LAS DEPENDENCIAS DE LOS CONTROLADORES
     */
    $container[EjemploController::class] = function ($container) {
        return new AppController\EjemploController($container);
    };
    ```
 
 4. El controlador ahora está disponible dentro del contenedor como **_$container->EjemploController_**
    
 5. Agregar el controlador y el método a las rutas en el archivo **_/src/routes.php_**
 
    ```php
    $app->get('/index' , 'EjemploController:Index');
    o
    $app->get('/index' , AppController\EjemploController::class . ':Index');

    ```    
 #### Agregar un modelo
 
 1. Crear la clase del modelo en la carpeta **_/src/models_** con le nombre del modelo. 
 La clase debe pertenecer al namespace **_AppModel_** o cualquier otro.
 Se usa la clase  **_Illuminate\Database\Eloquent\Model_** para que nuestro modelo herede del
 modelo de Eloquent.
 
    * Archivo EjemploModel.php:
    
     ```php
     <?php
     namespace AppModel;
     
     use Illuminate\Database\Eloquent\Model;
     
     class EjemploModel extends Model
     {
         protected $table = 'ejemplo';
         protected $fillable = ['nombre', 'edad', 'genero'];
         protected $guarded = ['id'];
         public $timestamps = false;
     }
     ```
 2. Se debe agregar la sentencia **_require_** en el archivo **_/src/models.php_** para que este disponible para los demás archivos.
 
        require  __DIR__ . '/../src/models/EjemploModel.php';
      
 3. Configurar los parámetros del modelo con las opciones de eloquente que se requieran.
    * $table: Nombre de la tabla en la base de datos.
    
    * $fillable: Campos de la tabla que pueden ser llenados con asignación masiva.
    
    * $guarded: Campos de la tabla que no pueden ser llenados de forma masiva.
    
    * $timestamps: Especifica si Eloquente maneja por default los campos **_created_at_** **_updated_at_** para fechas de creación y modificación.
  
  4. Hacer uso del modelo en un controlador, middleware o donde se necesite:
  
        
    use AppModel\EjemploModel;
    
    
 #### Agregar Middleware
 
 1. Crear la clase del middleware en la carpeta **_/src/middleware_** con le nombre del middleware. 
     La clase debe pertenecer al namespace **_AppMiddleware_** o cualquier otro.

    * Archivo EjemploMiddleware.php:
    ```php
    <?php
    namespace AppMiddleware;
    
    class EjemploMiddleware
    {
        private $container;
    
        public function __construct($container) {
            $this->container = $container;
        }
    
        public function __invoke($request, $response, $next)
        {
            /*
             *  TO DO: Acciones a realizar por el middleware
             */
            // Llama al siguiente middleware
            return $next($request, $response);
        }
    }
    ```
    
2. Se debe agregar la sentencia **_require_** en el archivo **_/src/middleware.php_** para que este disponible para los demás archivos.
 
        require  __DIR__ . '/../src/middleware/EjemploMiddleware.php';
      
3. Agregar el middleware a la ruta o a toda la aplicación.

   * Agregar a Toda la aplicación en el archivo **_/src/middleware.php_**:
        
        ```php
        $app->add(new \AppMiddleware\EjemploMiddleware($container);
        ```

   * Agregar a una ruta en particular en el archivo **_/src/routes.php_**:
        
        ```php
        $app->get('/index' , 'EjemploController:Index')->add(new \AppMiddleware\EjemploMiddleware($container);
        ```

#### Renderizar una vista

1. Agregar el archivo html de la vista en la carpeta **_/src/views_**
2. Renderizar la vista desde el controlador con el archivo html y los argumentos deseados:

    ```php
    return $this->container->view->render($response, 'index.phtml', $args);
    ```
        
    o renderizar desde la ruta
    
    ```php
    return $this->view->render($response, 'index.phtml', $args);
    ```
