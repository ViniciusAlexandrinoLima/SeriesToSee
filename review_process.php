<?php

    require_once("globals.php");
    require_once("conexao.php");
    require_once("models/Serie.php");
    require_once("models/Review.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");
    require_once("dao/SerieDAO.php");
    require_once("dao/ReviewDAO.php");

    $message = new Message($BASE_URL);
    $userDao = new UserDAO($conexao, $BASE_URL);
    $serieDao = new SerieDAO($conexao, $BASE_URL);
    $reviewDao = new ReviewDAO($conexao, $BASE_URL);


    // recebendo o tipo do formulário
    $type = filter_input(INPUT_POST, "type");

    // Resgata dados do usuário e verifica se está logado
    $userData = $userDao->verifyToken();

    if($type === "create") {

        // recebendo dados do post
        $rating = filter_input(INPUT_POST, "rating");
        $review = filter_input(INPUT_POST, "review");
        $series_id = filter_input(INPUT_POST, "series_id");
        $users_id = $userData->id;

        $reviewObject = new Review();

        $serieData = $serieDao->findById($series_id);

        //Validando se a série existe
        if($serieData) {

            // Verificar Dados minimos
            if(!empty($rating) && !empty($review) && !empty($series_id)) {

                $reviewObject->rating = $rating;
                $reviewObject->review = $review;
                $reviewObject->series_id = $series_id;
                $reviewObject->users_id = $users_id;

                $reviewDao->create($reviewObject);

            } else {

                $message->setMessage("Você precisa inserir a nota e o comentário!", "error", "back");
            }

        } else {

            $message->setMessage("Informações inválidas!", "error", "index.php");
        }

    } else {

        $message->setMessage("Informações inválidas!", "error", "index.php");

    }