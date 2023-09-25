<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/musica.css">
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
        require_once("./model/Musica.php");

        if (isMetodo("POST")) {
            if (parametrosValidos($_POST, ["titulo", "duracao", "album_id"])) {

                $titulo = strip_tags($_POST["titulo"]);
                $duracao = $_POST["duracao"];

                if (parametrosValidos($_POST, ["ano"]) and !empty($_POST["ano"])) {
                    $ano = $_POST['ano'];
                } else {
                    $ano = null;
                }

                $album_id = $_POST["album_id"];

                $existeMusica = Musica::getMusicaPorTitulo($titulo);

                if ($existeMusica) {
                    echo "<script>
                        Toastify({
                            text: 'Música já existe!',
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
                } else {
                    $res = Musica::addMusica($titulo, $duracao, $ano, $album_id);
                    if ($res) {
                        echo "<script>
                                Toastify({
                                    text: 'Música cadastrada com sucesso!',
                                    duration: 3000,
                                    style: {
                                    background: 'linear-gradient(to right, #00b09b, #96c93d)'
                                    },
                                    position: 'right',
                                    gravity: 'top',
                                    offset: {
                                    x: 20,
                                    y: 20
                                    }
                                }).showToast();
                            </script>";
                    } else {
                        echo "<script>
                                Toastify({
                                    text: 'Erro ao cadastrar música...',
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
                }
            }
        }


        if (isMetodo("GET")) {
            if (parametrosValidos($_GET, ["id", "op"])) {
                switch ($_GET["op"]) {
                    case "deletarMusica":
                        $res = Musica::deletarMusica($_GET["id"]);
                        if ($res) {
                            echo "<script>
                                    Toastify({
                                        text: 'Música removida com sucesso!',
                                        duration: 3000,
                                        style: {
                                        background: 'linear-gradient(to right, #00b09b, #96c93d)'
                                        },
                                        position: 'right',
                                        gravity: 'top',
                                        offset: {
                                        x: 20,
                                        y: 20
                                        }
                                    }).showToast();
                                </script>";
                        } else {
                            echo "<script>
                                    Toastify({
                                        text: 'Erro ao remover música...',
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
                        break;
                    default:
                        echo "<p>Comando não reconhecido</p>";
                        die;
                }
            }
        }

        $listaMusicas = Musica::listarMusics();
        $listaAlbuns = Album::listarAlbuns();
        ?>
        <div class="container" id="fill">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h2 class="text-center">Cadastro de Músicas</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label for="nome">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="form-group">
                            <label for="duracao">Duração</label>
                            <input type="text" class="form-control" id="duracao" name="duracao" required>
                        </div>
                        <div class="form-group">
                            <label for="ano">Ano (opcional)</label>
                            <input type="number" class="form-control" id="ano" name="ano">
                        </div>
                        <div class="form-group">
                            <label for="album_id">Álbum</label>
                            <select class="form-control" id="album_id" name="album_id">
                                <?php
                                if (!empty($listaAlbuns)) {
                                    foreach ($listaAlbuns as $album) {
                                        $id = $album["id"];
                                        $titulo = $album["titulo"];
                                        echo "<option value='$id'>$titulo</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>Nenhum álbum cadastrado :(</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12">
                    <h2 class="text-center">Músicas cadastradas</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titulo</th>
                                <th>Duração</th>
                                <th>Ano</th>
                                <th>ID do Álbum</th>
                                <th>Editar</th>
                                <th>Deletar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listaMusicas as $musica) {
                                $id = $musica["id"];
                                echo "<tr>";
                                echo "<td>" . $musica["id"] . "</td>";
                                echo "<td>" . $musica["titulo"] . "</td>";
                                echo "<td>" . $musica["duracao"] . "</td>";
                                echo "<td>" . $musica["ano"] . "</td>";
                                echo "<td>" . $musica["album_id"] . "</td>";
                                echo "<td><a href='editar_musica.php?id=$id' class='btn btn-primary'>Editar</a></td>";
                                echo "<td><a href='Musica.php?id=$id&op=deletarMusica' class='btn btn-danger'>Deletar</a></td>";
                                echo "</tr>";
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>