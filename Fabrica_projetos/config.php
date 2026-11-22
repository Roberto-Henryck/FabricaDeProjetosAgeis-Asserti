<?php

class Conexao {
    private static $instancia;

    public static function getConexao() {
        if (!isset(self::$instancia)) {
            $host = 'localhost';
            $dbname = 'asserti_db';
            $usuario = 'root'; 
            $senha = '';       

            try {
                self::$instancia = new PDO(
                    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                    $usuario,
                    $senha
                );
                // Configura o PDO para lançar exceções em caso de erro
                self::$instancia->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instancia->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Erro ao conectar com o banco de dados: " . $e->getMessage());
            }
        }
        return self::$instancia;
    }
}