<?php

$lancamentoDespesaId = isset($_GET['id']) ? $_GET['id'] : ID_NULL;
$isEdit = ($lancamentoDespesaId <> ID_NULL);

if ($isEdit == false) {
  //exibir o list
?>
  <div>
    <div class="row">
      <h1 class="m-0 fs-5 text-center fw-bold">Lançamentos de Despesas</h1>
    </div>
    <hr class="mt-2 mb-3">

    <div>
      <form method="post" action="<?php echo $links["screenLancamentos"] ?>" autocomplete="off">
        <div class="input-group input-group-sm my-1">
          <input type="text" class="form-control" name="search" id="searchInput" value="<?php echo $filtros['search'] ?>" placeholder="Pesquisar Lançamentos...">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary px-2" type="button" id="resetButton">Limpar</button>
            <button class="btn btn-outline-primary px-2" type="submit">Buscar</button>
          </div>
        </div>
      </form>
    </div>

    <div class="p-1 rounded" style="background-color: #F6F6F6;">
      <div class="row">
        <a class="text-decoration-none text-body" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
          <div>Filtros</div>
        </a>
      </div>

      <div class="collapse" id="collapseExample">
        <?php include('filtros.php') ?>
      </div>
    </div>

    <div class="mt-4 p-2 row g-0">
      <div class="col-8">
        <span class="fw-bold">Lançamentos</span>
        <span class="badge bg-secondary">Total <?php echo $lancamentoDespesa->count() ?></span>
      </div>
      <div class="col-4 d-flex justify-content-end">
        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#createModal">Adcionar</button>

      </div>

    </div>

    <div class="table-responsive" style="overflow-y: visible !important;">
      <table class="table table-striped table-bordered table-sm">
        <thead class="table-light">
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

          <?php $stmt = $lancamentoDespesa->read($filtros);
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dtVencimento = DateTime::createFromFormat('Y-m-d', $row["dtVencimento"]);
            $formattedDate = $dtVencimento ? $dtVencimento->format('d/m/Y') : $row["dtVencimento"];
          ?>
            <tr>
              <td class="text-nowrap py-1 px-2"><?php echo htmlspecialchars($formattedDate); ?></td>
              <td class="text-nowrap py-1 px-2"><?php echo htmlspecialchars($row["centroCustoNome"]); ?></td>
              <td class="text-nowrap py-1 px-2"><?php echo htmlspecialchars($row["despesaNome"]); ?></td>
              <td class="text-nowrap py-1 px-2"><?php echo htmlspecialchars($row["observacoes"]); ?></td>
              <td class="text-nowrap py-1 px-2 text-end"><?php echo htmlspecialchars($row["valor"]); ?></td>
              <td class="text-nowrap py-1 px-2 text-end"><?php echo htmlspecialchars($row["valorPago"]); ?></td>
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
          let confirmDelete = confirm("Você realmente deseja excluir o Lançamento de Despesa?");
          if(confirmDelete){
            document.getElementById('delete-id').value = this.dataset.id;
            document.getElementById('delete-form').submit();
          }
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
} else { //exibir  o edit
?>
  <div class="row">
    <h1 class="m-0 fs-5 text-center fw-bold">Atualizar Lancamento</h1>
  </div>
  <hr class="mt-2 mb-3">
  <?php

  include_once 'formularioCreateUpdateLancamento.php'; ?>

<?php
}
?>