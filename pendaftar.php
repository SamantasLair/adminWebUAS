<?php
session_start(); // Mulai session jika belum dimulai

// // Cek autentikasi (aktifkan jika sudah ada sistem login yang berfungsi)
// if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
//     header('Location: login.php');
//     exit;
// }

// Definisikan variabel khusus untuk halaman ini
$pageTitle = "Data Pendaftar";
$currentPage = "pendaftar"; // Untuk menandai menu aktif

// Data dummy pendaftar
$pendaftar_list_dummy = [
    [
        "id" => 1, "nama" => "Ahmad Fauzi", "npm" => "1234567890", "status" => "Diterima",
        "no_wa" => "081234567890", "mk_1" => "Pemrograman Web", "mk_2" => "Basis Data", "alasan" => "Ingin memperdalam ilmu dan berkontribusi.\nSemoga bisa memberikan yang terbaik.", "bersedia_2_mk" => true, "pernah_asdos" => false, "bersedia_mk_lain" => "Bersedia", "surat_pernyataan_url" => "https://via.placeholder.com/400x500.png?text=Surat+Ahmad"
    ],
    [
        "id" => 2, "nama" => "Bunga Citra Lestari", "npm" => "0987654321", "status" => "Ditolak",
        "no_wa" => "081209876543", "mk_1" => "Algoritma & Struktur Data", "mk_2" => "", "alasan" => "Tertarik dengan materi Algoritma dan ingin berbagi ilmu.", "bersedia_2_mk" => false, "pernah_asdos" => true, "bersedia_mk_lain" => "Tidak Bersedia", "surat_pernyataan_url" => "https://via.placeholder.com/400x500.png?text=Surat+Bunga"
    ],
    [
        "id" => 3, "nama" => "Charlie Puth", "npm" => "1122334455", "status" => "Diterima",
        "no_wa" => "081122334455", "mk_1" => "Jaringan Komputer", "mk_2" => "Keamanan Informasi", "alasan" => "Suka bidang jaringan dan keamanan. Pengalaman sebelumnya sebagai asisten lab.", "bersedia_2_mk" => true, "pernah_asdos" => true, "bersedia_mk_lain" => "Bersedia", "surat_pernyataan_url" => "https://via.placeholder.com/400x500.png?text=Surat+Charlie"
    ],
];

// 1. Include Komponen Head HTML
require __DIR__ . '/components/html_head.php';
?>

<body class="bg-primary text-gray-300">

    <?php
    // 2. Include Komponen Header Admin
    require __DIR__ . '/components/admin_header.php';
    ?>

    <div class="flex min-h-screen pt-[68px] sm:pt-[72px]">

        <?php
        // 3. Include Komponen Sidebar Admin
        require __DIR__ . '/components/admin_sidebar.php';
        ?>

        <main class="flex-1 p-6 sm:p-8 bg-gray-900 md:ml-64">
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg min-h-full">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                    <h1 class="text-2xl sm:text-3xl font-semibold text-gray-100 mb-4 sm:mb-0">Data Pendaftar</h1>
                    <div class="flex space-x-3">
                        <button id="btn-tambah-pendaftar" class="bg-secondary text-primary px-4 py-2 rounded-button hover:bg-yellow-500 font-semibold flex items-center space-x-2 transition-all duration-150 ease-in-out hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-opacity-75">
                            <i class="ri-user-add-line"></i>
                            <span>Tambah Pendaftar</span>
                        </button>
                    </div>
                </div>

                <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 items-end">
                    <div class="relative">
                         <label for="search-input-pendaftar" class="sr-only">Cari Nama atau NPM</label>
                        <input type="text" id="search-input-pendaftar" placeholder="Cari Nama atau NPM..."
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:ring-1 focus:ring-secondary focus:border-secondary placeholder-gray-400">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="ri-search-line"></i>
                        </div>
                    </div>
                    <div>
                        <label for="filter-status-pendaftar" class="block text-sm font-medium text-gray-400 mb-1.5">Status Pendaftaran</label>
                        <select id="filter-status-pendaftar" name="filter-status-pendaftar" class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:ring-1 focus:ring-secondary focus:border-secondary">
                            <option value="">Semua Status</option>
                            <option value="Dalam Review">Dalam Review</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                     <button id="btn-filter-pendaftar" class="bg-gray-600 hover:bg-gray-500 text-gray-200 px-4 py-2.5 rounded-lg font-medium flex items-center justify-center space-x-2 h-[46px] sm:h-auto sm:self-end transition-colors duration-150 ease-in-out">
                        <i class="ri-filter-3-line"></i>
                        <span>Filter Pendaftar</span>
                    </button>
                </div>

                <div class="overflow-x-auto rounded-lg shadow-md border border-gray-700">
                    <table class="w-full min-w-[600px]" id="tabel-pendaftar">
                        <thead class="bg-gray-700/50">
                            <tr class="text-left">
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Nama & NPM</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Kontak (WA)</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php
                            if (empty($pendaftar_list_dummy)): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <i class="ri-user-search-line text-4xl mb-2"></i>
                                            <span>Tidak ada data pendaftar yang ditemukan.</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php else:
                                foreach ($pendaftar_list_dummy as $pendaftar):
                                    $status_color = 'text-yellow-400 bg-yellow-500/20'; // Default untuk 'Dalam Review' atau status lain
                                    if ($pendaftar['status'] == 'Diterima') $status_color = 'text-green-400 bg-green-500/20';
                                    if ($pendaftar['status'] == 'Ditolak') $status_color = 'text-red-400 bg-red-500/20';
                                ?>
                                <tr class="hover:bg-gray-700/60 transition-colors duration-150 ease-in-out"
                                    data-id="<?= $pendaftar['id'] ?>"
                                    data-nama="<?= htmlspecialchars($pendaftar['nama']) ?>"
                                    data-npm="<?= htmlspecialchars($pendaftar['npm']) ?>"
                                    data-status="<?= htmlspecialchars($pendaftar['status']) ?>"
                                    data-no_wa="<?= htmlspecialchars($pendaftar['no_wa']) ?>"
                                    data-mk_1="<?= htmlspecialchars($pendaftar['mk_1']) ?>"
                                    data-mk_2="<?= htmlspecialchars($pendaftar['mk_2']) ?>"
                                    data-alasan="<?= htmlspecialchars($pendaftar['alasan']) ?>"
                                    data-bersedia_2_mk="<?= $pendaftar['bersedia_2_mk'] ? 'Ya' : 'Tidak' ?>"
                                    data-pernah_asdos="<?= $pendaftar['pernah_asdos'] ? 'Ya' : 'Tidak' ?>"
                                    data-bersedia_mk_lain="<?= htmlspecialchars($pendaftar['bersedia_mk_lain']) ?>"
                                    data-surat_pernyataan_url="<?= htmlspecialchars($pendaftar['surat_pernyataan_url']) ?>">
                                    <td class="px-6 py-4 align-top">
                                        <div>
                                            <div class="text-sm font-semibold text-gray-100"><?= htmlspecialchars($pendaftar['nama']) ?></div>
                                            <div class="text-xs text-gray-400 mt-0.5">NPM: <?= htmlspecialchars($pendaftar['npm']) ?></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 align-top">
                                         <?= htmlspecialchars($pendaftar['no_wa']) ?>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $status_color ?> leading-normal">
                                            <?= htmlspecialchars($pendaftar['status']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 align-top text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <button type="button" class="text-secondary hover:underline text-sm font-medium btn-lihat-lanjut">Detail</button>
                                            <button title="Edit Pendaftar" class="text-gray-300 hover:text-secondary p-1.5 rounded-md hover:bg-gray-600/50 transition-colors btn-edit-pendaftar"><i class="ri-pencil-line ri-lg"></i></button>
                                            <button title="Hapus Pendaftar" class="text-gray-300 hover:text-red-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors btn-hapus-pendaftar"><i class="ri-delete-bin-line ri-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
                <div id="no-results-pendaftar" class="hidden py-12 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <i class="ri-user-search-line text-4xl mb-2"></i>
                        <span>Tidak ada data pendaftar yang cocok dengan filter.</span>
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row justify-between items-center">
                    <div class="text-sm text-gray-400 mb-4 sm:mb-0">
                        Menampilkan <span class="font-medium text-gray-200" id="pendaftar-showing-from">1</span> sampai <span class="font-medium text-gray-200" id="pendaftar-showing-to">3</span> dari <span class="font-medium text-gray-200" id="pendaftar-total-results">3</span> hasil
                    </div>
                     <div class="inline-flex rounded-button shadow-sm">
                        <button class="px-3 py-2 border border-gray-600 bg-gray-700 text-gray-400 rounded-l-lg hover:bg-gray-600 disabled:opacity-50" disabled>
                            <i class="ri-arrow-left-s-line"></i>
                        </button>
                        <button class="pagination-btn px-4 py-2 border-y border-l border-gray-600 bg-secondary text-primary">1</button>
                        <button class="px-3 py-2 border border-gray-600 bg-gray-700 text-gray-300 rounded-r-lg hover:bg-gray-600">
                            <i class="ri-arrow-right-s-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="modal-lihat-lanjut" class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm flex items-center justify-center z-[80] hidden p-4 transition-opacity duration-300 ease-in-out opacity-0">
        <div class="bg-gray-800 p-6 sm:p-8 rounded-xl shadow-2xl w-full max-w-2xl max-h-[85vh] flex flex-col border border-gray-700 transform scale-95 transition-transform duration-300 ease-in-out">
            <div class="flex justify-between items-center mb-5 border-b border-gray-700 pb-4">
                <h2 class="text-xl font-semibold text-secondary">Detail Pendaftar</h2>
                <button id="btn-close-modal-lihat-lanjut" class="text-gray-400 hover:text-secondary transition-colors duration-150">
                    <i class="ri-close-line ri-xl"></i>
                </button>
            </div>
            <div class="space-y-4 overflow-y-auto flex-grow pr-2 text-sm custom-scrollbar">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3">
                    <div><strong class="font-medium text-gray-400">Nama Lengkap:</strong> <span id="detail-nama" class="text-gray-100 break-words ml-1"></span></div>
                    <div><strong class="font-medium text-gray-400">NPM:</strong> <span id="detail-npm" class="text-gray-100 break-words ml-1"></span></div>
                    <div><strong class="font-medium text-gray-400">No. WhatsApp:</strong> <span id="detail-no_wa" class="text-gray-100 break-words ml-1"></span></div>
                </div>
                 <hr class="border-gray-700 my-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3">
                    <div><strong class="font-medium text-gray-400">MK Pilihan 1:</strong> <span id="detail-mk_1" class="text-gray-100 break-words ml-1"></span></div>
                    <div><strong class="font-medium text-gray-400">MK Pilihan 2:</strong> <span id="detail-mk_2" class="text-gray-100 break-words ml-1"></span></div>
                </div>
                 <hr class="border-gray-700 my-3">
                <div class="space-y-1.5">
                    <p><strong class="font-medium text-gray-400">Alasan Mendaftar:</strong></p>
                    <p id="detail-alasan" class="text-gray-200 bg-gray-700/50 p-3.5 rounded-lg whitespace-pre-wrap text-sm leading-relaxed"></p>
                </div>
                 <hr class="border-gray-700 my-3">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-3">
                    <div><strong class="font-medium text-gray-400">Bersedia 2 MK:</strong> <span id="detail-bersedia_2_mk" class="text-gray-100 ml-1"></span></div>
                    <div><strong class="font-medium text-gray-400">Pernah Asdos:</strong> <span id="detail-pernah_asdos" class="text-gray-100 ml-1"></span></div>
                    <div><strong class="font-medium text-gray-400">Bersedia MK Lain:</strong> <span id="detail-bersedia_mk_lain" class="text-gray-100 ml-1"></span></div>
                </div>
                <div class="pt-2">
                    <p><strong class="font-medium text-gray-400">Surat Pernyataan:</strong></p>
                    <div class="mt-2 border border-gray-600 rounded-lg overflow-hidden max-h-80 flex justify-center items-start bg-gray-700/40 p-2">
                         <img id="detail-surat_pernyataan_url" src="" alt="Surat Pernyataan" class="max-w-full max-h-full object-contain rounded-md">
                    </div>
                </div>
            </div>
            <div class="mt-6 text-right border-t border-gray-700 pt-5">
                <button id="btn-ok-modal-lihat-lanjut" class="bg-secondary text-primary px-6 py-2.5 rounded-button hover:bg-yellow-500 font-semibold transition-all duration-150 ease-in-out hover:shadow-md focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-opacity-75">Tutup</button>
            </div>
        </div>
    </div>

    <div id="modal-add-edit-pendaftar" class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm flex items-center justify-center z-[90] hidden p-4 transition-opacity duration-300 ease-in-out opacity-0">
        <div class="bg-gray-800 p-6 sm:p-8 rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-gray-700 transform scale-95 transition-transform duration-300 ease-in-out custom-scrollbar">
            <div class="flex justify-between items-center mb-6 border-b border-gray-700 pb-4">
                <h2 id="modal-pendaftar-title" class="text-xl font-semibold text-secondary">Data Pendaftar</h2>
                <button id="btn-close-modal-add-edit" class="text-gray-400 hover:text-secondary transition-colors duration-150">
                    <i class="ri-close-line ri-xl"></i>
                </button>
            </div>
            <form id="form-add-edit-pendaftar" class="space-y-5">
                <input type="hidden" name="id" id="pendaftar-id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                    <div>
                        <label for="pendaftar-nama" class="form-label-custom">Nama Lengkap <span class="text-red-400">*</span></label>
                        <input type="text" name="nama" id="pendaftar-nama" required class="form-input-custom-modal" placeholder="Masukkan nama lengkap">
                    </div>
                    <div>
                        <label for="pendaftar-npm" class="form-label-custom">NPM <span class="text-red-400">*</span></label>
                        <input type="text" name="npm" id="pendaftar-npm" pattern="\d{10}" title="NPM harus 10 digit angka" required class="form-input-custom-modal" placeholder="Masukkan 10 digit NPM">
                    </div>
                    <div>
                        <label for="pendaftar-no_wa" class="form-label-custom">No. WA <span class="text-red-400">*</span></label>
                        <input type="tel" name="no_wa" id="pendaftar-no_wa" required class="form-input-custom-modal" placeholder="Contoh: 081234567890">
                    </div>
                    <div>
                        <label for="pendaftar-status" class="form-label-custom">Status <span class="text-red-400">*</span></label>
                        <select name="status" id="pendaftar-status" required class="form-input-custom-modal">
                            <option value="" disabled selected>Pilih Status</option> <option value="Dalam Review">Dalam Review</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div>
                        <label for="pendaftar-mk_1" class="form-label-custom">Mata Kuliah Pilihan 1</label>
                        <input type="text" name="mk_1" id="pendaftar-mk_1" class="form-input-custom-modal" placeholder="Contoh: Pemrograman Web">
                    </div>
                    <div>
                        <label for="pendaftar-mk_2" class="form-label-custom">Mata Kuliah Pilihan 2 (Opsional)</label>
                        <input type="text" name="mk_2" id="pendaftar-mk_2" class="form-input-custom-modal" placeholder="Contoh: Basis Data">
                    </div>
                </div>
                <div class="pt-1">
                    <label for="pendaftar-alasan" class="form-label-custom">Alasan Mendaftar</label>
                    <textarea name="alasan" id="pendaftar-alasan" rows="3" class="form-input-custom-modal" placeholder="Jelaskan alasan Anda mendaftar..."></textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-5 pt-1">
                    <div class="w-full">
                        <label for="pendaftar-bersedia_2_mk" class="form-label-custom">Bersedia 2 MK?</label>
                        <select name="bersedia_2_mk" id="pendaftar-bersedia_2_mk" class="form-input-custom-modal w-full">
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="pendaftar-pernah_asdos" class="form-label-custom">Pernah Jadi Asdos?</label>
                        <select name="pernah_asdos" id="pendaftar-pernah_asdos" class="form-input-custom-modal w-full">
                            <option value="Tidak">Tidak</option>
                            <option value="Ya">Ya</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="pendaftar-bersedia_mk_lain" class="form-label-custom">Bersedia MK Lain?</label>
                        <select name="bersedia_mk_lain" id="pendaftar-bersedia_mk_lain" class="form-input-custom-modal w-full">
                            <option value="Bersedia">Bersedia</option>
                            <option value="Tidak Bersedia">Tidak Bersedia</option>
                        </select>
                    </div>
                </div>
                <div class="pt-1">
                    <label for="pendaftar-surat_pernyataan_url" class="form-label-custom">Link Gambar Surat Pernyataan (URL)</label>
                    <input type="url" name="surat_pernyataan_url" id="pendaftar-surat_pernyataan_url" class="form-input-custom-modal" placeholder="https://example.com/gambar.jpg">
                    <div class="mt-2">
                        <img id="preview-surat-edit" src="" alt="Preview Surat Pernyataan" class="rounded-md max-h-36 hidden border border-gray-600 bg-gray-700/50 p-1">
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-5">
                    <button type="button" id="btn-cancel-modal-add-edit" class="px-5 py-2.5 rounded-button text-gray-300 hover:bg-gray-700 hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-75 transition-colors duration-150">Batal</button>
                    <button type="submit" id="btn-submit-modal-add-edit" class="bg-secondary text-primary px-6 py-2.5 rounded-button hover:bg-yellow-500 font-semibold transition-all duration-150 ease-in-out hover:shadow-md focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-opacity-75">Simpan</button>
                </div>
            </form>
        </div>
    </div>


    <?php
    require __DIR__ . '/components/notifications_dropdown.php';
    require __DIR__ . '/components/admin_menu_dropdown.php';
    require __DIR__ . '/components/mobile_menu.php';
    require __DIR__ . '/components/footer_scripts.php';
    ?>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalLihatLanjut = document.getElementById('modal-lihat-lanjut');
        const btnCloseModalLihatLanjut = document.getElementById('btn-close-modal-lihat-lanjut');
        const btnOkModalLihatLanjut = document.getElementById('btn-ok-modal-lihat-lanjut');
        const modalLihatLanjutContent = modalLihatLanjut ? modalLihatLanjut.querySelector('.transform') : null;


        const modalAddEditPendaftar = document.getElementById('modal-add-edit-pendaftar');
        const btnTambahPendaftar = document.getElementById('btn-tambah-pendaftar');
        const btnCloseModalAddEdit = document.getElementById('btn-close-modal-add-edit');
        const btnCancelModalAddEdit = document.getElementById('btn-cancel-modal-add-edit');
        const formAddEditPendaftar = document.getElementById('form-add-edit-pendaftar');
        const modalPendaftarTitle = document.getElementById('modal-pendaftar-title');
        const modalPendaftarSubmitBtn = document.getElementById('btn-submit-modal-add-edit');
        const pendaftarIdInput = document.getElementById('pendaftar-id');
        const pendaftarNpmInput = document.getElementById('pendaftar-npm');
        const pendaftarStatusSelect = document.getElementById('pendaftar-status'); // Ambil elemen select status
        const previewSuratEdit = document.getElementById('preview-surat-edit');
        const inputSuratPernyataanUrl = document.getElementById('pendaftar-surat_pernyataan_url');
        const modalAddEditContent = modalAddEditPendaftar ? modalAddEditPendaftar.querySelector('.transform') : null;


        const tabelPendaftarBody = document.querySelector('#tabel-pendaftar tbody');
        const noResultsPendaftarDiv = document.getElementById('no-results-pendaftar');

        let currentlyEditingRow = null;

        function openModalEnhanced(modalElement, modalContentElement) {
            if (!modalElement || !modalContentElement) return;
            modalElement.classList.remove('hidden');
            setTimeout(() => {
                modalElement.classList.remove('opacity-0');
                modalContentElement.classList.remove('scale-95');
            }, 10); // Small delay for CSS transition
        }

        function closeModalEnhanced(modalElement, modalContentElement) {
            if (!modalElement || !modalContentElement) return;
            modalElement.classList.add('opacity-0');
            modalContentElement.classList.add('scale-95');
            setTimeout(() => {
                modalElement.classList.add('hidden');
            }, 300); // Duration matches transition-opacity
        }


        if (btnCloseModalLihatLanjut) btnCloseModalLihatLanjut.addEventListener('click', () => closeModalEnhanced(modalLihatLanjut, modalLihatLanjutContent));
        if (btnOkModalLihatLanjut) btnOkModalLihatLanjut.addEventListener('click', () => closeModalEnhanced(modalLihatLanjut, modalLihatLanjutContent));
        if (modalLihatLanjut) {
            modalLihatLanjut.addEventListener('click', (e) => {
                if (e.target === modalLihatLanjut) closeModalEnhanced(modalLihatLanjut, modalLihatLanjutContent);
            });
        }

        function populateDetailModal(row) {
            document.getElementById('detail-nama').textContent = row.dataset.nama || 'N/A';
            document.getElementById('detail-npm').textContent = row.dataset.npm || 'N/A';
            document.getElementById('detail-no_wa').textContent = row.dataset.no_wa || 'N/A';
            document.getElementById('detail-mk_1').textContent = row.dataset.mk_1 || 'N/A';
            document.getElementById('detail-mk_2').textContent = row.dataset.mk_2 || 'Tidak Ada';
            document.getElementById('detail-alasan').textContent = row.dataset.alasan || 'N/A';
            document.getElementById('detail-bersedia_2_mk').textContent = row.dataset.bersedia_2_mk || 'N/A';
            document.getElementById('detail-pernah_asdos').textContent = row.dataset.pernah_asdos || 'N/A';
            document.getElementById('detail-bersedia_mk_lain').textContent = row.dataset.bersedia_mk_lain || 'N/A';
            const suratImg = document.getElementById('detail-surat_pernyataan_url');
            suratImg.src = row.dataset.surat_pernyataan_url || 'https://via.placeholder.com/300x100.png?text=Tidak+Ada+Gambar';
            suratImg.alt = "Surat Pernyataan " + (row.dataset.nama || '');
        }


        if (btnTambahPendaftar) {
            btnTambahPendaftar.addEventListener('click', () => {
                currentlyEditingRow = null;
                if(formAddEditPendaftar) formAddEditPendaftar.reset(); // Ini akan memilih opsi <option value="" disabled selected>
                if(pendaftarIdInput) pendaftarIdInput.value = '';
                if(modalPendaftarTitle) modalPendaftarTitle.textContent = 'Tambah Pendaftar Baru';
                if(modalPendaftarSubmitBtn) modalPendaftarSubmitBtn.textContent = 'Simpan';
                if(pendaftarNpmInput) pendaftarNpmInput.readOnly = false;
                // pendaftarStatusSelect.value = ""; // Pastikan placeholder terpilih saat tambah baru
                if(previewSuratEdit) {
                    previewSuratEdit.classList.add('hidden');
                    previewSuratEdit.src = '';
                }
                openModalEnhanced(modalAddEditPendaftar, modalAddEditContent);
            });
        }
        if (inputSuratPernyataanUrl) {
            inputSuratPernyataanUrl.addEventListener('input', function() {
                if (this.value && (this.value.startsWith('http://') || this.value.startsWith('https://'))) {
                    if(previewSuratEdit) {
                        previewSuratEdit.src = this.value;
                        previewSuratEdit.classList.remove('hidden');
                    }
                } else {
                    if(previewSuratEdit) {
                        previewSuratEdit.classList.add('hidden');
                        previewSuratEdit.src = '';
                    }
                }
            });
        }


        if (btnCloseModalAddEdit) btnCloseModalAddEdit.addEventListener('click', () => closeModalEnhanced(modalAddEditPendaftar, modalAddEditContent));
        if (btnCancelModalAddEdit) btnCancelModalAddEdit.addEventListener('click', () => closeModalEnhanced(modalAddEditPendaftar, modalAddEditContent));
         if (modalAddEditPendaftar) {
            modalAddEditPendaftar.addEventListener('click', (e) => {
                if (e.target === modalAddEditPendaftar) closeModalEnhanced(modalAddEditPendaftar, modalAddEditContent);
            });
        }

        if(formAddEditPendaftar){
            formAddEditPendaftar.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(formAddEditPendaftar);
                const pendaftarData = {
                    id: currentlyEditingRow ? currentlyEditingRow.dataset.id : Date.now().toString(), 
                    nama: formData.get('nama'),
                    npm: formData.get('npm'),
                    no_wa: formData.get('no_wa'),
                    status: formData.get('status'),
                    mk_1: formData.get('mk_1'),
                    mk_2: formData.get('mk_2') || '',
                    alasan: formData.get('alasan'),
                    bersedia_2_mk: formData.get('bersedia_2_mk'),
                    pernah_asdos: formData.get('pernah_asdos'),
                    bersedia_mk_lain: formData.get('bersedia_mk_lain'),
                    surat_pernyataan_url: formData.get('surat_pernyataan_url') || 'https://via.placeholder.com/300x100.png?text=Tidak+Ada+Gambar'
                };

                if (!pendaftarData.status) { // Validasi jika status belum dipilih
                    alert("Silakan pilih status pendaftaran.");
                    pendaftarStatusSelect.focus();
                    return;
                }

                if (currentlyEditingRow) {
                    updateTableRow(currentlyEditingRow, pendaftarData);
                } else {
                    addNewTableRow(pendaftarData);
                }
                updatePendaftarTableInfo();
                closeModalEnhanced(modalAddEditPendaftar, modalAddEditContent);
            });
        }

        function updateTableRow(row, data) {
            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                    row.dataset[key] = data[key];
                }
            }
            row.cells[0].innerHTML = `
                <div>
                    <div class="text-sm font-semibold text-gray-100">${data.nama}</div>
                    <div class="text-xs text-gray-400 mt-0.5">NPM: ${data.npm}</div>
                </div>`;
            row.cells[1].textContent = data.no_wa;
            const statusSpan = row.cells[2].querySelector('span');
            statusSpan.textContent = data.status;
            statusSpan.className = 'px-3 py-1 text-xs font-semibold rounded-full leading-normal '; 
            if (data.status === 'Diterima') {
                statusSpan.classList.add('text-green-400', 'bg-green-500/20');
            } else if (data.status === 'Ditolak') {
                statusSpan.classList.add('text-red-400', 'bg-red-500/20');
            } else { // Dalam Review
                statusSpan.classList.add('text-yellow-400', 'bg-yellow-500/20');
            }
        }

        function addNewTableRow(data) {
            if (!tabelPendaftarBody) return;
            const newRow = tabelPendaftarBody.insertRow(0); 
            newRow.classList.add('hover:bg-gray-700/60', 'transition-colors', 'duration-150', 'ease-in-out');

            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                    newRow.dataset[key] = data[key];
                }
            }

            let statusColorClass = 'text-yellow-400 bg-yellow-500/20'; 
            if (data.status === 'Diterima') {
                statusColorClass = 'text-green-400 bg-green-500/20';
            } else if (data.status === 'Ditolak') {
                statusColorClass = 'text-red-400 bg-red-500/20';
            }

            newRow.innerHTML = `
                <td class="px-6 py-4 align-top">
                    <div>
                        <div class="text-sm font-semibold text-gray-100">${data.nama}</div>
                        <div class="text-xs text-gray-400 mt-0.5">NPM: ${data.npm}</div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-300 align-top">${data.no_wa}</td>
                <td class="px-6 py-4 align-top">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full ${statusColorClass} leading-normal">${data.status}</span>
                </td>
                <td class="px-6 py-4 align-top text-center">
                    <div class="flex items-center justify-center space-x-2">
                        <button type="button" class="text-secondary hover:underline text-sm font-medium btn-lihat-lanjut">Detail</button>
                        <button title="Edit Pendaftar" class="text-gray-300 hover:text-secondary p-1.5 rounded-md hover:bg-gray-600/50 transition-colors btn-edit-pendaftar"><i class="ri-pencil-line ri-lg"></i></button>
                        <button title="Hapus Pendaftar" class="text-gray-300 hover:text-red-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors btn-hapus-pendaftar"><i class="ri-delete-bin-line ri-lg"></i></button>
                    </div>
                </td>
            `;
        }

        if(tabelPendaftarBody) {
            tabelPendaftarBody.addEventListener('click', function(e) {
                const row = e.target.closest('tr');
                if (!row || !row.dataset.id) return; 

                if (e.target.closest('.btn-lihat-lanjut')) {
                    populateDetailModal(row);
                    openModalEnhanced(modalLihatLanjut, modalLihatLanjutContent);
                } else if (e.target.closest('.btn-edit-pendaftar')) {
                    currentlyEditingRow = row;
                    if(modalPendaftarTitle) modalPendaftarTitle.textContent = 'Edit Pendaftar';
                    if(modalPendaftarSubmitBtn) modalPendaftarSubmitBtn.textContent = 'Update';
                    if(pendaftarNpmInput) pendaftarNpmInput.readOnly = true; 

                    if(pendaftarIdInput) pendaftarIdInput.value = row.dataset.id;
                    document.getElementById('pendaftar-nama').value = row.dataset.nama;
                    if(pendaftarNpmInput) pendaftarNpmInput.value = row.dataset.npm;
                    document.getElementById('pendaftar-no_wa').value = row.dataset.no_wa;
                    if(pendaftarStatusSelect) pendaftarStatusSelect.value = row.dataset.status; // Set nilai select
                    document.getElementById('pendaftar-mk_1').value = row.dataset.mk_1;
                    document.getElementById('pendaftar-mk_2').value = row.dataset.mk_2;
                    document.getElementById('pendaftar-alasan').value = row.dataset.alasan;
                    document.getElementById('pendaftar-bersedia_2_mk').value = row.dataset.bersedia_2_mk;
                    document.getElementById('pendaftar-pernah_asdos').value = row.dataset.pernah_asdos;
                    document.getElementById('pendaftar-bersedia_mk_lain').value = row.dataset.bersedia_mk_lain;
                    
                    const suratUrl = row.dataset.surat_pernyataan_url;
                    if(inputSuratPernyataanUrl) inputSuratPernyataanUrl.value = suratUrl;
                    if (previewSuratEdit && suratUrl && (suratUrl.startsWith('http://') || suratUrl.startsWith('https://'))) {
                        previewSuratEdit.src = suratUrl;
                        previewSuratEdit.classList.remove('hidden');
                    } else if (previewSuratEdit) {
                        previewSuratEdit.classList.add('hidden');
                        previewSuratEdit.src = '';
                    }
                    openModalEnhanced(modalAddEditPendaftar, modalAddEditContent);

                } else if (e.target.closest('.btn-hapus-pendaftar')) {
                    if (confirm('Apakah Anda yakin ingin menghapus pendaftar "' + row.dataset.nama + '"? Aksi ini tidak dapat diurungkan.')) {
                        row.remove();
                        updatePendaftarTableInfo();
                    }
                }
            });
        }

        function updatePendaftarTableInfo() {
            if (!tabelPendaftarBody) return;
            const rowCount = tabelPendaftarBody.querySelectorAll('tr').length;
            const showingFrom = document.getElementById('pendaftar-showing-from');
            const showingTo = document.getElementById('pendaftar-showing-to');
            const totalResults = document.getElementById('pendaftar-total-results');

            if (rowCount === 0) {
                if(noResultsPendaftarDiv) noResultsPendaftarDiv.classList.remove('hidden');
                if(showingFrom) showingFrom.textContent = '0';
                if(showingTo) showingTo.textContent = '0';
                if(totalResults) totalResults.textContent = '0';
            } else {
                if(noResultsPendaftarDiv) noResultsPendaftarDiv.classList.add('hidden');
                if(showingFrom) showingFrom.textContent = '1';
                if(showingTo) showingTo.textContent = rowCount;
                if(totalResults) totalResults.textContent = rowCount;
            }
        }
        updatePendaftarTableInfo(); // Initial call

        const searchInputPendaftar = document.getElementById('search-input-pendaftar');
        const filterStatusPendaftar = document.getElementById('filter-status-pendaftar');
        const btnFilterPendaftar = document.getElementById('btn-filter-pendaftar');

        if (btnFilterPendaftar) {
            btnFilterPendaftar.addEventListener('click', function() {
                const searchTerm = searchInputPendaftar.value.toLowerCase();
                const selectedStatus = filterStatusPendaftar.value;
                let visibleRows = 0;

                if(!tabelPendaftarBody) return;
                const rows = tabelPendaftarBody.querySelectorAll('tr');
                rows.forEach(row => {
                    const nama = (row.dataset.nama || '').toLowerCase();
                    const npm = (row.dataset.npm || '').toLowerCase();
                    const status = row.dataset.status || '';

                    const matchesSearch = nama.includes(searchTerm) || npm.includes(searchTerm);
                    const matchesStatus = selectedStatus === "" || status === selectedStatus;

                    if (matchesSearch && matchesStatus) {
                        row.style.display = '';
                        visibleRows++;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                const showingFrom = document.getElementById('pendaftar-showing-from');
                const showingTo = document.getElementById('pendaftar-showing-to');

                if (visibleRows === 0) {
                    if(noResultsPendaftarDiv) noResultsPendaftarDiv.classList.remove('hidden');
                    if(showingFrom) showingFrom.textContent = '0';
                    if(showingTo) showingTo.textContent = '0';
                } else {
                   if(noResultsPendaftarDiv) noResultsPendaftarDiv.classList.add('hidden');
                   if(showingFrom) showingFrom.textContent = '1';
                   if(showingTo) showingTo.textContent = visibleRows;
                }
            });
        }
    });
    </script>
    <style>
        .form-label-custom {
            @apply block text-sm font-medium text-gray-300 mb-1.5;
        }
        .form-input-custom-modal {
            @apply w-full px-4 py-2.5 bg-gray-700/70 border border-gray-600 text-gray-200 rounded-lg focus:ring-1 focus:ring-secondary focus:border-secondary transition-colors duration-150 ease-in-out placeholder-gray-400/70;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #374151; /* bg-gray-700 */
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #6b7280; /* bg-gray-500 */
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af; /* bg-gray-400 */
        }
    </style>

</body>
</html>