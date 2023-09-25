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
        require_once("./model/Album.php");
        require_once("./model/Artista.php");
        require_once("./model/Musica.php");

        if (isMetodo("POST")) {
            if (parametrosValidos($_POST, ["nome", "data_nascimento", "nacionalidade"])) {
                $nome = strip_tags($_POST["nome"]);
                $data = $_POST["data_nascimento"];
                $nacionalidade =strip_tags($_POST["nacionalidade"]);
                
                $existeArtista = Artista::getArtistaPorNome($nome);
                
                if ($existeArtista) {
                    echo "<script>
                        Toastify({
                            text: 'Artista já existe!',
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
                    $res = Artista::addArt($nome, $data, $nacionalidade);
                    if ($res) {
                        echo "<script>
                            Toastify({
                                text: 'Artista cadastrado com sucesso!',
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
                                text: 'Erro ao cadastrar artista...',
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
                    case "deletarArt":
                        $artista_id = $_GET["id"];
                        
                        $albunsDoArtista = Album::listarAlbunsDoArtista($artista_id);
        
                        foreach ($albunsDoArtista as $album) {
                            $album_id = $album["id"];
        
                            Musica::deletaridAlbum($album_id);
                            Album::deletarAlbum($album_id);
                        }
        
                        $res = Artista::deletarArt($artista_id);
        
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

        $listaArtistas = Artista::listarArt();
        ?>

        <div class="container" id="fill">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h2 class="text-center">Cadastro de Artistas</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="data_nascimento">Data de Nascimento</label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
                        </div>
                        <div class="form-group">
                            <label for="nacionalidade">Nacionalidade</label>
                            <input type="text" class="form-control" id="nacionalidade" name="nacionalidade" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
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
                                <th>Nome</th>
                                <th>Data de Nascimento</th>
                                <th>Nacionalidade</th>
                                <th>Deletar</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listaArtistas as $artista) {
                                $id = $artista["id"];
                                echo "<tr>";
                                echo "<td>" . $artista["id"] . "</td>";
                                echo "<td>" . $artista["nome"] . "</td>";
                                echo "<td>" . $artista["data_nascimento"] . "</td>";
                                echo "<td>" . $artista["nacionalidade"] . "</td>";
                                echo "<td><a href='editar_artista.php?id=$id' class='btn btn-primary'>Editar</a></td>";
                                echo "<td><a href='Artista.php?id=$id&op=deletarArt' class='btn btn-danger'>Deletar</a></td>";
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
