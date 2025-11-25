<div class="min-h-[calc(100vh-200px)] flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Crie sua Conta</h2>
        
        <?php if(isset($data['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo $data['error']; ?>
            </div>
        <?php endif; ?>

        <form action="/auth/salvar" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nome Completo</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                       id="name" name="name" type="text" placeholder="João da Silva" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">E-mail</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                       id="email" name="email" type="email" placeholder="seu@email.com" required>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Senha</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" 
                       id="password" name="password" type="password" placeholder="********" required>
            </div>
            
            <div class="flex items-center justify-between">
                <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full transition" 
                        type="submit">
                    Cadastrar
                </button>
            </div>
        </form>
        
        <p class="text-center text-gray-600 text-sm mt-6">
            Já tem conta? <a href="/auth/login" class="text-blue-600 font-bold hover:underline">Faça Login</a>
        </p>
    </div>
</div>