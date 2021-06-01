<?php
class Equipo
{
    private $idEquipo;
    private $nombre;
    private $lugar;
    private $paginaWeb;
    private $coleccionTraceurs;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idEquipo = 0;
        $this->nombre = "";
        $this->lugar = "";
        $this->paginaWeb = "";
        $this->coleccionTraceurs = [];
        $this->mensajeoperacion = "";
    }

    /**
     * @param int $id
     * @param string $nom
     * @param string $ubicacion
     * @param string $pagWeb
     */
    public function setear($id, $nom, $ubicacion, $pagWeb)
    {
        $this->setIdEquipo($id);
        $this->setNombre($nom);
        $this->setLugar($ubicacion);
        $this->setPaginaWeb($pagWeb);
    }

    /**
     * @return int
     */
    public function getIdEquipo()
    {
        return $this->idEquipo;
    }
    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    /**
     * @return string
     */
    public function getLugar()
    {
        return $this->lugar;
    }
    /**
     * @return string
     */
    public function getPaginaWeb()
    {
        return $this->paginaWeb;
    }
    /**
     * @return array
     */
    public function getTraceurs()
    {
        return $this->coleccionTraceurs;
    }
    /**
     * @return string
     */
    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    /**
     * @param int $id
     */
    public function setIdEquipo($id)
    {
        $this->idEquipo = $id;
    }
    /**
     * @param string $nom
     */
    public function setNombre($nom)
    {
        $this->nombre = $nom;
    }
    /**
     * @param string $ubicacion
     */
    public function setLugar($ubicacion)
    {
        $this->lugar = $ubicacion;
    }
    /**
     * @param string $pagWeb
     */
    public function setPaginaWeb($pagWeb)
    {
        $this->paginaWeb = $pagWeb;
    }
    /**
     * @param array $intgrants
     */
    public function setTraceurs($intgrants)
    {
        $this->coleccionTraceurs = $intgrants;
    }
    /**
     * @param string $valorMensaje
     */
    public function setmensajeoperacion($valorMensaje)
    {
        $this->mensajeoperacion = $valorMensaje;
    }

    /**
     * solo necesitamos que el Equipo tenga su id seteado para cargar todos los demas valores
     * @return boolean
     */
    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM equipo WHERE id_equipo = " . $this->getIdEquipo();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $fila = $base->Registro();
                    $this->setear($fila['id_equipo'], $fila['nombre_equipo'], $fila['lugar_equipo'], $fila['paginaweb_equipo']);
                    $resp = true;
                }
            }
        } else {
            $this->setmensajeoperacion("Equipo->listar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * una vez que el Equipo tenga sus valores seteados insertamos un nuevo equipo
     * con estos valores en la base de datos
     * @return boolean
     */
    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO equipo (nombre_equipo, lugar_equipo, paginaweb_equipo)  VALUES ('" . $this->getNombre() . "', '" . $this->getLugar() . "' , '" . $this->getPaginaWeb() . "');";
        if ($base->Iniciar()) {
            if ($idEq = $base->Ejecutar($sql)) {
                //al ejecutar nos devuelve la cantidad de inserciones realizadas, nuestro id
                $this->setIdEquipo($idEq);
                $resp = true;
            } else {
                $this->setmensajeoperacion("Equipo->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Equipo->insertar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * si seteamos nuevos datos no nos alcanza utilizar un metodo set sobre el Equipo
     * sino que debemos reflejar los nuevos cambios sobre la base de datos
     * @return boolean
     */
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE equipo SET paginaweb_equipo='" . $this->getPaginaWeb() . "', lugar_equipo='" . $this->getLugar() . "', nombre_equipo='" . $this->getNombre() . "' WHERE id_equipo=" . $this->getIdEquipo();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Equipo->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Equipo->modificar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * para borrar el Equipo de manera permanente lo debemos hacer en la base de datos
     * entonces al estar seteada el id, nos basta para buscarlos y realizar un DELETE
     * @return boolean
     */
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM equipo WHERE id_equipo=" . $this->getIdEquipo();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Equipo->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Equipo->eliminar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * guardamos los Equipos en un arreglo para poder manipular sobre ellos,
     * tenemos el parametro para cualquier especificacion sobre la busqueda de los Equipos
     * pero si el parametro es vacio solamente mostrarmos a los equipos sin restricciones
     * @param string $parametro
     * @return array
     */
    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM equipo ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) { //no es error de consulta o conexion o en la BD
            if ($res > 0) { //no esta vacia la rta de la BD
                while ($fila = $base->Registro()) {
                    $obj = new Equipo();
                    $obj->setear($fila['id_equipo'], $fila['nombre_equipo'], $fila['lugar_equipo'], $fila['paginaweb_equipo']);
                    $obj->cargarTraceurs();
                    array_push($arreglo, $obj);
                }
            }
        } else {
            Equipo::setmensajeoperacion("Equipo->listar: " . $base->getError());
        }
        return $arreglo;
    }

    public function cargarTraceurs()
    {
        $this->setTraceurs(Traceur::listar('id_grupo=' . $this->getIdEquipo()));
    }
}
