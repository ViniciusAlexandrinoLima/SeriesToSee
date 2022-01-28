<?php

    require_once("models/Review.php");
    require_once("models/Message.php");

    require_once("dao/UserDAO.php");

    class ReviewDAO implements ReviewDAOInterface {

        private $conexao;
        private $url;
        private $message;


        public function __construct(PDO $conexao, $url)
        {
            $this->conexao = $conexao;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildReview($data)
        {
            $reviewObject = new Review();

            $reviewObject->id = $data["id"];
            $reviewObject->rating = $data["rating"];
            $reviewObject->review = $data["review"];
            $reviewObject->users_id = $data["users_id"];
            $reviewObject->series_id = $data["series_id"];

            return $reviewObject;
        }

        public function create(Review $review)
        {
            $stmt = $this->conexao->prepare("INSERT INTO reviews (
                rating, review, series_id, users_id
                ) VALUES (
                :rating, :review, :series_id, :users_id
            )");

            $stmt->bindParam(":rating", $review->rating);
            $stmt->bindParam(":review", $review->review);
            $stmt->bindParam(":series_id", $review->series_id);
            $stmt->bindParam(":users_id", $review->users_id);

            $stmt->execute();

            // Mensagem de sucesso por adicionar série
            $this->message->setMessage("Crítica adicionada com sucesso!", "sucess", "index.php");
        }

        public function getSeriesReview($id)
        {
            $reviews = [];
            $stmt = $this->conexao->prepare("SELECT * FROM reviews WHERE series_id = :series_id");

            $stmt->bindParam(":series_id", $id);
            $stmt->execute();

            if($stmt->rowCount() > 0)
            {
                $reviewsData = $stmt->fetchAll();

                $userDao = new UserDAO($this->conexao, $this->url);

                foreach($reviewsData as $review) {

                    $reviewObject = $this->buildReview($review);

                    // Chamar dados do usuario
                    $user = $userDao->findById($reviewObject->users_id);

                    $reviewObject->user = $user;

                    $reviews[] = $reviewObject;
                }

            }

            return $reviews;
        }

        public function hasAlreadyReviewed($id, $userId)
        {
            $stmt = $this->conexao->prepare("SELECT * FROM reviews WHERE series_id = :series_id AND users_id = :users_id");

            $stmt->bindParam(":series_id", $id);
            $stmt->bindParam(":users_id", $userId);

            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function getRatings($id)
        {
            $stmt = $this->conexao->prepare("SELECT * FROM reviews WHERE series_id = :series_id");

            $stmt->bindParam(":series_id", $id);

            $stmt->execute();

            if($stmt->rowCount() > 0) {
                
                $rating = 0;

                $reviews = $stmt->fetchAll();

                foreach($reviews as $review) {
                    $rating += $review["rating"];
                }

                $rating = $rating / count($reviews);

            } else {

                $rating = "Não avaliado!";
            }

            return $rating;
        }

    }