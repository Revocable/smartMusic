<?php

require_once(__DIR__ . "/../config/Conexao.php");

class Album
{
    public static function addAlbum($titulo, $data_lancamento, $artista_id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("INSERT INTO Album(titulo, data_lancamento, artista_id) VALUES (?, ?, ?)");
            $stmt->execute([$titulo, $data_lancamento, $artista_id]);

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

    public static function deletarAlbum($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM Album WHERE id = ?");
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

    public static function atualizarAlbum($id, $titulo, $data_lancamento, $artista_id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("UPDATE Album SET titulo = ?, data_lancamento = ?, artista_id = ? WHERE id = ?");
            $stmt->execute([$titulo, $data_lancamento, $artista_id, $id]);

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

    public static function listarAlbuns()
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM Album ORDER BY id");
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function existeAlbum($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM Album WHERE id = ?");
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

    public static function getAlbumPorId($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM Album WHERE id = ?");
            $stmt->execute([$id]);

            return $stmt->fetchAll()[0];
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function listarAlbunsDoArtista($artista_id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM Album WHERE artista_id = ?");
            $stmt->execute([$artista_id]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    public static function deletarAlbunsDoArtista($artista_id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM Album WHERE artista_id = ?");
            $stmt->execute([$artista_id]);

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
}

?>