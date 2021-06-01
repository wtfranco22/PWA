<?php
class Traceur
{
    private $idTraceur;
    private $objGrupo;
    private $apellido;
    private $nombre;
    private $objPais;
    private $fechaNacimiento;
    private $biografia;
    private $coleccionImagenes;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idTraceur = 0;
        $this->objGrupo = new Equipo();
        $this->apellido = "";
        $this->nombre = "";
        $this->objPais = new Pais();
        $this->fechaNacimiento = "";
        $this->biografia = "";
        $this->coleccionImagenes=[];
        $this->mensajeoperacion = "";
    }

    /**
     * @param int $id
     * @param Equipo $grup
     * @param string $apellido
     * @param string $nombre
     * @param Pais $pais
     * @param Date $fechaNac
     * @param string $biografia
     * @param array $coleccionImagenes
     */
    public function setear($id,$grup,$nombre, $apellido, $fechaNac, $biografia, $pais)
    {
        $this->setIdTraceur($id);
        $this->setObjGrupo($grup);
        $this->setObjPais($pais);
        $this->setApellido($apellido);
        $this->setNombre($nombre);
        $this->setFechaNacimiento($fechaNac);
        $this->setBiografia($biografia);
    }

    /**
     * @return int
     */
    public function getIdTraceur()
    {
        return $this->idTraceur;
    }/**
     * @return Equipo
     */
    public function getObjGrupo()
    {
        return $this->objGrupo;
    }
    /**
     * @return Pais
     */
    public function getObjPais()
    {
        return $this->objPais;
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
    public function getApellido()
    {
        return $this->apellido;
    }
    /**
     * @param string
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }
    /**
     * @param string
     */
    public function getBiografia()
    {
        return $this->biografia;
    }
    /**
     * @return array
     */
    public function getImagenes()
    {
        return $this->coleccionImagenes;
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
    public function setIdTraceur($id)
    {
        $this->idTraceur = $id;
    }
    /**
     * @param Equipo $grup
     */
    public function setObjGrupo($grup)
    {
        $this->objGrupo = $grup;
    }
    /**
     * @param Pais $pais
     */
    public function setObjPais($pais)
    {
        $this->objPais = $pais;
    }
    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    /**
     * @param string $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }
    /**
     * @param string $fechaNac
     */
    public function setFechaNacimiento($fechaNac)
    {
        $this->fechaNacimiento = $fechaNac;
    }
    /**
     * @param string $bio
     */
    public function setbiografia($bio)
    {
        $this->biografia = $bio;
    }
    /**
     * @param array $imgs
     */
    public function setImagenes($imgs)
    {
        $this->coleccionImagenes = $imgs;
    }
    /**
     * @param string $valorMensaje
     */
    public function setmensajeoperacion($valorMensaje)
    {
        $this->mensajeoperacion = $valorMensaje;
    }

    /**
     * solo necesitamos que el Traceur tenga su id seteado para cargar todos los demas valores
     * @return boolean
     */
    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM traceur WHERE id_traceur = " . $this->getIdTraceur();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $fila = $base->Registro();
                    $objGrupo = new Equipo();
                    $objGrupo->setIdEquipo($fila['id_grupo']);
                    $objGrupo->cargar();
                    $objPais = new Pais();
                    $objPais->setIdPais($fila['id_pais']);
                    $objPais->cargar();
                    $this->setear($fila['id_traceur'],$objGrupo, $fila['nombre_traceur'], $fila['apellido_traceur'], $fila['fechanacimiento_traceur'], $fila['biografia_traceur'],$objPais);
                    $resp = true;
                }
            }
        } else {
            $this->setmensajeoperacion("Traceur->listar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * una vez que el traceur tenga sus valores seteados insertamos un nuevo traceur
     * con estos valores en la base de datos
     * @return boolean
     */
    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO traceur (id_grupo, nombre_traceur, apellido_traceur, id_pais, fechanacimiento_traceur, biografia_traceur)  VALUES(" . $this->getObjGrupo()->getIdEquipo() . " , '" . $this->getNombre() . "' ,'" . $this->getApellido() . "' , '" . $this->getObjPais()->getIdPais() . "' , '" . $this->getFechaNacimiento() . "' , '" . $this->getBiografia() . "');";
        if ($base->Iniciar()) {
            if ($idTc = $base->Ejecutar($sql)) {
                //al ejecutar nos devuelve la cantidad de inserciones realizadas, nuestro id
                $this->setidTraceur($idTc);
                $resp = true;
            } else {
                $this->setmensajeoperacion("Traceur->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Traceur->insertar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * si seteamos nuevos datos no nos alcanza utilizar un metodo set sobre el traceur
     * sino que debemos reflejar los nuevos cambios sobre la base de datos
     * @return boolean
     */
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE traceur SET id_grupo=" . $this->getObjGrupo()->getIdEquipo() . " ,apellido_traceur='" . $this->getApellido() . "', nombre_traceur='" . $this->getNombre() . "', id_pais='" . $this->getObjPais()->getIdPais() . "', fechanacimiento_traceur='" . $this->getFechaNacimiento() . "', biografia_traceur='" . $this->getBiografia() . "' WHERE id_traceur=" . $this->getIdTraceur();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Traceur->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Traceur->modificar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * para borrar el traceur de manera permanente lo debemos hacer en la base de datos
     * entonces al estar seteada el id, nos basta para buscarlos y realizar un DELETE
     * @return boolean
     */
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM traceur WHERE id_traceur=" . $this->getidTraceur();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Traceur->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Traceur->eliminar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * guardamos los traceurs en un arreglo para poder manipular sobre ellos,
     * tenemos el parametro para cualquier especificacion sobre la busqueda de los traceurs
     * pero si el parametro es vacio solamente mostrarmos a los traceurs sin restricciones
     * @param string $parametro
     * @return array
     */
    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM traceur ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($fila = $base->Registro()) {
                    $obj = new traceur();
                    $objGrupo = new Equipo();
                    $objGrupo->setIdEquipo($fila['id_grupo']);
                    $objGrupo->cargar();
                    $objPais = new Pais();
                    $objPais->setIdPais($fila['id_pais']);
                    $objPais->cargar();
                    $obj->setear($fila['id_traceur'],$objGrupo, $fila['nombre_traceur'], $fila['apellido_traceur'], $fila['fechanacimiento_traceur'], $fila['biografia_traceur'],$objPais);
                    $obj->cargarImagenes();
                    array_push($arreglo, $obj);
                }
            }
        } else {
            Traceur::setmensajeoperacion("Traceur->listar: " . $base->getError());
        }
        return $arreglo;
    }

    /**
     * vamos a cargar las coleccionImagenes si es que el usuario posee
     * si no se agrego ninguna imagen devolvemos falso
     */
    public function cargarImagenes(){
        $this->setImagenes(Imagen::listar('id_traceur='.$this->getIdTraceur()));
    }
}
