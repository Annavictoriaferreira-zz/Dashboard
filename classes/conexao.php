<?php
    try{
        $conexao = new PDO('mysql:host=localhost;dbname=sistemaphp', "root", '');
    }catch(Exception $e){
        echo "Erro";
    }
?>
