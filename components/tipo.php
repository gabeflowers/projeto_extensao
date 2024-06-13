<div class="content">
        <h3>Despesas / Tipo</h3>
        <hr>
        <div class="d-flex justify-content-end">
            <button class="btn btn-outline-success" data-toggle="modal" data-target="#myModal2">Cadastrar</button>
        </div>
        <div class="mt-2 p-2 text-dark" style="background-color: #F6F6F6;">
            <h3>Filtrar</h3>
        </div>
        <div class="input-group mt-3 mb-3">
            <span class="input-group-text" id="basic-addon1">Nome: </span>
            <input type="text" class="form-control" name="name" placeholder="Nome" aria-label="Nome" aria-describedby="basic-addon1">
        </div>
        <button class="btn btn-danger" type="reset">Limpar</button>
        <button class="btn btn-outline-success" type="submit">Buscar</button>
        
        <div class="mt-2 p-2 text-dark" style="background-color: #F6F6F6;">
            <h3>Tipos (Total: X)</h3>
        </div>
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cadastrar Item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Adicione os campos necessários para o formulário do modal -->
                            <div class="input-group mt-3 mb-3">
                                <span class="input-group-text" id="basic-addon1">Nome: </span>
                                <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="button" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>