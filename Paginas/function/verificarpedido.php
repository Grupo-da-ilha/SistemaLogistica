          <?php                  
                            $hostname = "127.0.0.1";
                            $user = "root";
                            $password = "";
                            $database = "logistica";

                            $conexao = new mysqli($hostname, $user, $password, $database);

                            if ($conexao->connect_errno) {
                                echo "Failed to connect to MySQL: " . $conexao->connect_error;
                                exit();
                            }else{
                                if(isset($_POST['enviar-pedido']) && !empty($_POST['nota_fiscal']) && !empty($_POST['cod_pedido'])){
                                    $_SESSION['nota_fiscal_doca'] = $_POST['nota_fiscal'];
                                    $_SESSION['codigo_pedido_doca'] = $_POST['cod_pedido'];

                                    $nota_fiscal = $conexao->real_escape_string($_POST['nota_fiscal']);
                                    $cod_pedido = $conexao->real_escape_string($_POST['cod_pedido']);

                                    $sql = "SELECT * FROM nota_fiscal WHERE cod_nota = '".$_SESSION['nota_fiscal_doca']."' AND cod_pedido = '".$_SESSION['codigo_pedido_doca']."'";
                                    $execute = $conexao->query($sql);

                                    if($execute->num_rows > 0){
                                        $sql = "SELECT * FROM pedido WHERE cod_pedido = '".$_SESSION['codigo_pedido_doca']."'";
                                        $execute = $conexao->query($sql);

                                        if($execute->num_rows > 0){
                                            $sql = "SELECT * FROM itenspedido WHERE cod_pedido = '".$_SESSION['codigo_pedido_doca']."'";
                                            $execute = $conexao->query($sql);

                                            if($execute->num_rows > 0){ 
                                                $sql = "SELECT produtos.cod_produto, produtos.Nome, produtos.PrecoUNI, produtos.UN, produtos.NCM, produtos.PesoGramas, itenspedido.Quantidade, itenspedido.cod_itenPedido, itenspedido.ValorTotal
                                                FROM produtos 
                                                LEFT JOIN itenspedido ON produtos.cod_produto = itenspedido.cod_produto 
                                                WHERE itenspedido.cod_pedido = '".$_SESSION['codigo_pedido_doca']."' ORDER BY produtos.Nome ASC";
                                                $resultado = $conexao->query($sql);  
                                                
                                                echo '<div class="produtos" style="overflow-y: auto;">
                                                        <h4>PRODUTOS:</h4>';
                                                while ($row = $resultado->fetch_assoc()){
                                                    echo '<h6>Produto: ' . htmlspecialchars($row['Nome']). '</h6>';
                                                    echo '<h6>Quantidade: ' . htmlspecialchars($row['Quantidade']). '</h6>';
                                                    echo '<h6>Preço Unitário: ' . htmlspecialchars($row['PrecoUNI']). '</h6>';
                                                    echo '<h6>Valor Total: ' . htmlspecialchars($row['ValorTotal']). '</h6>';
                                                    echo '<h6>UN: ' . htmlspecialchars($row['UN']). '</h6>';
                                                    echo '<form action="function/processorecebimento.php" method="POST">
                                                            <input type="hidden" name="codigoItemPedido" value="' . htmlspecialchars($row['cod_itenPedido']). '">
                                                            Avariado?
                                                            <input type="checkbox" id="avariado-produto" class="avariado-produto" name="avariado">
                                                            Faltando?
                                                            <input type="checkbox" id="avariado-produto" class="avariado-produto" name="Faltando">
                                                            <input type="submit" name="UpdateItem" value="OK">
                                                            <input type="submit" name="Confirmar-pedido" value="OK">
                                                          </form>';
                                                }
                                                echo '</div>';
                                            } else {
                                                echo 'Esse pedido não possui itens';
                                            }
                                        } else {
                                            echo 'Código do pedido incorreto';
                                        }
                                    } else {
                                        echo 'Código da nota fiscal e do pedido não correspondem';
                                    }  
                                }

                                
                            }
                            ?>