<?php
class LancamentoDespesa {
    private $conn;
    private $table_name = "lancamentodespesa";

    public $id;
    public $idDespesa;
    public $idUsuario;
    public $parcela;
    public $dtCadastro;
    public $dtVencimento;
    public $valor;
    public $dtPagamento;
    public $valorPago;
    public $observacoes;
    public $ativo;

    public function __construct($db) {
        $this->conn = $db;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " (idDespesa, idUsuario, parcela, dtCadastro, dtVencimento, valor, dtPagamento, valorPago, observacoes, ativo) VALUES (:idDespesa, :idUsuario, :parcela, :dtCadastro, :dtVencimento, :valor, :dtPagamento, :valorPago, :observacoes, :ativo)";
        $stmt = $this->conn->prepare($query);

        $this->idDespesa = htmlspecialchars(strip_tags($this->idDespesa));
        $this->idUsuario = htmlspecialchars(strip_tags($this->idUsuario));
        $this->parcela = htmlspecialchars(strip_tags($this->parcela));
        $this->dtCadastro = htmlspecialchars(strip_tags($this->dtCadastro));
        $this->dtVencimento = htmlspecialchars(strip_tags($this->dtVencimento));
        $this->valor = htmlspecialchars(strip_tags($this->valor));
        $this->dtPagamento = htmlspecialchars(strip_tags($this->dtPagamento));
        $this->valorPago = htmlspecialchars(strip_tags($this->valorPago));
        $this->observacoes = htmlspecialchars(strip_tags($this->observacoes));
        $this->ativo = htmlspecialchars(strip_tags($this->ativo));

        $stmt->bindParam(":idDespesa", $this->idDespesa);
        $stmt->bindParam(":idUsuario", $this->idUsuario);
        $stmt->bindParam(":parcela", $this->parcela);
        $stmt->bindParam(":dtCadastro", $this->dtCadastro);
        $stmt->bindParam(":dtVencimento", $this->dtVencimento);
        $stmt->bindParam(":valor", $this->valor);
        $stmt->bindParam(":dtPagamento", $this->dtPagamento);
        $stmt->bindParam(":valorPago", $this->valorPago);
        $stmt->bindParam(":observacoes", $this->observacoes);
        $stmt->bindParam(":ativo", $this->ativo);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function read($filtros = []) {
        $query = "SELECT ld.id, ld.idDespesa, ld.idUsuario, ld.parcela, ld.dtVencimento, ld.valor, ld.dtPagamento, ld.valorPago, left(ld.observacoes,20) as observacoes, d.nome as despesaNome, u.nome as usuarioNome, cc.nome as centroCustoNome 
                  FROM " . $this->table_name . " ld 
                  LEFT JOIN despesa d ON ld.idDespesa = d.id
                  LEFT JOIN usuario u ON ld.idUsuario = u.id
                  LEFT JOIN centrocusto cc ON d.idCentroCusto = cc.id WHERE ld.ativo='S'";
        
        if ($filtros['search']) {
            $query .= " AND (d.nome LIKE :search OR ld.observacoes LIKE :search) ";
        }

        if($filtros['dtVencimentoInicio']){
            $query .= " AND  ld.dtVencimento >= :dtVencimentoInicio";
        }

        if($filtros['dtVencimentoFim']){
            $query .= " AND  ld.dtVencimento <= :dtVencimentoFim";
        }
        
        if($filtros['dtPagamentoInicio']){
            $query .= " AND  ld.dtPagamento >= :dtPagamentoInicio";
        }

        if($filtros['dtPagamentoFim']){
            $query .= " AND  ld.dtPagamento <= :dtPagamentoFim";
        }

        if($filtros['centroCusto']){
            $query .= " AND  cc.id = :centroCusto";
        }
        
        if($filtros['despesa']){
            $query .= " AND  d.id = :despesa";
        }

        if($filtros['isPago']){
            $query .= " AND  (ld.dtPagamento <> '0000-00-00')";
        }

        $query .= " ORDER BY dtVencimento ASC";

        $stmt = $this->conn->prepare($query);

        $filtros['search'] = ($filtros['search'] ? "%{$filtros['search']}%" : "");
        $filtros['search'] ? $stmt->bindParam(":search", $filtros['search']) : ""; 
        $filtros['dtVencimentoInicio'] ? $stmt->bindParam(":dtVencimentoInicio", $filtros['dtVencimentoInicio']) : "";
        $filtros['dtVencimentoFim'] ? $stmt->bindParam(":dtVencimentoFim", $filtros['dtVencimentoFim']) : "";
        $filtros['dtPagamentoInicio'] ? $stmt->bindParam(":dtPagamentoInicio", $filtros['dtPagamentoInicio']) : "";
        $filtros['dtPagamentoFim'] ? $stmt->bindParam(":dtPagamentoFim", $filtros['dtPagamentoFim']) : "";
        $filtros['centroCusto'] ? $stmt->bindParam(":centroCusto", $filtros['centroCusto']) : "";
        $filtros['despesa'] ? $stmt->bindParam(":despesa", $filtros['despesa']) : "";

        $stmt->execute();
        return $stmt;
    }

    function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET idDespesa = :idDespesa, idUsuario = :idUsuario, parcela = :parcela, dtVencimento = :dtVencimento, valor = :valor, dtPagamento = :dtPagamento, valorPago = :valorPago, observacoes = :observacoes 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->idDespesa = htmlspecialchars(strip_tags($this->idDespesa));
        $this->idUsuario = htmlspecialchars(strip_tags($this->idUsuario));
        $this->parcela = htmlspecialchars(strip_tags($this->parcela));
        $this->dtVencimento = htmlspecialchars(strip_tags($this->dtVencimento));
        $this->valor = htmlspecialchars(strip_tags($this->valor));
        $this->dtPagamento = htmlspecialchars(strip_tags($this->dtPagamento));
        $this->valorPago = htmlspecialchars(strip_tags($this->valorPago));
        $this->observacoes = htmlspecialchars(strip_tags($this->observacoes));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":idDespesa", $this->idDespesa);
        $stmt->bindParam(":idUsuario", $this->idUsuario);
        $stmt->bindParam(":parcela", $this->parcela);
        $stmt->bindParam(":dtVencimento", $this->dtVencimento);
        $stmt->bindParam(":valor", $this->valor);
        $stmt->bindParam(":dtPagamento", $this->dtPagamento);
        $stmt->bindParam(":valorPago", $this->valorPago);
        $stmt->bindParam(":observacoes", $this->observacoes);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function delete() {
        $query = "UPDATE " . $this->table_name . " SET ativo = 'N' WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function getAll() {
        $query = "SELECT id, parcela FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getById($LancamentoDespesaId) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $LancamentoDespesaId);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {

            $this->id = $row['id'];
            $this->idDespesa = $row['idDespesa'];
            $this->idUsuario = $row['idUsuario'];
            $this->parcela = $row['parcela'];
            $this->dtCadastro = $row['dtCadastro'];
            $this->dtVencimento = $row['dtVencimento'];
            $this->valor = $row['valor'];
            $this->dtPagamento = $row['dtPagamento'];
            $this->valorPago = $row['valorPago'];
            $this->observacoes = $row['observacoes'];
            $this->ativo = $row['ativo'];
            return true;
        }else{
            //return the databaseError
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
    
}
?>
