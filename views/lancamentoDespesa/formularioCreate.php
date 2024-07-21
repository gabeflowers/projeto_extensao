<form method="post" action="<?php echo $links["submitCreate"] ?>">
  <input type="hidden" name="action" value="create">
  <div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="basic-addon1">Centro de Custo: </span>
    <select name="idCentroCusto" class="form-control" id="selectCentroCustoId">
      <option value='<?php echo ID_NULL ?>'>Selecione...</option>
      <?php
      $stmt = $centroCusto->getAll();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["nome"]) . '</option>';
      }
      ?>
    </select>
  </div>
  <div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="basic-addon1">Despesa: </span>
    <select class="form-control" name="idDespesa" id="selectDespesaId" disabled>
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
    <span class="input-group-text" id="basic-addon1">Usuário: </span>
    <select class="form-control" name="idUsuario">
      <option value="">Selecione...</option>
    </select>
  </div>
  <div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="basic-addon1">Parcela: </span>
    <input type="text" class="form-control" name="parcela" placeholder="Parcela" aria-label="Parcela" aria-describedby="basic-addon1">
  </div>
  <div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="basic-addon1">Valor: </span>
    <input type="text" class="form-control" name="valor" placeholder="Valor" aria-label="Valor" aria-describedby="basic-addon1">
  </div>
  <div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="basic-addon1">Vencimento: </span>
    <input type="date" class="form-control" name="dtVencimento" aria-label="Vencimento" aria-describedby="basic-addon1">
  </div>
  <div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="basic-addon1">Pagamento: </span>
    <input type="date" class="form-control" name="dtPagamento" aria-label="Pagamento" aria-describedby="basic-addon1">
  </div>
  <div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="basic-addon1">Valor Pago: </span>
    <input type="text" class="form-control" name="valorPago" placeholder="Valor Pago" aria-label="Valor Pago" aria-describedby="basic-addon1">
  </div>
  <div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="basic-addon1">Observações: </span>
    <textarea class="form-control" name="observacoes" placeholder="Observações" aria-label="Observações" aria-describedby="basic-addon1"></textarea>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    <input type="submit" name="create" class="btn btn-primary" value="Salvar">
  </div>
</form>