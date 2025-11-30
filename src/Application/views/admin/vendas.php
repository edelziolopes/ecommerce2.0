<div class="flex h-screen bg-gray-100">
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
        <div class="p-4 text-2xl font-bold border-b border-gray-700">Admin Panel</div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="/admin" class="block py-2 px-4 hover:bg-gray-700 rounded text-gray-300">Dashboard</a>
            <a href="/admin/produtos" class="block py-2 px-4 hover:bg-gray-700 rounded text-gray-300">Produtos</a>
            <a href="/admin/categorias" class="block py-2 px-4 hover:bg-gray-700 rounded text-gray-300">Categorias</a>
            <a href="/admin/vendas" class="block py-2 px-4 bg-gray-700 rounded text-white">Vendas</a>
            <a href="/admin/banners" class="block py-2 px-4 bg-gray-700 rounded text-white">Banners</a>
            <a href="/" class="block py-2 px-4 mt-8 bg-blue-600 hover:bg-blue-700 rounded text-center">Ir para Loja</a>
        </nav>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        <h1 class="text-2xl font-bold mb-6">Histórico de Vendas</h1>

        <div class="bg-white p-6 rounded shadow overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="p-4 w-10"></th> <!-- Coluna para o botão + -->
                        <th class="p-4">#ID</th>
                        <th class="p-4">Data</th>
                        <th class="p-4">Cliente</th>
                        <th class="p-4 text-right">Valor Total</th>
                        <th class="p-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['vendas'])): ?>
                        <?php foreach($data['vendas'] as $venda): ?>
                        
                        <!-- Linha Principal da Venda -->
                        <tr class="border-b hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-center">
                                <button onclick="toggleVenda(<?php echo $venda['id']; ?>)" class="text-blue-600 hover:text-blue-800 focus:outline-none font-bold text-xl">
                                    +
                                </button>
                            </td>
                            <td class="p-4 font-mono font-bold">#<?php echo str_pad($venda['id'], 6, '0', STR_PAD_LEFT); ?></td>
                            <td class="p-4 text-gray-600">
                                <?php echo date('d/m/Y H:i', strtotime($venda['data_venda'])); ?>
                            </td>
                            <td class="p-4">
                                <?php echo htmlspecialchars($venda['cliente']); ?>
                            </td>
                            <td class="p-4 text-right font-bold text-green-600">
                                R$ <?php echo number_format($venda['total_venda'], 2, ',', '.'); ?>
                            </td>
                            <td class="p-4 text-center">
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Concluído</span>
                            </td>
                        </tr>

                        <!-- Linha de Detalhes (Itens) - Inicialmente Escondida -->
                        <tr id="detalhes-<?php echo $venda['id']; ?>" class="hidden bg-gray-50">
                            <td colspan="6" class="p-4 border-b">
                                <div class="pl-12">
                                    <h4 class="font-bold text-gray-700 mb-2 text-sm uppercase">Itens do Pedido:</h4>
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="text-gray-500 border-b border-gray-200">
                                                <th class="pb-2 text-left">Produto</th>
                                                <th class="pb-2 text-center">Qtd</th>
                                                <th class="pb-2 text-right">Preço Unit.</th>
                                                <th class="pb-2 text-right">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($venda['itens'] as $item): ?>
                                            <tr>
                                                <td class="py-2 flex items-center gap-2">
                                                    <?php if($item['imagem']): ?>
                                                        <img src="/assets/img/<?php echo $item['imagem']; ?>" class="w-8 h-8 object-cover rounded border">
                                                    <?php endif; ?>
                                                    <?php echo $item['produto_nome']; ?>
                                                </td>
                                                <td class="py-2 text-center"><?php echo $item['quantidade']; ?></td>
                                                <td class="py-2 text-right">R$ <?php echo number_format($item['preco_unitario'], 2, ',', '.'); ?></td>
                                                <td class="py-2 text-right font-semibold">
                                                    R$ <?php echo number_format($item['quantidade'] * $item['preco_unitario'], 2, ',', '.'); ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">
                                Nenhuma venda registrada no sistema.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<script>
function toggleVenda(id) {
    const row = document.getElementById('detalhes-' + id);
    if (row.classList.contains('hidden')) {
        row.classList.remove('hidden');
    } else {
        row.classList.add('hidden');
    }
}
</script>