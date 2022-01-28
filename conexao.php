<?php

    $db_nome = "seriestosee";
    $db_host = "localhost";
    $db_user = "root";
    $db_senha = "";

    try{
    $conexao = new PDO("mysql:dbname=". $db_nome . ";host=". $db_host, $db_user, $db_senha);
    //habilitar error PDO
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    catch(PDOException $e)
    {
        die("Banco não conectado: " . $e->getMessage());
    }
