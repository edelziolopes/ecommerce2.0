<?php
ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loja MVC PHP</title>
  <link href="/assets/css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800 flex flex-col min-h-screen">

  <!-- Cabeçalho -->
  <header class="bg-blue-600 text-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <!-- Logo -->
      <a href="/" class="text-2xl font-bold flex items-center gap-2 hover:text-blue-100 transition">
         🛒 TechStore
      </a>
      
      <nav class="flex items-center gap-6">
        
        <!-- Link de Admin (Apenas se ID = 1) -->
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1): ?>
            <a href="/admin" class="bg-gray-900 text-white px-3 py-1 rounded text-sm hover:bg-gray-800 transition shadow border border-gray-700 flex items-center gap-1">
                ⚙️ Admin
            </a>
        <?php endif; ?>

        <a href="/" class="hover:text-blue-200 transition font-medium">Produtos</a>
        
        <!-- Carrinho -->
        <a href="/carrinho" class="hover:text-blue-200 transition flex items-center relative group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="bg-red-500 text-white text-xs rounded-full px-2 py-0.5 ml-1 font-bold absolute -top-2 -right-2 shadow-sm">
                <?php echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0; ?>
            </span>
        </a>

        <div class="border-l border-blue-400 h-6 mx-2 hidden sm:block"></div>

        <!-- Área do Usuário -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="flex items-center gap-4 relative group">
                <div class="text-right hidden sm:block">
                    <span class="block text-xs text-blue-200">Bem-vindo,</span>
                    <span class="block text-sm font-bold leading-tight"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                </div>
                
                <a href="/auth/logout" class="text-sm bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded transition shadow border border-blue-500">
                    Sair
                </a>
            </div>
        <?php else: ?>
            <div class="flex items-center gap-3 text-sm font-semibold">
                <a href="/auth/login" class="hover:underline text-white">Entrar</a>
                <a href="/auth/register" class="bg-white text-blue-600 px-4 py-2 rounded shadow hover:bg-gray-100 transition">
                    Cadastrar
                </a>
            </div>
        <?php endif; ?>

      </nav>
    </div>
  </header>

  <!-- Conteúdo Principal -->
  <main class="container mx-auto px-4 py-8 flex-grow">
      <?php
        require '../Application/autoload.php';
        
        spl_autoload_register(function ($class) {
            $file = '../' . str_replace('\\', '/', $class) . '.php';
            if (file_exists($file)) {
                require $file;
            }
        });

        use Application\core\App;
        
        $app = new App();
      ?>
  </main>

  <!-- Rodapé -->
  <footer class="bg-gray-800 text-gray-300 py-8 mt-12">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <h3 class="text-xl font-bold text-white">TechStore</h3>
                <p class="text-sm mt-2">A melhor tecnologia para você.</p>
            </div>
            <div class="text-sm">
                &copy; <?php echo date('Y'); ?> Todos os direitos reservados.
            </div>
        </div>
    </div>
  </footer>

</body>
</html>
<?php
ob_end_flush();
?>