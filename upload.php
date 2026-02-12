<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$conn = mysqli_connect("localhost", "root", "", "ecommerce_db");
if (!$conn) die("Koneksi gagal");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama      = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga     = (int) $_POST['harga'];
    $stok      = (int) $_POST['stok'];
    $kategori  = mysqli_real_escape_string($conn, $_POST['kategori']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
        die("Gambar wajib diupload");
    }

    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','webp'];

    if (!in_array($ext, $allowed)) {
        die("Format gambar tidak didukung");
    }

    if (!is_dir('uploads')) {
        mkdir('uploads', 0755, true);
    }

    $foto = uniqid('product_', true) . '.' . $ext;
    $path = "uploads/" . $foto;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $path)) {

        $query = "INSERT INTO products 
            (image, name, price, stock, category, description, created_at)
            VALUES ('$path', '$nama', $harga, $stok, '$kategori', '$deskripsi', NOW())";

        if (mysqli_query($conn, $query)) {
            $success = "Produk berhasil disimpan!";
        } else {
            $error = mysqli_error($conn);
        }
    } else {
        $error = "Upload gambar gagal";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .preview-card {
            transition: all 0.3s ease;
            min-height: 400px;
        }
        .image-preview {
            min-height: 200px;
            background: linear-gradient(45deg, #f3f4f6 25%, #e5e7eb 25%, #e5e7eb 50%, #f3f4f6 50%, #f3f4f6 75%, #e5e7eb 75%, #e5e7eb);
            background-size: 20px 20px;
        }
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen pb-20">
    

    <!-- Notifikasi -->
    <?php if(isset($success)): ?>
        <div class="max-w-7xl mx-auto px-4 mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i> <?php echo $success; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if(isset($error)): ?>
        <div class="max-w-7xl mx-auto px-4 mb-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                <i class="fas fa-exclamation-circle mr-2"></i> <?php echo $error; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content Grid -->
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Kolom Kiri: Form Input -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-edit text-blue-500 mr-2"></i> Form Tambah Produk
                </h2>
                
                <form method="POST" enctype="multipart/form-data" class="space-y-5" id="productForm">
                    <!-- Nama Produk -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag text-blue-500 mr-1"></i> Nama Produk
                        </label>
                        <input type="text" 
                               id="nama"
                               name="nama"
                               required
                               placeholder="Contoh: Smartphone XYZ"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition duration-200"
                               oninput="updatePreview()">
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-money-bill text-green-500 mr-1"></i> Harga
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">Rp</span>
                            </div>
                            <input type="number" 
                                   id="harga"
                                   name="harga"
                                   required
                                   placeholder="0"
                                   class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl form-input focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition duration-200"
                                   oninput="updatePreview()">
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-list text-purple-500 mr-1"></i> Kategori
                        </label>
                        <select id="kategori"
                                name="kategori"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition duration-200"
                                onchange="updatePreview()">
                            <option value="">Pilih Kategori</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Rumah Tangga">Rumah Tangga</option>
                            <option value="Olahraga">Olahraga</option>
                            <option value="Hobi">Hobi</option>
                        </select>
                    </div>

                    <!-- Stok -->
                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-boxes text-orange-500 mr-1"></i> Stok Tersedia
                        </label>
                        <input type="number" 
                               id="stok"
                               name="stok"
                               value="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition duration-200"
                               oninput="updatePreview()">
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-align-left text-indigo-500 mr-1"></i> Deskripsi
                        </label>
                        <textarea id="deskripsi"
                                  name="deskripsi"
                                  rows="3"
                                  placeholder="Deskripsikan produk Anda..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition duration-200 resize-none"
                                  oninput="updatePreview()"></textarea>
                    </div>

                    <!-- Upload Gambar -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-image text-pink-500 mr-1"></i> Gambar Produk
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-blue-400 transition duration-200">
                            <input type="file" 
                                   id="image"
                                   name="image"
                                   accept="image/*"
                                   required
                                   class="hidden"
                                   onchange="handleImagePreview(event)">
                            <div class="space-y-2 cursor-pointer" onclick="document.getElementById('image').click()">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                                <p class="text-gray-600">Klik atau drag gambar ke sini</p>
                                <p class="text-sm text-gray-500">Format: JPG, PNG, WebP (Maks. 5MB)</p>
                                <button type="button" 
                                        class="bg-blue-50 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-100 transition duration-200">
                                    Pilih File
                                </button>
                            </div>
                        </div>
                        <div id="imagePreview" class="mt-3 hidden">
                            <img id="previewImage" class="w-32 h-32 object-cover rounded-lg border">
                        </div>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="pt-4">
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i> Simpan Produk
                        </button>
                    </div>
                </form>
            </div>

            <!-- Kolom Kanan: Preview Card -->
            <div class="space-y-6">
                <!-- Header Preview -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-eye text-green-500 mr-2"></i> Preview Produk
                    </h2>
                    <p class="text-gray-600 text-sm">Ini adalah preview bagaimana produk Anda akan tampil di toko</p>
                </div>

                <!-- Card Preview -->
                <div class="preview-card bg-white rounded-2xl shadow-lg overflow-hidden">
                    <!-- Preview Image -->
                    <div class="image-preview relative">
                        <img id="cardImage" 
                             src="" 
                             alt="Preview Image" 
                             class="w-full h-48 object-cover hidden">
                        <div id="defaultImage" class="w-full h-48 flex flex-col items-center justify-center text-gray-400">
                            <i class="fas fa-image text-4xl mb-2"></i>
                            <p>Gambar akan muncul di sini</p>
                        </div>
                    </div>
                    
                    <!-- Preview Content -->
                    <div class="p-5">
                        <!-- Category -->
                        <div id="cardCategory" class="text-xs text-gray-500 mb-2">
                            <span class="bg-gray-100 px-2 py-1 rounded">Kategori</span>
                        </div>
                        
                        <!-- Product Name -->
                        <h3 id="cardName" class="font-bold text-gray-800 text-lg mb-2 truncate">
                            Nama Produk
                        </h3>
                        
                        <!-- Description -->
                        <p id="cardDescription" class="text-gray-600 text-sm mb-3 line-clamp-2">
                            Deskripsi produk akan muncul di sini...
                        </p>
                        
                        <!-- Price -->
                        <div class="mb-4">
                            <div id="cardPrice" class="text-xl font-bold text-blue-600">
                                Rp 0
                            </div>
                        </div>
                        
                        <!-- Stock & Actions -->
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <!-- Stock Status -->
                            <div id="cardStock" class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                <i class="fas fa-check-circle mr-1"></i>
                                Stok: 0
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <i class="fas fa-cart-plus text-sm"></i>
                                </div>
                                <div class="w-8 h-8 rounded-full bg-red-100 text-red-500 flex items-center justify-center">
                                    <i class="far fa-heart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <nav class="fixed bottom-0 left-0 right-0 bg-white shadow-2xl border-t border-gray-200 py-3 px-4 z-50">
        <div class="flex justify-between items-center max-w-md mx-auto">
            <!-- Home -->
            <a href="homepage.php" class="flex flex-col items-center text-gray-600 hover:text-blue-600 relative">
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
                <a href="upload.php" 
                   class="w-14 h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-plus text-xl"></i>
                </a>
            </div>
            
            <!-- Wishlist -->
            <a href="#" class="flex flex-col items-center text-gray-600 hover:text-blue-600">
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

    <!-- JavaScript untuk Real-time Preview -->
    <script>
        // Format angka ke format Rupiah
        function formatRupiah(angka) {
            if (!angka || angka === '') return 'Rp 0';
            return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
        }

        // Update preview ketika input berubah
        function updatePreview() {
            // Update nama
            const nama = document.getElementById('nama').value;
            document.getElementById('cardName').textContent = nama || 'Nama Produk';
            
            // Update harga
            const harga = document.getElementById('harga').value;
            document.getElementById('cardPrice').textContent = formatRupiah(harga);
            
            // Update kategori
            const kategori = document.getElementById('kategori').value;
            if (kategori) {
                document.getElementById('cardCategory').innerHTML = `<span class="bg-gray-100 px-2 py-1 rounded">${kategori}</span>`;
            } else {
                document.getElementById('cardCategory').innerHTML = '<span class="bg-gray-100 px-2 py-1 rounded">Kategori</span>';
            }
            
            // Update stok
            const stok = parseInt(document.getElementById('stok').value) || 0;
            const cardStock = document.getElementById('cardStock');
            if (stok > 0) {
                cardStock.innerHTML = `<i class="fas fa-check-circle mr-1"></i> Stok: ${stok}`;
                cardStock.className = 'text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full';
            } else {
                cardStock.innerHTML = `<i class="fas fa-times-circle mr-1"></i> Habis`;
                cardStock.className = 'text-xs text-red-600 bg-red-50 px-2 py-1 rounded-full';
            }
            
            // Update deskripsi
            const deskripsi = document.getElementById('deskripsi').value;
            document.getElementById('cardDescription').textContent = deskripsi || 'Deskripsi produk akan muncul di sini...';
        }

        // Handle image upload preview
        function handleImagePreview(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Tampilkan preview di form
                    const previewImage = document.getElementById('previewImage');
                    previewImage.src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                    
                    // Tampilkan preview di card
                    const cardImage = document.getElementById('cardImage');
                    cardImage.src = e.target.result;
                    cardImage.classList.remove('hidden');
                    document.getElementById('defaultImage').classList.add('hidden');
                }
                
                reader.readAsDataURL(file);
            }
        }

        // Inisialisasi preview awal
        document.addEventListener('DOMContentLoaded', function() {
            updatePreview();
        });
    </script>
</body>
</html>