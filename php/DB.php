<?php
/**
 * Class: Conexion
 * Version: 1.0
 * Date: 2013/07/23
 * Author: Octavio León López
 *
 */
include ('adodb5/adodb-exceptions.inc.php');
include ('adodb5/adodb.inc.php');

//include ('adodb5/adodb-error.inc.php');
//include ('adodb5/adodb-errorhandler.inc.php');
/**
 * Create a data object
 * The __construct needs to know the database type
 * example: 'myslq','postrgres', 'odbc_mssql', etc...
 *
 * Crea un objeto de datos
 * El __constructor necesita conocer el tipo de base de datos
 * Ejemplo: 'myslq', 'postrgres', 'odbc_mssql', etc...
 *
 * @param type - database type.
 * @return dataObject.
 */
class Conexion {

    private $host;
    private $port;
    private $username;
    private $password;
    private $dataBase;
    private $schema;
    private $dsn;
    protected $driver;
    protected $tipo;
    private $debug;
    private $cnx;
    private $host_info;
    private $char_set;
    protected $result;
    protected $data = array();
    protected $num_rows = 0;
    protected $num_cols = 0;
    protected $affected_rows = 0;
    protected $lastId = 1;
    protected $error = array();
    protected $errores;

    function __construct($tipo = TIPODB, $debug = FALSE) {
        $this -> tipo = $tipo;
        $this -> debug = $debug;
        switch ($this->tipo) {
            case 'MySQL' :
                $this -> driver = array('driver' => 'mwsqli', 'host' => 'localhost', 'user' => 'root', 'pass' => 'SiteSlt', 'database' => 'mvc3l');
                break;
            case 'control_escolar' :
                $this -> driver = array('driver' => 'postgres', 'host' => 'a', 'user' => '', 'pass' => 'a', 'database' => 'control_escolar');
                break;
            case 'pruebas' :
                $this -> driver = array('driver' => 'postgres', 'host' => '', 'user' => '', 'pass' => '', 'database' => 'pruebas');
                break;
            case 'local' :
                $this -> driver = array('driver' => 'postgres', 'host' => 'localhost:5432', 'user' => 'octavio', 'pass' => 'octavio', 'database' => 'pruebas');
                break;
            default :
                throw new Exception("No reconozco la base de datos: " . $this -> tipo);
                //$this->errores="No reconozco la base de datos";
                break;
        }
        $this -> Connect($this -> driver);
    }

    /**
     * Make the connection according to the type of database selected in the __ construct.
     *
     * Realiza la conexión de acuerdo al tipo de base de datos seleccionada en el __constructor.
     *
     * @param $driver String
     */
    public function Connect($driver) {
        # ej. 'mysql' o 'oci8'
        $this -> cnx = ADONewConnection($driver['driver']);
        $this -> cnx -> debug = $this -> debug;
        $this -> cnx -> Connect($driver['host'], $driver['user'], $driver['pass'], $driver['database']);
        $this -> cnx -> EXECUTE("SET NAMES 'utf8'");
    }

    public function view($sql = "SELECT 'Consulta Vacia';") {
        $this -> cnx -> SetFetchMode(ADODB_FETCH_ASSOC);
        if ($this -> result = $this -> cnx -> Execute($sql)) {
            $this -> num_rows = $this -> result -> RecordCount();
            $this -> num_cols = $this -> result -> FieldCount();
            $this -> affected_rows = 0;
            $this -> data = $this -> result -> GetRows();
        } else {
            $this -> num_rows = 0;
            $this -> num_cols = 0;
            $this -> affected_rows = 0;
            $this -> data = array();
        }
    }

    public function viewAssoc($sql = "SELECT 'Consulta Vacia';") {
        $this -> cnx -> SetFetchMode(ADODB_FETCH_NUM);
        if ($this -> result = $this -> cnx -> Execute($sql)) {
            $this -> num_rows = $this -> result -> RecordCount();
            $this -> num_cols = $this -> result -> FieldCount();
            $this -> affected_rows = 0;
            $this -> data = $this -> result -> GetRows();

        } else {
            $this -> num_rows = 0;
            $this -> num_cols = 0;
            $this -> affected_rows = 0;
            $this -> data = array();
        }
    }

    public function execute($sql = "SELECT 'Consulta Vacia';") {
        if ($this -> result = $this -> cnx -> Execute($sql)) {
            $this -> num_rows = 0;
            $this -> num_cols = 0;
            $this -> affected_rows = $this -> cnx -> Affected_Rows();
            $this -> data = array();
        } else {
            $this -> num_rows = 0;
            $this -> num_cols = 0;
            $this -> affected_rows = 0;
            $this -> data = array();
        }
    }

    public function viewLimit($sql = "SELECT 'Consulta Vacia';", $limit = -1, $offset = false) {
        $this -> cnx -> SetFetchMode(ADODB_FETCH_ASSOC);
        if ($this -> result = $this -> cnx -> SelectLimit($sql, $limit, $offset)) {
            $this -> num_rows = $this -> result -> RecordCount();
            $this -> num_cols = $this -> result -> FieldCount();
            $this -> affected_rows = 0;
            $this -> data = $this -> result -> GetRows();
        } else {
            $this -> num_rows = 0;
            $this -> num_cols = 0;
            $this -> affected_rows = 0;
            $this -> data = array();
        }

    }

    public function viewLimitAssoc($sql = "SELECT 'Consulta Vacia';", $limit = -1, $offset = false) {
        $this -> cnx -> SetFetchMode(ADODB_FETCH_NUM);
        if ($this -> result = $this -> cnx -> SelectLimit($sql, $limit, $offset)) {
            $this -> num_rows = $this -> result -> RecordCount();
            $this -> num_cols = $this -> result -> FieldCount();
            $this -> affected_rows = 0;
            $this -> data = $this -> result -> GetRows();
        } else {
            $this -> num_rows = 0;
            $this -> num_cols = 0;
            $this -> affected_rows = 0;
            $this -> data = array();
        }
    }

    /**
     * Devuelve el valor de la primera columna              - Returns the value of the first column
     * de la consulta                                       - of the query
     */
    public function getOne($sql = "SELECT 'Consulta Vacia';") {
        if ($this -> result = $this -> cnx -> GetOne($sql)) {
            $this -> num_rows = 0;
            $this -> num_cols = 0;
            $this -> affected_rows = 0;
            $this -> data = array();
        } else {
            $this -> num_rows = 0;
            $this -> num_cols = 0;
            $this -> affected_rows = 0;
            $this -> data = array();
        }
        return $this -> result;
    }

    /**
     * Devuelve la consulta en forma de array               - Returns the query as an array
     */
    public function getRows() {
        if (empty($this -> data)) {
            return null;
        } else {
            return $this -> data;
        }
    }

    /**
     * Devuelve el número de filas en la consulta           - Returns the number of rows in the query
     */
    public function getNumRows() {
        return $this -> num_rows;
    }

    /**
     * Devuelve el número de columnas en la consulta        - Returns the number of columns in the query
     */
    public function getNumCols() {
        return $this -> num_cols;
    }

    /**
     * Devuelve el número de filas afectadas en la consulta - Returns the number of rows affected by the query
     */
    public function getAffectedRows() {
        return $this -> affected_rows;
    }

    /**
     * Devuelve los errores generados en la consulta        - Returns errors generated in the query
     */
    public function getErrores() {
        return $this -> errores;
    }

    /**
     * Devuelve el ultimo Id insertado
     */
    public function lastID($table = '', $columnId = '') {
        return $this -> GetOne("SELECT MAX($columnId) FROM $table");
    }

    /**
     * Devuelve una tabla HTML de los errores generados en la consulta        - Returns errors generated in the query
     */
    public function GetTable($data = null, $name = 'Tabla de Datos', $styleClass = 'Algo', $id='tabla') {
    	$formato = $styleClass;
        if (is_null($data) && is_null($this -> data)) {
            $table = "No hay datos para mostrar";
            return $table;
        } elseif (is_null($data)) {
            $data = $this -> data;
        }
        $table = '
		<h1>' . $name . '</h1>
		<table id="'.$id.'" class="'.$formato.'">';
        $tabla = $data;
        $keys = array_keys($tabla[0]);
        $table .= '
        	<thead>
			<tr>
				<th>' . implode('</th>
				<th>', $keys) . '</th>
			</tr>
			</thead>
			<tbody>';
        foreach ($tabla as $v1) {
            $table .= '
			<tr>';
            foreach ($v1 as $v2) {
                $table .= '
		        <td>' . $v2 . '</td>';
            }
            $table .= '
			</tr>';
        }
        $table .= '
        </tbody>
		</table>';
        return $table;
    }
	
	public function __destruct()
	{
		$this -> cnx -> Close();
	}

}

/*
 error_reporting(E_ALL);
 ini_set('display_errors', 1);
 require_once '../settings/main.php';
 header('Content-Type: text/html; charset=UTF-8');
 try{
 $cnx = new Conexion('pruebas',false);
 $sql ="select * from mvc3l.usuarios ORDER BY 1";
 $cnx->viewLimit($sql);
 echo "<h1>Get NumRows " . $cnx->getNumRows() ."</h1>";
 echo "<h1>Get NumCols " . $cnx->getNumCols() ."</h1>";
 echo "<h1>Get AffectedRows " . $cnx->getAffectedRows() ."</h1>";
 echo "<h1>Get Rows</h1>";
 echo "<pre>";
 print_r($cnx->getRows());
 echo "</pre>";

 echo $cnx->GetTable(null,'Usuarios');

 $sql = "Select nombre,login From mvc3l.usuarios where id_usuario=1";
 echo $cnx->getOne($sql);
 echo "<h1>Las ID inserted + 1 : " . ($cnx->lastID('mvc3l.tipo_publicaciones','id_tipo_publicacion') + 1) ."</h1>";
 } catch (Exception $e) {
 echo '<pre>Ocurri&oacute; el siguiente error123: ', $e->getMessage() . '</pre>';
 }
 catch (ErrorException $e) {
 echo '<pre>Ocurri&oacute; el siguiente error456: ', $e->getMessage() . '</pre>';
 }
 */
