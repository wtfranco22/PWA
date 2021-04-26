<?php
class Traceur
{
    private $idTraceur;
    private $idGrupo;
    private $apellido;
    private $nombre;
    private $pais;
    private $fechaNacimiento;
    private $biografia;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idTraceur = "";
        $this->idGrupo = "";
        $this->apellido = "";
        $this->nombre = "";
        $this->pais = "";
        $this->fechaNacimiento =date('Y-m-d');
        $this->biografia = "";
        $this->mensajeoperacion = "";
    }

    /**
     * @param int $id
     * @param int $idGrup
     * @param string $apellido
     * @param string $nombre
     * @param string $pais
     * @param Date $fechaNac
     * @param string $biografia
     */
    public function setear($id,$idGrup,$nombre, $apellido, $fechaNac, $biografia, $pais)
    {
        $this->setIdTraceur($id);
        $this->setIdGrupo($idGrup);
        $this->setPais($pais);
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
     * @return int
     */
    public function getIdGrupo()
    {
        return $this->idGrupo;
    }
    /**
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
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
    private function getbiografia()
    {
        return $this->biografia;
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
     * @param int $idGrup
     */
    public function setIdGrupo($idGrup)
    {
        $this->idTraceur = $idGrup;
    }
    /**
     * @param string $pais
     */
    public function setpais($pais)
    {
        $this->pais = $pais;
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
        $sql = "SELECT * FROM traceur WHERE idTraceur = " . $this->getIdTraceur();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['idtraceur'],$row['idgrupo'],$row['pais'], $row['apellido'], $row['nombre'], $row['fechanacimiento'], $row['biografia']);
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
        $sql = "INSERT INTO traceur (idgrupo, nombre, apellido, pais, fechanacimiento, biografia)  VALUES('" . $this->getIdGrupo() . "' , '" . $this->getNombre() . "' ,'" . $this->getApellido() . "' , '" . $this->getPais() . "' , '" . $this->getFechaNacimiento() . "' , '" . $this->getBiografia() . "');";
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
        $sql = "UPDATE traceur SET idgrupo='" . $this->getIdGrupo() . "' ,apellido='" . $this->getApellido() . "', nombre='" . $this->getNombre() . "', pais='" . $this->getPais() . "', fechanacimiento='" . $this->getFechaNacimiento() . "', biografia='" . $this->getBiografia() . "' WHERE idTraceur='" . $this->getidTraceur() . "'";
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
        $sql = "DELETE FROM traceur WHERE idTraceur=" . $this->getidTraceur();
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
                while ($row = $base->Registro()) {
                    $obj = new traceur();
                    $obj->setear($row['idtraceur'],$row['idgrupo'], $row['pais'], $row['apellido'], $row['nombre'], $row['fechanacimiento'], $row['biografia']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            Traceur::setmensajeoperacion("Traceur->listar: " . $base->getError());
        }
        return $arreglo;
    }
}