<?php

include_once '../config/config.php';
include_once '../models/Despesa.php';

class LancamentoDespesaController{
  private $db;
  private $despesa;

  public function __construct() {
    $database = new Database();
    $this->db = $database->getConnection();
    $this->despesa = new Despesa($this->db);

}

  public function getDespesasByCentroCustoId($centroCustoId){
    
    $stmt = $this->despesa->getDespesasByCentroCusto($centroCustoId);
    $centrosDeCusto = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($centrosDeCusto);
  }

}


// precisamos conversar sobre isso aqui Gabriel ~jsflores
if(isset($_GET['centroCustoId'])){
  $lancamentoDespesaController = new LancamentoDespesaController();
  $lancamentoDespesaController->getDespesasByCentroCustoId($_GET['centroCustoId']);
}


?>