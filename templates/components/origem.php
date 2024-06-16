<?php
include '../config/config.php';
include '../templates/header.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'create':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST['nome'];
            $ativo = 'S';
            $dtCadastro = date('Y-m-d H:i:s');
            $idUsuario = 1; // Substitua pelo ID do usuário logado

            $sql = "INSERT INTO centrocusto (idUsuario, nome, ativo, dtCadastro) VALUES ('$idUsuario', '$nome', '$ativo', '$dtCadastro')";

            if ($conn->query($sql) === TRUE) {
                header("Location: centrocusto.php");
            } else {
                echo "Erro: " . $sql . "<br>" . $conn->error;
            }
        }
        break;

    case 'update':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $nome = $_POST['nome'];

            $sql = "UPDATE centrocusto SET nome='$nome' WHERE id=$id";

            if ($conn->query($sql) === TRUE) {
                header("Location: centrocusto.php");
            } else {
                echo "Erro: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $id = $_GET['id'];
            $sql = "SELECT nome FROM centrocusto WHERE id=$id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $nome = $row['nome'];
            }
        }
        break;

    case 'delete':
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $id = $_GET['id'];

            $sql = "DELETE FROM centrocusto WHERE id=$id";

            if ($conn->query($sql) === TRUE) {
                header("Location: centrocusto.php");
            } else {
                echo "Erro: " . $sql . "<br>" . $conn->error;
            }
        }
        break;

    default:
        // Lista os centros de custo
        echo '<div class="content">
                <h3>Despesas / Origem</h3>
                <hr>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-success" data-toggle="modal" data-target="#createModal">Cadastrar</button>
                </div>
                <div class="mt-2 p-2 rounded text-dark" style="background-color: #F6F6F6;">
                    <h3>Filtrar</h3>
                </div>
                <div class="input-group mt-3 mb-3">
                    <span class="input-group-text" id="basic-addon1">Nome: </span>
                    <input type="text" class="form-control" name="name" placeholder="Nome" aria-label="Nome" aria-describedby="basic-addon1">
                </div>
                <button class="btn btn-danger" type="reset">Limpar</button>
                <button class="btn btn-outline-success" type="submit">Buscar</button>
                <div class="mt-2 p-2 text-dark" style="background-color: #F6F6F6;">
                    <h3>Origens (Total: X)</h3>
                </div>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th class="col-sm-10 p-3" scope="col">Nome</th>
                            <th class="p-3 col-auto text-center" colspan="2" scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "SELECT id, nome FROM centrocusto";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["nome"]. "</td><td><a href='centrocusto.php?action=update&id=".$row["id"]."'>Editar</a> <a href='centrocusto.php?action=delete&id=".$row["id"]."'>Excluir</a></td></tr>";
            }
        } else {
            echo "<tr><td colspan='2'>0 resultados</td></tr>";
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
                <h5 class="modal-title" id="exampleModalLabel">Cadastrar Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="centrocusto.php?action=create">
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
<?php if ($action == 'update' && isset($id)): ?>
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: block;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.href='centrocusto.php';">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="centrocusto.php?action=update">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="basic-addon1">Nome: </span>
                        <input type="text" class="form-control" name="nome" value="<?php echo $nome; ?>" placeholder="Nome" aria-label="Nome" aria-describedby="basic-addon1">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.href='centrocusto.php';">Fechar</button>
                        <input type="submit" name="update" class="btn btn-primary" value="Salvar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#updateModal').modal('show');
    });
</script>
<?php endif; ?>
