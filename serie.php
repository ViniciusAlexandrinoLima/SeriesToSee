<?php
    require_once("templates/header.php");
    require_once("models/Serie.php");
    require_once("dao/SerieDAO.php");
    require_once("dao/ReviewDAO.php");

    //Pegar o ID da série
    $id = filter_input(INPUT_GET, "id");

    $serie;

    $serieDao = new SerieDAO($conexao, $BASE_URL);
    $reviewDao = new ReviewDAO($conexao, $BASE_URL);

    if(empty($id)) {

        $message->setMessage("A série não foi encontrado!", "error", "index.php");
    
    } else {

        $serie = $serieDao->findById($id);

        // Verifica se a série existe
        if(!$serie) {
            
            $message->setMessage("A série não foi encontrado!", "error", "index.php");
        
        }

    }

    // Checar se a série tem imagem
    if($serie->image == "")
    {
        $serie->image = "imgindisponivel.jpg";
    }

    // Checar se a série é do usuário
    $userOwnsSerie = false;

    if(!empty($userData)) { //userdata vem do header

        if($userData->id === $serie->users_id) {
            $userOwnsSerie = true;

        }

        // Resgatar as reviews da série
        $alreadyReviewed = $reviewDao->hasAlreadyReviewed($id, $userData->id);
    }

    // Resgatar as reviews da série
    $serieReviews = $reviewDao->getSeriesReview($serie->id);



?>
<div id="main-container" class="container-fluid">
    <div class="row">
        <div class="offset-md-1 col-md-6 serie-container">
            <h1 class="page-title"><?= $serie->title ?></h1>
            <p class="serie-details">
                <span>Duração: <?= $serie->length ?></span>
                <span class="pipe"></span>
                <span><?= $serie->category ?></span>
                <span class="pipe"></span>
                <span><i class="fas fa-star"></i><?= $serie->rating ?></span>
            </p>
            <iframe src="<?= $serie->trailer ?>" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encryted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <p><?= $serie->description ?></p>
        </div>
        <div class="col-md-4">
           <div class="serie-image-container" style="background-image: url('<?= $BASE_URL ?>img/series/<?= $serie->image ?>')"></div>     
        </div>
        <div class="offset-md-1 col-md-10" id="reviews-container">
            <h3 id="reviews-title">Avaliações:</h3>
            <!-- verifica se habilita a review para o usuário ou não -->
            <?php if(!empty($userData) && !$userOwnsSerie && !$alreadyReviewed): ?> <!--Usuario precisa estar logado, não pode ser o dono do filme, não pode ter comentado -->
            <div class="col-md-12" id="review-form-container">
                <h4>Envie sua avaliação:</h4>
                <p class="page-description">Preencha o formulário com a nota e com comentario sobre a série</p>
                <form action="<?= $BASE_URL ?>review_process.php" id="review-form" method="POST">
                    <input type="hidden" name="type" value="create">
                    <input type="hidden" name="series_id" value="<?= $serie->id ?>">
                    <div class="form-group">
                        <label for="rating">Nota da série:</label>
                        <select name="rating" id="rating" class="form-control">
                            <option value="">Selecione</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="review">Seu comentário:</label>
                        <textarea name="review" id="review" rows="3" class="form-control" placeholder="O que você achou da série?"></textarea>
                    </div>
                    <input type="submit" class="btn card-btn" value="Enviar comentario">
                </form>
            </div>
            <?php endif; ?>
            <!-- Comentários --> 
            <?php foreach($serieReviews as $review): ?>
                <?php require("templates/user_review.php"); ?>
            <?php endforeach; ?>
            <?php if(count($serieReviews) == 0): ?>
                <p class="empty-list">Não há comentários para esta série ainda!</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php 
    require_once("templates/footer.php");
?>