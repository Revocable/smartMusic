<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/album.css">
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
        require_once("./model/Album.php");
        require_once("./model/Artista.php");

        if (isMetodo("POST")) {
            if (parametrosValidos($_POST, ["titulo", "data_lancamento", "artista_id"])) {
                $id = $_POST["id"];
                $titulo = $_POST["titulo"];
                $data_lancamento = $_POST["data_lancamento"];
                $artista_id = $_POST["artista_id"];

                $res = Album::atualizarAlbum($id, $titulo, $data_lancamento, $artista_id);

                if ($res) {
                    echo "<script>
                    Toastify({
                        text: 'Álbum atualizado com sucesso!',
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
                            window.location.href = 'artista.php';
                        }
                    }).showToast();
                  </script>";
                } else {
                    echo "<script>
                    Toastify({
                        text: 'Erro ao editar álbum...',
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
                     text: 'Erro ao editar álbum...',
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

                if (Album::existeAlbum($_GET["id"])) {
                    $album = Album::getAlbumPorId($_GET["id"]);
                } else {
                    echo "<script>
                    Toastify({
                        text: 'Esse álbum não existe!',
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

        $listaArtistas = Artista::listarArt();
        ?>

        <div class="container" id="fill">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h2 class="text-center">Edição do Álbum
                        <?= $album["titulo"] ?>
                    </h2>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $album["id"] ?>">
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo"
                                value="<?= $album["titulo"] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="data_lancamento">Data de Lançamento</label>
                            <input type="date" class="form-control" id="data_lancamento" name="data_lancamento"
                                value="<?= $album["data_lancamento"] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="artista_id">Artista</label>
                            <select class="form-control" id="artista_id" name="artista_id">
                                <?php
                                foreach ($listaArtistas as $artista) {
                                    $id = $artista["id"];
                                    $nome = $artista["nome"];
                                    $selected = ($id == $album["artista_id"]) ? 'selected' : '';
                                    echo "<option value='$id' $selected>$nome</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </div>
    </div>
    </div>
</body>

</html>