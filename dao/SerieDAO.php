<?php

    require_once("models/Serie.php");
    require_once("models/Message.php");
    require_once("dao/ReviewDAO.php");

    class SerieDAO implements SerieDAOInterface
    {
        private $conexao;
        private $url;
        private $message;

        public function __construct(PDO $conexao, $url)
        {
            $this->conexao = $conexao;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildSerie($data)
        {
            $serie = new Serie();

            $serie->id = $data["id"];
            $serie->title = $data["title"];
            $serie->description = $data["description"];
            $serie->image = $data["image"];
            $serie->trailer = $data["trailer"];
            $serie->category = $data["category"];
            $serie->length = $data["length"];
            $serie->users_id = $data["users_id"];

            //recebe as ratings da série
            $reviewDao = new ReviewDAO($this->conexao, $this->url);

            $rating = $reviewDao->getRatings($serie->id);
            
            $serie->rating = $rating;

            return $serie;
        }

        public function findAll()
        {

        }

        public function getLatestSeries()
        {
            $series = [];

            $stmt = $this->conexao->query("SELECT * FROM series ORDER BY id DESC");

            $stmt->execute();

            if($stmt->rowCount() > 0)
            {
                $seriesArray = $stmt->fetchAll();

                foreach($seriesArray as $serie)
                {
                    $series[] = $this->buildSerie($serie);
                }
            }

            return $series;
        }

        public function getSeriesByCategory($category)
        {
            $series = [];

            $stmt = $this->conexao->prepare("SELECT * FROM series 
                    WHERE category = :category ORDER BY id DESC");

            $stmt->bindParam(":category", $category);
            $stmt->execute();

            if($stmt->rowCount() > 0)
            {
                $seriesArray = $stmt->fetchAll();

                foreach($seriesArray as $serie)
                {
                    $series[] = $this->buildSerie($serie);
                }
            }

            return $series;
        }

        public function getSeriesByUserId($id)
        {
            $series = [];

            $stmt = $this->conexao->prepare("SELECT * FROM series 
                    WHERE users_id = :users_id");

            $stmt->bindParam(":users_id", $id);
            $stmt->execute();

            if($stmt->rowCount() > 0)
            {
                $seriesArray = $stmt->fetchAll();

                foreach($seriesArray as $serie)
                {
                    $series[] = $this->buildSerie($serie);
                }
            }

            return $series;
        }

        public function findById($id)
        {
            $serie = [];

            $stmt = $this->conexao->prepare("SELECT * FROM series 
                    WHERE id = :id");

            $stmt->bindParam(":id", $id);
            $stmt->execute();

            if($stmt->rowCount() > 0)
            {
                $serieData = $stmt->fetch();

                $serie = $this->buildSerie($serieData);

                return $serie;

            } else {

                return false;
            }

        }

        public function findByTitle($title)
        {
            $series = [];

            $stmt = $this->conexao->prepare("SELECT * FROM series 
                    WHERE title LIKE :title");

            $stmt->bindValue(":title", '%'.$title.'%'); // busca qualquer titulo que contenha
            $stmt->execute();

            if($stmt->rowCount() > 0)
            {
                $seriesArray = $stmt->fetchAll();

                foreach($seriesArray as $serie)
                {
                    $series[] = $this->buildSerie($serie);
                }
            }

            return $series;
        }

        public function create(Serie $serie)
        {
            $stmt = $this->conexao->prepare("INSERT INTO series (
                title, description, image, trailer, category, length, users_id
            ) VALUES (
                :title, :description, :image, :trailer, :category, :length, :users_id
            )");

            $stmt->bindParam(":title", $serie->title);
            $stmt->bindParam(":description", $serie->description);
            $stmt->bindParam(":image", $serie->image);
            $stmt->bindParam(":trailer", $serie->trailer);
            $stmt->bindParam(":category", $serie->category);
            $stmt->bindParam(":length", $serie->length);
            $stmt->bindParam(":users_id", $serie->users_id);

            $stmt->execute();

            // Mensagem de sucesso por adicionar série
            $this->message->setMessage("Série adicionada com sucesso!", "sucess", "index.php");
        }

        public function update(Serie $serie)
        {
            $stmt = $this->conexao->prepare("UPDATE series SET
            title = :title,
            description = :description,
            image = :image,
            category = :category,
            trailer = :trailer,
            length = :length
            WHERE id = :id      
          ");
    
          $stmt->bindParam(":title", $serie->title);
          $stmt->bindParam(":description", $serie->description);
          $stmt->bindParam(":image", $serie->image);
          $stmt->bindParam(":category", $serie->category);
          $stmt->bindParam(":trailer", $serie->trailer);
          $stmt->bindParam(":length", $serie->length);
          $stmt->bindParam(":id", $serie->id);
    
          $stmt->execute();
    
          // Mensagem de sucesso por editar série
          $this->message->setMessage("Série atualizado com sucesso!", "sucess", "dashboard.php");
        }

        public function destroy($id)
        {
            $stmt = $this->conexao->prepare("DELETE FROM series WHERE id = :id");

            $stmt->bindParam(":id", $id);

            $stmt->execute();

            // Mensagem de sucesso por remover serie
            $this->message->setMessage("Série removida com sucesso!", "sucess", "dashboard.php");
        }
    }