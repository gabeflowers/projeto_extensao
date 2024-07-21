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
        <?php include 'formularioCreate.php'; ?>
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
            <span class="input-group-text" id="basic-addon1">Centro de Custo: </span>
            <select class="form-control" name="idCentroCusto" id="edit-idCentroCusto">
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
            <span class="input-group-text" id="basic-addon1">Parcela: </span>
            <input type="text" class="form-control" name="parcela" id="edit-parcela" placeholder="Parcela" aria-label="Parcela" aria-describedby="basic-addon1">
          </div>
          <div class="input-group mt-3 mb-3">
            <span class="input-group-text" id="basic-addon1">Valor: </span>
            <input type="number" class="form-control" name="valor" id="edit-valor" value="0" placeholder="Valor">
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

<script>
  let selectCentroCusto = document.getElementById("selectCentroCustoId");
  let selectDespesa = document.getElementById("selectDespesaId");

  //onChangeCentroCusto
  selectCentroCusto.addEventListener('change', async (e) => {

    let selectCentroCusto = e.target;
    let centroCustoId = selectCentroCusto.options[selectCentroCusto.selectedIndex].value;

    if (centroCustoId == '<?php echo ID_NULL ?>') {
      selectDespesa.setAttribute("disabled", "")
      return
    }

    fetch(`../controllers/LancamentoDespesaController.php?centroCustoId=${centroCustoId}`)
      .then(response => response.json())
      .then(data => {
        selectDespesa.innerHTML = ""

        let optionDefault = new Option("Selecione..", null, true, true)
        optionDefault.disabled = true
        selectDespesa.add(optionDefault)

        data.forEach(despesa => {
          let option = new Option(despesa.nome, despesa.id)
          selectDespesa.add(option)
        })

        selectDespesa.removeAttribute("disabled")
      })
      .catch(error => console.error('Erro:', error));
  })
</script>