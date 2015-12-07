<?php

require_once('funcoes.php');

$sentenca = $_POST['data']['sentenca'];
$DadosValorTerminalEstado = json_decode($_POST['data']['DadosValorTerminalEstado']);
$SimbolosFinais = json_decode($_POST['data']['SimbolosFinais']);
$SimboloInicial = $_POST['data']['SimboloInicial'];
//var_dump($DadosValorTerminalEstado);exit;
$indexUltimaLetra = strlen($sentenca) - 1;

$estadoAtual = $SimboloInicial;
$retorno['msg'] = 'Sentença não Reconhecida!';
for ($i = 0; $i < strlen($sentenca); $i++) {
    $letra = $sentenca[$i];
    //var_dump($DadosValorTerminalEstado->$letra->$estadoAtual); exit;   
    if(Funcoes::temMaisDeUmEstadoDestino($DadosValorTerminalEstado->$letra->$estadoAtual)) {
        $proximaLetra = '';
        $nextIndex = $i + 1;
        if(isset($sentenca[$nextIndex])) {
            $proximaLetra = $sentenca[$nextIndex];
        }
        
        //var_dump($proximaLetra);
        //var_dump($sentenca[$nextIndex]);        
        $estadoDestino = Funcoes::getEstadoDestino($DadosValorTerminalEstado->$letra->$estadoAtual, $letra, $proximaLetra, $estadoAtual);
    } else {
        $estadoDestino = $DadosValorTerminalEstado->$letra->$estadoAtual;
    }
    
    
    //var_dump('estadoAtual: ' . $estadoAtual);
    //var_dump('estadoDestino: ' . $estadoDestino);
    if (empty($estadoDestino)) {
        echo json_encode($retorno);
        exit();
    }

    $estadoAtual = $estadoDestino;
    if ($i == $indexUltimaLetra) {
        if (!Funcoes::estadoIsFinal($estadoAtual, $SimbolosFinais)) {
            echo json_encode($retorno);
            exit();
        }
    }
}

$retorno['msg'] = 'Sentença Reconhecida!';
echo json_encode($retorno);
exit();
