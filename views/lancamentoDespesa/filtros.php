<form method="post" action="<?php echo $links["screenLancamentos"] ?>" autocomplete="off">
  <div class="form-group row g-2 my-2">
    <div class="col-sm-6">
      <div class="input-group input-group-sm">
        <span class="input-group-text col-4">Vencimento </span>
        <input type="date" class="form-control col-8" name="filtro_dtVencimento" aria-label="Vencimento">
      </div>
      <div class="input-group input-group-sm">      
        <span class="input-group-text col-4">Origem</span>  
        <select name="filtro_centroCusto" class="form-control col-8" aria-label="Origem - Centro de Custo">
          <option value="0">opcao 0</option>
          <option value="1">opcao 1</option>
          <option value="2">opcao 2</option>
        </select>
      </div>
      <div class="input-group input-group-sm">      
        <span class="input-group-text col-4">Despesa</span>  
        <select name="filtro_despesa" class="form-control col-8" aria-label="Despesa">
          <option value="0">opcao 0</option>
          <option value="1">opcao 1</option>
          <option value="2">opcao 2</option>
        </select>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="input-group input-group-sm">
        <span class="input-group-text col-4">Pagamento </span>
        <input type="date" class="form-control col-8" name="filtro_dtPagamento" aria-label="Pagamento">
      </div>
      <div class="input-group input-group-sm ">
        <span class="input-group-text col-4">Pago?</span>
        <div class="col-8 mt-1">
          <span class="form-switch">
            <input class="form-check-input" type="checkbox" name="filtro_isPago">
          </span>
        </div>
      </div>
    </div>
    <div class="col-12 d-flex justify-content-end">
      <button class="btn btn-sm btn-outline-primary mx-2" type="submit">Filtrar</button>

    </div>
  </div>
</form>