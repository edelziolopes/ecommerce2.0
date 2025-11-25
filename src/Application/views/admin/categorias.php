<div class="flex h-screen bg-gray-100">
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
        <div class="p-4 text-2xl font-bold border-b border-gray-700">Admin Panel</div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="/admin" class="block py-2 px-4 hover:bg-gray-700 rounded text-gray-300">Dashboard</a>
            <a href="/admin/produtos" class="block py-2 px-4 hover:bg-gray-700 rounded text-gray-300">Produtos</a>
            <a href="/admin/categorias" class="block py-2 px-4 bg-gray-700 rounded text-white">Categorias</a>
            <a href="/admin/vendas" class="block py-2 px-4 hover:bg-gray-700 rounded text-gray-300">Vendas</a>
            <a href="/" class="block py-2 px-4 mt-8 bg-blue-600 hover:bg-blue-700 rounded text-center">Ir para Loja</a>
        </nav>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        <h1 class="text-2xl font-bold mb-6">Gerenciar Categorias</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded shadow h-fit">
                <h2 class="text-lg font-bold mb-4 border-b pb-2">Nova Categoria</h2>
                <form action="/admin/salvar_categoria" method="POST">
                    <input type="hidden" name="id" id="catId">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Nome da Categoria</label>
                        <input type="text" name="nome" id="catNome" class="w-full border rounded p-2" required>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Salvar</button>
                    <button type="button" onclick="document.querySelector('form').reset(); document.getElementById('catId').value=''" class="ml-2 text-gray-500">Limpar</button>
                </form>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <table class="w-full text-left">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="p-3">ID</th>
                            <th class="p-3">Nome</th>
                            <th class="p-3 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['categorias'] as $cat): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 font-bold"><?php echo $cat['id']; ?></td>
                            <td class="p-3"><?php echo $cat['nome']; ?></td>
                            <td class="p-3 text-right">
                                <button onclick="document.getElementById('catId').value='<?php echo $cat['id']; ?>'; document.getElementById('catNome').value='<?php echo $cat['nome']; ?>'" class="text-blue-600 hover:underline mr-2">Editar</button>
                                <a href="/admin/deletar_categoria/<?php echo $cat['id']; ?>" class="text-red-600 hover:underline" onclick="return confirm('Excluir esta categoria?')">Excluir</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>