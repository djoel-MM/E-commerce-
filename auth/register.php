<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MyAccount</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md">
        <!-- Logo / Brand -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white mb-4">
                <i class="fas fa-user-plus text-3xl text-purple-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-white">Buat Akun Baru</h1>
            <p class="text-white/80 mt-2">Mulai perjalanan Anda bersama kami</p>
        </div>
        
        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Decorative Header -->
            <div class="h-2 bg-gradient-to-r from-purple-600 to-blue-500"></div>
            
            <!-- Form Container -->
            <div class="p-8">
                <!-- Register Form -->
                <form action="proses_register.php" method="POST" id="registerForm">
                    <div class="space-y-4">
                        <!-- Name Input -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Lengkap
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       placeholder="Masukkan nama lengkap" 
                                       required
                                       class="w-full px-4 py-3 pl-11 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                                <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        
                        <!-- Email Input -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email Address
                            </label>
                            <div class="relative">
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       placeholder="you@example.com" 
                                       required
                                       class="w-full px-4 py-3 pl-11 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                                <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        
                        <!-- Password Input -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                Password
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       placeholder="Minimal 6 karakter" 
                                       required
                                       minlength="6"
                                       class="w-full px-4 py-3 pl-11 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                                <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        
                        <!-- Confirm Password Input -->
                        <div>
                            <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">
                                Konfirmasi Password
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="confirmPassword" 
                                       id="confirmPassword" 
                                       placeholder="Ketik ulang password" 
                                       required
                                       class="w-full px-4 py-3 pl-11 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                                <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            <div id="passwordMatchMessage" class="text-xs mt-1 hidden"></div>
                        </div>
                        
                        <!-- Terms & Conditions -->
                        <div class="flex items-start mt-4">
                            <input type="checkbox" 
                                   id="terms"
                                   required
                                   class="h-4 w-4 mt-1 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <label for="terms" class="ml-2 block text-sm text-gray-700">
                                Saya menyetujui Syarat & Ketentuan
                            </label>
                        </div>
                        
                        <!-- Error Message Display -->
                        <div id="errorMessage" class="text-red-500 text-sm hidden"></div>
                        
                        <!-- Submit Button -->
                        <button type="submit" 
                                name="register"
                                class="w-full bg-gradient-to-r from-purple-600 to-blue-500 text-white py-3 px-4 rounded-lg font-semibold
                                       hover:opacity-90 transition duration-300 mt-6">
                            <i class="fas fa-user-plus mr-2"></i>
                            Daftar Sekarang
                        </button>
                    </div>
                </form>
                
                <!-- Login Link -->
                <div class="text-center pt-6 border-t border-gray-200 mt-6">
                    <p class="text-gray-600">
                        Sudah punya akun?
                        <a href="login.php" 
                           class="text-purple-600 hover:text-purple-800 font-semibold ml-1">
                            Login Sekarang
                        </a>
                    </p>
                </div>
            </div>
            
            <!-- Bottom Decoration -->
            <div class="h-2 bg-gradient-to-r from-blue-500 to-purple-600"></div>
        </div>
    </div>
    
    <!-- JavaScript Sederhana -->
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const errorMessage = document.getElementById('errorMessage');
            const passwordMatchMessage = document.getElementById('passwordMatchMessage');
            
            // Reset error messages
            errorMessage.classList.add('hidden');
            errorMessage.textContent = '';
            passwordMatchMessage.classList.add('hidden');
            
            // Validasi password
            if (password.length < 6) {
                e.preventDefault();
                errorMessage.textContent = 'Password minimal 6 karakter!';
                errorMessage.classList.remove('hidden');
                return false;
            }
            
            // Validasi password match
            if (password !== confirmPassword) {
                e.preventDefault();
                passwordMatchMessage.textContent = 'Password tidak cocok!';
                passwordMatchMessage.classList.remove('hidden');
                passwordMatchMessage.className = 'text-red-500 text-xs mt-1';
                return false;
            }
            
            // Validasi terms
            if (!document.getElementById('terms').checked) {
                e.preventDefault();
                errorMessage.textContent = 'Anda harus menyetujui Syarat & Ketentuan!';
                errorMessage.classList.remove('hidden');
                return false;
            }
            
            return true;
        });
        
        // Real-time password match check
        document.getElementById('confirmPassword').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const passwordMatchMessage = document.getElementById('passwordMatchMessage');
            
            if (confirmPassword === '') {
                passwordMatchMessage.classList.add('hidden');
                return;
            }
            
            if (password === confirmPassword) {
                passwordMatchMessage.textContent = '✓ Password cocok';
                passwordMatchMessage.className = 'text-green-500 text-xs mt-1';
                passwordMatchMessage.classList.remove('hidden');
            } else {
                passwordMatchMessage.textContent = '✗ Password tidak cocok';
                passwordMatchMessage.className = 'text-red-500 text-xs mt-1';
                passwordMatchMessage.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>