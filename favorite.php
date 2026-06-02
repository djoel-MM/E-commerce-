<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "ecommerce_db");

if(!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = (int) $_SESSION['user']['id'];

$query = mysqli_query($conn, "
    SELECT p.*
    FROM favorite_products fp
    JOIN products p ON fp.product_id = p.id
    WHERE fp.user_id = $user_id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Daftar Favorit</title>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .product-card-horizontal {
            transition: all 0.3s ease;
        }
        .product-card-horizontal:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen pb-20">
    
    
    <div class="max-w-7xl mx-auto px-4 py-6">
        <?php if (mysqli_num_rows($query) === 0): ?>
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-32 h-32 bg-gradient-to-br from-red-50 to-pink-50 rounded-full flex items-center justify-center mx-auto mb-8">
                    <i class="fas fa-heart text-red-300 text-5xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-4">Belum ada produk favorit ❤️</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-10 text-lg">
                    Anda belum menambahkan produk apapun ke daftar favorit.
                </p>
                <a href="index.php" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-xl hover:from-blue-600 hover:to-blue-700 transition shadow-lg">
                    <i class="fas fa-store mr-3 text-lg"></i>
                    Jelajahi Produk
                </a>
            </div>
        <?php else: ?>
            <!-- Horizontal Products Grid -->
            <div class="space-y-4">
                <?php while ($product = mysqli_fetch_assoc($query)): ?>
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden product-card-horizontal">
                        <div class="flex flex-col md:flex-row">
                            <!-- Product Image -->
                            <div class="md:w-1/4 lg:w-1/5 relative">
                                <img src="<?= htmlspecialchars($product['image']) ?>" 
                                     alt="<?= htmlspecialchars($product['name']) ?>" 
                                     class="w-full h-48 md:h-full object-cover">
                                
                                <!-- Quick Action Overlay -->
                                <div class="absolute top-4 right-4">
                                    <button class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-blue-50 transition"
                                            onclick="addToCart(<?= $product['id'] ?>)"
                                            title="Tambah ke Keranjang">
                                        <i class="fas fa-cart-plus text-blue-600 text-sm"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="md:w-3/4 lg:w-4/5 p-5 md:p-6">
                                <div class="flex flex-col h-full">
                                    <!-- Top Section -->
                                    <div class="flex justify-between items-start mb-3">
                                        <span class="text-xs bg-blue-50 text-blue-700 px-3 py-1 rounded-full font-medium">
                                            <?= isset($product['category']) ? htmlspecialchars($product['category']) : 'General' ?>
                                        </span>
                                        
                                        <?php if(isset($product['stock']) && $product['stock'] > 0): ?>
                                            <span class="text-xs bg-green-50 text-green-700 px-3 py-1 rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Stok: <?= $product['stock'] ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-xs bg-red-50 text-red-700 px-3 py-1 rounded-full font-medium">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Habis
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Product Name -->
                                    <h3 class="text-lg font-bold text-gray-800 mb-2">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </h3>
                                    
                                    <!-- Description -->
                                    <?php if(isset($product['description']) && !empty($product['description'])): ?>
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                            <?= htmlspecialchars($product['description']) ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <!-- Price and Actions -->
                                    <div class="flex flex-col md:flex-row md:items-center justify-between mt-auto">
                                        <!-- Price -->
                                        <div class="mb-4 md:mb-0">
                                            <div class="text-xl font-bold text-blue-600">
                                                Rp <?= number_format($product['price'], 0, ',', '.') ?>
                                            </div>
                                            <?php if(isset($product['original_price']) && $product['original_price'] > $product['price']): ?>
                                                <div class="text-sm text-gray-400 line-through">
                                                    Rp <?= number_format($product['original_price'], 0, ',', '.') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Action Buttons -->
                                        <div class="flex space-x-3">
                                            <form action="wishlist_toggle.php" method="POST" class="w-full md:w-auto">
                                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                                <button type="submit" 
                                                        class="w-full md:w-auto px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-xl font-medium transition shadow-md hover:shadow-lg">
                                                    <i class="fas fa-trash-alt mr-2"></i>
                                                    Hapus dari Favorit
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            
            <!-- Summary -->
            <div class="mt-8 bg-white rounded-xl shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-gray-800">Total Produk Favorit</h3>
                        <p class="text-gray-600 text-sm"><?= mysqli_num_rows($query) ?> produk tersimpan</p>
                    </div>
                    <a href="index.php" class="text-blue-600 hover:text-blue-800 font-medium">
                        <i class="fas fa-plus-circle mr-2"></i>Tambah Lagi
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bottom Navigation -->
     <!-- Bottom Navigation -->
    <nav class="fixed bottom-0 left-0 right-0 bg-white shadow-2xl border-t border-gray-200 py-3 px-4 z-50">
        <div class="flex justify-between items-center max-w-md mx-auto">
            <!-- Home -->
            <a href="homepage.php" class="flex flex-col items-center  text-gray-600 hover:text-blue-600 relative">
                <i class="fas fa-home text-lg mb-1"></i>
                <span class="text-xs">Beranda</span>
            </a>
            
            <!-- Cart -->
            <a href="#" class="flex flex-col items-center text-gray-600 hover:text-blue-600 relative">
                <i class="fas fa-shopping-cart text-lg mb-1"></i>
                <span class="text-xs">Keranjang</span>
                <span id="cart-count" class="absolute -top-1 -right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center hidden">0</span>
            </a>
            
            <!-- Add Product -->
            <div class="relative -top-6">
                <button onclick="window.location.href='upload.php'" 
                        class="w-14 h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-plus text-xl"></i>
                </button>
            </div>
            
            <!-- Wishlist -->
            <a href="favorite.php" class="flex flex-col items-center text-gray-600 hover:text-blue-600">
                <i class="fas fa-heart text-lg mb-1"></i>
                <span class="text-xs">Favorit</span>
            </a>
            
            <!-- User -->
            <a href="user.php" class="flex flex-col items-center text-gray-600 hover:text-blue-600">
                <i class="fas fa-user text-lg mb-1"></i>
                <span class="text-xs">User</span>
            </a>
        </div>
    </nav>
    <!-- Notification Container -->
    <div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <script>
        
        
        function showNotification(message, type = 'info') {
            const container = document.getElementById('notification-container');
            const notification = document.createElement('div');
            
            let bgColor = 'bg-blue-500';
            let icon = 'fa-info-circle';
            
            if (type === 'success') {
                bgColor = 'bg-green-500';
                icon = 'fa-check-circle';
            } else if (type === 'error') {
                bgColor = 'bg-red-500';
                icon = 'fa-exclamation-circle';
            }
            
            notification.className = `${bgColor} text-white px-4 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${icon} mr-2"></i>
                    <span class="font-medium">${message}</span>
                </div>
            `;
            
            container.appendChild(notification);
            
            // Show notification
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 10);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
        
       
        
    </script>
</body>
</html>