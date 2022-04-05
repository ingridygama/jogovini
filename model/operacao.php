<?php

class Operacao{
    private $con;

    function __construct()
    {
        require_once dirname(__FILE__).'./Conexao.php';

        $bd = new Conexao();

        $this->con = $bd->connect();
    }

    function createFruta($campo_2,$campo_3,$campo_4){
        $stmt = $this->con->prepare("INSERT INTO jogo_tb ('nomejogo','imgjogo','valorjogo')VALUES(?,?,?)");
        $stmt->bind_param("sss",$campo_2,$campo_3,$campo_4);
            if($stmt->execute())
                return true;
            return var_dump($stmt);
    }

    function getJogo(){
        $stmt = $this->con->prepare("Select * from jogo_tb");
        $stmt->execute();
        $stmt->bind_result($uid,$nomejogo,$imgjogo,$valorjogo);

        $dicas = array();

        while($stmt->fetch()){
            $dica = array();
            $dica['uid'] = $uid;
            $dica['nomejogo'] = $nomejogo;
            $dica['imgjogo'] = $imgjogo;
            $dica['valorjogo'] = $valorjogo;
            array_push($dicas,$dica);
        }
        return $dicas;
    }

    function updateJogo($campo_1,$campo_2,$campo_3,$campo_4){
        $stmt = $this->con->prepare("update jogo_tb set nomejogo = ? ,imgjogo = ? ,valorjogo = ? where uid = ?");
        $stmt->bind_param('sssi',$campo_2,$campo_3,$campo_4,$campo_1);
        if($stmt->execute())
            return true;
        return false;
    }

    function deleteJogo($campo_1){
        $stmt = $this->con->prepare("delete from jogo_tb where uid= ?");
        $stmt->bind_param("i" ,$campo_1);
        if($stmt->execute())
        return true;
    return false;
    }
}