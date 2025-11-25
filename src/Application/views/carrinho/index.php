<div class="max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Seu Carrinho de Compras</h2>

    <?php if (empty($data['itens'])): ?>
        <div class="bg-white p-6 rounded shadow text-center">
            <p class="text-gray-600 mb-4">Seu carrinho está vazio.</p>
            <a href="/" class="text-blue-600 hover:underline">Voltar para a loja</a>
        </div>
    <?php else: ?>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="p-4 text-left">Produto</th>
                        <th class="p-4 text-center">Qtd</th>
                        <th class="p-4 text-right">Preço Unit.</th>
                        <th class="p-4 text-right">Subtotal</th>
                        <th class="p-4 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['itens'] as $item): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <?php if(!empty($item['imagem'])): ?>
                                    <img src="/assets/img/<?php echo $item['imagem']; ?>" class="w-12 h-12 object-cover rounded border">
                                <?php endif; ?>
                                <span class="font-bold"><?php echo $item['nome']; ?></span>
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            <?php echo $item['qtd_carrinho']; ?>
                        </td>
                        <td class="p-4 text-right">
                            R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?>
                        </td>
                        <td class="p-4 text-right font-bold text-blue-600">
                            R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?>
                        </td>
                        <td class="p-4 text-center">
                            <a href="/carrinho/remover/<?php echo $item['id']; ?>" class="text-red-500 hover:text-red-700 text-sm font-semibold">Remover</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Rodapé do Carrinho -->
            <div class="p-6 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
                
                <!-- Lado Esquerdo: Limpar -->
                <div class="w-full md:w-auto text-center md:text-left">
                    <a href="/carrinho/limpar" class="text-red-500 text-sm hover:underline hover:text-red-700 transition">
                        Esvaziar Carrinho
                    </a>
                </div>
                
                <!-- Lado Direito: Totais e Ações -->
                <div class="flex flex-col items-end gap-4 w-full md:w-auto">
                    
                    <!-- Total -->
                    <div class="text-right border-b border-gray-200 pb-2 w-full">
                        <p class="text-gray-600">Total do Pedido</p>
                        <p class="text-3xl font-bold text-gray-800">R$ <?php echo number_format($data['total'], 2, ',', '.'); ?></p>
                    </div>
                    
                    <!-- Botões de Ação (Agrupados à direita) -->
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <a href="/" class="text-center bg-white border border-gray-300 text-gray-700 font-bold py-3 px-6 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition shadow-sm w-full sm:w-auto">
                            Continuar Comprando
                        </a>

                        <form action="/checkout/finalizar" method="POST" class="w-full sm:w-auto">
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 px-8 rounded-lg shadow-md hover:bg-green-700 hover:shadow-lg transition transform hover:-translate-y-0.5">
                                    Finalizar Compra
                                </button>
                            <?php else: ?>
                                <a href="/auth/login" class="block text-center w-full bg-blue-600 text-white font-bold py-3 px-8 rounded-lg shadow-md hover:bg-blue-700 transition">
                                    Entrar para Comprar
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    <?php endif; ?>
</div>