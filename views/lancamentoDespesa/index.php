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

$filtros = Array(
    'search' => isset($_POST['search']) ? $_POST['search'] : '',
    'dtVencimentoInicio' =>  isset($_POST['filtro_dtVencimentoInicio']) ? $_POST['filtro_dtVencimentoInicio'] : '',
    'dtVencimentoFim' =>  isset($_POST['filtro_dtVencimentoFim']) ? $_POST['filtro_dtVencimentoFim'] : '',
    'centroCusto' =>  isset($_POST['filtro_centroCusto']) ? $_POST['filtro_centroCusto'] : '',
    'despesa' =>  isset($_POST['filtro_despesa']) ? $_POST['filtro_despesa'] : '',
    'dtPagamento' =>  isset($_POST['filtro_dtPagamento']) ? $_POST['filtro_dtPagamento'] : '',
    'isPago' =>  isset($_POST['filtro_isPago']) ? $_POST['filtro_isPago'] : '',
);

$links = Array(
    "screenLancamentos" => 'index.php?menu=lancamentos',
    "screenEditLancamento" => 'index.php?menu=lancamentos&id='
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
        $lancamentoDespesa->id = $_POST['lancamentoDespesaId'];
        $lancamentoDespesa->idDespesa = $_POST['idDespesa'];
        $lancamentoDespesa->idUsuario = 1;
        $lancamentoDespesa->parcela = $_POST['parcela'];
        $lancamentoDespesa->dtVencimento = $_POST['dtVencimento'];
        $lancamentoDespesa->valor = $_POST['valor'];
        $lancamentoDespesa->dtPagamento = $_POST['dtPagamento'];
        $lancamentoDespesa->valorPago = $_POST['valorPago'];
        $lancamentoDespesa->observacoes = $_POST['observacoes'];

        if ($lancamentoDespesa->update()) {
            echo '<div class="p-1 mb-2 bg-secondary text-white fixed-bottom">Lançamento Atualizado com sucesso!</div>';
            include_once 'endScreen.php';
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

