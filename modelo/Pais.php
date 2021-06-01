<?php
class Pais
{
    private $idPais;
    private $nombre;
    private $coleccionProvincias;
    private $coleccionTraceurs;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idPais = "";
        $this->nombre = "";
        $this->coleccionProvincias = [];
        $this->coleccionTraceurs = [];
        $this->mensajeoperacion = "";
    }

    /**
     * @param int $id
     * @param string $name
     */
    public function setear($id,$name)
    {
        $this->setIdPais($id);
        $this->setNombre($name);
    }

    /**
     * @return int
     */
    public function getIdPais()
    {
        return $this->idPais;
    }
    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    /**
     * @return array
     */
    public function getProvincias()
    {
        return $this->coleccionProvincias;
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
    public function setIdPais($id)
    {
        $this->idPais = $id;
    }
    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    /**
     * @param array $coleccionProv
     */
    public function setProvincias($coleccionProv)
    {
        $this->coleccionProvincias = $coleccionProv;
    }
    /**
     * @param array $colTraceurs
     */
    public function setTraceurs($colTraceurs)
    {
        $this->coleccionTraceurs = $colTraceurs;
    }
    /**
     * @param string $valorMensaje
     */
    public function setmensajeoperacion($valorMensaje)
    {
        $this->mensajeoperacion = $valorMensaje;
    }

    /**
     * solo necesitamos que el Pais tenga su id seteado para cargar todos los demas valores
     * @return boolean
     */
    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM pais WHERE id_pais = " . $this->getIdPais();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['id_pais'],$row['nombre_pais']);
                    $resp = true;
                }
            }
        } else {
            $this->setmensajeoperacion("Pais->listar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * una vez que el Pais tenga sus valores seteados insertamos un nuevo Pais
     * con estos valores en la base de datos
     * @return boolean
     */
    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO pais (nombre_pais)  VALUES('" . $this->getNombre() . "');";
        if ($base->Iniciar()) {
            if ($idP = $base->Ejecutar($sql)) {
                //al ejecutar nos devuelve la cantidad de inserciones realizadas, nuestro id
                $this->setIdPais($idP);
                $resp = true;
            } else {
                $this->setmensajeoperacion("Pais->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Pais->insertar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * si seteamos nuevos datos no nos alcanza utilizar un metodo set sobre Pais
     * sino que debemos reflejar los nuevos cambios sobre la base de datos
     * @return boolean
     */
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE pais SET nombre_pais='". $this->getNombre() . "' WHERE id_pais=" . $this->getIdPais();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Pais->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Pais->modificar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * para borrar el Pais de manera permanente lo debemos hacer en la base de datos
     * entonces al estar seteada el id, nos basta para buscarlos y realizar un DELETE
     * @return boolean
     */
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM pais WHERE id_pais=" . $this->getIdPais();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Pais->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Pais->eliminar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * guardamos los Paises en un arreglo para poder manipular sobre ellos,
     * tenemos el parametro para cualquier especificacion sobre la busqueda de los Paises
     * pero si el parametro es vacio solamente mostrarmos a los objTraceurs sin restricciones
     * @param string $parametro
     * @return array
     */
    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM pais ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new Pais();
                    $obj->setear($row['id_pais'], $row['nombre_pais']);
                    $obj->cargarProvincias();
                    $obj->cargarTraceurs();
                    array_push($arreglo, $obj);
                }
            }
        } else {
            Pais::setmensajeoperacion("Pais->listar: " . $base->getError());
        }
        return $arreglo;
    }

    public function cargarProvincias(){
        $this->setProvincias(Provincia::listar('id_pais='.$this->getIdPais()));
    }
    public function cargarTraceurs(){
        $this->setTraceurs(Traceur::listar('id_pais='.$this->getIdPais()));
    }
}