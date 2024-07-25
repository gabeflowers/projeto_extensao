<?php

$lancamentoDespesaId = isset($_GET['id']) ? $_GET['id'] : ID_NULL;
$isEdit = ($lancamentoDespesaId <> ID_NULL);

if ($isEdit == false) {
  //exibir o list
?>
  <div>
    <h3>Lançamentos de Despesas</h3>
    <hr>
    <div class="d-flex justify-content-end">
      <button class="btn btn-success" data-toggle="modal" data-target="#createModal">Cadastrar</button>
    </div>
    <div class="mt-2 p-2 rounded text-dark" style="background-color: #F6F6F6;">
      <h3>Filtrar</h3>
    </div>

    <form method="post" action="<?php echo $links["screenLancamentos"] ?>" autocomplete="off">
      <div class="input-group mt-3 mb-3">
        <span class="input-group-text" id="basicaddon1">Buscar: </span>
        <input type="text" class="form-control" name="search" id="searchInput" value="<?php echo htmlspecialchars($search) ?>" placeholder="Digite sua busca...">
      </div>
      <button class="btn btn-danger" type="button" id="resetButton">Limpar</button>
      <button class="btn btn-outline-success" type="submit">Buscar</button>
    </form>

    <div class="mt-2 p-2 text-dark" style="background-color: #F6F6F6;">
      <h3>Lançamentos (Total: <?php echo $lancamentoDespesa->count() ?>)</h3>
    </div>
    <div class="table-responsive-xl">
      <table class="table table-striped table-bordered">
        <thead class="table-dark">
          <tr>
            <th scope="col" class="text-nowrap px-2">Vencimento</th>
            <th scope="col" class="text-nowrap px-2">Origem</th>
            <th scope="col" class="text-nowrap px-2">Despesa</th>
            <th scope="col" class="text-nowrap px-2">Observações</th>
            <th scope="col" class="text-nowrap px-2">Valor</th>
            <th scope="col" class="text-nowrap px-2">Valor Pago</th>
            <th class="text-center px-2" scope="col">Ações</th>
          </tr>
        </thead>
        <tbody>

          <?php $stmt = $lancamentoDespesa->read($search);
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dtVencimento = DateTime::createFromFormat('Y-m-d', $row["dtVencimento"]);
            $formattedDate = $dtVencimento ? $dtVencimento->format('d/m/Y') : $row["dtVencimento"];
          ?>
            <tr>
              <td class="text-nowrap"><?php echo htmlspecialchars($formattedDate); ?></td>
              <td class="text-nowrap"><?php echo htmlspecialchars($row["centroCustoNome"]); ?></td>
              <td class="text-nowrap"><?php echo htmlspecialchars($row["despesaNome"]); ?></td>
              <td class=""><?php echo htmlspecialchars($row["observacoes"]); ?></td>
              <td class="text-nowrap"><?php echo htmlspecialchars($row["valor"]); ?></td>
              <td class="text-nowrap"><?php echo htmlspecialchars($row["valorPago"]); ?></td>
              <td class='d-flex justify-content-center'>
                <a href='#' class='edit btn btn-warning btn-sm' data-id='<?php echo  $row["id"] ?>'>
                  <i class='fas fa-pencil-alt'>
                  </i>
                </a>
                <a href='#' class='delete btn btn-danger btn-sm ml-2' data-id='<?php echo  $row["id"] ?>'>
                  <i class='fa fa-trash'></i>
                </a>
              </td>
            </tr>
          <?php
          }
          ?>

        </tbody>
      </table>
    </div>
  </div>

  <!-- Hidden Form for Delete -->
  <form method="post" action="<?php echo $links["screenLancamentos"] ?>" id="delete-form" style="display:none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="id" id="delete-id">
  </form>

  <!-- Modal for Create and Update -->
  <?php include 'modalCreateUpdate.php'; ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.edit').forEach(function(button) {
        button.addEventListener('click', function() {
          console.log(this.dataset.id)
          window.location.href = ('<?php echo $links["screenEditLancamento"] ?>' + this.dataset.id);
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
        window.location.href = '<?php echo $links["screenLancamentos"] ?>';
      });
    });
  </script>
<?php 
} else { //exibir  o edit?>
  <h3>Atualizar Lançamento</h3>
  <hr>
<?php 
  
  include_once 'formularioCreateUpdateLancamento.php'; ?>

<?php
}
?>