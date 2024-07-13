<?php
include_once '../config/config.php';
include_once '../models/CentroCusto.php';

$database = new Database();
$db = $database->getConnection();
$centroCusto = new CentroCusto($db);

$action = isset($_POST['action']) ? $_POST['action'] : '';
$search = isset($_POST['search']) ? $_POST['search'] : '';

$total = $centroCusto->count();

switch ($action) {
    case 'create':
        $centroCusto->idUsuario = 1; // Substitua pelo ID do usuário logado
        $centroCusto->nome = $_POST['nome'];
        $centroCusto->ativo = 'S';
        $centroCusto->dtCadastro = date('Y-m-d H:i:s');

        if ($centroCusto->create()) {
            header("Location: ../templates/index.php?menu=origem");
        } else {
            echo "Erro ao criar o centro de custo.";
        }
        break;

    case 'update':
        $centroCusto->id = $_POST['id'];
        $centroCusto->nome = $_POST['nome'];

        if ($centroCusto->update()) {
            header("Location: ../templates/index.php?menu=origem");
        } else {
            echo "Erro ao atualizar o centro de custo.";
        }
        break;

    case 'delete':
        $centroCusto->id = $_POST['id'];
        $centroCusto->ativo = 'N';

        if ($centroCusto->delete()) {
            header("Location: ../templates/index.php?menu=origem");
        } else {
            echo "Erro ao deletar o centro de custo.";
        }
        break;

    default:
        // Lista os centros de custo
        echo '<div>
                <h3>Despesas / Origem</h3>
                <hr>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-success" data-toggle="modal" data-target="#createModal">Cadastrar</button>
                </div>
                <div class="mt-2 p-2 rounded text-dark" style="background-color: #F6F6F6;">
                    <h3>Filtrar</h3>
                </div>
                <form method="post" action="../templates/index.php?menu=origem">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basicaddon1">Nome: </span>
                        <input type="text" class="form-control" name="search" value="' . htmlspecialchars($search) . '" placeholder="Nome" aria-label="Nome" aria-describedby="basic-addon1">
                    </div>
                    <button class="btn btn-danger" type="button" id="resetButton">Limpar</button>
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
                <div class="mt-2 p-2 text-dark" style="background-color: #F6F6F6;">
                    <h3>Origens (Total: ' . $total . ')</h3>
                </div>
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th class="col-sm-10 p-3" scope="col">Nome</th>
                            <th class="p-3 col-auto text-center" colspan="2" scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>';
            $stmt = $centroCusto->read($search);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>" . htmlspecialchars($row["nome"]) . "</td><td class='d-flex justify-content-center'>
                <a href='#' class='edit btn btn-warning btn-sm' data-id='" . $row["id"] . "' data-name='" . htmlspecialchars($row["nome"]) . "'>
                <i class='fas fa-pencil-alt'> 
                </i>
                </a>
                <a href='#' class='delete btn btn-danger btn-sm ml-2' data-id='" . $row["id"] . "'>
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
                <h5 class="modal-title" id="exampleModalLabel">Cadastrar Centro de Custo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createForm" method="post" action="../public/centrocusto.php">
                    <input type="hidden" name="action" value="create">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Nome: </span>
                        <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" aria-label="Nome" aria-describedby="basic-addon1" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <input type="submit" name="create" class="btn btn-success" value="Salvar">
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
                <h5 class="modal-title" id="exampleModalLabel">Editar Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="../public/centrocusto.php">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Nome: </span>
                        <input type="text" class="form-control" name="nome" id="edit-name" placeholder="Nome" aria-label="Nome" aria-describedby="basic-addon1">
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

<!-- Modal for Confirmar delete -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationLabel">Confirmar Exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Você tem certeza que deseja excluir este item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                <button type="button" class="btn btn-success" id="confirmDeleteButton">Sim</button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Form for Delete -->
<form method="post" action="../public/centrocusto.php" id="delete-form" style="display:none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="id" id="delete-id">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.edit').forEach(function(button) {
            button.addEventListener('click', function() {
                document.getElementById('edit-id').value = this.dataset.id;
                document.getElementById('edit-name').value = this.dataset.name;
                $('#updateModal').modal('show');
            });
        });

        document.querySelectorAll('.delete').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                deleteId = this.dataset.id;
                $('#deleteConfirmationModal').modal('show');
            });
        });

        document.getElementById('resetButton').addEventListener('click', function() {
            console.log('reset button clicked');
            document.querySelector('input[name="search"]').value = '';
            window.location.href = '../templates/index.php?menu=origem';
        });

        document.querySelectorAll('[data-dismiss="modal"]').forEach(function(button) {
            button.addEventListener('click', function() {
                $('#updateModal').modal('hide');
                $('#deleteConfirmationModal').modal('hide');
            });
        });

        document.getElementById('createForm').addEventListener('submit', function(event) {
        var nome = document.getElementById('nome').value;
        if (!nome) {
            event.preventDefault(); // Impede o envio do formulário
            alert('O campo Nome é obrigatório.');
        }
        });

        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            document.getElementById('delete-id').value = deleteId;
            document.getElementById('delete-form').submit();
        });
    });
</script>
