<?php

class Funcoes {

    public static function estadoIsFinal($estado, $simbolosFim) {
        foreach ($simbolosFim as $simFim) {
            if ($simFim == $estado) {
                return true;
            }
        }

        return false;
    }

    public static function formaTextoEstado($estado, $simboloInicio, $simbolosFim) {
        $texto = '';
        if (self::estadoIsFinal($estado, $simbolosFim)) {
            $texto .= '->';
        }
        if ($estado == $simboloInicio) {
            $texto .= '*';
        }

        $texto .= $estado;
        return $texto;
    }

    public static function automatoIsDeterministico($dadosValorTerminalEstado) {
        foreach ($dadosValorTerminalEstado as $dadoTerminalEstados) {
            foreach ($dadoTerminalEstados as $estado) {
                if (strlen($estado) > 2) {
                    return false;
                }
            }
        }

        return true;
    }
    
    public static function temMaisDeUmEstadoDestino($estado) {
        $estadosDestino = explode(',', $estado);
        if(count($estadosDestino) > 1) {
            return true;
        }
        
        return false;
    }
    
    public static function getEstadoDestino($estadosDestino, $atualTerminalDaSentenca, $proximoTerminalDaSentenca, $estadoAtual) {
        /*var_dump($estadosDestino);
        var_dump($atualTerminalDaSentenca);
        var_dump($proximoTerminalDaSentenca);
        var_dump($estadoAtual);*/
        $estadosDestinoArray = explode(',', $estadosDestino);
        //var_dump($estadosDestinoArray);
        if($atualTerminalDaSentenca == $proximoTerminalDaSentenca) {
            foreach ($estadosDestinoArray as $estado) {
                if($estado == $estadoAtual) {
                    return $estado;
                }
            }
        }
        
        foreach ($estadosDestinoArray as $estado) {
                if($estado != $estadoAtual) {
                    return $estado;
                }
            }
        
        //exit;
    }

}