<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/artista.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <title>Smart Music</title>
</head>

<body>
    <div class="container">
        <nav>
            <a href="index.php" style="text-decoration: none;">
                <div class="logo">MUSIC<b>.</b></div>
            </a>
            <ul class="navItems">
                <li><a href="artista.php">Artistas</a></li>
                <li><a href="album.php">Álbuns</a></li>
                <li><a href="selecionarOpcao.php">Músicas</a></li>
            </ul>
            <div class="links">
                <a href="spotifyApiCall.php"><i
                        class="fab fa-spotify" style="font-size: 35px;"></i></a>
            </div>
        </nav>

        <?php
        require_once("./config/utils.php");
        require_once("./model/Artista.php");

        if (isMetodo("POST")) {
            if (parametrosValidos($_POST, ["nome", "data_nascimento", "nacionalidade"])) {
                $id = $_POST["id"];
                $nome = $_POST["nome"];
                $data = $_POST["data_nascimento"];
                $nacionalidade = $_POST["nacionalidade"];

                $res = Artista::atualizarArt($id, $nome, $data, $nacionalidade);

                if ($res) {
                    echo "<script>
                    Toastify({
                        text: 'Artista atualizado com sucesso!',
                        duration: 500,
                        style: {
                            background: 'linear-gradient(to right, #00b09b, #96c93d)'
                        },
                        position: 'right',
                        gravity: 'top',
                        offset: {
                            x: 20,
                            y: 20
                        },
                        callback: function() {
                            window.location.href = 'album.php';
                        }
                    }).showToast();
                  </script>";
                } else {
                    echo "<script>
                    Toastify({
                        text: 'Erro ao editar artista...',
                        duration: 3000,
                        style: {
                            background: 'linear-gradient(to right, #f44336, #ff5722)',
                        },
                        position: 'right',
                        gravity: 'top',
                        offset: {
                            x: 20,
                            y: 20
                        }
                    }).showToast();
                   </script>";
                }
                die;
            } else {
                echo "<script>
                 Toastify({
                     text: 'Erro ao editar artista...',
                     duration: 3000,
                     style: {
                         background: 'linear-gradient(to right, #f44336, #ff5722)',
                     },
                     position: 'right',
                     gravity: 'top',
                     offset: {
                         x: 20,
                         y: 20
                     }
                 }).showToast();
                </script>";
                die;
            }
        }

        if (isMetodo("GET")) {
            if (parametrosValidos($_GET, ["id"])) {

                if (Artista::existeArt($_GET["id"])) {
                    $artista = Artista::getArtPorId($_GET["id"]);
                } else {
                    echo "<script>
                    Toastify({
                        text: 'Esse artista não existe!',
                        duration: 3000,
                        style: {
                            background: 'linear-gradient(to right, #f44336, #ff5722)',
                        },
                        position: 'right',
                        gravity: 'top',
                        offset: {
                            x: 20,
                            y: 20
                        }
                    }).showToast();
                   </script>";
                    die;
                }
            } else {
                echo "<script>
                Toastify({
                    text: 'ID não foi enviado',
                    duration: 3000,
                    style: {
                        background: 'linear-gradient(to right, #f44336, #ff5722)',
                    },
                    position: 'right',
                    gravity: 'top',
                    offset: {
                        x: 20,
                        y: 20
                    }
                }).showToast();
               </script>";
                die;
            }
        }
        ?>

        <div class="container" id="fill">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h2 class="text-center">Edição do Artista <?= $artista["nome"] ?></h2>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $artista["id"] ?>">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome"
                                value="<?= $artista["nome"] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="data_nascimento">Data de Nascimento</label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento"
                                value="<?= $artista["data_nascimento"] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nacionalidade">Nacionalidade</label>
                            <input type="text" class="form-control" id="nacionalidade" name="nacionalidade"
                                value="<?= $artista["nacionalidade"] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </div>
    </div>
    </div>
</body>
</html>