<?php
class Provincia
{
    private $idProvincia;
    private $objPais;
    private $nombre;
    private $coleccionSuscriptores;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idProvincia = 0;
        $this->nombre = "";
        $this->objPais = new Pais();
        $this->coleccionSuscriptores = [];
        $this->mensajeoperacion = "";
    }

    /**
     * @param int $id
     * @param string $nombr
     * @param Pais $objP
     */
    public function setear($id, $nombr, $objP)
    {
        $this->setIdProvincia($id);
        $this->setNombre($nombr);
        $this->setObjPais($objP);
    }

    /**
     * @return int
     */
    public function getIdProvincia()
    {
        return $this->idProvincia;
    }
    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    /**
     * @return Pais
     */
    public function getObjPais()
    {
        return $this->objPais;
    }
    /**
     * @return array
     */
    public function getSuscriptores()
    {
        return $this->coleccionSuscriptores;
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
    public function setIdProvincia($id)
    {
        $this->idProvincia = $id;
    }
    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    /**
     * @param Pais $objP
     */
    public function setObjPais($objP)
    {
        $this->objPais = $objP;
    }
    /**
     * @param array $colSuscriptores
     */
    public function setSuscriptores($colSuscriptores)
    {
        $this->coleccionSuscriptores = $colSuscriptores;
    }
    /**
     * @param string $valorMensaje
     */
    public function setmensajeoperacion($valorMensaje)
    {
        $this->mensajeoperacion = $valorMensaje;
    }

    /**
     * solo necesitamos que el Provincia tenga su id seteado para cargar todos los demas valores
     * @return boolean
     */
    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM provincia WHERE id_provincia = " . $this->getIdProvincia();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $fila = $base->Registro();
                    $objPais = new Pais();
                    $objPais->setIdPais($fila['id_pais']);
                    $objPais->cargar();
                    $this->setear($fila['id_provincia'], $fila['nombre_provincia'], $objPais);
                    $resp = true;
                }
            }
        } else {
            $this->setmensajeoperacion("Provincia->listar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * una vez que el Provincia tenga sus valores seteados insertamos un nuevo Provincia
     * con estos valores en la base de datos
     * @return boolean
     */
    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO provincia (nombre_provincia,id_pais)  VALUES('" . $this->getNombre() . "', " . $this->getObjPais()->getIdPais() . ");";
        if ($base->Iniciar()) {
            if ($idP = $base->Ejecutar($sql)) {
                //al ejecutar nos devuelve la cantidad de inserciones realizadas, nuestro id
                $this->setIdProvincia($idP);
                $resp = true;
            } else {
                $this->setmensajeoperacion("Provincia->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Provincia->insertar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * si seteamos nuevos datos no nos alcanza utilizar un metodo set sobre Provincia
     * sino que debemos reflejar los nuevos cambios sobre la base de datos
     * @return boolean
     */
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE provincia SET nombre_provincia='" . $this->getNombre() . "' WHERE id_provincia=" . $this->getIdProvincia();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Provincia->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Provincia->modificar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * para borrar el Provincia de manera permanente lo debemos hacer en la base de datos
     * entonces al estar seteada el id, nos basta para buscarlos y realizar un DELETE
     * @return boolean
     */
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM provincia WHERE id_provincia=" . $this->getIdProvincia();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Provincia->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Provincia->eliminar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * guardamos los Provinciaes en un arreglo para poder manipular sobre ellos,
     * tenemos el parametro para cualquier especificacion sobre la busqueda de los Provinciaes
     * pero si el parametro es vacio solamente mostrarmos a los objTraceurs sin restricciones
     * @param string $parametro
     * @return array
     */
    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM provincia ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($fila = $base->Registro()) {
                    $obj = new Provincia();
                    $objPais = new Pais();
                    $objPais->setIdPais($fila['id_pais']);
                    $objPais->cargar();
                    $obj->setear($fila['id_provincia'], $fila['nombre_provincia'], $objPais);
                    $obj->cargarSuscriptores();
                    array_push($arreglo, $obj);
                }
            }
        } else {
            Provincia::setmensajeoperacion("Provincia->listar: " . $base->getError());
        }
        return $arreglo;
    }
    public function cargarSuscriptores()
    {
        $this->setSuscriptores(Suscriptor::listar('id_provincia=' . $this->getIdProvincia()));
    }
}
