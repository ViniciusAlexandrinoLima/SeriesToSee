<?php 

    if(empty($serie->image))
    {
        $serie->image = "imgindisponivel.jpg";
    }
?>
<div class="card serie-card">
    <div class="card-img-top" style="background-image: url('<?= $BASE_URL ?>img/series/<?= $serie->image ?>')"></div>
        <div class="card-body">
            <p class="card-rating">
                <i class="fas fa-star"></i>
                <span class="rating"><?= $serie->rating ?></span>
            </p>
            <h5 class="card-title">
                <a href="<?= $BASE_URL ?>serie.php?id=<?= $serie->id ?>"><?= $serie->title ?></a>
             </h5>
                <a href="<?= $BASE_URL ?>serie.php?id=<?= $serie->id ?>" class="btn btn-primary rate-btn">Avaliar</a>
                <a href="<?= $BASE_URL ?>serie.php?id=<?= $serie->id ?>" class="btn btn-primary card-btn">Conhecer</a>
        </div>
</div>