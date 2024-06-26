<?php
include_once '../config/config.php';
include_once '../models/Usuario.php';
include_once '../models/Empresa.php';

$database = new Database();
$db = $database->getConnection();
$usuario = new Usuario($db);
$empresa = new Empresa($db);

$action = isset($_POST['action']) ? $_POST['action'] : '';
$search = isset($_POST['search']) ? $_POST['search'] : '';

switch ($action) {
    case 'create':
        $usuario->idEmpresa = $_POST['idEmpresa'];
        $usuario->idPerfil = $_POST['idPerfil'];
        $usuario->nome = $_POST['nome'];
        $usuario->email = $_POST['email'];
        $usuario->ativo = 'S';
        $usuario->dtCadastro = date('Y-m-d H:i:s');

        if ($usuario->create()) {
            header("Location: ../templates/index.php?page=usuario");
        } else {
            echo "Erro ao criar o usuário.";
        }
        break;

    case 'update':
        $usuario->id = $_POST['id'];
        $usuario->idEmpresa = $_POST['idEmpresa'];
        $usuario->idPerfil = $_POST['idPerfil'];
        $usuario->nome = $_POST['nome'];
        $usuario->email = $_POST['email'];

        if ($usuario->update()) {
            header("Location: ../templates/index.php?menu=usuario");
        } else {
            echo "Erro ao atualizar o usuário.";
        }
        break;

    case 'delete':
        $usuario->id = $_POST['id'];

        if ($usuario->delete()) {
            header("Location: ../templates/index.php?menu=usuario");
        } else {
            echo "Erro ao deletar o usuário.";
        }
        break;

    default:
        // Lista os usuários
        echo '<div class="content">
                <h3>Usuários</h3>
                <hr>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-success" data-toggle="modal" data-target="#createModal">Cadastrar</button>
                </div>
                <div class="mt-2 p-2 rounded text-dark" style="background-color: #F6F6F6;">
                    <h3>Filtrar</h3>
                </div>
                <form method="post" action="../templates/index.php?menu=usuario">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basicaddon1">Nome: </span>
                        <input type="text" class="form-control" name="search" value="' . htmlspecialchars($search) . '" placeholder="Nome" aria-label="Nome" aria-describedby="basic-addon1">
                    </div>
                    <button class="btn btn-danger" type="button" id="resetButton">Limpar</button>
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
                <div class="mt-2 p-2 text-dark" style="background-color: #F6F6F6;">
                    <h3>Usuários (Total: X)</h3>
                </div>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th class="col-sm-2 p-3" scope="col">Nome</th>
                            <th class="col-sm-2 p-3" scope="col">Email</th>
                            <th class="col-sm-2 p-3" scope="col">Empresa</th>
                            <th class="col-sm-2 p-3" scope="col">Perfil</th>
                            <th class="p-3 col-auto text-center" colspan="2" scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>';
            $stmt = $usuario->read($search);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["nome"]) . "</td>
                        <td>" . htmlspecialchars($row["email"]) . "</td>
                        <td>" . htmlspecialchars($row["empresaNome"]) . "</td>
                        <td>" . htmlspecialchars($row["perfilNome"]) . "</td>
                        <td><a href='#' class='edit' data-id='" . $row["id"] . "' data-nome='" . htmlspecialchars($row["nome"]) . "' data-email='" . htmlspecialchars($row["email"]) . "' data-idEmpresa='" . $row["idEmpresa"] . "' data-idPerfil='" . $row["idPerfil"] . "'>Editar</a> <a href='#' class='delete' data-id='" . $row["id"] . "'>Excluir</a></td>
                    </tr>";
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
                <h5 class="modal-title" id="exampleModalLabel">Cadastrar Usuário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="../public/usuario.php">
                    <input type="hidden" name="action" value="create">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Nome: </span>
                        <input type="text" class="form-control" name="nome" placeholder="Nome" aria-label="Nome" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Email: </span>
                        <input type="email" class="form-control" name="email" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Empresa: </span>
                        <select class="form-control" name="idEmpresa">
                            <option value="">Selecione...</option>
                            <?php
                            $stmt = $empresa->getAll();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["nome"]) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Perfil: </span>
                        <input type="text" class="form-control" name="idPerfil" placeholder="Perfil" aria-label="Perfil" aria-describedby="basic-addon1">
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
                <h5 class="modal-title" id="exampleModalLabel">Editar Usuário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="../public/usuario.php">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Nome: </span>
                        <input type="text" class="form-control" name="nome" id="edit-nome" placeholder="Nome" aria-label="Nome" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Email: </span>
                        <input type="email" class="form-control" name="email" id="edit-email" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Empresa: </span>
                        <select class="form-control" name="idEmpresa" id="edit-idEmpresa">
                            <option value="">Selecione...</option>
                            <?php
                            $stmt = $empresa->getAll();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["nome"]) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Perfil: </span>
                        <input type="text" class="form-control" name="idPerfil" id="edit-idPerfil" placeholder="Perfil" aria-label="Perfil" aria-describedby="basic-addon1">
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
<form method="post" action="../public/usuario.php" id="delete-form" style="display:none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="id" id="delete-id">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.edit').forEach(function(button) {
            button.addEventListener('click', function() {
                document.getElementById('edit-id').value = this.dataset.id;
                document.getElementById('edit-nome').value = this.dataset.nome;
                document.getElementById('edit-email').value = this.dataset.email;
                document.getElementById('edit-idEmpresa').value = this.dataset.idEmpresa;
                document.getElementById('edit-idPerfil').value = this.dataset.idPerfil;
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
            window.location.href = '../templates/index.php?menu=usuario';
        });
    });
</script>
