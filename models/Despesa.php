<?php
class Despesa {
    private $conn;
    private $table_name = "despesa";

    public $id;
    public $idCentroCusto;
    public $idUsuario;
    public $nome;
    public $ativo;
    public $dtCadastro;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read($search = "") {
        $query = "SELECT d.id, d.nome, d.idCentroCusto, c.nome AS centroCustoNome 
                  FROM " . $this->table_name . " d 
                  JOIN centrocusto c ON d.idCentroCusto = c.id WHERE d.ativo='S'";
        
        if ($search) {
            $query .= " AND d.nome LIKE :search";
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
        $query = "SELECT id, nome FROM " . $this->table_name . " WHERE ativo = 'S'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (idCentroCusto, idUsuario, nome, ativo, dtCadastro) VALUES (:idCentroCusto, :idUsuario, :nome, :ativo, :dtCadastro)";
        $stmt = $this->conn->prepare($query);

        $this->idCentroCusto = htmlspecialchars(strip_tags($this->idCentroCusto));
        $this->idUsuario = htmlspecialchars(strip_tags($this->idUsuario));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->ativo = htmlspecialchars(strip_tags($this->ativo));
        $this->dtCadastro = htmlspecialchars(strip_tags($this->dtCadastro));

        $stmt->bindParam(":idCentroCusto", $this->idCentroCusto);
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
        $query = "UPDATE " . $this->table_name . " SET idCentroCusto = :idCentroCusto, nome = :nome WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->idCentroCusto = htmlspecialchars(strip_tags($this->idCentroCusto));
        $this->nome = htmlspecialchars(strip_tags($this->nome));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":idCentroCusto", $this->idCentroCusto);
        $stmt->bindParam(":nome", $this->nome);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "UPDATE " . $this->table_name . " SET ativo = 'N' WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getSingle() {
        $query = "SELECT idCentroCusto, nome FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->idCentroCusto = $row['idCentroCusto'];
            $this->nome = $row['nome'];
        } else {
            $this->idCentroCusto = null;
            $this->nome = null;
        }
    }

    public function getCentroCustoByDespesaId($despesaId) {
        $query = "SELECT idCentroCusto FROM " . $this->table_name . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $despesaId);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $row['idCentroCusto'];
        } else {
            return false;
        }
    }

    public function count() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE ativo = 'S'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
    
    public function getDespesasByCentroCusto($centroCustoId){
        $query = "SELECT id, nome FROM " . $this->table_name . " WHERE ativo = 'S' and idCentroCusto = :idCentroCusto";
        $stmt = $this->conn->prepare($query);
        
        $centroCustoId = htmlspecialchars(strip_tags($centroCustoId));
        $stmt->bindParam(":idCentroCusto", $centroCustoId);

        $stmt->execute();
        return $stmt;
    }
}
?>
