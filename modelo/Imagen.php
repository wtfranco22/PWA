<?php
class Imagen
{
    private $idImagen;
    private $objTraceur;
    private $nivel;
    private $nombre;
    private $ruta;
    private $descripcion;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idImagen = 0;
        $this->objTraceur = new Traceur();
        $this->nivel = "";
        $this->nombre = "";
        $this->ruta = "";
        $this->descripcion = "";
        $this->mensajeoperacion = "";
    }

    /**
     * @param int $id
     * @param Traceur $objTraceur
     * @param int $nivel
     * @param string $nombre
     * @param string $ruta
     * @param string $descripcion
     */
    public function setear($id, $objTraceur,$nombre,$ruta, $descripcion,$nivel)
    {
        $this->setIdImagen($id);
        $this->setObjTraceur($objTraceur);
        $this->setRuta($ruta);
        $this->setNivel($nivel);
        $this->setNombre($nombre);
        $this->setDescripcion($descripcion);
    }

    /**
     * @return int
     */
    public function getIdImagen()
    {
        return $this->idImagen;
    }/**
     * @return Traceur
     */
    public function getObjTraceur()
    {
        return $this->objTraceur;
    }
    /**
     * @return string
     */
    public function getRuta()
    {
        return $this->ruta;
    }
    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    /**
     * @return int
     */
    public function getNivel()
    {
        return $this->nivel;
    }
    /**
     * @param string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
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
    public function setIdImagen($id)
    {
        $this->idImagen = $id;
    }
    /**
     * @param Traceur $objTrac
     */
    public function setObjTraceur($objTrac)
    {
        $this->objTraceur = $objTrac;
    }
    /**
     * @param string $ruta
     */
    public function setRuta($ruta)
    {
        $this->ruta = $ruta;
    }
    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    /**
     * @param int $nivel
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
    }
    /**
     * @param string $bio
     */
    public function setDescripcion($bio)
    {
        $this->descripcion = $bio;
    }
    /**
     * @param string $valorMensaje
     */
    public function setmensajeoperacion($valorMensaje)
    {
        $this->mensajeoperacion = $valorMensaje;
    }

    /**
     * solo necesitamos que el Imagen tenga su id seteado para cargar todos los demas valores
     * @return boolean
     */
    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM imagen WHERE id_imagen = " . $this->getIdImagen();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $fila = $base->Registro();
                    $objTraceur = new Traceur();
                    $objTraceur->setIdTraceur($fila['id_traceur']);
                    $objTraceur->cargar();
                    $this->setear($fila['id_imagen'],$objTraceur,$fila['nombre_imagen'], $fila['ruta_imagen'], $fila['descripcion_imagen'], $fila['nivel_imagen']);
                    $resp = true;
                }
            }
        } else {
            $this->setmensajeoperacion("Imagen->listar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * una vez que el imagen tenga sus valores seteados insertamos un nuevo imagen
     * con estos valores en la base de datos
     * @return boolean
     */
    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO imagen (id_traceur, nombre_imagen, ruta_imagen, descripcion_imagen, nivel_imagen)  VALUES(" . $this->getObjTraceur()->getIdTraceur() . " , '" . $this->getNombre() . "' ,'" . $this->getRuta() . "' , '" . $this->getDescripcion() . "' , '" . $this->getNivel() . "');";
        if ($base->Iniciar()) {
            if ($idTc = $base->Ejecutar($sql)) {
                //al ejecutar nos devuelve la cantidad de inserciones realizadas, nuestro id
                $this->setIdImagen($idTc);
                $resp = true;
            } else {
                $this->setmensajeoperacion("Imagen->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Imagen->insertar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * si seteamos nuevos datos no nos alcanza utilizar un metodo set sobre imagen
     * sino que debemos reflejar los nuevos cambios sobre la base de datos
     * @return boolean
     */
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE imagen SET id_traceur=" . $this->getObjTraceur()->getIdTraceur() . ", nivel_imagen=" . $this->getNivel() . ", nombre_imagen='" . $this->getNombre() . "', ruta_imagen='" . $this->getRuta() . "', descripcion_imagen='" . $this->getDescripcion() . "' WHERE id_imagen=" . $this->getIdImagen();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Imagen->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Imagen->modificar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * para borrar el imagen de manera permanente lo debemos hacer en la base de datos
     * entonces al estar seteada el id, nos basta para buscarlos y realizar un DELETE
     * @return boolean
     */
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM imagen WHERE id_imagen=" . $this->getIdImagen();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Imagen->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Imagen->eliminar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * guardamos los imagenes en un arreglo para poder manipular sobre ellos,
     * tenemos el parametro para cualquier especificacion sobre la busqueda de los imagenes
     * pero si el parametro es vacio solamente mostrarmos a los objTraceurs sin restricciones
     * @param string $parametro
     * @return array
     */
    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM imagen ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($fila = $base->Registro()) {
                    $obj = new Imagen();
                    $objTraceur = new Traceur();
                    $objTraceur->setIdTraceur($fila['id_traceur']);
                    $objTraceur->cargar();
                    $obj->setear($fila['id_imagen'],$objTraceur, $fila['nombre_imagen'], $fila['ruta_imagen'], $fila['descripcion_imagen'], $fila['nivel_imagen']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            Imagen::setmensajeoperacion("Imagen->listar: " . $base->getError());
        }
        return $arreglo;
    }
}
