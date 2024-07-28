<?php
if ($isEdit) {
  $success = $lancamentoDespesa->getById($lancamentoDespesaId);
  $centroCustoId = $despesa->getCentroCustoByDespesaId($lancamentoDespesa->idDespesa);

  if (!$success) {
    echo '<div class="p-1 mb-2 bg-danger text-white fixed-bottom">Database Error: Lançamento de Despesa não foi encontrado.!</div>';
  }
}
?>
<form method="post" action="<?php echo $links["screenLancamentos"] ?>" autocomplete="off">
  <input type="hidden" name="action" value=<?php echo ($isEdit ? "update" : "create"); ?>>
  <input type="hidden" name="lancamentoDespesaId" value=<?php echo ($isEdit ? $lancamentoDespesaId : ""); ?>>
  <div class="input-group my-2">
    <span class="input-group-text col-4 col-md-2">Origem</span>
    <select name="idCentroCusto" class="form-control col-8 col-md-10" id="selectCentroCustoId">
      <option value='<?php echo ID_NULL ?>'>Selecione...</option>
      <?php
      $stmt = $centroCusto->getAll();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $selected = $row["id"] == $centroCustoId ? "selected" : "";
      ?>
        <option value='<?php echo htmlspecialchars($row["id"]) ?>' <?php echo $selected ?>> <?php echo htmlspecialchars($row["nome"]) ?></option>
      <?php
      }
      ?>
    </select>
  </div>
  <div class="input-group my-2">
    <span class="input-group-text col-4 col-md-2">Despesa</span>
    <select class="form-control col-8 col-md-10" name="idDespesa" id="selectDespesaId" <?php echo ($isEdit ? "" : "disabled"); ?>>
      <option value="">Selecione...</option>
      <?php
      $stmt = $despesa->getDespesasByCentroCusto($centroCustoId);
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $selected = $row["id"] == $lancamentoDespesa->idDespesa ? "selected" : "";
        echo '<option value="' . htmlspecialchars($row["id"]) . '" ' . $selected . '>' . htmlspecialchars($row["nome"]) . '</option>';
      }
      ?>
    </select>
  </div>
  <div class="input-group my-2">
    <span class="input-group-text col-4 col-md-2">Usuário</span>
    <select class="form-control col-8 col-md-10" name="idUsuario">
      <option value="">null</option>
    </select>
  </div>
  <div class="input-group my-2">
    <span class="input-group-text col-4 col-md-2">Parcela</span>
    <input type="text" class="form-control col-8 col-md-10" name="parcela" placeholder="Parcela" value="<?php echo ($isEdit ? $lancamentoDespesa->parcela : ""); ?>" aria-label="Parcela">
  </div>
  <div class="input-group my-2">
    <span class="input-group-text col-4 col-md-2">Valor</span>
    <input type="text" class="form-control col-8 col-md-10" name="valor" placeholder="Valor" value="<?php echo ($isEdit ? $lancamentoDespesa->valor : ""); ?>" aria-label="Valor">
  </div>
  <div class="input-group my-2">
    <span class="input-group-text col-4 col-md-2">Vencimento</span>
    <input type="date" class="form-control col-8 col-md-10" name="dtVencimento" value="<?php echo ($isEdit ? $lancamentoDespesa->dtVencimento : ""); ?>" aria-label="Vencimento">
  </div>
  <div class="input-group my-2">
    <span class="input-group-text col-4 col-md-2">Pagamento</span>
    <input type="date" class="form-control col-8 col-md-10" name="dtPagamento" value="<?php echo ($isEdit ? $lancamentoDespesa->dtPagamento : ""); ?>" aria-label="Pagamento">
  </div>
  <div class="input-group my-2">
    <span class="input-group-text col-4 col-md-2">Valor Pago</span>
    <input type="text" class="form-control col-8 col-md-10" name="valorPago" placeholder="Valor Pago" value="<?php echo ($isEdit ? $lancamentoDespesa->valorPago : ""); ?>" aria-label="Valor Pago">
  </div>
  <div class="input-group my-2">
    <span class="input-group-text col-4 col-md-2">Observações</span>
    <textarea class="form-control col-8 col-md-10" name="observacoes" placeholder="Observações" aria-label="Observações"><?php echo ($isEdit ? $lancamentoDespesa->observacoes : ""); ?></textarea>
  </div>

  <?php
  if ($isEdit) {
  ?>

    <div class="d-flex justify-content-end">
      <a href="<?php echo $links["screenLancamentos"] ?>" type="button" class="btn btn-secondary mx-2">Voltar</a>
      <input type="submit" name="update" class="btn btn-primary" value="Atualizar">
    </div>

  <?php
  } else {
  ?>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      <input type="submit" name="create" class="btn btn-primary ml-2" value="Salvar">
    </div>
  <?php
  }
  ?>
</form>

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