<?php
    if (isset($_POST['itemselecionado']) && is_array($_POST['itemselecionado'])) {
        foreach ($_POST['itemselecionado'] as $cod_Itemestoque) {
            echo "Item selecionado: " . htmlspecialchars($cod_Itemestoque) . "<br>";
        }
    } else {
        echo "Nenhum item selecionado";
    }

?>