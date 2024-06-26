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

    function getAll() {
        $query = "SELECT id, nome FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
