<!DOCTYPE html>
<html>

<head>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
        <title>Exemplos</title>
    </head>
</head>

<body>
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
            <a href="spotifyApiCall.php"><i class="fab fa-spotify" style="font-size: 35px;"></i></a>
        </div>
    </nav>
    <div class="container mt-5" style="background-color: white;">
        <div class="row">
            <div class="col">
                <h2 class="text-center">Listagem de Artistas e Número de Álbuns</h2>
                <ul class="list-group">
                    <?php
                    require_once(__DIR__ . "/config/Conexao.php");

                    function listarArtistasEAlbums()
                    {
                        $pdo = Conexao::getConexao();

                        $sql = "SELECT a.nome AS artista, COUNT(al.id) AS num_albums
                                FROM artista a
                                LEFT JOIN album al ON a.id = al.artista_id
                                GROUP BY a.id";

                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();

                        while ($row = $stmt->fetch()) {
                            echo "<li class='list-group-item'>{$row['artista']} - {$row['num_albums']} álbuns</li>";
                        }
                    }

                    listarArtistasEAlbums();
                    ?>
                </ul>
            </div>
            <div class="col">
                <h2 class="text-center">Listagem de Álbuns e Número de Músicas</h2>
                <ul class="list-group">
                    <?php

                    function listarAlbumsEMusicas()
                    {
                        $pdo = Conexao::getConexao();

                        $sql = "SELECT al.titulo AS album, COUNT(m.id) AS num_musicas
                                FROM album al
                                LEFT JOIN musica m ON al.id = m.album_id
                                GROUP BY al.id
                                ORDER BY num_musicas DESC";

                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();

                        while ($row = $stmt->fetch()) {
                            echo "<li class='list-group-item'>{$row['album']} - {$row['num_musicas']} músicas</li>";
                        }
                    }

                    listarAlbumsEMusicas();
                    ?>
                </ul>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <h2 class="text-center">Música Mais Antiga <br>Cadastrada</h2>
                <ul class="list-group">
                    <?php

                    function listarMusicaMaisAntiga()
                    {
                        $pdo = Conexao::getConexao();

                        $sql = "SELECT titulo, ano
                                FROM musica
                                WHERE ano IS NOT NULL
                                ORDER BY ano ASC
                                LIMIT 1";

                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();

                        $row = $stmt->fetch();

                        if ($row) {
                            echo "<li class='list-group-item'>Título: {$row['titulo']}</li>";
                            echo "<li class='list-group-item'>Ano: {$row['ano']}</li>";
                        } else {
                            echo "<li class='list-group-item'>Nenhuma música com ano de lançamento cadastrado.</li>";
                        }
                    }

                    listarMusicaMaisAntiga();
                    ?>
                </ul>
            </div>
            <div class="col">
                <h2 class="text-center">Música Mais Recente Cadastrada</h2>
                <ul class="list-group">
                    <?php

                    function listarMusicaMaisRecente()
                    {
                        $pdo = Conexao::getConexao();

                        $sql = "SELECT titulo, ano
                                FROM musica
                                WHERE ano IS NOT NULL
                                ORDER BY ano DESC
                                LIMIT 1";

                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();

                        $row = $stmt->fetch();

                        if ($row) {
                            echo "<li class='list-group-item'>Título: {$row['titulo']}</li>";
                            echo "<li class='list-group-item'>Ano: {$row['ano']}</li>";
                        } else {
                            echo "<li class='list-group-item'>Nenhuma música com ano de lançamento cadastrado.</li>";
                        }
                    }

                    listarMusicaMaisRecente();
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>