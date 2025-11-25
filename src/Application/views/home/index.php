<div class="mb-8">
    <!-- Banner Promocional -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg shadow-lg p-8 mb-10 text-white flex flex-col md:flex-row items-center justify-between">
        <div>
            <h2 class="text-4xl font-bold mb-2">Ofertas da Semana!</h2>
            <p class="text-lg opacity-90">Hardware e periféricos com até 30% de desconto.</p>
        </div>
        <a href="#produtos" class="mt-4 md:mt-0 bg-white text-blue-600 font-bold py-2 px-6 rounded-full hover:bg-gray-100 transition">
            Ver Ofertas
        </a>
    </div>

    <!-- Título e Filtros -->
    <div id="produtos" class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800 border-l-4 border-blue-600 pl-4">Nossos Produtos</h2>
        
        <!-- Botões de Categoria -->
        <div class="flex flex-wrap gap-2">
            <button onclick="filtrarProdutos('todos')" 
                    class="btn-filtro bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-semibold transition hover:bg-blue-700 shadow-sm ring-2 ring-blue-600 ring-offset-2">
                Todos
            </button>
            
            <?php foreach ($data['categorias'] as $cat): ?>
                <button onclick="filtrarProdutos(<?php echo $cat['id']; ?>)" 
                        class="btn-filtro bg-white text-gray-600 px-4 py-2 rounded-full text-sm font-semibold transition hover:bg-gray-100 hover:text-blue-600 shadow-sm border border-gray-200">
                    <?php echo $cat['nome']; ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Grid de Produtos (Container onde o JS vai injetar o HTML) -->
    <div id="grid-produtos" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 min-h-[300px]">
        
        <!-- Loop PHP Inicial (Server Side Render) -->
        <?php if (empty($data['produtos'])): ?>
            <div class="col-span-full bg-yellow-50 border border-yellow-200 text-yellow-700 p-6 rounded-lg text-center">
                <p class="text-lg">Nenhum produto disponível no momento.</p>
            </div>
        <?php else: ?>
            <?php foreach ($data['produtos'] as $produto): ?>
                <!-- Card do Produto (Mantendo o mesmo design) -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="h-56 bg-gray-50 relative overflow-hidden flex items-center justify-center p-4">
                        <?php if(!empty($produto['imagem'])): ?>
                            <img src="/assets/img/<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>" class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-500">
                        <?php else: ?>
                            <div class="text-gray-300 flex flex-col items-center">
                                <span class="text-sm">Sem Foto</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-5">
                        <span class="text-xs font-bold text-blue-500 uppercase tracking-wider">Tech</span>
                        <h3 class="text-lg font-bold text-gray-800 mt-1 truncate"><?php echo $produto['nome']; ?></h3>
                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-xs line-through">R$ <?php echo number_format($produto['preco'] * 1.2, 2, ',', '.'); ?></p>
                                <p class="text-2xl font-bold text-gray-900">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                            </div>
                        </div>
                        <a href="/produto/detalhes/<?php echo $produto['id']; ?>" class="mt-5 w-full block text-center border-2 border-blue-600 text-blue-600 font-bold py-2 px-4 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200">
                            Ver Detalhes
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>

<!-- JAVASCRIPT AJAX -->
<script>
    async function filtrarProdutos(id) {
        // 1. Atualizar visual dos botões
        const botoes = document.querySelectorAll('.btn-filtro');
        botoes.forEach(btn => {
            btn.classList.remove('bg-blue-600', 'text-white', 'ring-2', 'ring-blue-600', 'ring-offset-2');
            btn.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-200');
            
            if(btn.getAttribute('onclick').includes(`'${id}'`) || btn.getAttribute('onclick').includes(`(${id})`)) {
                btn.classList.remove('bg-white', 'text-gray-600', 'border', 'border-gray-200');
                btn.classList.add('bg-blue-600', 'text-white', 'ring-2', 'ring-blue-600', 'ring-offset-2');
            }
        });

        const grid = document.getElementById('grid-produtos');
        
        // 2. Loading State
        grid.innerHTML = `
            <div class="col-span-full flex justify-center items-center py-20">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            </div>
        `;

        try {
            // 3. Chamada AJAX
            const response = await fetch(`/home/filtrar/${id}`);

            if (!response.ok) {
                throw new Error(`Erro HTTP: ${response.status} - ${response.statusText}`);
            }

            // Lê como texto primeiro para evitar erro de JSON inválido silencioso
            const textData = await response.text();
            let produtos;

            try {
                produtos = JSON.parse(textData);
            } catch (jsonError) {
                console.error("Resposta do servidor não é JSON:", textData);
                throw new Error("Resposta inválida do servidor. Verifique o console.");
            }

            // 4. Limpa o grid
            grid.innerHTML = '';

            if (produtos.length === 0) {
                grid.innerHTML = `
                    <div class="col-span-full bg-gray-50 border border-gray-200 text-gray-600 p-8 rounded-lg text-center">
                        <p class="text-xl font-semibold">Nenhum produto encontrado nesta categoria.</p>
                        <button onclick="filtrarProdutos('todos')" class="mt-4 text-blue-600 hover:underline">Limpar filtros</button>
                    </div>
                `;
                return;
            }

            // 5. Reconstrói o HTML
            produtos.forEach(produto => {
                const preco = parseFloat(produto.preco).toLocaleString('pt-BR', { minimumFractionDigits: 2 });
                const precoAntigo = (parseFloat(produto.preco) * 1.2).toLocaleString('pt-BR', { minimumFractionDigits: 2 });

                const html = `
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group animate-fade-in">
                    <div class="h-56 bg-gray-50 relative overflow-hidden flex items-center justify-center p-4">
                        ${produto.imagem 
                            ? `<img src="/assets/img/${produto.imagem}" alt="${produto.nome}" class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-500">`
                            : `<div class="text-gray-300 flex flex-col items-center"><span class="text-sm">Sem Foto</span></div>`
                        }
                    </div>
                    <div class="p-5">
                        <span class="text-xs font-bold text-blue-500 uppercase tracking-wider">Tech</span>
                        <h3 class="text-lg font-bold text-gray-800 mt-1 truncate">${produto.nome}</h3>
                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-xs line-through">R$ ${precoAntigo}</p>
                                <p class="text-2xl font-bold text-gray-900">R$ ${preco}</p>
                            </div>
                        </div>
                        <a href="/produto/detalhes/${produto.id}" class="mt-5 w-full block text-center border-2 border-blue-600 text-blue-600 font-bold py-2 px-4 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200">
                            Ver Detalhes
                        </a>
                    </div>
                </div>
                `;
                grid.innerHTML += html;
            });

        } catch (error) {
            console.error('Erro detalhado:', error);
            grid.innerHTML = `
                <div class="col-span-full text-center text-red-600 p-4 border border-red-200 bg-red-50 rounded">
                    <p class="font-bold">Ocorreu um erro ao carregar os produtos.</p>
                    <p class="text-sm mt-2 text-gray-700">${error.message}</p>
                    <p class="text-xs mt-1 text-gray-500">Verifique o Console do Navegador (F12) para ver a resposta bruta.</p>
                </div>
            `;
        }
    }
</script>

<style>
    /* Animação simples para suavizar a entrada dos cards */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>