<?php

require_once('../model/Operacao.php');

function isTheseParametersAvailable($params){
    $available = true;
    $missingparans = "";

    foreach($params as $param){
        if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
            $available = false;
            $missingparans = $missingparans.", ".$param;
        }
    }

    if(!$available){
        $response = array();
        $response['error'] = true;
        $response['message'] = 'Parameters'.substr($missingparans, 1, strlen($missingparans)).' missing';

        echo json_encode($response);

        die();
    }
    
}

$response = array();

if(isset($_GET['apicall'])){
    switch($_GET['apicall']){

        case 'createjogo':
            isTheseParametersAvailable(array('campo_2','campo_3','campo_4'));

            $db= new Operacao();

            $result = $db->createjogo(
                $_POST['campo_2'],
                $_POST['campo_3'],
                $_POST['campo_4'],
            );

            if($result){
                $response['error'] = false;
                $response['message'] = 'Dados inseridos com sucesso.';
                $response['dadoscreate'] = $db->getjogo();
            }else{
                $response['error'] = true;
                $response['message'] = 'Dados nao foram inseridos.';
            }

        break;
        case 'getjogo':
            $db = new Operacao();
            $response['error'] = false.
            $response['message'] = 'Dados listados com sucesso.';
            $response['dadoslista']=$db->getjogo();
        
        break;
        case 'updatejogo':
            isTheseParametersAvailable(array('campo_1','campo_2','campo_3','campo_4'));
            
            $db = new Operacao();
            $result = $db->updatejogo(
                $_POST['campo_1'],
                $_POST['campo_2'],
                $_POST['campo_3'],
                $_POST['campo_4'],
            );

            if($result){
                $response['error'] = false;
                $response['message'] = "Dados alterados com sucesso.";
                $response['dadosalterar'] = $db->getjogo();                
            }else{
                $response['error'] = true;
                $response['message'] = "Dados não alterados.";
            }
        break;
        case 'deletejogo':
            if(isset($_GET['uid'])){
                $db = new Operacao();
                if($db->deletejogo($_GET['uid'])){
                    $response['error'] = false;
                    $response['message'] = 'Dado excluido com sucesso.';
                    $response['deletejogo'] = $db->getjogo();
                }else{
                    $response['error'] = true;
                    $response['message'] = "Algo deu errado";
                }    
                }else{
                    $response['error'] = true;
                    $response['message'] = "Dados não apagados";
                }
            break;
            }    
    }else{
        $response['error'] = true;
        $response['message'] = "Chamada de API com defeito";
    }
echo json_encode($response);