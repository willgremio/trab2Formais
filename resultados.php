<?php
if (!isset($_POST['data'])) {
    header('Location: index.html');
}
require_once('funcoes.php');
$dadosEstados = $_POST['data']['Estados'];
$dadosTerminais = $_POST['data']['Terminais'];
$dadosValorTerminalEstado = $_POST['data']['ValorTerminalEstado'];
$qntTerminais = count($dadosTerminais);
$simboloInicio = $_POST['data']['simbolo_inicio'];
$simbolosFim = $_POST['data']['simbolo_fim'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/index.css">
        <script src="js/jquery.js"></script>
        <script>
            $(function() {
                $('#ButtonTesteSentenca').click(function() {
                    var sentenca = $('#sentenca').val();
                    var DadosValorTerminalEstado = $('#DadosValorTerminalEstado').val();
                    var SimbolosFinais = $('#SimbolosFinais').val();
                    var SimboloInicial = $('#SimboloInicial').val();
                    $.ajax({
                        url: 'ajax/reconhecer_sentenca.php',
                        dataType: 'json',
                        data: 'data[sentenca]=' + sentenca + '&data[DadosValorTerminalEstado]=' + DadosValorTerminalEstado
                                + '&data[SimbolosFinais]=' + SimbolosFinais + '&data[SimboloInicial]=' + SimboloInicial,
                        type: 'POST',
                        success: function(retorno) {
                            $('#RespostaSentenca').html(retorno.msg + '<br />' + retorno.passosAutomato);
                        },
                        error: function() {
                            alert('Houve algum erro ao tentar fazer o teste da sentença!');
                        }
                    });
                })

            });
        </script>
    </head>
    <body>
        <h1>Resultados</h1>

        <input id="DadosValorTerminalEstado" type="hidden" value='<?= json_encode($dadosValorTerminalEstado); ?>' />
        <input id="SimbolosFinais" type="hidden" value='<?= json_encode($simbolosFim); ?>' />
        <input id="SimboloInicial" type="hidden" value='<?= $simboloInicio; ?>' />

        <h3>Tabela de Transições:</h3>
        <p>*: Estado Inicial <br />
            ->: Estado Final</p>
        <table border="1" cellspacing="1px">
            <tr>
                <th></th>
                <?php foreach ($dadosTerminais as $Terminal) : ?>
                    <th><?= $Terminal ?></th>
                <?php endforeach; ?>

            </tr>

            <?php
            foreach ($dadosEstados as $estado) :
                $textoEstado = Funcoes::formaTextoEstado($estado, $simboloInicio, $simbolosFim);
                ?>
                <tr>
                    <td style="padding: 0 15px"><?= $textoEstado; ?></td>
                    <?php
                    for ($i = 0; $i < $qntTerminais; $i++) {
                        $valorTerminal = $dadosTerminais[$i];
                        echo '<td style="width: 100px; height: 60px"; align="center">' . $dadosValorTerminalEstado[$valorTerminal][$estado] . '</td>';
                    }
                    ?>
                </tr>
            <?php endforeach; ?>
        </table>

        <p>
            <?php echo Funcoes::automatoIsDeterministico($dadosValorTerminalEstado) ? 'Autômato Determinístico' : 'Autômato Não-Determinístico' ?>
        </p>

        <br />

        <h3>Teste de Sentenças:</h3>
        <input type="text" placeholder="Digite a sentença" id="sentenca" />
        <button id="ButtonTesteSentenca" type="button">Testar Sentença!</button>
        <p id="RespostaSentenca"></p>
    </body>
</html>