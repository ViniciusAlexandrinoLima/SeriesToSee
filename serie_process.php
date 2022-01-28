<?php

    require_once("globals.php");
    require_once("conexao.php");
    require_once("models/Serie.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");
    require_once("dao/serieDAO.php");

    $message = new Message($BASE_URL);
    $userDao = new UserDAO($conexao, $BASE_URL);
    $serieDao = new SerieDAO($conexao, $BASE_URL);

    // resgata o tipo do formulário
    $type = filter_input(INPUT_POST, "type");

    // Resgata dados do usuário e verifica se está logado
    $userData = $userDao->verifyToken();

    if($type === "create") {
        
        // receber os dados dos inputs
        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $trailer = filter_input(INPUT_POST, "trailer");
        $category = filter_input(INPUT_POST, "category");
        $length = filter_input(INPUT_POST, "length");

        $serie = New Serie();

        // Validação minima de dados
        if(!empty($title) && !empty($description) && !empty($category)) {

            $serie->title = $title;
            $serie->description = $description;
            $serie->trailer = $trailer;
            $serie->category = $category;
            $serie->length = $length;
            $serie->users_id = $userData->id;

            // Upload de imagem da série
            if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

                $image = $_FILES["image"];
                $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                $jpgArray = ["image/jpeg", "image/jpg"];

                // Checando tipo da imagem
                if(in_array($image["type"], $imageTypes)) {

                    // Checa se imagem é JPG
                    if(in_array($image["type"], $jpgArray)) {
                        $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                    } else {
                        $imageFile = imagecreatefrompng($image["tmp_name"]);
                    }

                    // gerando o nome da imagem
                    $imageName = $serie->imageGenerateName();

                    imagejpeg($imageFile, "./img/series/" . $imageName, 100);

                    $serie->image = $imageName;

                } else {

                    $message->setMessage("Tipo inválido de imagem, insira PNG ou JPEG!", "error", "back");
                }

            } 

            $serieDao->create($serie);

        } else {

            $message->setMessage("Você precisa adicionar pelo menos: Título, descrição e categoria!", "error", "back");
        }

    
    
    } else if($type === "delete") {
        
        //recebe os dados do form
        $id = filter_input(INPUT_POST, "id");

        $serie = $serieDao->findById($id);

        if($serie) {

            // Verifica se a serie é do usuario
            if($serie->users_id === $userData->id) {

                $serieDao->destroy($serie->id);
                
            } else {

                $message->setMessage("Informações inválidas!", "error", "index.php");
            }

        } else {

            $message->setMessage("Informações inválidas!", "error", "index.php");
        }
    
    } else if($type === "update") {

        // receber os dados dos inputs
        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $trailer = filter_input(INPUT_POST, "trailer");
        $category = filter_input(INPUT_POST, "category");
        $length = filter_input(INPUT_POST, "length");
        $id = filter_input(INPUT_POST, "id");

        $serieData = $serieDao->findById($id); //encontra o id que veio do post

        // Verifica se encontrou a serie
        if($serieData) {

            // Verifica se a serie é do usuario
            if($serieData->users_id === $userData->id) {

                // Validação minima de dados
                if(!empty($title) && !empty($description) && !empty($category)) {
                
                //Edição da série
                $serieData->title = $title;
                $serieData->description = $description;
                $serieData->trailer = $trailer;
                $serieData->category = $category;
                $serieData->length = $length;

                // upload de imagem da série
                if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

                    $image = $_FILES["image"];
                    $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                    $jpgArray = ["image/jpeg", "image/jpg"];
    
                    // Checando tipo da imagem
                    if(in_array($image["type"], $imageTypes)) {
    
                        // Checa se imagem é JPG
                        if(in_array($image["type"], $jpgArray)) {
                            $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                        } else {
                            $imageFile = imagecreatefrompng($image["tmp_name"]);
                        }
    
                        // gerando o nome da imagem
                        $serie = new Serie();
                        $imageName = $serie->imageGenerateName();
    
                        imagejpeg($imageFile, "./img/series/" . $imageName, 100);
    
                        $serieData->image = $imageName;
    
                    } else {
    
                        $message->setMessage("Tipo inválido de imagem, insira PNG ou JPEG!", "error", "back");
                    }
    
                } 

                    $serieDao->update($serieData);

                } else { 

                    $message->setMessage("Você precisa adicionar pelo menos: Título, descrição e categoria!", "error", "back");
                }
                
            } else {

                $message->setMessage("Informações inválidas!", "error", "index.php");
            }
        } else {

            $message->setMessage("Informações inválidas!", "error", "index.php");
        }

    
    } else {

        $message->setMessage("Informações inválidas!", "error", "index.php");
    }