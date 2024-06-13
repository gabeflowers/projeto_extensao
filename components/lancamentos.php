<div class="content">
        <h3>Despesas / Lançamento</h3>
        <hr>
        <div class="d-flex justify-content-end">
            <button class="btn btn-outline-success" data-toggle="modal" data-target="#myModal3">Cadastrar</button>
        </div>
        <div class="mt-2 mb-3 p-2 text-dark" style="background-color: #F6F6F6;">
            <h3>Filtrar</h3>
        </div>
        <div class="row">
            <div class="col d-flex justify-content-between">
                <label class="align-content-center" for="sel1">Origem: </label>
                <select class="form-control w-75" id="sel1" name="origem">
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                </select>
            </div>
            <div class="col d-flex justify-content-between">
                <label class="align-content-center" for="sel1">Tipo: </label>
                <select class="form-control w-75" id="sel1" name="tipo">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                </select>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col d-flex justify-content-between">
                <label for="de">De:</label>
                <input type="date" class="w-75 form-control" id="de" name="de">
            </div>
            <div class="col d-flex justify-content-between">
                <label for="ate">Até:</label>
                <input type="date" class="w-75 form-control" id="ate" name="ate">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col justify-content-between d-flex ">
                <label for="observacao">Busca Observação</label>
                <textarea class="form-control w-75" placeholder="Leave a comment here" id="observacao" name="observacao"></textarea>
            </div>
        </div>
        <button class="btn btn-danger" type="reset">Limpar</button>
        <button class="btn btn-outline-success" type="submit">Buscar</button>
        
        <div class="mt-2 p-2 text-dark" style="background-color: #F6F6F6;">
            <h3>Lançamentos (Total: X)</h3>
        </div>
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Vencimento</th>
                    <th scope="col">Origem</th>
                    <th scope="col">Despesa</th>
                    <th scope="col">Observação</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Valor Pago</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
</div>

    <!-- Modal -->
    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastrar Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulário dentro do modal -->
                    <form class="d-flex flex-wrap">
                        <div class="col-md-6 ms-auto">
                            <div class="input-group mt-3 mb-3">
                                <span class="input-group-text" id="basic-addon1">Parcela:</span>
                                <input type="number" class="form-control" name="parcela" aria-label="Parcela" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mt-3 mb-3">
                                <span class="input-group-text" id="basic-addon1">Data de Vencimento:</span>
                                <input type="date" class="form-control" name="data_vencimento" aria-label="Data de Vencimento" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mt-3 mb-3">
                                <span class="input-group-text" id="basic-addon1">Valor:</span>
                                <input type="number" step="0.01" class="form-control" name="valor" aria-label="Valor" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-6 ms-auto">
                            <div class="input-group mt-3 mb-3">
                                <span class="input-group-text" id="basic-addon1">Data de Pagamento:</span>
                                <input type="date" class="form-control" name="data_pagamento" aria-label="Data de Pagamento" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mt-3 mb-3">
                                <span class="input-group-text" id="basic-addon1">Valor Pago:</span>
                                <input type="number" step="0.01" class="form-control" name="valor_pago" aria-label="Valor Pago" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mt-3 mb-3">
                                <span class="input-group-text" id="basic-addon1">Ativo:</span>
                                <select class="form-control" name="ativo" aria-label="Ativo">
                                    <option value="s">Sim</option>
                                    <option value="n">Não</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-group col mt-3 mb-3">
                            <span class="input-group-text" id="basic-addon1">Observações:</span>
                            <textarea class="form-control" name="observacoes" aria-label="Observações"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>