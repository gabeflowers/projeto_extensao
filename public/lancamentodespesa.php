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
            header("Location: ../templates/index.php?menu=lancamentos");
        } else {
            echo "Erro ao criar o lançamento de despesa.";
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
            echo "Erro ao atualizar o lançamento de despesa.";
        }
        break;

    case 'delete':
        $lancamentoDespesa->id = $_POST['id'];

        if ($lancamentoDespesa->delete()) {
            header("Location: ../templates/index.php?menu=lancamentos");
        } else {
            echo "Erro ao deletar o lançamento de despesa.";
        }
        break;

    default:
        // Lista os lançamentos de despesas
        echo '<div>
                <h3>Lançamentos de Despesas</h3>
                <hr>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-success" data-toggle="modal" data-target="#createModal">Cadastrar</button>
                </div>
                <div class="mt-2 p-2 rounded text-dark" style="background-color: #F6F6F6;">
                    <h3>Filtrar</h3>
                </div>
                <form method="post" action="../templates/index.php?menu=lancamentodespesa">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basicaddon1">Nome: </span>
                        <input type="text" class="form-control" name="search" value="' . htmlspecialchars($search) . '" placeholder="Nome" aria-label="Nome" aria-describedby="basic-addon1">
                    </div>
                    <button class="btn btn-danger" type="button" id="resetButton">Limpar</button>
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
                <div class="mt-2 p-2 text-dark" style="background-color: #F6F6F6;">
                    <h3>Lançamentos (Total: X)</h3>
                </div>
        <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th  scope="col">Vencimento</th>
                <th  scope="col">Origem</th>
                <th  scope="col">Despesa</th>
                <th  scope="col">Observações</th>
                <th  scope="col">Valor</th>
                <th  scope="col">Valor Pago</th>
                <th class="p-3  text-center" scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>';
        $stmt = $lancamentoDespesa->read($search);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dtVencimento = DateTime::createFromFormat('Y-m-d', $row["dtVencimento"]);
            $formattedDate = $dtVencimento ? $dtVencimento->format('d/m/Y') : $row["dtVencimento"];

            echo "<tr>
                    <td>" . htmlspecialchars($formattedDate) . "</td>
                    <td>" . htmlspecialchars($row["centroCustoNome"]) . "</td>
                    <td>" . htmlspecialchars($row["despesaNome"]) . "</td>
                    <td>" . htmlspecialchars($row["observacoes"]) . "</td>
                    <td>" . htmlspecialchars($row["valor"]) . "</td>
                    <td>" . htmlspecialchars($row["valorPago"]) . "</td>
                    <td class='d-flex justify-content-center'>
                        <a href='#' class='edit btn btn-warning btn-sm' data-id='" . $row["id"] . "'>
                            <i class='fas fa-pencil-alt'> 
                            </i>
                        </a>
                        <a href='#' class='delete btn btn-danger btn-sm ml-2' data-id='" . $row["id"] . "'>
                            <i class='fa fa-trash'></i>
                        </a>
                    </td>
                </tr>";
        }

    echo '      </tbody>
        </table>
              </div>';
        break;
}
?>

<!-- Modal for Create -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document">


        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastrar Lançamento de Despesa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="../public/lancamentodespesa.php">
                    <input type="hidden" name="action" value="create">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Centro de Custo: </span>
                        <select name="idCentroCusto" class="form-control" id="selectCentroCustoId">
                            <option value='<?php echo ID_NULL ?>'>Selecione...</option>
                            <?php
                            $stmt = $centroCusto->getAll();
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                echo '<option value="' . htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["nome"]) . '</option>';
                            }

                            ?>
                        </select>
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Despesa: </span>
                        <select class="form-control" name="idDespesa" id="selectDespesaId">
                            <option value="">Selecione...</option>
                            <?php
                            $stmt = $despesa->getAll();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["nome"]) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Usuário: </span>
                        <select class="form-control" name="idUsuario">
                            <option value="">Selecione...</option>
                            
                        </select>
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Parcela: </span>
                        <input type="text" class="form-control" name="parcela" placeholder="Parcela" aria-label="Parcela" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Valor: </span>
                        <input type="text" class="form-control" name="valor" placeholder="Valor" aria-label="Valor" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Vencimento: </span>
                        <input type="date" class="form-control" name="dtVencimento" aria-label="Vencimento" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Pagamento: </span>
                        <input type="date" class="form-control" name="dtPagamento" aria-label="Pagamento" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Valor Pago: </span>
                        <input type="text" class="form-control" name="valorPago" placeholder="Valor Pago" aria-label="Valor Pago" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Observações: </span>
                        <textarea class="form-control" name="observacoes" placeholder="Observações" aria-label="Observações" aria-describedby="basic-addon1"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <input type="submit" name="create" class="btn btn-primary" value="Salvar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Update -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Lançamento de Despesa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="../public/lancamentodespesa.php">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Despesa: </span>
                        <select class="form-control" name="idDespesa" id="edit-idDespesa">
                            <option value="">Selecione...</option>
                            <?php
                            $stmt = $despesa->getAll();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["nome"]) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Centro de Custo: </span>
                        <select class="form-control" name="idDespesa" id="edit-idDespesa">
                            <option value="">Selecione...</option>
                            <?php
                            $stmt = $despesa->getAll();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["nome"]) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Parcela: </span>
                        <input type="text" class="form-control" name="parcela" id="edit-parcela" placeholder="Parcela" aria-label="Parcela" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Valor: </span>
                        <input type="text" class="form-control" name="valor" id="edit-valor" placeholder="Valor" aria-label="Valor" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Vencimento: </span>
                        <input type="date" class="form-control" name="dtVencimento" id="edit-dtVencimento" aria-label="Vencimento" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Pagamento: </span>
                        <input type="date" class="form-control" name="dtPagamento" id="edit-dtPagamento" aria-label="Pagamento" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Valor Pago: </span>
                        <input type="text" class="form-control" name="valorPago" id="edit-valorPago" placeholder="Valor Pago" aria-label="Valor Pago" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Observações: </span>
                        <textarea class="form-control" name="observacoes" id="edit-observacoes" placeholder="Observações" aria-label="Observações" aria-describedby="basic-addon1"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <input type="submit" name="update" class="btn btn-primary" value="Salvar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Form for Delete -->
<form method="post" action="../public/lancamentodespesa.php" id="delete-form" style="display:none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="id" id="delete-id">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.edit').forEach(function(button) {
            button.addEventListener('click', function() {
                document.getElementById('edit-id').value = this.dataset.id;
                document.getElementById('edit-idDespesa').value = this.dataset.idDespesa;
                document.getElementById('edit-idUsuario').value = this.dataset.idUsuario;
                document.getElementById('edit-parcela').value = this.dataset.parcela;
                document.getElementById('edit-valor').value = this.dataset.valor;
                document.getElementById('edit-dtVencimento').value = this.dataset.dtVencimento;
                document.getElementById('edit-dtPagamento').value = this.dataset.dtPagamento;
                document.getElementById('edit-valorPago').value = this.dataset.valorPago;
                document.getElementById('edit-observacoes').value = this.dataset.observacoes;
                $('#updateModal').modal('show');
            });
        });

        document.querySelectorAll('.delete').forEach(function(button) {
            button.addEventListener('click', function() {
                document.getElementById('delete-id').value = this.dataset.id;
                document.getElementById('delete-form').submit();
            });
        });

        document.getElementById('resetButton').addEventListener('click', function() {
            console.log('reset button clicked');
            document.querySelector('input[name="search"]').value = '';
            window.location.href = '../templates/index.php?menu=lancamentodespesa';
        });
    });

    let selectCentroCusto = document.getElementById("selectCentroCustoId");

    //onChangeCentroCusto
    selectCentroCusto.addEventListener('change', async(e) => {
        
        let selectCentroCusto = e.target;
        let centroCustoId = selectCentroCusto.options[selectCentroCusto.selectedIndex].value;
        
        fetch(`../controllers/LancamentoDespesaController.php?centroCustoId=${centroCustoId}`)
            .then(response => response.json())
            .then(data => {
                console.log(data)
            })
        .catch(error => console.error('Erro:', error));
    })

</script>
