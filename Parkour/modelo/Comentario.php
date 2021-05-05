<?php
class Comentario
{
    private $idComentario;
    private $objSuscriptor;
    private $contenido;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idComentario = 0;
        $this->contenido = "";
        $this->objSuscriptor = new Suscriptor();
        $this->mensajeoperacion = "";
    }

    /**
     * @param int $id
     * @param string $comentario
     * @param Suscriptor $suscript
     */
    public function setear($id, $comentario, $suscript)
    {
        $this->setIdComentario($id);
        $this->setContenido($comentario);
        $this->setObjSuscriptor($suscript);
    }

    /**
     * @return int
     */
    public function getIdComentario()
    {
        return $this->idComentario;
    }
    /**
     * @return string
     */
    public function getContenido()
    {
        return $this->contenido;
    }
    /**
     * @return Suscriptor
     */
    public function getObjSuscriptor()
    {
        return $this->objSuscriptor;
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
    public function setIdComentario($id)
    {
        $this->idComentario = $id;
    }
    /**
     * @param string $comentario
     */
    public function setContenido($comentario)
    {
        $this->contenido = $comentario;
    }
    /**
     * @param Suscriptor $objSuscript
     */
    public function setObjSuscriptor($objSuscript)
    {
        $this->objSuscriptor = $objSuscript;
    }
    /**
     * @param string $valorMensaje
     */
    public function setmensajeoperacion($valorMensaje)
    {
        $this->mensajeoperacion = $valorMensaje;
    }

    /**
     * solo necesitamos que el Comentario tenga su id seteado para cargar todos los demas valores
     * @return boolean
     */
    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM comentario WHERE id_comentario = " . $this->getIdComentario();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $fila = $base->Registro();
                    $objSus = new Suscriptor();
                    $objSus->setNombre($fila['id_suscriptor']);
                    $this->setear($fila['id_comentario'], $fila['contenido_comentario'], $objSus);
                    $resp = true;
                }
            }
        } else {
            $this->setmensajeoperacion("Comentario->listar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * una vez que el Comentario tenga sus valores seteados insertamos un nuevo Comentario
     * con estos valores en la base de datos
     * @return boolean
     */
    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO comentario (contenido_comentario,id_suscriptor)  VALUES('" . $this->getContenido() . "','" . $this->getObjSuscriptor()->getNombre() . "');";
        if ($base->Iniciar()) {
            if ($idP = $base->Ejecutar($sql)) {
                //al ejecutar nos devuelve la cantidad de inserciones realizadas, nuestro id
                $this->setIdComentario($idP);
                $resp = true;
            } else {
                $this->setmensajeoperacion("Comentario->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Comentario->insertar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * si seteamos nuevos datos no nos alcanza utilizar un metodo set sobre Comentario
     * sino que debemos reflejar los nuevos cambios sobre la base de datos
     * @return boolean
     */
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE comentario SET contenido_comentario='" . $this->getContenido() . "' WHERE id_comentario='" . $this->getIdComentario() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Comentario->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Comentario->modificar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * para borrar el Comentario de manera permanente lo debemos hacer en la base de datos
     * entonces al estar seteada el id, nos basta para buscarlos y realizar un DELETE
     * @return boolean
     */
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM comentario WHERE id_comentario=" . $this->getIdComentario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Comentario->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Comentario->eliminar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * guardamos los Comentarioes en un arreglo para poder manipular sobre ellos,
     * tenemos el parametro para cualquier especificacion sobre la busqueda de los Comentarioes
     * pero si el parametro es vacio solamente mostrarmos a los objTraceurs sin restricciones
     * @param string $parametro
     * @return array
     */
    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM comentario ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($fila = $base->Registro()) {
                    $obj = new Comentario();
                    $objSus = new Suscriptor();
                    $objSus->setNombre($fila['id_suscriptor']);
                    $objSus->cargar();
                    $obj->setear($fila['id_comentario'], $fila['contenido_comentario'], $objSus);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            Comentario::setmensajeoperacion("Comentario->listar: " . $base->getError());
        }
        return $arreglo;
    }
}
