<?php
class Usuario {
    private $conn;
    private $table_name = "usuario";

    public $id;
    public $idEmpresa;
    public $idPerfil;
    public $nome;
    public $email;
    public $ativo;
    public $dtCadastro;

    public function __construct($db) {
        $this->conn = $db;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " (idEmpresa, idPerfil, nome, email, ativo, dtCadastro) VALUES (:idEmpresa, :idPerfil, :nome, :email, :ativo, :dtCadastro)";
        $stmt = $this->conn->prepare($query);

        $this->idEmpresa = htmlspecialchars(strip_tags($this->idEmpresa));
        $this->idPerfil = htmlspecialchars(strip_tags($this->idPerfil));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->ativo = htmlspecialchars(strip_tags($this->ativo));
        $this->dtCadastro = htmlspecialchars(strip_tags($this->dtCadastro));

        $stmt->bindParam(":idEmpresa", $this->idEmpresa);
        $stmt->bindParam(":idPerfil", $this->idPerfil);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":ativo", $this->ativo);
        $stmt->bindParam(":dtCadastro", $this->dtCadastro);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function read($search = "") {
        $query = "SELECT u.id, u.nome, u.email, u.idEmpresa, e.nome as empresaNome, u.idPerfil, p.nome as perfilNome
                  FROM " . $this->table_name . " u
                  LEFT JOIN empresa e ON u.idEmpresa = e.id
                  LEFT JOIN perfil p ON u.idPerfil = p.id";

        if ($search) {
            $query .= " WHERE u.nome LIKE :search OR u.email LIKE :search OR e.nome LIKE :search OR p.nome LIKE :search";
        }

        $stmt = $this->conn->prepare($query);

        if ($search) {
            $search = "%{$search}%";
            $stmt->bindParam(":search", $search);
        }

        $stmt->execute();
        return $stmt;
    }

    function update() {
        $query = "UPDATE " . $this->table_name . " SET idEmpresa = :idEmpresa, idPerfil = :idPerfil, nome = :nome, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->idEmpresa = htmlspecialchars(strip_tags($this->idEmpresa));
        $this->idPerfil = htmlspecialchars(strip_tags($this->idPerfil));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":idEmpresa", $this->idEmpresa);
        $stmt->bindParam(":idPerfil", $this->idPerfil);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}