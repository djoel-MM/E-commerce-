<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "ecommerce_db");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$user_id = $_SESSION['user']['id'];

$favQuery = mysqli_query($conn, "
    SELECT product_id 
    FROM favorite_products 
    WHERE user_id = $user_id
");

$favIds = [];
while ($f = mysqli_fetch_assoc($favQuery)) {
    $favIds[] = $f['product_id'];
}

// Query untuk produk
$result = mysqli_query($conn, "SELECT * FROM products");


// Query untuk statistik dashboard
$totalProducts = mysqli_query($conn, "SELECT COUNT(*) as total FROM products");
$totalProductsData = mysqli_fetch_assoc($totalProducts);

// Query untuk total user - asumsi ada tabel users
$totalUsers = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$totalUsersData = mysqli_fetch_assoc($totalUsers);


$totalUserCount = isset($totalUsersData['total']) ? $totalUsersData['total'] : 0;

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Ecommerce</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen pb-20">
   

   <!-- Hero Section -->
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Welcome Header -->
    <div class="mb-10">
        <h1 class="text-3xl font-light text-gray-900">
            Selamat datang, <span class="font-semibold"><?= isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Pengguna' ?></span>
        </h1>
        <p class="text-gray-600 mt-2">Temukan produk terbaik untuk kebutuhan Anda</p>
    </div>

    <!-- Stats Cards - Minimalist -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <!-- Total Produk -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Produk</p>
                    <p class="text-2xl font-semibold text-gray-900"><?= $totalProductsData['total'] ?></p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-box text-blue-500 text-lg"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-400">Semua produk tersedia</p>
            </div>
        </div>

        <!-- Kategori Produk -->
        <?php
            $categoryQuery = mysqli_query($conn, "SELECT COUNT(DISTINCT category) as total FROM products");
            $categoryData = mysqli_fetch_assoc($categoryQuery);
        ?>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Kategori</p>
                    <p class="text-2xl font-semibold text-gray-900"><?= $categoryData['total'] ?></p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-tags text-emerald-500 text-lg"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-400">Variasi produk</p>
            </div>
        </div>

        <!-- Total User -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Pengguna</p>
                    <p class="text-2xl font-semibold text-gray-900"><?= $totalUserCount ?></p>
                </div>
                <div class="w-12 h-12 bg-violet-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-violet-500 text-lg"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-400">Pengguna aktif</p>
            </div>
        </div>
    </div>

    <!-- Search & Filter Section -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Produk Tersedia</h2>
                <p class="text-gray-500 text-sm mt-1">Jelajahi koleksi produk kami</p>
            </div>
            
            <div class="relative w-full md:w-96">
                <div class="relative">
                    <input type="text" 
                           placeholder="Cari produk..." 
                           class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 text-gray-900">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="mt-6 flex flex-wrap gap-2">
            <button class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium hover:bg-blue-100 transition-colors">
                Semua Produk
            </button>
            <button class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors">
                Terpopuler
            </button>
            <button class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors">
                Diskon
            </button>
            <button class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors">
                Terbaru
            </button>
        </div>
    </div>

  

   

        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php while($product = mysqli_fetch_assoc($result)) : ?>
                 <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <!-- Product Image -->
                    <div class="relative">
                        <img src="<?= htmlspecialchars($product['image']) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>" 
                             class="w-full h-48 object-cover">
                    </div>
                    
                    <!-- Product Info -->
                    <div class="p-4">
                        <div class="text-xs text-gray-500 mb-2">
                            <?= isset($product['category']) ? htmlspecialchars($product['category']) : 'General' ?>
                        </div>
                        
                        <!-- Product Name -->
                        <h3 class="font-bold text-gray-800 mb-2 truncate">
                            <?= htmlspecialchars($product['name']) ?>
                        </h3>
                        
                        <!-- Description -->
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                            <?= htmlspecialchars($product['description']) ?>
                        </p>
                        
                        <!-- Price -->
                        <div class="mb-4">
                            <div class="text-lg font-bold text-blue-600">
                                Rp <?= number_format($product['price'], 0, ',', '.') ?>
                            </div>
                        </div>
                        
                        <!-- Stock & Action -->
                        <div class="flex items-center justify-between">
                            <!-- Stock Status -->
                            <?php if(isset($product['stock']) && $product['stock'] > 0): ?>
                                <span class="text-xs text-green-600">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Stok: <?= $product['stock'] ?>
                                </span>
                            <?php else: ?>
                                <span class="text-xs text-red-600">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Habis
                                </span>
                            <?php endif; ?>
                            
                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <button class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200"
                                        onclick="addToCart(<?= $product['id'] ?>)"
                                        title="Tambah ke Keranjang">
                                    <i class="fas fa-cart-plus text-sm"></i>
                                </button>
                                <button class="w-8 h-8 rounded-full bg-red-100 text-red-500 flex items-center justify-center hover:bg-red-200 wishlist-btn"
                                        data-product-id="<?= $product['id'] ?>"
                                        
                                        onclick="toggleWishlist(this)"
                                        title="Tambahkan ke Wishlist">

                                  <i class="<?= in_array($product['id'], $favIds)
                                       ? 'fas fa-heart text-red-500'
                                       : 'far fa-heart text-gray-400' ?>">
                                 </i>

                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <nav class="fixed bottom-0 left-0 right-0 bg-white shadow-2xl border-t border-gray-200 py-3 px-4 z-50">
        <div class="flex justify-between items-center max-w-md mx-auto">
            <!-- Home -->
            <a href="#" class="flex flex-col items-center  text-gray-600 hover:text-blue-600 relative">
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

    <!-- Simple JavaScript -->
    <script>
       
        
        function addToCart(productId) {
           
            // Show notification
            showNotification('Produk ditambahkan ke keranjang', 'success');
            
            // Save to localStorage (simulasi)
            let cart = JSON.parse(localStorage.getItem('cart') || '[]');
            cart.push({id: productId, timestamp: new Date().getTime()});
            localStorage.setItem('cart', JSON.stringify(cart));
        }
        
       
        
        
       
     function toggleWishlist(button) {
    const heartIcon = button.querySelector('i');
    const productId = button.getAttribute('data-product-id');

    fetch("wishlist_toggle.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        credentials: "same-origin",
        body: "product_id=" + productId
    })
    .then(res => res.text())
    .then(() => {
        // Toggle icon (visual only)
        if (heartIcon.classList.contains('far')) {
            heartIcon.classList.remove('far');
            heartIcon.classList.add('fas', 'text-red-500');
            showNotification('Ditambahkan ke favorit', 'success');
        } else {
            heartIcon.classList.remove('fas', 'text-red-500');
            heartIcon.classList.add('far', 'text-gray-500');
            showNotification('Dihapus dari favorit', 'info');
        }
    })
    .catch(() => {
        showNotification('Gagal memproses favorit', 'error');
    });
}


        
        // Notification function
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
            
            notification.className = `${bgColor} text-white px-4 py-2 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${icon} mr-2"></i>
                    <span>${message}</span>
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
        
        // Initialize cart count from localStorage
        function initializeCart() {
            let cart = JSON.parse(localStorage.getItem('cart') || '[]');
            cartCount = cart.length;
            if (cartCount > 0) {
                updateCartCount();
            }
        }
        
        // Initialize wishlist buttons
        function initializeWishlist() {
            let wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
            
            document.querySelectorAll('.wishlist-btn').forEach(button => {
                const productId = button.getAttribute('data-product-id');
                const heartIcon = button.querySelector('i');
                
                if (wishlist.includes(productId)) {
                    heartIcon.classList.remove('far', 'text-gray-500');
                    heartIcon.classList.add('fas', 'text-red-500');
                }
            });
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeCart();
            initializeWishlist();
        });
    </script>
</body>
</html>