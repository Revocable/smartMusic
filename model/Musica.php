<?php

require_once(__DIR__ . "/../config/Conexao.php");

class Musica
{
    public static function addMusica($titulo, $duracao, $ano, $album_id)
    {
        try {
            $conexao = Conexao::getConexao();
            if ($ano === null) {
                $stmt = $conexao->prepare("INSERT INTO Musica(titulo, duracao, album_id) VALUES (?, ?, ?)");
                $stmt->execute([$titulo, $duracao, $album_id]);
            } else {
                $stmt = $conexao->prepare("INSERT INTO Musica(titulo, duracao, ano, album_id) VALUES (?, ?, ?, ?)");
                $stmt->execute([$titulo, $duracao, $ano, $album_id]);
            }
    
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
    
    public static function getMusicaPorTitulo($titulo)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM Musica WHERE titulo = ?");
            $stmt->execute([$titulo]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
    
    public static function deletarMusica($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM Musica WHERE id = ?");
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

    public static function atualizarMusica($id, $titulo, $duracao, $ano, $album_id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("UPDATE Musica SET titulo = ?, duracao = ?, ano = ?, album_id = ? WHERE id = ?");
            $stmt->execute([$titulo, $duracao, $ano, $album_id, $id]);

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

    public static function listarMusics()
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM Musica ORDER BY id");
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function existeMusica($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM Musica WHERE id = ?");
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

    public static function getMusicaPorId($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM Musica WHERE id = ?");
            $stmt->execute([$id]);

            return $stmt->fetchAll()[0];
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function listarMusicasDoAlbum($album_id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM Musica WHERE album_id = ?");
            $stmt->execute([$album_id]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    public static function deletarMusicasDoAlbum($album_id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM Musica WHERE album_id = ?");
            $stmt->execute([$album_id]);

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