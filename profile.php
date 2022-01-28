<?php
  require_once("templates/header.php");
  require_once("models/User.php");
  require_once("dao/UserDAO.php");
  require_once("dao/SerieDAO.php");

  $user = new User();
  $userDao = new UserDAO($conexao, $BASE_URL);
  $serieDao = new SerieDAO($conexao, $BASE_URL);

  // pegar o ID do usuário
  $id = filter_input(INPUT_GET, "id");

  
  //checar se o usuario existe
  if(empty($id)) {

    if(!empty($userData)){
        
        $id = $userData->id;

    } else {

        $message->setMessage("Usuário não encontrado!", "error", "index.php");
    }

  } else {

    $userData = $userDao->findById($id);

    // se não encontrar usuário
    if(!$userData) {
        $message->setMessage("Usuário não encontrado!", "error", "index.php");
    }

  }

  $fullName = $user->getFullName($userData);

    if($userData->image == "")
    {
        $userData->image = "usuario.png";
    }

    // Séries que o usuario adicionou
    $userSeries = $serieDao->getSeriesByUserId($id);

?>
<div id="main-container" class="container-fluid">
    <div class="col-md-8 offset-md-2">
        <div class="row profile-container">
            <div class="col-md-12 about-container">
                <h1 class="page-title"><?= $fullName ?></h1>
                <div id="profile-image-container" class="profile-image" style="background-image: url('<?= $BASE_URL ?>img/usuarios/<?= $userData->image ?>')"></div>
                <h3 class="about-title">Sobre:</h3>
                <?php if(!empty($userData->bio)): ?>
                    <p class="profile-description"><?= $userData->bio ?></p>
                <?php else: ?>
                    <p class="profile-description">O usuário não escreveu nada por aqui...</p>
                <?php endif; ?>
            </div>
            <div class="col-md-12 added-series-container">
                <h3>Séries que enviou:</h3>
                <div class="series-container">
                    <?php foreach($userSeries as $serie): ?>
                        <?php require("templates/serie_card.php"); ?>
                    <?php endforeach; ?>
                    <?php if(count($userSeries) === 0): ?>
                        <p class="empty-list">O usuário ainda não enviou séries</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
  require_once("templates/footer.php");
?>