<?php
    require_once("templates/header.php");
    require_once("models/User.php");
    require_once("dao/UserDAO.php");
    require_once("dao/SerieDAO.php");

    //Verifica se o usuario está autenticado
    $user = new User();
    $userDao = new UserDAO($conexao, $BASE_URL);
    $serieDao = new SerieDAO($conexao, $BASE_URL);

    $userData = $userDao->verifyToken(true);

    $userSeries = $serieDao->getSeriesByUserId($userData->id);

?>
    <div id="main-container" class="container-fluid">
       <h2 class="section-title">Dashboard</h2>
       <p class="section-description">Adicione ou atualize as informações das séries que você enviou!</p>
       <div class="col-md-12" id="add-serie-container">
            <a href="<?= $BASE_URL ?>newserie.php" class="btn card-btn">
                <i class="fas fa-plus"></i> Adicionar Série
            </a>
       </div>
       <div class="col-md-12" id="series-dashboard">
            <table class="table">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Título</th>
                    <th scope="col">Nota</th>
                    <th scope="col" class="actions-column">Ações</th>
                </thead>
                <tbody>
                    <?php foreach($userSeries as $serie): ?>
                    <tr>
                        <td scope="row"><?= $serie->id ?></td>
                        <td><a href="<?= $BASE_URL ?>serie.php?id=<?= $serie->id ?>" class="table-serie-title"><?= $serie->title ?></a></td>
                        <td><i class="fas fa-star"></i><?= $serie->rating ?></td>
                        <td class="actions-column">
                            <a href="<?= $BASE_URL ?>editserie.php?id=<?= $serie->id ?>" class="edit-btn">
                                <i class="far fa-edit"></i> Editar
                            </a>
                            <form action="<?= $BASE_URL ?>serie_process.php" method="POST">
                            <input type="hidden" name="type" value="delete">
                            <input type="hidden" name="id" value="<?= $serie->id ?>">
                                <button type="submit" class="delete-btn">
                                    <i class="fas fa-times"></i> Deletar
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
       </div>
    </div>
<?php
    require_once("templates/footer.php");
?>