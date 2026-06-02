<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "ecommerce_db");
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM users");




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Document</title>
</head>
<body class="bg-gray-100 gap-6">
      <div class="min-h-screen flex flex-col md:flex-row">
        
        <div class="flex-1 p-6 md:p-10">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Selamat Datang, <span class="text-purple-600"><?= $_SESSION['user']['name'] ?>!</span></h2>
                    <p class="text-gray-600 mt-2">Ini adalah halaman dashboard akun Anda</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-green-100 text-green-800 text-sm">
                        <i class="fas fa-circle text-xs mr-2"></i>
                        Akun Aktif
                    </span>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="stat-card shadow-lg rounded-2xl p-6 card-hover">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-400">Total Pesanan</p>
                            <h3 class="text-3xl font-bold mt-2 text-gray-800">15</h3>
                        </div>
                        <i class="fas fa-shopping-bag text-4xl text-purple-500"></i>
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/30">
                        <a href="#" class="text-sm  text-gray-400 hover:underline">Lihat semua →</a>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-lg card-hover">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-600 text-sm">Dalam Proses</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">3</h3>
                        </div>
                        <i class="fas fa-clock text-4xl text-yellow-500"></i>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="#" class="text-purple-600 text-sm hover:underline">Lihat detail →</a>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-lg card-hover">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-600 text-sm">Member sejak</p>
                            <h3 class="text-xl font-bold text-gray-800 mt-2"><?= date ("d M Y",  ($_SESSION['user']['created_at'])) ?></h3>
                        </div>
                        <i class="fas fa-calendar-check text-4xl text-green-500"></i>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-gray-500 text-sm"><?= floor ((time() - strtotime($_SESSION['user']['created_at'])) / (60*60*24)) ?> hari</p>
                    </div>
                </div>
            </div>
            
            <!-- Profile Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 card-hover">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Profil Saya</h3>
                    <a href="#" class="text-purple-600 hover:text-purple-800 font-medium">
                        <i class="fas fa-edit mr-2"></i>Edit Profil
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <p class="text-gray-500 text-sm mb-2">Nama Lengkap</p>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <i class="fas fa-user text-gray-400 mr-3"></i>
                                <span class="font-medium"><?= $_SESSION['user']['name'] ?></span>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-gray-500 text-sm mb-2">Email</p>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <i class="fas fa-envelope text-gray-400 mr-3"></i>
                                <span class="font-medium"><?= $_SESSION['user']['email'] ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <p class="text-gray-500 text-sm mb-2">ID Member</p>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <i class="fas fa-id-card text-gray-400 mr-3"></i>
                                <span class="font-mono">USR<?= str_pad($_SESSION['user']['id'], 6, '0', STR_PAD_LEFT) ?></span>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-gray-500 text-sm mb-2">Status Akun</p>
                            <div class="flex items-center p-3 bg-green-50 rounded-lg">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <span class="font-medium text-green-700">Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="mt-10 pt-8 border-t border-gray-100">
                    <h4 class="text-lg font-semibold mb-6">Aksi Cepat</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="#" class="flex flex-col items-center justify-center p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition duration-300">
                            <i class="fas fa-key text-purple-600 text-2xl mb-2"></i>
                            <span class="text-sm font-medium">Ganti Password</span>
                        </a>
                        <a href="#" class="flex flex-col items-center justify-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition duration-300">
                            <i class="fas fa-history text-blue-600 text-2xl mb-2"></i>
                            <span class="text-sm font-medium">Riwayat</span>
                        </a>
                        <a href="favorite.php   " class="flex flex-col items-center justify-center p-4 bg-green-50 rounded-xl hover:bg-green-100 transition duration-300">
                            <i class="fas fa-heart text-green-600 text-2xl mb-2"></i>
                            <span class="text-sm font-medium">Favorit</span>
                        </a>
                        <a href="auth/logout.php" class="flex flex-col items-center justify-center p-4 bg-red-50 rounded-xl hover:bg-red-100 transition duration-300">
                            <i class="fas fa-sign-out-alt text-red-600 text-2xl mb-2"></i>
                            <span class="text-sm font-medium">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="bg-white rounded-2xl shadow-lg p-8 card-hover">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Aktivitas Terbaru</h3>
                <div class="space-y-4">
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                            <i class="fas fa-sign-in-alt text-purple-600"></i>
                        </div>
                        <div>
                            <p class="font-medium">Login berhasil</p>
                            <p class="text-sm text-gray-500">Baru saja • Browser: Chrome</p>
                        </div>
                        <span class="ml-auto text-sm text-gray-500">Hari ini</span>
                    </div>
                    
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                            <i class="fas fa-user-check text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-medium">Akun diverifikasi</p>
                            <p class="text-sm text-gray-500">Email: <?= $_SESSION['user']['email'] ?></p>
                        </div>
                        <span class="ml-auto text-sm text-gray-500"><?= date('d M Y', strtotime($_SESSION['user']['created_at'])) ?></span>
                    </div>
                </div>
            </div>
              
        </div>
    </div>
    
    <script>
        // Smooth hover effects
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-5px)';
                    card.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.1)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0)';
                    card.style.boxShadow = '';
                });
            });
        });
    </script>
  



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

    <!-- JavaScript untuk interaksi -->
    <script>
        // Menambahkan interaksi pada item navbar
        document.addEventListener('DOMContentLoaded', function() {
            const navItems = document.querySelectorAll('.nav-item');
            
            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Hapus kelas active dari semua item
                    navItems.forEach(nav => {
                        nav.classList.remove('active');
                        nav.querySelector('div').classList.remove('text-blue-500');
                        nav.querySelector('div').classList.add('text-gray-600');
                        nav.querySelector('span').classList.remove('text-blue-500');
                        nav.querySelector('span').classList.add('text-gray-600');
                    });
                    
                    // Tambahkan kelas active pada item yang diklik
                    this.classList.add('active');
                    this.querySelector('div').classList.remove('text-gray-600');
                    this.querySelector('div').classList.add('text-blue-500');
                    this.querySelector('span').classList.remove('text-gray-600');
                    this.querySelector('span').classList.add('text-blue-500');
                  
                });
            });
            
            // Interaksi untuk tombol tengah (FAB)
          
  const fabButton = document.querySelector('.fab');

  fabButton.addEventListener('click', function () {
    // animasi
    this.classList.add('animate-pulse');

    // redirect setelah animasi
    setTimeout(() => {
      this.classList.remove('animate-pulse');
      window.location.href = 'upload.php';
    }, 500);
  });


            });
    </script>
</body>
</html>

