<?php

require_once('funcoes.php');

$sentenca = $_POST['data']['sentenca'];
$DadosValorTerminalEstado = json_decode($_POST['data']['DadosValorTerminalEstado']);
$SimbolosFinais = json_decode($_POST['data']['SimbolosFinais']);
$SimboloInicial = $_POST['data']['SimboloInicial'];

$ultimaLetra = strlen($sentenca) - 1;

$estadoAtual = $SimboloInicial;
$retorno['msg'] = 'Sentença não Reconhecida!';
for ($i = 0; $i < strlen($sentenca); $i++) {
    $letra = $sentenca[$i];
    //var_dump($letra);    
    $estadoDestino = $DadosValorTerminalEstado->$letra->$estadoAtual;
    //var_dump('estadoAtual: ' . $estadoAtual);
    //var_dump('estadoDestino: ' . $estadoDestino);
    if (empty($estadoDestino)) {
        echo json_encode($retorno);
        exit();
    }

    $estadoAtual = $estadoDestino;
    if ($i == $ultimaLetra) {
        if (!Funcoes::estadoIsFinal($estadoAtual, $SimbolosFinais)) {
            echo json_encode($retorno);
            exit();
        }
    }
}

$retorno['msg'] = 'Sentença Reconhecida!';
echo json_encode($retorno);
exit();
