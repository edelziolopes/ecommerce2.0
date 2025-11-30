<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Detalhes da Compra #<?php echo $data['venda']['id']; ?></h1>
        <a href="/dashboard" class="text-blue-600 hover:underline">&larr; Voltar</a>
    </div>

    <div class="bg-white shadow overflow-hidden rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Resumo</h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Data da Compra</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?php echo date('d/m/Y H:i', strtotime($data['venda']['data_venda'])); ?></dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Total</dt>
                    <dd class="mt-1 text-lg font-bold text-gray-900">R$ <?php echo number_format($data['venda']['total_venda'], 2, ',', '.'); ?></dd>
                </div>
            </dl>
        </div>
    </div>

    <h2 class="text-xl font-bold text-gray-800 mb-4">Itens do Pedido</h2>
    <div class="bg-white shadow overflow-hidden rounded-lg">
        <ul class="divide-y divide-gray-200">
            <?php foreach ($data['itens'] as $item): ?>
                <li class="p-4 flex items-center">
                    <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                         <?php if(!empty($item['imagem'])): ?>
                            <img src="/assets/img/<?php echo $item['imagem']; ?>" alt="<?php echo $item['produto_nome']; ?>" class="h-full w-full object-cover object-center">
                        <?php else: ?>
                            <div class="h-full w-full bg-gray-100 flex items-center justify-center text-xs text-gray-400">Sem foto</div>
                        <?php endif; ?>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-medium text-gray-900"><?php echo $item['produto_nome']; ?></h3>
                        <p class="text-sm text-gray-500">Qtd: <?php echo $item['quantidade']; ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">R$ <?php echo number_format($item['preco_unitario'], 2, ',', '.'); ?></p>
                        <p class="text-xs text-gray-500">Total: R$ <?php echo number_format($item['preco_unitario'] * $item['quantidade'], 2, ',', '.'); ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
