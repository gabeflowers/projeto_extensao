<?php 
  if($isEdit){
    $success = $lancamentoDespesa->getById($lancamentoDespesaId);
    $centroCustoId = $despesa->getCentroCustoByDespesaId($lancamentoDespesa->idDespesa);

    if(!$success){
      echo '<div class="p-1 mb-2 bg-danger text-white fixed-bottom">Database Error: Lançamento de Despesa não foi encontrado.!</div>';
    }
    
  }
?>
<form method="post" action="<?php echo $links["screenLancamentos"] ?>" autocomplete="off">
  <input type="hidden" name="action" value=<?php echo($isEdit ? "update" : "create");?>>
  <input type="hidden" name="lancamentoDespesaId" value=<?php echo($isEdit ? $lancamentoDespesaId : "" );?>>
  <div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="basic-addon1">Centro de Custo: </span>
    <select name="idCentroCusto" class="form-control" id="selectCentroCustoId">
      <option value='<?php echo ID_NULL ?>'>Selecione...</option>
      <?php
      $stmt = $centroCusto->getAll();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $selected = $row["id"] == $centroCustoId ? "selected" : "";
        ?>
        <option value='<?php echo htmlspecialchars($row["id"])?>' <?php echo $selected ?> > <?php echo htmlspecialchars($row["nome"]) ?></option>
        <?php
      }
      ?>
    </select>
  </div>
  <div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="basic-addon1">Despesa: </span>
    <select class="form-control" name="idDespesa" id="selectDespesaId" <?php echo($isEdit ? "" : "disabled");?>>
      <option value="">Selecione...</option>
      <?php
      $stmt = $despesa->getDespesasByCentroCusto($centroCustoId);
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $selected = $row["id"] == $lancamentoDespesa->idDespesa ? "selected" : "";
        echo '<option value="'.htmlspecialchars($row["id"]).'" '.$selected.'>' . htmlspecialchars($row["nome"]) . '</option>';
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
    <input type="text" class="form-control" name="parcela" placeholder="Parcela" 
      value="<?php echo($isEdit ? $lancamentoDespesa->parcela : "");?>"  
      aria-label="Parcela" aria-describedby="basic-addon1"
    >
  </div>
  <div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="basic-addon1">Valor: </span>
    <input type="text" class="form-control" name="valor" placeholder="Valor" 
      value="<?php echo($isEdit ? $lancamentoDespesa->valor : "");?>"
      aria-label="Valor" aria-describedby="basic-addon1">
  </div>
  <div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="basic-addon1">Vencimento: </span>
    <input type="date" class="form-control" name="dtVencimento" 
      value="<?php echo($isEdit ? $lancamentoDespesa->dtVencimento : "");?>"
      aria-label="Vencimento" aria-describedby="basic-addon1">
  </div>
  <div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="basic-addon1">Pagamento: </span>
    <input type="date" class="form-control" name="dtPagamento" 
      value="<?php echo($isEdit ? $lancamentoDespesa->dtPagamento : "");?>"
      aria-label="Pagamento" aria-describedby="basic-addon1">
  </div>
  <div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="basic-addon1">Valor Pago: </span>
    <input type="text" class="form-control" name="valorPago" placeholder="Valor Pago" 
      value="<?php echo($isEdit ? $lancamentoDespesa->valorPago : "");?>"
      aria-label="Valor Pago" aria-describedby="basic-addon1">
  </div>
  <div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="basic-addon1">Observações: </span>
    <textarea class="form-control" name="observacoes" placeholder="Observações" 
      aria-label="Observações" aria-describedby="basic-addon1"><?php echo($isEdit ? $lancamentoDespesa->observacoes : "");?></textarea>
  </div>
  
  <?php 
    if($isEdit){
      ?>

      <div class="d-flex justify-content-end">
        <a href="<?php echo $links["screenLancamentos"] ?>" type="button" class="btn btn-secondary mx-2">Voltar</a>
        <input type="submit" name="update" class="btn btn-primary" value="Atualizar">
      </div>
      
      <?php
    }else{
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