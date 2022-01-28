<?php

    class Serie 
    {
        public $id;
        public $title;
        public $description;
        public $image;
        public $trailer;
        public $category;
        public $length;
        public $users_id;

        public function imageGenerateName()
        {
            return bin2hex(random_bytes(60)) . ".jpeg";
        }

    }

    interface SerieDAOInterface
    {
        public function buildSerie($data);
        public function findAll();
        public function getLatestSeries();
        public function getSeriesByCategory($category);
        public function getSeriesByUserId($id);
        public function findById($id);
        public function findByTitle($title);
        public function create(Serie $serie);
        public function update(Serie $serie);
        public function destroy($id);

    }