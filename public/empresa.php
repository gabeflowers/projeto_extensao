<?php
include_once '../config/config.php';
include_once '../models/Empresa.php';

$database = new Database();
$db = $database->getConnection();
$empresa = new Empresa($db);

$action = isset($_POST['action']) ? $_POST['action'] : '';
$search = isset($_POST['search']) ? $_POST['search'] : '';

switch ($action) {
    case 'create':
        $empresa->nome = $_POST['nome'];
        $empresa->dtCadastro = date('Y-m-d');

        if ($empresa->create()) {
            header("Location: ../templates/index.php?menu=empresa");
        } else {
            echo "Erro ao criar a empresa.";
        }
        break;

    case 'update':
        $empresa->id = $_POST['id'];
        $empresa->nome = $_POST['nome'];

        if ($empresa->update()) {
            header("Location: ../templates/index.php?menu=empresa");
        } else {
            echo "Erro ao atualizar a empresa.";
        }
        break;

    case 'delete':
        $empresa->id = $_POST['id'];

        if ($empresa->delete()) {
            header("Location: ../templates/index.php?menu=empresa");
        } else {
            echo "Erro ao deletar a empresa.";
        }
        break;

    default:
        // Lista as empresas
        echo '<div class="content">
                <h3>Empresas</h3>
                <hr>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-success" data-toggle="modal" data-target="#createModal">Cadastrar</button>
                </div>
                <div class="mt-2 p-2 rounded text-dark" style="background-color: #F6F6F6;">
                    <h3>Filtrar</h3>
                </div>
                <form method="post" action="../templates/index.php?menu=empresa">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basicaddon1">Nome: </span>
                        <input type="text" class="form-control" name="search" value="' . htmlspecialchars($search) . '" placeholder="Nome" aria-label="Nome" aria-describedby="basic-addon1">
                    </div>
                    <button class="btn btn-danger" type="button" id="resetButton">Limpar</button>
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
                <div class="mt-2 p-2 text-dark" style="background-color: #F6F6F6;">
                    <h3>Empresas (Total: X)</h3>
                </div>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th class="col-sm-10 p-3" scope="col">Nome</th>
                            <th class="p-3 col-auto text-center" colspan="2" scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>';
            $stmt = $empresa->read($search);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>" . htmlspecialchars($row["nome"]) . "</td><td><a href='#' class='edit' data-id='" . $row["id"] . "' data-nome='" . htmlspecialchars($row["nome"]) . "'>Editar</a> <a href='#' class='delete' data-id='" . $row["id"] . "'>Excluir</a></td></tr>";
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
                <h5 class="modal-title" id="exampleModalLabel">Cadastrar Empresa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="../public/empresa.php">
                    <input type="hidden" name="action" value="create">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Nome: </span>
                        <input type="text" class="form-control" name="nome" placeholder="Nome" aria-label="Nome" aria-describedby="basic-addon1">
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
                <h5 class="modal-title" id="exampleModalLabel">Editar Empresa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="../public/empresa.php">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Nome: </span>
                        <input type="text" class="form-control" name="nome" id="edit-nome" placeholder="Nome" aria-label="Nome" aria-describedby="basic-addon1">
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
<form method="post" action="../public/empresa.php" id="delete-form" style="display:none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="id" id="delete-id">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.edit').forEach(function(button) {
            button.addEventListener('click', function() {
                document.getElementById('edit-id').value = this.dataset.id;
                document.getElementById('edit-nome').value = this.dataset.nome;
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
            window.location.href = '../templates/index.php?menu=empresa';
        });
    });
</script>
 