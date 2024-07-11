<?php
class CentroCusto {
    private $conn;
    private $table_name = "centrocusto";

    public $id;
    public $idUsuario;
    public $nome;
    public $ativo;
    public $dtCadastro;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read($search = "") {
        $query = "SELECT * FROM " . $this->table_name;
        if ($search) {
            $query .= " WHERE nome LIKE :search";
        }
        $stmt = $this->conn->prepare($query);

        if ($search) {
            $search = "%{$search}%";
            $stmt->bindParam(":search", $search);
        }

        $stmt->execute();
        return $stmt;
    }

    public function getAll() {
        $query = "SELECT id, nome FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (idUsuario, nome, ativo, dtCadastro) VALUES (:idUsuario, :nome, :ativo, :dtCadastro)";
        $stmt = $this->conn->prepare($query);

        $this->idUsuario = htmlspecialchars(strip_tags($this->idUsuario));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->ativo = htmlspecialchars(strip_tags($this->ativo));
        $this->dtCadastro = htmlspecialchars(strip_tags($this->dtCadastro));

        $stmt->bindParam(":idUsuario", $this->idUsuario);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":ativo", $this->ativo);
        $stmt->bindParam(":dtCadastro", $this->dtCadastro);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nome = :nome WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nome = htmlspecialchars(strip_tags($this->nome));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nome", $this->nome);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getSingle() {
        $query = "SELECT nome FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->nome = $row['nome'];
        } else {
            $this->nome = null;
        }
    }
}
?>
