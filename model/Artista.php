<?php

require_once(__DIR__ . "/../config/Conexao.php");

class Artista
{
    public static function addArt($nome, $data_nascimento, $nacionalidade)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("INSERT INTO Artista(nome, data_nascimento, nacionalidade) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $data_nascimento, $nacionalidade]);

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function getArtistaPorNome($nome)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM Artista WHERE nome = ?");
            $stmt->execute([$nome]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function deletarArt($id)
    {
        try {
            $conexao = Conexao::getConexao();

            $stmt = $conexao->prepare("SELECT COUNT(*) FROM Album WHERE artista_id = ?");
            $stmt->execute([$id]);
            $numAlbuns = $stmt->fetchColumn();

            if ($numAlbuns > 0) {
                return true;
            } else {
                $stmt = $conexao->prepare("DELETE FROM Artista WHERE id = ?");
                $stmt->execute([$id]);

                if ($stmt->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function atualizarArt($id, $nome, $data_nascimento, $nacionalidade)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("UPDATE Artista SET nome = ?, data_nascimento = ?, nacionalidade = ? WHERE id = ?");
            $stmt->execute([$nome, $data_nascimento, $nacionalidade, $id]);

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function listarArt()
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM Artista ORDER BY id");
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function deletaridAlbum($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM Musica WHERE album_id = ?");
            $stmt->execute([$id]);

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function existeArt($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM Artista WHERE id = ?");
            $stmt->execute([$id]);

            if ($stmt->fetchColumn() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function getArtPorId($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM Artista WHERE id = ?");
            $stmt->execute([$id]);

            return $stmt->fetchAll()[0];
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

}

?>