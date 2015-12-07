<?php
if (!isset($_POST['data'])) {
    header('Location: index.html');
}

$dadosEstados = $_POST['data']['Estados'];
$dadosTerminais = $_POST['data']['Terminais'];
$qntTerminais = count($dadosTerminais);
?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <script src="js/jquery.js"></script>
        <link rel="stylesheet" type="text/css" href="css/index.css">
        <script>

            var boxClicado = {};
            $(function() {
                $('.variaveis').click(function() {
                    var objeto = getObjetoClicado();
                    var valorAntigo = $(objeto).val();
                    var valor = $(this).val();  
                    var insereVirgula = '';
                    if(valorAntigo.length > 0) {
                        insereVirgula = ',';
                    }
                    
                    var valorNovo = valorAntigo + insereVirgula + valor; // pega o valor que ja tinha no input e concatena com o valor clicado
                    $(objeto).val(valorNovo);
                })

                $('.botaoLimpar').click(function() {
                    var objeto = getObjetoClicado();
                    $(objeto).val('');
                })

            });

            $(document).on('click', '.box', function() {
                $('.box').removeClass('boxClicado'); // remove background-color do outro box
                setObjetoClicado($(this));
                $(this).addClass('boxClicado');

            });

            function setObjetoClicado(objeto) {
                boxClicado = objeto;
            }

            function getObjetoClicado() {
                if (jQuery.isEmptyObject(boxClicado)) {
                    alert('Clique em algum box primeiro!');
                    return false;
                }

                return boxClicado;
            }

        </script>
    </head>
    <body>        
        <h1>Forme a tabela de transição</h1>
        <p>Clique primeiro em um box e depois em algum dos estados abaixo.</p>
        <form action="resultados.php" method="post">
            <?php
            echo 'Estados: ';
            foreach ($dadosEstados as $estado) {
                echo '<input class="variaveis" readonly type="button" value="Q' . $estado . '">';
            }

            //echo '<br /><br />';
            //echo '<input class="variaveis" readonly type="button" value="-">';
            ?>

            <br /><br />
            <input class="botaoLimpar" value="Limpar Box Selecionado" type="button" />
            <br /><br /><br /><br /><br />
            <?php
            foreach ($dadosTerminais as $Terminal) {
                echo '<input type="hidden" name="data[Terminais][]" value="' . $Terminal . '" />';
            }
            ?>  

            <table border="1" cellspacing="1px">
                <tr>
                    <th></th>
                    <?php foreach ($dadosTerminais as $Terminal) : ?>
                        <th><?= $Terminal ?></th>
                    <?php endforeach; ?>

                </tr>

                <?php foreach ($dadosEstados as $estado) : ?>
                    <tr>
                        <td style="padding: 0 15px">Q<?= $estado; ?></td>
                        <?php
                        for ($i = 0; $i < $qntTerminais; $i++) {
                            $valorTerminal = $dadosTerminais[$i];
                            echo '<td><input style="width: 100px; height: 60px" readonly class="box" '
                            . 'name="data[ValorTerminalEstado][' . $valorTerminal . '][Q' . $estado . ']" type="text" /></td>';
                        }
                        ?>
                    </tr>
                <?php endforeach; ?>

            </table>

            <br /><br /><br />
            Escolha o Estado Inicial:
            <div>
                <?php
                foreach ($dadosEstados as $indice => $estado) {
                    $checked = '';
                    if ($indice == 0) {
                        $checked = 'checked';  // atribui para o 1º NT checked
                    }

                    echo '<input id="lab' . $indice . '" type="radio" name="data[simbolo_inicio]" ' . $checked . ' value="Q' . $estado . '">';
                    echo '<label for="lab' . $indice . '">Q' . $estado . '</label>';
                    echo '<input type="hidden" name="data[Estados][]" value="Q' . $estado . '" />';
                    echo '<br />';
                }
                ?>
            </div>
            <br /><br />

            Escolha o(s) Estado(s) Final(is):
            <div>
                <?php
                foreach ($dadosEstados as $indice => $estado) {
                    echo '<input id="labF' . $indice . '" type="checkbox" name="data[simbolo_fim][]" value="Q' . $estado . '">';
                    echo '<label for="labF' . $indice . '">Q' . $estado . '</label>';
                    echo '<br />';
                }
                ?>
            </div>
            <br /><br />
            <input type="submit">
        </form>
    </body>
</html>




