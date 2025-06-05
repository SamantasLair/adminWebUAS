<?php
session_start(); // Mulai session jika belum dimulai

// // Cek autentikasi (aktifkan jika sudah ada sistem login yang berfungsi)
// if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
//     header('Location: login.php');
//     exit;
// }

// Definisikan variabel khusus untuk halaman ini
$pageTitle = "Kelola Pengumuman"; // Sesuai permintaan untuk tidak mengubah ini kecuali diminta
$currentPage = "pengumuman"; // Untuk menandai menu aktif

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
                    <h1 class="text-2xl sm:text-3xl font-semibold text-gray-100 mb-4 sm:mb-0">Hasil Seleksi Asisten Dosen</h1>
                    <div class="flex space-x-3">
                        <button id="tambah-asdos-btn" class="bg-secondary text-primary px-4 py-2 rounded-button hover:bg-yellow-500 font-medium flex items-center space-x-2">
                            <i class="ri-user-add-line"></i>
                            <span>Tambah Asisten Dosen</span>
                        </button>
                    </div>
                </div>

                <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 items-end">
                    <div class="relative">
                        <input type="text" id="search-input" placeholder="Cari Nama atau NPM..."
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:ring-1 focus:ring-secondary focus:border-secondary placeholder-gray-400">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="ri-search-line"></i>
                        </div>
                    </div>
                    <div>
                        <label for="filter-matkul" class="block text-sm font-medium text-gray-400 mb-1.5">Mata Kuliah</label>
                        <select id="filter-matkul" name="filter-matkul" class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:ring-1 focus:ring-secondary focus:border-secondary">
                            <option value="">Semua Matkul</option>
                            <option value="Pemrograman Web">Pemrograman Web</option>
                            <option value="Basis Data">Basis Data</option>
                            <option value="Struktur Data">Struktur Data</option>
                            <option value="Jaringan Komputer">Jaringan Komputer</option>
                        </select>
                    </div>
                     <button id="filter-button" class="bg-gray-600 hover:bg-gray-500 text-gray-200 px-4 py-2.5 rounded-lg font-medium flex items-center justify-center space-x-2 h-[46px] sm:h-auto sm:self-end mt-4 sm:mt-0">
                        <i class="ri-filter-3-line"></i>
                        <span>Filter</span>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[800px]" id="tabel-asdos">
                        <thead>
                            <tr class="bg-gray-700/50 text-left">
                                <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider rounded-tl-lg">NPM</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">PJ Kelas</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Mata Kuliah</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-200">2317051001</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-100">Andi Wijaya</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-200">SI-01A</td>
                                <td class="px-6 py-4 text-sm text-gray-200">Pemrograman Web</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full text-green-400 bg-green-500/20">Koordinator</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-1">
                                        <button title="Edit" class="text-gray-400 hover:text-blue-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors edit-btn"><i class="ri-pencil-line ri-lg"></i></button>
                                        <button title="Hapus" class="text-gray-400 hover:text-red-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors delete-btn"><i class="ri-delete-bin-line ri-lg"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-200">2317051002</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-100">Budi Santoso</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-200">SI-01B</td>
                                <td class="px-6 py-4 text-sm text-gray-200">Pemrograman Web</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full text-blue-400 bg-blue-500/20">Anggota</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-1">
                                        <button title="Edit" class="text-gray-400 hover:text-blue-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors edit-btn"><i class="ri-pencil-line ri-lg"></i></button>
                                        <button title="Hapus" class="text-gray-400 hover:text-red-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors delete-btn"><i class="ri-delete-bin-line ri-lg"></i></button>
                                    </div>
                                </td>
                            </tr>
                             <tr>
                                <td class="px-6 py-4 text-sm text-gray-200">2317051003</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-100">Citra Lestari</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-200">TI-02A</td>
                                <td class="px-6 py-4 text-sm text-gray-200">Basis Data</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full text-green-400 bg-green-500/20">Koordinator</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-1">
                                        <button title="Edit" class="text-gray-400 hover:text-blue-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors edit-btn"><i class="ri-pencil-line ri-lg"></i></button>
                                        <button title="Hapus" class="text-gray-400 hover:text-red-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors delete-btn"><i class="ri-delete-bin-line ri-lg"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="no-results" class="hidden py-12 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <i class="ri-user-search-line text-4xl mb-2"></i>
                        <span>Tidak ada data asisten dosen yang ditemukan.</span>
                    </div>
                </div>


                <div class="mt-8 flex flex-col sm:flex-row justify-between items-center">
                    <div class="text-sm text-gray-400 mb-4 sm:mb-0">
                        Menampilkan <span class="font-medium text-gray-200" id="showing-from">1</span> sampai <span class="font-medium text-gray-200" id="showing-to">3</span> dari <span class="font-medium text-gray-200" id="total-results">3</span> hasil
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

    <div id="tambah-asdos-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-[80] hidden p-4">
        <div class="bg-gray-800 p-6 sm:p-8 rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 id="modal-title" class="text-xl font-semibold text-gray-100">Tambah Asisten Dosen Baru</h2>
                <button id="close-modal-btn" class="text-gray-400 hover:text-gray-200">
                    <i class="ri-close-line ri-xl"></i>
                </button>
            </div>
            <form id="form-tambah-asdos" class="space-y-5">
                <div>
                    <label for="modal-npm" class="block text-sm font-medium text-gray-300 mb-1.5">NPM</label>
                    <input type="text" name="npm" id="modal-npm" pattern="\d{10}" title="NPM harus 10 digit angka" required
                        class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:ring-1 focus:ring-secondary focus:border-secondary placeholder-gray-400">
                </div>
                <div>
                    <label for="modal-nama" class="block text-sm font-medium text-gray-300 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="nama" id="modal-nama" required
                        class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:ring-1 focus:ring-secondary focus:border-secondary placeholder-gray-400">
                </div>
                <div>
                    <label for="modal-pj-kelas" class="block text-sm font-medium text-gray-300 mb-1.5">PJ Kelas</label>
                    <input type="text" name="pj_kelas" id="modal-pj-kelas" required
                        class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:ring-1 focus:ring-secondary focus:border-secondary placeholder-gray-400">
                </div>
                <div>
                    <label for="modal-matkul" class="block text-sm font-medium text-gray-300 mb-1.5">Mata Kuliah</label>
                    <select name="matkul" id="modal-matkul" required
                        class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:ring-1 focus:ring-secondary focus:border-secondary">
                        <option value="" disabled selected>Pilih Mata Kuliah</option>
                        <option value="Pemrograman Web">Pemrograman Web</option>
                        <option value="Basis Data">Basis Data</option>
                        <option value="Struktur Data">Struktur Data</option>
                        <option value="Jaringan Komputer">Jaringan Komputer</option>
                        <option value="Kecerdasan Buatan">Kecerdasan Buatan</option>
                    </select>
                </div>
                <div>
                    <label for="modal-keterangan" class="block text-sm font-medium text-gray-300 mb-1.5">Peran/Keterangan</label>
                    <select name="keterangan" id="modal-keterangan" required
                        class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:ring-1 focus:ring-secondary focus:border-secondary">
                        <option value="" disabled selected>Pilih Peran</option>
                        <option value="Koordinator">Koordinator</option>
                        <option value="Anggota">Anggota</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" id="cancel-modal-btn" class="px-4 py-2 rounded-button text-gray-300 hover:bg-gray-700">Batal</button>
                    <button type="submit" id="modal-submit-btn" class="bg-secondary text-primary px-6 py-2 rounded-button hover:bg-yellow-500 font-semibold">
                        Simpan Asisten
                    </button>
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
    // Skrip spesifik untuk halaman ini
    document.addEventListener('DOMContentLoaded', function () {
        const tambahAsdosBtn = document.getElementById('tambah-asdos-btn');
        const modal = document.getElementById('tambah-asdos-modal');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const cancelModalBtn = document.getElementById('cancel-modal-btn');
        const formTambahAsdos = document.getElementById('form-tambah-asdos');
        const tabelAsdosBody = document.querySelector('#tabel-asdos tbody');
        const noResultsDiv = document.getElementById('no-results');
        
        const modalTitleEl = document.getElementById('modal-title');
        const modalSubmitBtn = document.getElementById('modal-submit-btn');
        const modalNpmInput = document.getElementById('modal-npm');

        let editingRow = null; // Stores the <tr> element being edited

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            formTambahAsdos.reset();
            editingRow = null; 
            modalTitleEl.textContent = 'Tambah Asisten Dosen Baru';
            modalSubmitBtn.textContent = 'Simpan Asisten';
            modalNpmInput.readOnly = false;
        }

        if (tambahAsdosBtn) {
            tambahAsdosBtn.addEventListener('click', function() {
                editingRow = null; // Ensure not in edit mode
                modalTitleEl.textContent = 'Tambah Asisten Dosen Baru';
                modalSubmitBtn.textContent = 'Simpan Asisten';
                modalNpmInput.readOnly = false;
                formTambahAsdos.reset();
                openModal();
            });
        }

        if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
        if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeModal);
        
        if (modal) {
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeModal();
                }
            });
        }

        if (formTambahAsdos) {
            formTambahAsdos.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(formTambahAsdos);
                const npm = formData.get('npm');
                const nama = formData.get('nama');
                const pjKelas = formData.get('pj_kelas');
                const matkul = formData.get('matkul');
                const keterangan = formData.get('keterangan');

                let keteranganClass = 'text-blue-400 bg-blue-500/20'; // Default Anggota
                if (keterangan.toLowerCase() === 'koordinator') {
                    keteranganClass = 'text-green-400 bg-green-500/20';
                }

                if (editingRow) { // Update existing row
                    editingRow.cells[0].textContent = npm; // NPM is readOnly, value should be original
                    editingRow.cells[1].querySelector('div').textContent = nama;
                    editingRow.cells[2].textContent = pjKelas;
                    editingRow.cells[3].textContent = matkul;
                    editingRow.cells[4].querySelector('span').textContent = keterangan;
                    editingRow.cells[4].querySelector('span').className = `px-2 py-1 text-xs font-semibold rounded-full ${keteranganClass}`;
                } else { // Add new row
                    const newRow = document.createElement('tr');
                    newRow.classList.add('hover:bg-gray-700/50', 'transition-colors', 'duration-150');
                    newRow.innerHTML = `
                        <td class="px-6 py-4 text-sm text-gray-200">${npm}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-100">${nama}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-200">${pjKelas}</td>
                        <td class="px-6 py-4 text-sm text-gray-200">${matkul}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full ${keteranganClass}">${keterangan}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-1">
                                <button title="Edit" class="text-gray-400 hover:text-blue-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors edit-btn"><i class="ri-pencil-line ri-lg"></i></button>
                                <button title="Hapus" class="text-gray-400 hover:text-red-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors delete-btn"><i class="ri-delete-bin-line ri-lg"></i></button>
                            </div>
                        </td>
                    `;
                    if (tabelAsdosBody) {
                        tabelAsdosBody.appendChild(newRow);
                    }
                }
                if (tabelAsdosBody) updateTableInfo();
                closeModal();
            });
        }

        if (tabelAsdosBody) {
            tabelAsdosBody.addEventListener('click', function(event) {
                const targetElement = event.target;
                const deleteButton = targetElement.closest('.delete-btn');
                const editButton = targetElement.closest('.edit-btn');

                if (deleteButton) {
                    deleteButton.closest('tr').remove();
                    updateTableInfo();
                } else if (editButton) {
                    editingRow = editButton.closest('tr');
                    const npm = editingRow.cells[0].textContent;
                    const nama = editingRow.cells[1].querySelector('div').textContent;
                    const pjKelas = editingRow.cells[2].textContent;
                    const matkul = editingRow.cells[3].textContent;
                    const keteranganText = editingRow.cells[4].querySelector('span').textContent;

                    modalNpmInput.value = npm;
                    document.getElementById('modal-nama').value = nama;
                    document.getElementById('modal-pj-kelas').value = pjKelas;
                    document.getElementById('modal-matkul').value = matkul;
                    document.getElementById('modal-keterangan').value = keteranganText;
                    
                    modalTitleEl.textContent = 'Edit Data Asisten Dosen';
                    modalSubmitBtn.textContent = 'Update Data';
                    modalNpmInput.readOnly = true; // NPM is usually a primary key and not editable

                    openModal();
                }
            });
        }
        
        function updateTableInfo() {
            if (!tabelAsdosBody) return;
            const rowCount = tabelAsdosBody.querySelectorAll('tr').length;
            const showingFrom = document.getElementById('showing-from');
            const showingTo = document.getElementById('showing-to');
            const totalResults = document.getElementById('total-results');

            if (rowCount === 0) {
                if (noResultsDiv) noResultsDiv.classList.remove('hidden');
                if (showingFrom) showingFrom.textContent = '0';
                if (showingTo) showingTo.textContent = '0';
                if (totalResults) totalResults.textContent = '0';
            } else {
                if (noResultsDiv) noResultsDiv.classList.add('hidden');
                if (showingFrom) showingFrom.textContent = '1';
                if (showingTo) showingTo.textContent = rowCount;
                if (totalResults) totalResults.textContent = rowCount;
            }
        }

        updateTableInfo(); // Initial call

        // Filter logic (UI only)
        const searchInput = document.getElementById('search-input');
        const filterMatkulSelect = document.getElementById('filter-matkul');
        const filterButton = document.getElementById('filter-button');

        if (filterButton) {
            filterButton.addEventListener('click', function() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedMatkul = filterMatkulSelect.value; // Keep case for comparison if needed, or .toLowerCase()
                let visibleRows = 0;

                if (tabelAsdosBody) {
                    const rows = tabelAsdosBody.querySelectorAll('tr');
                    rows.forEach(row => {
                        const npm = row.cells[0].textContent.toLowerCase();
                        const nama = row.cells[1].textContent.toLowerCase();
                        const matkulInRow = row.cells[3].textContent;
                        
                        const matchesSearch = npm.includes(searchTerm) || nama.includes(searchTerm);
                        const matchesMatkul = selectedMatkul === "" || matkulInRow === selectedMatkul;

                        if (matchesSearch && matchesMatkul) {
                            row.style.display = '';
                            visibleRows++;
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }
                
                const showingFrom = document.getElementById('showing-from');
                const showingTo = document.getElementById('showing-to');
                // totalResults should ideally show total unfiltered results or be hidden during filter

                if (visibleRows === 0) {
                    if (noResultsDiv) noResultsDiv.classList.remove('hidden');
                    if (showingFrom) showingFrom.textContent = '0';
                    if (showingTo) showingTo.textContent = '0';
                } else {
                    if (noResultsDiv) noResultsDiv.classList.add('hidden');
                    if (showingFrom) showingFrom.textContent = '1';
                    if (showingTo) showingTo.textContent = visibleRows;
                }
                 // Handle no results message visibility based on whether filters are active
                if (visibleRows === 0 && (searchTerm || selectedMatkul)) {
                     if (noResultsDiv) noResultsDiv.classList.remove('hidden');
                } else if (visibleRows === 0 && !searchTerm && !selectedMatkul && tabelAsdosBody.querySelectorAll('tr').length > 0) {
                    // This case might mean all rows are hidden by filter, but there is data.
                    // Or if table is truly empty after all deletions.
                     if (noResultsDiv && tabelAsdosBody.querySelectorAll('tr[style*="display: none"]').length === tabelAsdosBody.querySelectorAll('tr').length && tabelAsdosBody.querySelectorAll('tr').length > 0){
                          noResultsDiv.classList.remove('hidden'); // Show "no results" if filters hide everything
                     } else if (tabelAsdosBody.querySelectorAll('tr').length === 0){
                          noResultsDiv.classList.remove('hidden'); // Show if table is empty
                     }
                } else if (visibleRows > 0) {
                     if (noResultsDiv) noResultsDiv.classList.add('hidden');
                }
            });
        }
    });
    </script>
</body>
</html>