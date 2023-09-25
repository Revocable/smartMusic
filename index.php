<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
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

        <div class="wrapper">
            <div class="cols cols0">
                <h1><span class="multiText"></span></h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat nihil, omnis at est qui ea aperiam!
                </p>
            </div>
            <div class="cols cols1">
                <div class="imgbox">
                <a href="exemplosCRUD.php"><img src="assets\girl2.png"></a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
    <script>
        var typpingEffect = new Typed(".multiText", {
            strings: ["musica", "arte", "cultura"],
            loop: true,
            typeSpeed: 100,
            backSpeed: 80,
            backDelay: 1500
        })
    </script>
</body>

</html>