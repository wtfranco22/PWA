<?php
class Imagen
{
    private $idImagen;
    private $idTraceur;
    private $nivel;
    private $nombre;
    private $img;
    private $descripcion;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idImagen = "";
        $this->idTraceur = "";
        $this->nivel = "";
        $this->nombre = "";
        $this->img = "";
        $this->descripcion = "";
        $this->mensajeoperacion = "";
    }

    /**
     * @param int $id
     * @param int $idTraceur
     * @param int $nivel
     * @param string $nombre
     * @param string $img
     * @param string $descripcion
     */
    public function setear($id, $idTraceur,$nombre,$img, $descripcion,$nivel)
    {
        $this->setIdImagen($id);
        $this->setIdTraceur($idTraceur);
        $this->setImg($img);
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
     * @return int
     */
    public function getIdTraceur()
    {
        return $this->idTraceur;
    }
    /**
     * @return string
     */
    public function getImg()
    {
        return $this->img;
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
    private function getDescripcion()
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
     * @param int $idTrac
     */
    public function setIdTraceur($idTrac)
    {
        $this->idTraceur = $idTrac;
    }
    /**
     * @param string $img
     */
    public function setImg($img)
    {
        $this->img = $img;
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
        $sql = "SELECT * FROM imagen WHERE idimagen = " . $this->getIdImagen();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['idimagen'],$row['idtraceur'],$row['nombre'], $row['img'], $row['descripcion'], $row['img']);
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
        $sql = "INSERT INTO imagen (idtraceur, nombre, img, descripcion, nivel)  VALUES('" . $this->getIdTraceur() . "' , '" . $this->getNombre() . "' ,'" . $this->getImg() . "' , '" . $this->getDescripcion() . "' , '" . $this->getNivel() . "');";
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
        $sql = "UPDATE imagen SET nivel='" . $this->getNivel() . "', nombre='" . $this->getNombre() . "', img='" . $this->getImg() . "', descripcion='" . $this->getDescripcion() . "' WHERE idimagen='" . $this->getIdImagen() . "'";
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
        $sql = "DELETE FROM imagen WHERE idimagen=" . $this->getIdImagen();
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
     * pero si el parametro es vacio solamente mostrarmos a los traceurs sin restricciones
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
                while ($row = $base->Registro()) {
                    $obj = new Imagen();
                    $obj->setear($row['idimagen'],$row['idtraceur'], $row['nombre'], $row['img'], $row['descripcion'], $row['nivel']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            Imagen::setmensajeoperacion("Imagen->listar: " . $base->getError());
        }
        return $arreglo;
    }
}