<?php
include_once '../config/config.php';
include_once '../models/LancamentoDespesa.php';
include_once '../models/Despesa.php';
include_once '../models/Usuario.php';
include_once '../models/CentroCusto.php';

define("ID_NULL", "");

$database = new Database();
$db = $database->getConnection();
$lancamentoDespesa = new LancamentoDespesa($db);
$centroCusto = new CentroCusto($db);
$despesa = new Despesa($db);
$usuario = new Usuario($db);

$action = isset($_POST['action']) ? $_POST['action'] : '';
$search = isset($_POST['search']) ? $_POST['search'] : '';

$links = Array(
    "submitDelete" => 'index.php?menu=lancamentos',
    "submitSearch" => 'index.php?menu=lancamentos',
    "submitCreate" => 'index.php?menu=lancamentos',
    "editScreen" => 'index.php?menu=lancamentos&id='
);

switch ($action) {
    case 'create':
        $lancamentoDespesa->idDespesa = $_POST['idDespesa'];
        $lancamentoDespesa->idUsuario = 1;
        $lancamentoDespesa->parcela = $_POST['parcela'];
        $lancamentoDespesa->dtCadastro = date('Y-m-d H:i:s');
        $lancamentoDespesa->dtVencimento = $_POST['dtVencimento'];
        $lancamentoDespesa->valor = $_POST['valor'];
        $lancamentoDespesa->dtPagamento = $_POST['dtPagamento'];
        $lancamentoDespesa->valorPago = $_POST['valorPago'];
        $lancamentoDespesa->observacoes = $_POST['observacoes'];
        $lancamentoDespesa->ativo = 'S';

        if ($lancamentoDespesa->create()) {
            echo '<div class="p-1 mb-2 bg-secondary text-white fixed-bottom">Lançamento salvo com sucesso!</div>';
            include_once 'endScreen.php';
        } else {
            throw new Exception("Erro ao criar o lançamento de despesa.");
        }
        break;

    case 'update':
        $lancamentoDespesa->id = $_POST['id'];
        $lancamentoDespesa->idDespesa = $_POST['idDespesa'];
        $lancamentoDespesa->idUsuario = 1;
        $lancamentoDespesa->parcela = $_POST['parcela'];
        $lancamentoDespesa->dtVencimento = $_POST['dtVencimento'];
        $lancamentoDespesa->valor = $_POST['valor'];
        $lancamentoDespesa->dtPagamento = $_POST['dtPagamento'];
        $lancamentoDespesa->valorPago = $_POST['valorPago'];
        $lancamentoDespesa->observacoes = $_POST['observacoes'];

        if ($lancamentoDespesa->update()) {
            header("Location: ../templates/index.php?menu=lancamentos");
        } else {
            echo '<div class="p-1 mb-2 bg-danger text-white fixed-bottom">Erro ao atualizar o lançamento de despesa.!</div>';
        }
        break;

    case 'delete':
        $lancamentoDespesa->id = $_POST['id'];

        if ($lancamentoDespesa->delete()) {
            echo '<div class="p-1 mb-2 bg-secondary text-white fixed-bottom">Registro deletado com sucesso!</div>';
            include_once 'endScreen.php';
        } else {
            echo '<div class="p-1 mb-2 bg-danger text-white fixed-bottom">Erro ao deletar o lançamento de despesa.!</div>';
        }
        break;

    default:
        include_once 'endScreen.php';
}
?>

