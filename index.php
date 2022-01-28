<?php
    require_once("templates/header.php");
    require_once("dao/SerieDAO.php");

    // DAO das series
    $serieDao = new SerieDAO($conexao, $BASE_URL);

    $latestSeries = $serieDao->getLatestSeries();

    $actionSeries = $serieDao->getSeriesByCategory("Ação");

    $comedySeries = $serieDao->getSeriesByCategory("Comédia");
?>
    <div id="main-container" class="container-fluid">
        <h2 class="section-title">Séries novas</h2>
        <p class="section-description">Veja as críticas das ultimas séries adicionadas no SeriesToSee!</p>
        <div class="series-container">
        <?php foreach($latestSeries as $serie): ?>
          <?php  require("templates/serie_card.php"); ?>
        <?php endforeach; ?>
        <?php if(count($latestSeries) === 0): ?>
            <p class="empty-list">Ainda não há séries cadastradas!</p>
        <?php endif; ?>
        </div>
        <h2 class="section-title">Ação</h2>
        <p class="section-description">Veja as melhores séries de ação!</p>
        <div class="series-container">
        <?php foreach($actionSeries as $serie): ?>
          <?php  require("templates/serie_card.php"); ?>
        <?php endforeach; ?>
        <?php if(count($actionSeries) === 0): ?>
            <p class="empty-list">Ainda não há séries de ação cadastradas!</p>
        <?php endif; ?>
        </div>  
        <h2 class="section-title">Comédia</h2>
        <p class="section-description">Veja as melhores séries de comédia!</p>
        <div class="series-container">
        <?php foreach($comedySeries as $serie): ?>
          <?php  require("templates/serie_card.php"); ?>
        <?php endforeach; ?>
        <?php if(count($comedySeries) === 0): ?>
            <p class="empty-list">Ainda não há séries de comédia cadastradas!</p>
        <?php endif; ?>
        </div>
    </div>
<?php
    require_once("templates/footer.php");
?>