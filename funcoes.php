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

}