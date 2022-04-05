<?php

class Conexao{

    Private $con;
    function _construct()
    {

    }

    function connect(){
        include_once dirname(__FILE__).'./constants.php';

        $this->con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

        if(mysqli_connect_errno()){
            echo("Conexão falhou....".mysqli_connect_error());
        }
    }
}