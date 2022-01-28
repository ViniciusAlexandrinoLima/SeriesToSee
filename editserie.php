<?php
  require_once("templates/header.php");
  require_once("models/User.php");
  require_once("dao/UserDAO.php");
  require_once("dao/SerieDAO.php");

  $user = new User();
  $userDao = new UserDao($conexao, $BASE_URL);

  $userData = $userDao->verifyToken(true);

  $serieDao = new SerieDAO($conexao, $BASE_URL);

  $id = filter_input(INPUT_GET, "id");

  if(empty($id)) {

    $message->setMessage("A série não foi encontrada!", "error", "index.php");

  } else {

    $serie = $serieDao->findById($id);

    // Verifica se a série existe
    if(!$serie) {

      $message->setMessage("A série não foi encontrada!", "error", "index.php");

    }

  }

  // Checar se a série tem imagem
  if($serie->image == "") {
    $serie->image = "imgindisponivel.jpg";
  }

?>
  <div id="main-container" class="container-fluid">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6 offset-md-1">
          <h1><?= $serie->title ?></h1>
          <p class="page-description">Altere os dados da serie no fomrulário abaixo:</p>
          <form id="edit-serie-form" action="<?= $BASE_URL ?>serie_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="update">
            <input type="hidden" name="id" value="<?= $serie->id ?>">
            <div class="form-group">
              <label for="title">Título:</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="Digite o título da sua série" value="<?= $serie->title ?>">
            </div>
            <div class="form-group">
              <label for="image">Imagem:</label>
              <input type="file" class="form-control-file" name="image" id="image">
            </div>
            <div class="form-group">
              <label for="length">Duração:</label>
              <input type="text" class="form-control" id="length" name="length" placeholder="Digite a duração da série" value="<?= $serie->length ?>">
            </div>
            <div class="form-group">
              <label for="category">Categoria:</label>
              <select name="category" id="category" class="form-control">
                <option value="">Selecione</option>
                <option value="Ação" <?= $serie->category === "Ação" ? "selected" : "" ?>>Ação</option>
                <option value="Drama" <?= $serie->category === "Drama" ? "selected" : "" ?>>Drama</option>
                <option value="Comédia" <?= $serie->category === "Comédia" ? "selected" : "" ?>>Comédia</option>
                <option value="Fantasia" <?= $serie->category === "Fantasia" ? "selected" : "" ?>>Fantasia</option>
                <option value="Romance" <?= $serie->category === "Romance" ? "selected" : "" ?>>Romance</option>
                <option value="Terror" <?= $serie->category === "Terror" ? "selected" : "" ?>>Terror</option>
                <option value="Policiais" <?= $serie->category === "Policiais" ? "selected" : "" ?>>Policiais</option>
                <option value="Esportes" <?= $serie->category === "Esportes" ? "selected" : "" ?>>Esportes</option>
                <option value="Séries documentais" <?= $serie->category === "Séries documentais" ? "selected" : "" ?>>Séries documentais</option>
                <option value="Mistério" <?= $serie->category === "Mistério" ? "selected" : "" ?>>Mistério</option>
              </select>
            </div>
            <div class="form-group">
              <label for="trailer">Trailer:</label>
              <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer" value="<?= $serie->trailer ?>">
            </div>
            <div class="form-group">
              <label for="description">Descrição:</label>
              <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva a série"><?= $serie->description ?></textarea>
            </div>
            <input type="submit" class="btn card-btn" value="Editar serie">
          </form>
        </div>
        <div class="col-md-3">
          <div class="serie-image-container" style="background-image: url('<?= $BASE_URL ?>img/series/<?= $serie->image ?>')"></div>
        </div>
      </div>
    </div>
  </div>
<?php
  require_once("templates/footer.php");
?>
