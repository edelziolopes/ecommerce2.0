<?php $p = $data['produto']; ?>

<div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden my-8">
    <div class="flex flex-col md:flex-row">
        
        <!-- Coluna da Esquerda: Imagem -->
        <div class="md:w-1/2 bg-gray-50 p-8 flex items-center justify-center border-r border-gray-100">
            <?php if(!empty($p['imagem'])): ?>
                <img src="/assets/img/<?php echo $p['imagem']; ?>" 
                     alt="<?php echo $p['nome']; ?>" 
                     class="max-h-[400px] object-contain drop-shadow-lg hover:scale-105 transition-transform duration-500">
            <?php else: ?>
                <div class="text-gray-300 text-center">
                    <svg class="w-24 h-24 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="text-xl font-medium">Imagem indisponível</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Coluna da Direita: Informações e Compra -->
        <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-between">
            <div>
                <nav class="text-sm text-gray-500 mb-4">
                    <a href="/" class="hover:underline">Home</a> &rsaquo; 
                    <span class="text-gray-800 font-semibold">Produto #<?php echo $p['id']; ?></span>
                </nav>

                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"><?php echo $p['nome']; ?></h1>
                
                <!-- Avaliação Fake para visual -->
                <div class="flex items-center mb-6">
                    <div class="flex text-yellow-400">
                        <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                    </div>
                    <span class="text-gray-400 text-sm ml-2">(4.9 de 5 estrelas)</span>
                </div>

                <div class="prose text-gray-600 mb-8">
                    <h3 class="font-bold text-gray-800 mb-2">Descrição:</h3>
                    <p class="leading-relaxed"><?php echo nl2br($p['descricao']); ?></p>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <div class="flex items-end gap-4 mb-2">
                    <span class="text-4xl font-bold text-blue-700">R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?></span>
                    <span class="text-gray-400 text-sm mb-2 line-through">R$ <?php echo number_format($p['preco'] * 1.3, 2, ',', '.'); ?></span>
                </div>

                <div class="mb-6">
                    <?php if($p['quantidade_estoque'] > 0): ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            Em Estoque (<?php echo $p['quantidade_estoque']; ?> un.)
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            Esgotado
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Ação de Compra -->
                <?php if($p['quantidade_estoque'] > 0): ?>
                    <form action="/carrinho/adicionar/<?php echo $p['id']; ?>" method="POST" class="flex gap-4">
                        <button type="submit" class="flex-1 bg-green-600 text-white font-bold py-4 px-8 rounded-lg shadow-lg hover:bg-green-700 hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Adicionar ao Carrinho
                        </button>
                    </form>
                <?php else: ?>
                    <button disabled class="w-full bg-gray-300 text-gray-500 font-bold py-4 px-8 rounded-lg cursor-not-allowed">
                        Produto Indisponível
                    </button>
                <?php endif; ?>
                
                <div class="mt-4 text-center">
                    <a href="/" class="text-blue-600 hover:underline text-sm">Continuar vendo outros produtos</a>
                </div>
            </div>
        </div>
    </div>
</div>