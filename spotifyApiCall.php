<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/api.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Spotify Track Info</title>
</head>
<body>
    <header>
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
    </header>
    <main>
        <div class="container">
            <h1 class="text-center mt-5 text-white">Spotify Track Info</h1>
            <form method="post" id="spotifyForm" action="spotifyApiCall.php" class="mt-5">
                <label for="spotifyLink">Insira o link do Spotify (antes, você deve cadastrar o artista correspondente...):</label>
                <div class="input-group">
                    <input type="text" name="spotifyLink" id="spotifyLink" class="form-control" placeholder="Insira o link do Spotify">
                    <div class="input-group-append">
                        <button type="submit" name="submitButton" class="btn btnSpotify">Enviar</button>
                    </div>
                </div>
            </form>
      <?php
      if (isset($_POST['spotifyLink'])) {
        $spotifyLink = $_POST['spotifyLink'];
        $trackId = extractTrackId($spotifyLink);
        require_once("./model/Musica.php");
        require_once("./model/Album.php");
        require_once("./model/Artista.php");


        if ($trackId) {
          $accessToken = getAccessToken();
          $trackData = getTrackInfo($trackId, $accessToken);
          $anoLancamento = substr($trackData['album']['release_date'], 0, 4);



          // Exibir informações da faixa
          // echo '<div class="mt-5">';
          // echo '<a href="' . $spotifyLink . '"><img src="' . $trackData['album']['images'][0]['url'] . '" alt="Capa do álbum"></a>';
          // echo '<p>Nome da música: ' . $trackData['name'] . '</p>';
          // echo '<p>Nome do álbum: ' . $trackData['album']['name'] . '</p>';
      
          // Exibir artistas
          // echo '<p>Artistas: ';
          $artistas = $trackData['artists'];
          $artistasNomes = array_column($artistas, 'name');
          // echo implode(', ', $artistasNomes);
          // echo '</p>';
      
          // Calcular a duração
          $duracaoMinutos = floor($trackData['duration_ms'] / 60000);
          $restoMilissegundos = $trackData['duration_ms'] % 60000;
          $tempoEmSegundos = floor($restoMilissegundos / 1000);
          if (strlen($tempoEmSegundos) == 1) {
            $tempoEmSegundos = $tempoEmSegundos . "0";
          }
          $duracao = $duracaoMinutos . ':' . $tempoEmSegundos;
          // echo '<p>Duração: ' . $duracao . '</p>';
          // echo '</div>';
      

          echo '<div class="mt-5">';
          echo '<h2 class="text-center text-white">Editar Informações da Música</h2>';
          echo '<form method="POST">';
          echo '<div class="form-group">';
          echo '<label for="titulo">Título</label>';
          echo '<input type="text" class="form-control" id="titulo" name="titulo" value="' . $trackData['name'] . '" required>';
          echo '</div>';
          echo '<div class="form-group">';
          echo '<label for="duracao">Duração</label>';
          echo '<input type="text" class="form-control" id="duracao" name="duracao" value="' . $duracao . '" required>';
          echo '</div>';
          echo '<div class="form-group">';
          echo '<label for="ano">Ano</label>';
          echo '<input type="number" class="form-control" id="ano" name="ano" value="' . $anoLancamento . '">';
          echo '</div>';
          echo '<div class="form-group">';
          echo '<label for="album_id">Álbum</label>';
          echo '<select class="form-control" id="album_id" name="album_id">';
          
          $albumName = $trackData['album']['name'];
          $albumEncontrado = false;
          $artistaNome = $trackData['artists'][0]['name']; // Obtenha o nome do primeiro artista
      
          foreach (Album::listarAlbuns() as $album) {
            $id = $album["id"];
            $titulo = $album["titulo"];

            if ($albumName == $titulo) {
              $selected = 'selected';
              $albumEncontrado = true;
            }

            echo "<option value='$id' $selected>$titulo</option>";
          }
          // esse codigo verifica se o artista esta cadastrado no nosso banco de dados, se estiver ele cria automaticamente o album correspondente a musica que adicionamos
          if (!$albumEncontrado) {
            $artistaInfo = Artista::getArtistaPorNome($artistaNome);

            if ($artistaInfo !== null) {
              if ($trackData['album']['release_date'] == '0000-00-00') {
                $albumId = Album::addAlbum($albumName, null, $artistaInfo['id']);
              } else {
                $albumId = Album::addAlbum($albumName, $trackData['album']['release_date'], $artistaInfo['id']);
              }
              if ($albumId) {
                echo "<option value='$albumId' selected>$albumName</option>";
              } else {
                echo "<option value='' selected>Erro ao adicionar o álbum</option>";
              }
            } else {
              echo "<option value='' selected>Selecione um álbum</option>";
            }
          }
        } else {
          echo "<script>
            Toastify({
                text: 'Link inválido...',
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

        echo '</select>';
        echo '</div>';
        echo '<button type="submit" class="btn btn-primary" name="cadastrar">Cadastrar</button>';
        echo '</form>';
        echo '</div>';
      }
      ?>
    </div>
    </main>
    <?php
    require_once("./model/Musica.php");
    require_once("./config/utils.php");

    if (isset($_POST['cadastrar']) && isMetodo("POST")) {
      if (parametrosValidos($_POST, ["titulo", "duracao", "album_id"])) {
        $titulo = $_POST["titulo"];
        $duracao = $_POST["duracao"];

        if (isset($_POST["ano"]) && !empty($_POST["ano"])) {
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
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>

  </html>

  <?php
  function extractTrackId($spotifyLink)
  {
    $matches = [];
    if (preg_match('/track\/([a-zA-Z0-9]+)/', $spotifyLink, $matches)) {
      return $matches[1];
    } else {
      return null;
    }
  }

  function getAccessToken()
  {
    require_once('./config/config.php');

    $base64Credentials = base64_encode($clientId . ':' . $clientSecret);

    $postData = http_build_query([
      'grant_type' => 'client_credentials'
    ]);

    $context = stream_context_create([
      'http' => [
        'method' => 'POST',
        'header' => [
          'Authorization: Basic ' . $base64Credentials,
          'Content-Type: application/x-www-form-urlencoded'
        ],
        'content' => $postData
      ]
    ]);

    $response = file_get_contents('https://accounts.spotify.com/api/token', false, $context);

    if ($response) {
      $responseData = json_decode($response, true);
      return $responseData['access_token'];
    } else {
      throw new Exception('Failed to fetch access token from Spotify API');
    }
  }

  function getTrackInfo($trackId, $accessToken)
  {
    $url = "https://api.spotify.com/v1/tracks/{$trackId}";
    $headers = [
      'Authorization: Bearer ' . $accessToken
    ];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    curl_close($curl);

    if ($response) {
      $responseData = json_decode($response, true);
      return $responseData;
    } else {
      throw new Exception('Failed to fetch track data from Spotify API');
    }
  }
  ?>