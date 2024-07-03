<?php
class Empresa {
    private $conn;
    private $table_name = "empresa";

    public $id;
    public $nome;
    public $dtCadastro;

    public function __construct($db) {
        $this->conn = $db;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " (nome, dtCadastro) VALUES (:nome, :dtCadastro)";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->dtCadastro = htmlspecialchars(strip_tags($this->dtCadastro));

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":dtCadastro", $this->dtCadastro);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function read($search = "") {
        $query = "SELECT id, nome FROM " . $this->table_name;
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

    function update() {
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

    function getAll() {
        $query = "SELECT id, nome FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
