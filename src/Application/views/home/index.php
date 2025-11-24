<h1 class="mb-4">Produtos</h1>

<div class="d-flex flex-wrap gap-4">
  <?php foreach($data['produtos'] as $produto): ?>
    <div class="card shadow" style="width: 18rem; display: flex; flex-direction: column;">
      <img src="<?=$produto['imagem_link']?>" class="card-img-top" style="height: 200px; object-fit: cover;">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">
          <i class="fas fa-box-open me-2"></i><?=$produto['produto_descricao']?>
        </h5>
        <p class="card-text text-success fw-bold">
          <i class="fas fa-tag me-2"></i>R$ <?=number_format($produto['produto_preco'], 2, ',', '.')?>
        </p>
        <p class="card-text text-muted">
          <i class="fas fa-layer-group me-2"></i><?=$produto['categoria_nome']?>
        </p>
        <a href="#" class="btn btn-primary mt-auto w-100">
          <i class="fas fa-shopping-cart me-2"></i>Comprar
        </a>
      </div>
    </div>
  <?php endforeach; ?>
</div>