<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MyAccount</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        .input-focus:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    
    <!-- Login Container -->
    <div class="w-full max-w-md">
        <!-- Logo / Brand -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white mb-4">
                <i class="fas fa-user-lock text-3xl text-purple-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-white">Welcome Back</h1>
            <p class="text-white/80 mt-2">Sign in to your account</p>
        </div>
        
        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden card-hover">
            <!-- Decorative Header -->
            <div class="h-2 bg-gradient-to-r from-purple-600 to-blue-500"></div>
            
            <!-- Form Container -->
            <div class="p-8">
                <!-- Login Form -->
                <form action="proses_login.php" method="POST" class="space-y-6">
                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-gray-400"></i>Email Address
                        </label>
                        <div class="relative">
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   placeholder="you@example.com" 
                                   required
                                   class="w-full px-4 py-3 pl-11 border border-gray-300 rounded-lg focus:outline-none input-focus
                                          transition duration-300 ease-in-out">
                            <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                    
                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-key mr-2 text-gray-400"></i>Password
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   placeholder="••••••••" 
                                   required
                                   class="w-full px-4 py-3 pl-11 border border-gray-300 rounded-lg focus:outline-none input-focus
                                          transition duration-300 ease-in-out">
                            <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <button type="button" 
                                    onclick="togglePassword()"
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Remember & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="remember"
                                   class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Remember me
                            </label>
                        </div>
                        <a href="#" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                            Forgot password?
                        </a>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" 
                            name="login"
                            class="w-full gradient-bg text-white py-3 px-4 rounded-lg font-semibold
                                   hover:opacity-90 transition duration-300 ease-in-out
                                   flex items-center justify-center space-x-2">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Sign In</span>
                    </button>
                </form>
                
                <!-- Divider -->
                <div class="my-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Or continue with</span>
                        </div>
                    </div>
                </div>
                
                <!-- Social Login -->
                <div class="grid grid-cols-2 gap-3 mb-8">
                    <button type="button" 
                            class="flex items-center justify-center space-x-2 p-3 border border-gray-300 rounded-lg
                                   hover:bg-gray-50 transition duration-300">
                        <i class="fab fa-google text-red-500"></i>
                        <span class="text-sm font-medium">Google</span>
                    </button>
                    <button type="button" 
                            class="flex items-center justify-center space-x-2 p-3 border border-gray-300 rounded-lg
                                   hover:bg-gray-50 transition duration-300">
                        <i class="fab fa-facebook text-blue-600"></i>
                        <span class="text-sm font-medium">Facebook</span>
                    </button>
                </div>
                
                <!-- Register Link -->
                <div class="text-center pt-6 border-t border-gray-200">
                    <p class="text-gray-600">
                        Don't have an account?
                        <a href="register.php" 
                           class="text-purple-600 hover:text-purple-800 font-semibold ml-1">
                            Create Account
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </p>
                </div>
            </div>
            
            <!-- Bottom Decoration -->
            <div class="h-2 bg-gradient-to-r from-blue-500 to-purple-600"></div>
        </div>
        
        <!-- Security Notice -->
        <div class="mt-6 text-center">
            <p class="text-white/70 text-sm">
                <i class="fas fa-shield-alt mr-1"></i>
                Your security is our priority. We use encryption to protect your data.
            </p>
        </div>
    </div>
    
    <!-- JavaScript for Toggle Password -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        // Add focus effects
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-purple-300');
                });
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-purple-300');
                });
            });
        });
    </script>
</body>
</html>