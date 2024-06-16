<?php
$action = isset($_GET['action']) && $_GET['action'] == 'update' ? 'update' : 'create';
$id = isset($id) ? $id : '';
$nome = isset($nome) ? $nome : '';
?>
<form method="post" action="../public/centrocusto.php?action=<?php echo $action; ?>">
    <?php if ($action == 'update'): ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
    <?php endif; ?>
    <div class="input-group mt-3 mb-3">
        <span class="input-group-text" id="basic-addon1">Nome: </span>
        <input type="text" class="form-control" name="nome" value="<?php echo $nome; ?>" placeholder="Nome" aria-label="Nome" aria-describedby="basic-addon1">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <input type="submit" name="<?php echo $action; ?>" class="btn btn-primary" value="Salvar">
    </div>
</form>
