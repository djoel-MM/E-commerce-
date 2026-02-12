<?php
$conn = mysqli_connect("localhost", "root", "", "ecommerce_db");
if (!$conn) {
    exit("Koneksi gagal");
}

// Ambil produk terpopuler
$featuredProducts = mysqli_query($conn, "SELECT * FROM products LIMIT 8");
$newArrivals = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC LIMIT 4");
$categories = mysqli_query($conn, "SELECT DISTINCT category, COUNT(*) as count FROM products GROUP BY category LIMIT 6");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueMart - Marketplace Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .bg-primary-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .bg-secondary-gradient {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        .btn-secondary {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }
        .category-card {
            transition: all 0.3s ease;
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.15);
        }
        .product-card {
            transition: all 0.3s ease;
        }
        .product-card:hover {
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.15);
            border-color: #667eea;
        }
        .nav-shadow {
            box-shadow: 0 2px 10px rgba(102, 126, 234, 0.08);
        }
        .text-primary {
            color: #667eea;
        }
        .border-primary {
            border-color: #667eea;
        }
        .bg-primary-light {
            background-color: rgba(102, 126, 234, 0.1);
        }
        .bg-purple-light {
            background-color: rgba(118, 75, 162, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white z-50 nav-shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="w-9 h-9 bg-primary-gradient rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-white"></i>
                    </div>
                    <span class="ml-3 text-xl font-bold text-gray-900">Blue<span class="text-primary">Mart</span></span>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-gray-700 hover:text-primary font-medium transition">Home</a>
                    <a href="#products" class="text-gray-700 hover:text-primary font-medium transition">Produk</a>
                    <a href="#categories" class="text-gray-700 hover:text-primary font-medium transition">Kategori</a>
                    <a href="#sellers" class="text-gray-700 hover:text-primary font-medium transition">Penjual</a>
                    <a href="#promo" class="text-gray-700 hover:text-primary font-medium transition">Promo</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    <a href="auth/login.php" 
                       class="px-5 py-2 text-gray-700 font-medium hover:text-primary transition">
                        <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                    </a>
                    <a href="auth/register.php" 
                       class="px-6 py-2 btn-primary text-white font-medium rounded-lg shadow-md">
                        <i class="fas fa-user-plus mr-2"></i>Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Banner -->
    <section id="home" class="pt-20">
        <div class="bg-primary-gradient">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="text-white">
                        <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                            Belanja Online 
                            <span class="text-blue-200">Mudah</span> & 
                            <span class="text-purple-200">Terpercaya</span>
                        </h1>
                        <p class="mt-6 text-lg opacity-90 max-w-lg">
                            Temukan jutaan produk dari berbagai kategori dengan harga terbaik. Pengalaman berbelanja yang aman dan menyenangkan.
                        </p>
                        <div class="mt-8">
                            <div class="relative max-w-md">
                                <input type="text" 
                                       placeholder="Cari produk, brand, atau kategori..." 
                                       class="w-full pl-12 pr-4 py-3 rounded-xl border-none focus:outline-none focus:ring-2 focus:ring-blue-300">
                                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-secondary-gradient text-white px-4 py-1.5 rounded-lg hover:opacity-90">
                                    Cari
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" 
                             alt="Online Shopping" 
                             class="rounded-2xl shadow-2xl">
                        <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-2xl shadow-xl">
                            <div class="text-3xl font-bold text-primary">500+</div>
                            <div class="text-gray-600">Produk Tersedia</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section id="categories" class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
                <?php 
                $categoryIcons = [
                    'Electronics' => 'fas fa-laptop',
                    'Fashion' => 'fas fa-tshirt',
                    'Home' => 'fas fa-home',
                    'Sports' => 'fas fa-basketball-ball',
                    'Beauty' => 'fas fa-spa',
                    'Books' => 'fas fa-book'
                ];
                
                $i = 0;
                while($cat = mysqli_fetch_assoc($categories)): 
                    $icon = $categoryIcons[$cat['category']] ?? 'fas fa-box';
                    $gradient = $i % 2 == 0 ? 'from-blue-500 to-blue-600' : 'from-purple-500 to-purple-600';
                ?>
                    <a href="auth/register.php" class="category-card">
                        <div class="bg-gradient-to-br <?= $gradient ?> text-white rounded-xl p-6 text-center hover:shadow-lg">
                            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                                <i class="<?= $icon ?> text-white text-xl"></i>
                            </div>
                            <h3 class="font-semibold"><?= $cat['category'] ?></h3>
                            <p class="text-sm opacity-80 mt-1"><?= $cat['count'] ?> produk</p>
                        </div>
                    </a>
                <?php $i++; endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="products" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Produk <span class="text-primary">Terpopuler</span></h2>
                    <p class="text-gray-600 mt-2">Produk paling laris dan banyak dicari</p>
                </div>
                <a href="auth/register.php" class="text-primary font-medium hover:text-purple-700">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <?php while($product = mysqli_fetch_assoc($featuredProducts)): ?>
                    <a href="auth/register.php" class="product-card">
                        <div class="bg-white rounded-lg overflow-hidden border border-gray-200 hover:border-primary">
                            <div class="relative aspect-square">
                                <img src="<?= htmlspecialchars($product['image']) ?>" 
                                     alt="<?= htmlspecialchars($product['name']) ?>" 
                                     class="w-full h-full object-cover">
                                
                                <?php if(isset($product['discount']) && $product['discount'] > 0): ?>
                                    <div class="absolute top-2 left-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs px-2 py-1 rounded">
                                        -<?= $product['discount'] ?>%
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="p-3">
                                <h3 class="text-sm text-gray-900 font-medium line-clamp-2 mb-2">
                                    <?= htmlspecialchars($product['name']) ?>
                                </h3>
                                
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-base font-bold text-gray-900">
                                            Rp <?= number_format($product['price'], 0, ',', '.') ?>
                                        </div>
                                        <?php if(isset($product['original_price']) && $product['original_price'] > $product['price']): ?>
                                            <div class="text-xs text-gray-400 line-through">
                                                Rp <?= number_format($product['original_price'], 0, ',', '.') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="text-xs text-gray-500">
                                        <i class="fas fa-star text-yellow-400"></i> 4.8
                                    </div>
                                </div>
                                
                                <div class="mt-2 text-xs text-gray-500">
                                    Terjual <?= rand(50, 500) ?>
                                </div>
                                
                                <div class="mt-3">
                                    <span class="text-xs px-2 py-1 bg-primary-light text-primary rounded">Gratis Ongkir</span>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- New Arrivals -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Baru <span class="text-purple-600">Datang</span></h2>
                    <p class="text-gray-600 mt-2">Produk terbaru yang baru ditambahkan</p>
                </div>
                <a href="auth/register.php" class="text-primary font-medium hover:text-purple-700">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php mysqli_data_seek($newArrivals, 0); while($product = mysqli_fetch_assoc($newArrivals)): ?>
                    <div class="product-card bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-lg">
                        <div class="relative h-48">
                            <img src="<?= htmlspecialchars($product['image']) ?>" 
                                 alt="<?= htmlspecialchars($product['name']) ?>" 
                                 class="w-full h-full object-cover">
                            <div class="absolute top-4 left-4">
                                <span class="bg-gradient-to-r from-blue-500 to-purple-500 text-white text-xs px-2 py-1 rounded">NEW</span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-2 line-clamp-1">
                                <?= htmlspecialchars($product['name']) ?>
                            </h3>
                            
                            <div class="flex items-center mb-3">
                                <div class="flex text-yellow-400">
                                    <?php for($j = 0; $j < 5; $j++): ?>
                                        <i class="fas fa-star text-sm"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="text-xs text-gray-500 ml-2">(<?= rand(10, 100) ?>)</span>
                            </div>
                            
                            <div class="text-lg font-bold text-primary">
                                Rp <?= number_format($product['price'], 0, ',', '.') ?>
                            </div>
                            
                            <a href="auth/register.php" 
                               class="mt-4 w-full py-2 bg-primary-light text-primary font-medium rounded-lg text-center hover:bg-blue-100 transition block">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16 bg-gradient-to-br from-blue-50 to-purple-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Mengapa Memilih <span class="text-primary">BlueMart</span>?</h2>
                <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Kami memberikan pengalaman berbelanja terbaik untuk Anda</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-primary text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">100% Aman</h3>
                    <p class="text-gray-600 text-sm">Transaksi terjamin dengan sistem keamanan terbaik</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-light rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-truck text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Gratis Ongkir</h3>
                    <p class="text-gray-600 text-sm">Gratis pengiriman untuk pesanan di atas Rp 100.000</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-primary text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Support 24/7</h3>
                    <p class="text-gray-600 text-sm">Customer service siap membantu kapan saja</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-light rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-undo text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Garansi 30 Hari</h3>
                    <p class="text-gray-600 text-sm">Garansi pengembalian uang hingga 30 hari</p>
                </div>
            </div>
        </div>
    </section>

   

    <!-- CTA Section -->
    <section class="py-20 bg-primary-gradient">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Bergabunglah dengan <span class="text-blue-200">Jutaan Pengguna</span> BlueMart
            </h2>
            <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto">
                Mulai berbelanja dengan mudah dan nikmati berbagai penawaran menarik
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="auth/register.php" 
                   class="px-8 py-3 bg-white text-primary font-bold rounded-xl hover:bg-gray-100 transition shadow-lg">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                </a>
                <a href="auth/login.php" 
                   class="px-8 py-3 bg-transparent border-2 border-white text-white font-bold rounded-xl hover:bg-white/10 transition">
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                </a>
            </div>
            <p class="text-blue-100 mt-6 text-sm">
                Gratis biaya pendaftaran • Proses cepat • Mulai berjualan
            </p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <div class="w-9 h-9 bg-primary-gradient rounded-lg flex items-center justify-center">
                            <i class="fas fa-shopping-bag text-white"></i>
                        </div>
                        <span class="ml-3 text-xl font-bold">Blue<span class="text-blue-400">Mart</span></span>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Marketplace terpercaya dengan jutaan produk berkualitas dari berbagai penjual.
                    </p>
                    <div class="flex space-x-4 mt-6">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook text-lg"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram text-lg"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter text-lg"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-youtube text-lg"></i></a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4 text-blue-300">Beli</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm">Semua Kategori</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm">Produk Terlaris</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm">Flash Sale</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm">Cashback</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4 text-purple-300">Jual</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm">Mulai Berjualan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm">Panduan Penjual</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm">Promo Toko</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm">Komisi</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4 text-blue-300">Bantuan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm">Pusat Bantuan</a></li>
                        <li><a href="auth/login.php" class="text-gray-400 hover:text-white text-sm">Masuk</a></li>
                        <li><a href="auth/register.php" class="text-gray-400 hover:text-white text-sm">Daftar</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; <?= date('Y') ?> BlueMart. All rights reserved. • <a href="#" class="text-blue-400 hover:text-blue-300">Privacy Policy</a> • <a href="#" class="text-purple-400 hover:text-purple-300">Terms of Service</a></p>
                <p class="mt-2">Jl. Sudirman No. 123, Jakarta Selatan • support@bluemart.com • 1500-123</p>
            </div>
        </div>
    </footer>

    <!-- Floating Cart & Chat -->
    <div class="fixed bottom-8 right-8 flex flex-col gap-3">
        <button onclick="window.location.href='auth/register.php'" 
                class="w-12 h-12 bg-primary-gradient text-white rounded-full shadow-lg hover:opacity-90 transition flex items-center justify-center">
            <i class="fas fa-shopping-cart"></i>
        </button>
        <button class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full shadow-lg hover:opacity-90 transition flex items-center justify-center">
            <i class="fas fa-comment"></i>
        </button>
    </div>

    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if(targetId !== '#') {
                    const targetElement = document.querySelector(targetId);
                    if(targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
        
        // Flash sale timer
        function updateFlashSaleTimer() {
            const timerElement = document.getElementById('flashSaleTimer');
            if(timerElement) {
                // Implement timer logic here
            }
        }
        
        setInterval(updateFlashSaleTimer, 1000);
    </script>
</body>
</html>