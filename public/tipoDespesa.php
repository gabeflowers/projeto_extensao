<?php
include_once '../config/config.php';
include_once '../models/Despesa.php';
include_once '../models/CentroCusto.php';

$database = new Database();
$db = $database->getConnection();

$despesa = new Despesa($db);
$centroCusto = new CentroCusto($db);

$action = isset($_POST['action']) ? $_POST['action'] : '';
$search = isset($_POST['search']) ? $_POST['search'] : '';

switch ($action) {
    case 'create':
        $despesa->idCentroCusto = $_POST['idCentroCusto'];
        $despesa->idUsuario = 1;
        $despesa->nome = $_POST['nome'];
        $despesa->ativo = 'S';
        $despesa->dtCadastro = date('Y-m-d H:i:s');

        if ($despesa->create()) {
            header("Location: ../templates/index.php?menu=tipo");
        } else {
            echo "Erro ao criar o tipo de despesa.";
        }
        break;

    case 'update':
        $despesa->id = $_POST['id'];
        $despesa->idCentroCusto = $_POST['idCentroCusto'];
        $despesa->nome = $_POST['nome'];

        if ($despesa->update()) {
            header("Location: ../templates/index.php?menu=tipo");
        } else {
            echo "Erro ao atualizar o tipo de despesa.";
        }
        break;

    case 'delete':
        $despesa->id = $_POST['id'];

        if ($despesa->delete()) {
            header("Location: ../templates/index.php?menu=tipo");
        } else {
            echo "Erro ao deletar o tipo de despesa.";
        }
        break;

    default:
        // Render the list of despesas
        echo '<div class="content">
                <h3>Despesas / Tipo de Despesa</h3>
                <hr>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-success" data-toggle="modal" data-target="#createModal">Cadastrar</button>
                </div>
                <div class="mt-2 p-2 rounded text-dark" style="background-color: #F6F6F6;">
                    <h3>Filtrar</h3>
                </div>
                <form method="post" action="../templates/index.php?menu=tipo">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Nome: </span>
                        <input type="text" class="form-control" name="search" value="' . htmlspecialchars($search) . '" placeholder="Nome" aria-label="Nome" aria-describedby="basic-addon1">
                    </div>
                    <button class="btn btn-danger" type="button" id="resetButton">Limpar</button>
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
                <div class="mt-2 p-2 text-dark" style="background-color: #F6F6F6;">
                    <h3>Tipos de Despesa (Total: X)</h3>
                </div>
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th class="col-sm-10 p-3" scope="col">Nome</th>
                            <th class="col-sm-10 p-3" scope="col">Centro de Custo</th>
                            <th class="p-3 col-auto text-center" colspan="2" scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>';

                    $stmt = $despesa->read($search);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr><td>" . htmlspecialchars($row["nome"]) . "</td><td>" . htmlspecialchars($row["centroCustoNome"]) . "</td><td>
                        <a href='#' class='edit btn btn-warning btn-sm' data-id=' data-id='" . $row["id"] . "' data-name='" . htmlspecialchars($row["nome"]) . "' >
                        <i class='bi bi-0-circle'></i>
                        </a> 
                        <a href='#' class='delete btn btn-danger btn-sm' data-id='" . $row["id"] . "'>
                            <i class='fa fa-trash'></i>
                        </a></td></tr>";
                    }

        echo '      </tbody>
                </table>
              </div>';
        break;
}
?>

<!-- Modal for Create -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastrar Tipo de Despesa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="../public/tipoDespesa.php">
                    <input type="hidden" name="action" value="create">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Nome: </span>
                        <input type="text" class="form-control" name="nome" placeholder="nome" aria-label="Nome" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Centro de Custo: </span>
                        <select class="form-control" name="idCentroCusto">
                            <option value="">Selecione...</option>';
                            <?php
                            $stmt = $centroCusto->getAll();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["nome"]) . '</option>';
                            }
                            ?>
                        </select>
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
                <h5 class="modal-title" id="exampleModalLabel">Editar Tipo de Despesa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="../public/tipoDespesa.php">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Nome: </span>
                        <input type="text" class="form-control" name="nome" id="edit-name" placeholder="Nome" aria-label="Nome" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Centro de Custo: </span>
                        <select class="form-control" name="idCentroCusto" id="edit-idCentroCusto">
                            <option value="">Selecione...</option>';
                            <?php
                            $stmt = $centroCusto->getAll();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["nome"]) . '</option>';
                            }
                            ?>
                            
                        </select>
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
<form method="post" action="../public/tipoDespesa.php" id="delete-form" style="display:none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="id" id="delete-id">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.edit').forEach(function(button) {
            button.addEventListener('click', function() {
                document.getElementById('edit-id').value = this.dataset.id;
                document.getElementById('edit-name').value = this.dataset.name;

                // Selecionar o valor do Centro de Custo no dropdown
                const centroCustoId = this.dataset.idCentroCusto;
                const selectCentroCusto = document.getElementById('edit-idCentroCusto');
                for (let i = 0; i < selectCentroCusto.options.length; i++) {
                    if (selectCentroCusto.options[i].value == centroCustoId) {
                        selectCentroCusto.options[i].selected = true;
                        break;
                    }
                }

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
            document.querySelector('input[name="search"]').value = '';
            window.location.href = 'despesa.php';
        });
    });
</script>
