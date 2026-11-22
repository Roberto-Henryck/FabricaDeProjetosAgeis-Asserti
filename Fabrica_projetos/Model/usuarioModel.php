<?php
require_once '../config.php';

class Usuario {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getConexao();
    }

   
    public function cadastrar($nome, $email, $senha, $telefone) {
        if ($this->buscarPorEmail($email)) {
            return false;
        }

        $sql = "INSERT INTO usuarios (nome, email, senha, telefone) VALUES (:nome, :email, :senha, :telefone)";
        $stmt = $this->pdo->prepare($sql);

       
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senhaHash);
        $stmt->bindValue(':telefone', $telefone);

        return $stmt->execute();
    }

    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetch();
    }

    // 1. Gera e salva o token se o e-mail existir
    public function salvarTokenRecuperacao($email, $token, $expiracao) {
        $usuario = $this->buscarPorEmail($email);
        if (!$usuario) {
            return false;
        }

        $sql = "UPDATE usuarios SET token_recuperacao = :token, token_expira = :expira WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':token', $token);
        $stmt->bindValue(':expira', $expiracao);
        $stmt->bindValue(':email', $email);

        return $stmt->execute();
    }

    // 2. Busca o usuário pelo token (apenas se ainda estiver dentro do prazo)
    public function buscarPorToken($token) {
        $sql = "SELECT * FROM usuarios WHERE token_recuperacao = :token AND token_expira > NOW() LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':token', $token);
        $stmt->execute();

        return $stmt->fetch();
    }

    // 3. Atualiza a senha com hash e limpa o token para não ser usado de novo
    public function atualizarSenha($id, $novaSenha) {
        $sql = "UPDATE usuarios SET senha = :senha, token_recuperacao = NULL, token_expira = NULL WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        $stmt->bindValue(':senha', $senhaHash);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }
}