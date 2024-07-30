<form method="post" action="<?php echo htmlspecialchars($links["screenLancamentos"]) ?>" autocomplete="off">
  <div class="form-group row g-2 my-2">
    <div class="col-sm-6">
      <div class="input-group input-group-sm">
        <span class="input-group-text col-4">Vencimento de </span>
        <input type="date" class="form-control col-8" name="filtro_dtVencimentoInicio" 
        value="<?php echo htmlspecialchars($filtros['dtVencimentoInicio']) ?>" aria-label="Filtro vencimento inicio'">
      </div>
      <div class="input-group input-group-sm">
        <span class="input-group-text col-4">Vencimento até </span>
        <input type="date" class="form-control col-8" name="filtro_dtVencimentoFim" 
        value="<?php echo htmlspecialchars($filtros['dtVencimentoFim']) ?>" aria-label="Filtro vencimento fim">
      </div>
      <div class="input-group input-group-sm">      
        <span class="input-group-text col-4">Origem</span>  
        <select name="filtro_centroCusto" class="form-control col-8" aria-label="Origem - Centro de Custo" value="<?php echo $filtros['centroCusto'] ?>">
        <option value='<?php echo ID_NULL ?>'>Selecione...</option>
        <?php
            $stmt = $centroCusto->getAll();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $selected = $row["id"] == $filtros['centroCusto'] ? "selected" : "";
            ?>
              <option value='<?php echo htmlspecialchars($row["id"]) ?>' <?php echo $selected ?>> <?php echo htmlspecialchars($row["nome"]) ?></option>
            <?php
            }
            ?>
        </select>
      </div>
      <div class="input-group input-group-sm">      
        <span class="input-group-text col-4">Despesa</span>  
        <select name="filtro_despesa" class="form-control col-8" aria-label="Despesa" value="<?php echo htmlspecialchars($filtros['despesa']) ?>">
          <option value="">Selecione ...</option>
          <?php
          $stmt = $despesa->getAll();
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $selected = $row["id"] == $filtros['despesa'] ? "selected" : "";
            ?>
              <option value='<?php echo htmlspecialchars($row["id"]) ?>' <?php echo $selected ?>> <?php echo htmlspecialchars($row["nome"]) ?></option>
            <?php
          }
          ?>
        </select>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="input-group input-group-sm">
        <span class="input-group-text col-4">Pagamento de </span>
        <input type="date" class="form-control col-8" name="filtro_dtPagamentoInicio" aria-label="Filtro Pagamento Inicio" value="<?php echo htmlspecialchars($filtros['dtPagamentoInicio']) ?>">
      </div>
      <div class="input-group input-group-sm">
        <span class="input-group-text col-4">Pagamento até </span>
        <input type="date" class="form-control col-8" name="filtro_dtPagamentoFim" aria-label="Filtro Pagamento fim" value="<?php echo htmlspecialchars($filtros['dtPagamentoFim']) ?>">
      </div>
      <div class="input-group input-group-sm ">
        <span class="input-group-text col-4">Pago?</span>
        <div class="col-8 mt-1">
          <span class="form-switch">
            <?php $checked = $filtros['isPago'] ? "checked" : "" ?>
            <input class="form-check-input" type="checkbox" name="filtro_isPago" <?php echo $checked ?>>
          </span>
        </div>
      </div>
    </div>
    <div class="col-12 d-flex justify-content-end">
      <button class="btn btn-sm btn-outline-primary mx-2" type="submit">Filtrar</button>

    </div>
  </div>
</form>