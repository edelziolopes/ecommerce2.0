<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
        <div class="p-4 text-2xl font-bold border-b border-gray-700">Admin Panel</div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="/admin" class="block py-2 px-4 hover:bg-gray-700 rounded text-gray-300">Dashboard</a>
            <a href="/admin/produtos" class="block py-2 px-4 hover:bg-gray-700 rounded text-gray-300">Produtos</a>
            <a href="/admin/categorias" class="block py-2 px-4 hover:bg-gray-700 rounded text-gray-300">Categorias</a>
            <a href="/admin/vendas" class="block py-2 px-4 hover:bg-gray-700 rounded text-gray-300">Vendas</a>
            <a href="/admin/banners" class="block py-2 px-4 bg-gray-700 rounded text-white">Banners</a>
            <a href="/" class="block py-2 px-4 mt-8 bg-blue-600 hover:bg-blue-700 rounded text-center">Ir para Loja</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Gerenciar Banners</h1>
            <button onclick="openModal()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                + Novo Banner
            </button>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagem</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($data['banners'] as $banner): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="/assets/img/<?php echo $banner['imagem']; ?>" alt="Banner" class="h-16 w-32 object-cover rounded">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo $banner['link'] ?: '-'; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $banner['status'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                    <?php echo $banner['status'] ? 'Ativo' : 'Inativo'; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="/admin/toggle_banner/<?php echo $banner['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-4">
                                    <?php echo $banner['status'] ? 'Desativar' : 'Ativar'; ?>
                                </a>
                                <a href="/admin/deletar_banner/<?php echo $banner['id']; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Modal -->
<div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Adicionar Banner</h3>
            <form action="/admin/salvar_banner" method="POST" enctype="multipart/form-data" class="mt-2 text-left">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="imagem">
                        Imagem
                    </label>
                    <input type="file" name="imagem" id="imagem" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="link">
                        Link (Opcional)
                    </label>
                    <input type="text" name="link" id="link" placeholder="#loja" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="status" checked class="form-checkbox h-5 w-5 text-blue-600">
                        <span class="ml-2 text-gray-700">Ativo</span>
                    </label>
                </div>
                <div class="flex items-center justify-between mt-4">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Cancelar</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
    }
</script>
