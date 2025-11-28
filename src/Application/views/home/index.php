<div class="mb-8">
    <!-- Banner Promocional -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg shadow-lg p-8 mb-10 text-white flex flex-col md:flex-row items-center justify-between">
        <div>
            <h2 class="text-4xl font-bold mb-2">Ofertas da Semana!</h2>
            <p class="text-lg opacity-90">Hardware e periféricos com até 30% de desconto.</p>
        </div>
        <a href="#loja" class="mt-4 md:mt-0 bg-white text-blue-600 font-bold py-2 px-6 rounded-full hover:bg-gray-100 transition">
            Ver Ofertas
        </a>
    </div>

    <!-- Layout Principal: Grid com Sidebar e Conteúdo -->
    <div id="loja" class="flex flex-col lg:flex-row gap-8">
        
        <!-- SIDEBAR (FILTROS) -->
        <aside class="w-full lg:w-1/4">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 sticky top-24">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filtros
                </h3>

                <!-- Categorias -->
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-700 mb-2 text-sm uppercase">Categorias</h4>
                    <ul class="space-y-2">
                        <li>
                            <label class="flex items-center space-x-2 cursor-pointer hover:text-blue-600">
                                <input type="radio" name="categoria" value="todos" checked onchange="aplicarFiltros()" class="text-blue-600 focus:ring-blue-500">
                                <span>Todas as Categorias</span>
                            </label>
                        </li>
                        <?php foreach ($data['categorias'] as $cat): ?>
                        <li>
                            <label class="flex items-center space-x-2 cursor-pointer hover:text-blue-600">
                                <input type="radio" name="categoria" value="<?php echo $cat['id']; ?>" onchange="aplicarFiltros()" class="text-blue-600 focus:ring-blue-500">
                                <span><?php echo $cat['nome']; ?></span>
                            </label>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <hr class="border-gray-200 mb-6">

                <!-- Faixa de Preço -->
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-700 mb-2 text-sm uppercase">Faixa de Preço</h4>
                    <div class="flex gap-2 items-center mb-3">
                        <div class="relative w-full">
                            <span class="absolute inset-y-0 left-0 pl-2 flex items-center text-gray-500 text-xs">R$</span>
                            <input type="number" id="precoMin" placeholder="Mín" class="w-full pl-6 pr-2 py-1 border rounded text-sm focus:ring-1 focus:ring-blue-500 focus:outline-none">
                        </div>
                        <span class="text-gray-400">-</span>
                        <div class="relative w-full">
                            <span class="absolute inset-y-0 left-0 pl-2 flex items-center text-gray-500 text-xs">R$</span>
                            <input type="number" id="precoMax" placeholder="Máx" class="w-full pl-6 pr-2 py-1 border rounded text-sm focus:ring-1 focus:ring-blue-500 focus:outline-none">
                        </div>
                    </div>
                    <button onclick="aplicarFiltros()" class="w-full bg-blue-600 text-white py-2 rounded text-sm font-bold hover:bg-blue-700 transition">
                        Filtrar Preço
                    </button>
                </div>
            </div>
        </aside>

        <!-- GRID DE PRODUTOS -->
        <div class="w-full lg:w-3/4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Produtos Disponíveis</h2>
                <span id="contador-produtos" class="text-sm text-gray-500"><?php echo count($data['produtos']); ?> produto(s)</span>
            </div>

            <!-- Grid (Container do JS) -->
            <div id="grid-produtos" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Renderização Inicial PHP -->
                <?php if (empty($data['produtos'])): ?>
                    <div class="col-span-full bg-yellow-50 border border-yellow-200 text-yellow-700 p-6 rounded-lg text-center">
                        <p class="text-lg">Nenhum produto disponível no momento.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($data['produtos'] as $produto): ?>
                        <!-- Card Produto -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full">
                            <div class="h-48 bg-gray-50 relative overflow-hidden flex items-center justify-center p-4">
                                <?php if(!empty($produto['imagem'])): ?>
                                    <img src="/assets/img/<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>" class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-500">
                                <?php else: ?>
                                    <div class="text-gray-300 flex flex-col items-center"><span class="text-sm">Sem Foto</span></div>
                                <?php endif; ?>
                            </div>
                            <div class="p-4 flex flex-col flex-grow">
                                <span class="text-xs font-bold text-blue-500 uppercase tracking-wider">Tech</span>
                                <h3 class="text-base font-bold text-gray-800 mt-1 truncate"><?php echo $produto['nome']; ?></h3>
                                <div class="mt-auto pt-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <p class="text-xl font-bold text-gray-900">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                                    </div>
                                    <a href="/produto/detalhes/<?php echo $produto['id']; ?>" class="w-full block text-center border border-blue-600 text-blue-600 font-bold py-2 px-4 rounded hover:bg-blue-600 hover:text-white transition duration-200">
                                        Ver Detalhes
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<script>
    async function aplicarFiltros() {
        // 1. Coletar dados dos inputs
        const categoria = document.querySelector('input[name="categoria"]:checked').value;
        const min = document.getElementById('precoMin').value;
        const max = document.getElementById('precoMax').value;

        const grid = document.getElementById('grid-produtos');
        const contador = document.getElementById('contador-produtos');
        
        // 2. Loading State
        grid.innerHTML = `
            <div class="col-span-full flex flex-col justify-center items-center py-20">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                <p class="text-gray-500">Buscando produtos...</p>
            </div>
        `;

        try {
            // 3. Chamada AJAX (POST)
            const response = await fetch('/home/filtrar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    categoria: categoria,
                    min: min,
                    max: max
                })
            });

            if (!response.ok) throw new Error('Erro na requisição');

            const textData = await response.text();
            let produtos;
            try {
                produtos = JSON.parse(textData);
            } catch (e) {
                console.error("Erro JSON:", textData);
                throw new Error("Resposta inválida do servidor");
            }

            // 4. Atualizar UI
            grid.innerHTML = '';
            contador.innerText = `${produtos.length} produto(s)`;

            if (produtos.length === 0) {
                grid.innerHTML = `
                    <div class="col-span-full flex flex-col items-center justify-center bg-gray-50 border border-gray-200 text-gray-600 p-8 rounded-lg text-center h-64">
                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-lg font-semibold">Nenhum produto encontrado</p>
                        <p class="text-sm text-gray-500">Tente ajustar seus filtros de preço.</p>
                    </div>
                `;
                return;
            }

            produtos.forEach(produto => {
                const preco = parseFloat(produto.preco).toLocaleString('pt-BR', { minimumFractionDigits: 2 });
                
                const html = `
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full animate-fade-in">
                    <div class="h-48 bg-gray-50 relative overflow-hidden flex items-center justify-center p-4">
                        ${produto.imagem 
                            ? `<img src="/assets/img/${produto.imagem}" alt="${produto.nome}" class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-500">`
                            : `<div class="text-gray-300 flex flex-col items-center"><span class="text-sm">Sem Foto</span></div>`
                        }
                    </div>
                    <div class="p-4 flex flex-col flex-grow">
                        <span class="text-xs font-bold text-blue-500 uppercase tracking-wider">Tech</span>
                        <h3 class="text-base font-bold text-gray-800 mt-1 truncate" title="${produto.nome}">${produto.nome}</h3>
                        <div class="mt-auto pt-4">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-xl font-bold text-gray-900">R$ ${preco}</p>
                            </div>
                            <a href="/produto/detalhes/${produto.id}" class="w-full block text-center border border-blue-600 text-blue-600 font-bold py-2 px-4 rounded hover:bg-blue-600 hover:text-white transition duration-200">
                                Ver Detalhes
                            </a>
                        </div>
                    </div>
                </div>
                `;
                grid.innerHTML += html;
            });

        } catch (error) {
            console.error(error);
            grid.innerHTML = `<p class="text-red-500 text-center col-span-full">Erro ao carregar produtos: ${error.message}</p>`;
        }
    }
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.4s ease-out forwards;
    }
</style>