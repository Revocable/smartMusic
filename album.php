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
        require_once("./model/Musica.php");

        if (isMetodo("POST")) {
            if (parametrosValidos($_POST, ["titulo", "data_lancamento", "artista_id"])) {
                $titulo = strip_tags($_POST["titulo"]);
                $data_lancamento = $_POST["data_lancamento"];
                $artista_id = $_POST["artista_id"];

                $res = Album::addAlbum($titulo, $data_lancamento, $artista_id);
                if ($res) {
                    echo "<script>
                            Toastify({
                                text: 'Álbum cadastrado com sucesso!',
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
                                text: 'Erro ao cadastrar álbum...',
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

        if (isMetodo("GET")) {
            if (parametrosValidos($_GET, ["id", "op"])) {
                switch ($_GET["op"]) {
                    case "deletarAlbum":
                        Musica::deletaridAlbum($_GET["id"]);
                        $res = Album::deletarAlbum($_GET["id"]);
                        if ($res) {
                            echo "<script>
                                    Toastify({
                                        text: 'Artista removido com sucesso!',
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
                                        text: 'Erro ao remover artista...',
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

        $listaAlbuns = Album::listarAlbuns();
        $listaArtistas = Artista::listarArt();
        ?>

        <div class="container" id="fill">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h2 class="text-center">Cadastro de Álbuns</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label for="nome">Título</label>
                            <input type="text" class="form-control" id="title" name="titulo" required>
                        </div>
                        <div class="form-group">
                            <label for="data_lancamento">Data de lançamento</label>
                            <input type="date" class="form-control" id="data_lancamento" name="data_lancamento"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="artista_id">Artista</label>
                                <select class="form-control" id="artista_id" name="artista_id"">
                                    <?php
                                    if (!empty($listaArtistas)) {
                                        foreach ($listaArtistas as $artista) {
                                            $id = $artista["id"];
                                            $nome = $artista["nome"];
                                            echo "<option value='$id'>$nome</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>Nenhum artista cadastrado :(</option>";
                                    }
                                    ?>
                                </select>
                        </div>
                            <button type=" submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12">
                    <h2 class="text-center">Artistas cadastrados</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titulo</th>
                                <th>Data de Lançamento</th>
                                <th>ID do Artista</th>
                                <th>Deletar</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listaAlbuns as $album) {
                                $id = $album["id"];
                                echo "<tr>";
                                echo "<td>" . $album["id"] . "</td>";
                                echo "<td>" . $album["titulo"] . "</td>";
                                echo "<td>" . $album["data_lancamento"] . "</td>";
                                echo "<td>" . $album["artista_id"] . "</td>";
                                echo "<td><a href='editar_album.php?id=$id' class='btn btn-primary'>Editar</a></td>";
                                echo "<td><a href='Album.php?id=$id&op=deletarAlbum' class='btn btn-danger'>Deletar</a></td>";
                                echo "</tr>"; 
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>