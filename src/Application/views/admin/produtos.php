<div class="flex h-screen bg-gray-100">
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
        <div class="p-4 text-2xl font-bold border-b border-gray-700">Admin Panel</div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="/admin" class="block py-2 px-4 hover:bg-gray-700 rounded text-gray-300">Dashboard</a>
            <a href="/admin/produtos" class="block py-2 px-4 bg-gray-700 rounded text-white">Produtos</a>
            <a href="/admin/categorias" class="block py-2 px-4 hover:bg-gray-700 rounded text-gray-300">Categorias</a>
            <a href="/admin/vendas" class="block py-2 px-4 hover:bg-gray-700 rounded text-gray-300">Vendas</a>
            <a href="/admin/banners" class="block py-2 px-4 bg-gray-700 rounded text-white">Banners</a>
            <a href="/" class="block py-2 px-4 mt-8 bg-blue-600 hover:bg-blue-700 rounded text-center">Ir para Loja</a>
        </nav>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        <h1 class="text-2xl font-bold mb-6">Gerenciar Produtos</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Formulário -->
            <div class="bg-white p-6 rounded shadow lg:col-span-1 h-fit">
                <h2 class="text-lg font-bold mb-4 border-b pb-2" id="formTitle">Novo Produto</h2>
                <form action="/admin/salvar_produto" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="prodId">
                    
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Nome</label>
                        <input type="text" name="nome" id="prodNome" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Categoria</label>
                        <select name="categoria_id" id="prodCat" class="w-full border rounded p-2">
                            <?php foreach($data['categorias'] as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>"><?php echo $cat['nome']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Preço</label>
                        <input type="number" step="0.01" name="preco" id="prodPreco" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Estoque</label>
                        <input type="number" name="quantidade_estoque" id="prodQtd" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Descrição</label>
                        <textarea name="descricao" id="prodDesc" rows="3" class="w-full border rounded p-2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Imagem</label>
                        <input type="file" name="imagem" class="w-full text-sm">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full">Salvar</button>
                        <button type="button" onclick="limparForm()" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Limpar</button>
                    </div>
                </form>
            </div>

            <!-- Lista -->
            <div class="bg-white p-6 rounded shadow lg:col-span-2">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="p-3">ID</th>
                            <th class="p-3">Imagem</th>
                            <th class="p-3">Nome</th>
                            <th class="p-3">Preço</th>
                            <th class="p-3">Estoque</th>
                            <th class="p-3 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['produtos'] as $prod): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 font-bold"><?php echo $prod['id']; ?></td>
                            <td class="p-3">
                                <?php if($prod['imagem']): ?>
                                    <img src="/assets/img/<?php echo $prod['imagem']; ?>" class="w-10 h-10 object-cover rounded">
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs">Sem img</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-3"><?php echo $prod['nome']; ?></td>
                            <td class="p-3">R$ <?php echo number_format($prod['preco'], 2, ',', '.'); ?></td>
                            <td class="p-3 <?php echo $prod['quantidade_estoque'] < 5 ? 'text-red-500 font-bold' : ''; ?>">
                                <?php echo $prod['quantidade_estoque']; ?>
                            </td>
                            <td class="p-3 text-right space-x-2">
                                <button onclick='editar(<?php echo json_encode($prod); ?>)' class="text-blue-600 hover:underline">Editar</button>
                                <a href="/admin/deletar_produto/<?php echo $prod['id']; ?>" class="text-red-600 hover:underline" onclick="return confirm('Tem certeza?')">Excluir</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script>
    function editar(prod) {
        document.getElementById('formTitle').innerText = 'Editar Produto #' + prod.id;
        document.getElementById('prodId').value = prod.id;
        document.getElementById('prodNome').value = prod.nome;
        document.getElementById('prodCat').value = prod.categoria_id;
        document.getElementById('prodPreco').value = prod.preco;
        document.getElementById('prodQtd').value = prod.quantidade_estoque;
        document.getElementById('prodDesc').value = prod.descricao;
    }

    function limparForm() {
        document.getElementById('formTitle').innerText = 'Novo Produto';
        document.querySelector('form').reset();
        document.getElementById('prodId').value = '';
    }
</script>