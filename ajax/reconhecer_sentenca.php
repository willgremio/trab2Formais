<?php

require_once('../funcoes.php');

$sentenca = $_POST['data']['sentenca'];
$DadosValorTerminalEstado = json_decode($_POST['data']['DadosValorTerminalEstado']);
$SimbolosFinais = json_decode($_POST['data']['SimbolosFinais']);
$SimboloInicial = $_POST['data']['SimboloInicial'];
$indexUltimaLetra = strlen($sentenca) - 1;

$estadoAtual = $passosAutomato = $SimboloInicial;
$retorno['msg'] = 'Sentença não Reconhecida!';
for ($i = 0; $i < strlen($sentenca); $i++) {
    $letra = $sentenca[$i];    
    if (is_object($DadosValorTerminalEstado)) {
        $estadosDestinos = $DadosValorTerminalEstado->$letra->$estadoAtual;
    } else {
        $estadosDestinos = $DadosValorTerminalEstado[$letra]->$estadoAtual;
    }
    
    if(Funcoes::temMaisDeUmEstadoDestino($estadosDestinos)) {
        $proximaLetra = '';
        $nextIndex = $i + 1;
        if(isset($sentenca[$nextIndex])) {
            $proximaLetra = $sentenca[$nextIndex];
        }
        
        $estadoDestino = Funcoes::getEstadoDestino($estadosDestinos, $letra, $proximaLetra, $estadoAtual);
    } else {
        $estadoDestino = $estadosDestinos;
    }
    
    if (empty($estadoDestino)) {
        $retorno['passosAutomato'] = $passosAutomato . '->(Não foi achado estado destino)';
        echo json_encode($retorno);
        exit();
    }

    $passosAutomato .= '->' . $estadoDestino;
    $estadoAtual = $estadoDestino;
    if ($i == $indexUltimaLetra) {
        if (!Funcoes::estadoIsFinal($estadoAtual, $SimbolosFinais)) {
            $retorno['passosAutomato'] = $passosAutomato . '(Não é estado final)';
            echo json_encode($retorno);
            exit();
        }
    }
}

$retorno['msg'] = 'Sentença Reconhecida!';
$retorno['passosAutomato'] = $passosAutomato;
echo json_encode($retorno);
exit();
