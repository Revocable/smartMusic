<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/musica.css">
    <title>Smart Music</title>
    <style>
        .button-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            height: 50vh;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #01d475;
            color: white;
            border: none;
            border-radius: 5px;
            margin: 10px;
            text-decoration: none;
        }
        .textAndButton{
            padding-top: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 50vh;
        }
    </style>
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
        <div class="textAndButton">
            <h1>Como você deseja cadastrar?</h1>
            <div class="button-container">
                <a class="button" href="spotifyApiCall.php">Adicionar por link do Spotify</a>
                <a class="button" href="musica.php">Adicionar manualmente ou editar uma música</a>
            </div>
        </div>
    </div>
</body>

</html>