<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
        <div class="p-4 text-2xl font-bold border-b border-gray-700">Admin Panel</div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="/admin" class="block py-2 px-4 bg-gray-700 rounded text-white">Dashboard</a>
            <a href="/admin/produtos" class="block py-2 px-4 hover:bg-gray-700 rounded text-gray-300">Produtos</a>
            <a href="/admin/categorias" class="block py-2 px-4 hover:bg-gray-700 rounded text-gray-300">Categorias</a>
            <a href="/admin/vendas" class="block py-2 px-4 hover:bg-gray-700 rounded text-gray-300">Vendas</a>
            <a href="/" class="block py-2 px-4 mt-8 bg-blue-600 hover:bg-blue-700 rounded text-center">Ir para Loja</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Visão Geral</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card Faturamento -->
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                <p class="text-gray-500 text-sm font-semibold uppercase">Faturamento Total</p>
                <h2 class="text-2xl font-bold text-gray-800">R$ <?php echo number_format($data['stats']['faturamento'], 2, ',', '.'); ?></h2>
            </div>

            <!-- Card Vendas -->
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                <p class="text-gray-500 text-sm font-semibold uppercase">Vendas Realizadas</p>
                <h2 class="text-2xl font-bold text-gray-800"><?php echo $data['stats']['vendas']; ?></h2>
            </div>

            <!-- Card Produtos -->
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
                <p class="text-gray-500 text-sm font-semibold uppercase">Produtos Cadastrados</p>
                <h2 class="text-2xl font-bold text-gray-800"><?php echo $data['stats']['produtos']; ?></h2>
            </div>

            <!-- Card Usuários -->
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
                <p class="text-gray-500 text-sm font-semibold uppercase">Usuários</p>
                <h2 class="text-2xl font-bold text-gray-800"><?php echo $data['stats']['usuarios']; ?></h2>
            </div>
        </div>
    </main>
</div>