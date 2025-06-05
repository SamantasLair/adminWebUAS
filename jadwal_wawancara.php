<?php
session_start();

// if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
//     header('Location: login.php');
//     exit;
// }

$pageTitle = "Dashboard";
$currentPage = "dashboard";

function getMataKuliahFromImage() {
    return [
        [
            'kode' => 'IF210',
            'nama' => 'Dasar Pemrograman',
            'sks' => 3,
            'semester' => 1,
            'dosen' => 'Dwi Sakethi',
            'kuota' => 2,
            'status' => 'Aktif'
        ],
        [
            'kode' => 'IF220',
            'nama' => 'Struktur Data & Algoritma',
            'sks' => 4,
            'semester' => 2,
            'dosen' => 'Rico Adrian',
            'kuota' => 3,
            'status' => 'Aktif'
        ],
        [
            'kode' => 'IF310',
            'nama' => 'Pemrograman Web',
            'sks' => 3,
            'semester' => 3,
            'dosen' => 'Rizky Prabowo',
            'kuota' => 2,
            'status' => 'Aktif'
        ],
        [
            'kode' => 'IF320',
            'nama' => 'Basis Data',
            'sks' => 3,
            'semester' => 4,
            'dosen' => 'Aristoteles',
            'kuota' => 1,
            'status' => 'Aktif'
        ],
        [
            'kode' => 'KU400',
            'nama' => 'Etika',
            'sks' => 2,
            'semester' => 5,
            'dosen' => 'Wartarius',
            'kuota' => 4,
            'status' => 'Aktif'
        ]
    ];
}

function getTotalMataKuliahAktif() {
    $courses = getMataKuliahFromImage();
    $active_count = 0;
    foreach ($courses as $course) {
        if (isset($course['status']) && $course['status'] === 'Aktif') {
            $active_count++;
        }
    }
    return $active_count;
}

$mata_kuliah_list = getMataKuliahFromImage();

require __DIR__ . '/components/html_head.php';
?>

<body class="bg-primary text-gray-300">

    <?php
    require __DIR__ . '/components/admin_header.php';
    ?>

    <div class="flex min-h-screen pt-[68px] sm:pt-[72px]">

        <?php
        require __DIR__ . '/components/admin_sidebar.php';
        ?>

        <main class="flex-1 p-6 sm:p-8 bg-gray-900 md:ml-64">
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg min-h-full">
                <h1 class="text-2xl sm:text-3xl font-semibold text-gray-100 mb-6">Dashboard</h1>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <div class="bg-gray-700/50 p-6 rounded-xl border border-gray-600">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-400">Total Pendaftar</p>
                                <h3 class="text-2xl font-semibold text-gray-100 mt-1">248</h3>
                            </div>
                            <div class="w-12 h-12 bg-secondary/20 rounded-lg flex items-center justify-center">
                                <i class="ri-group-2-line text-2xl text-secondary"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-700/50 p-6 rounded-xl border border-gray-600">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-400">Total Mata Kuliah</p>
                                <h3 class="text-2xl font-semibold text-gray-100 mt-1"><?= getTotalMataKuliahAktif() ?></h3>
                            </div>
                            <div class="w-12 h-12 bg-secondary/20 rounded-lg flex items-center justify-center">
                                <i class="ri-book-2-line text-2xl text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-700/50 rounded-xl border border-gray-600 overflow-hidden mb-8">
                    <div class="p-4 border-b border-gray-600">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                            <h2 class="text-lg font-semibold text-gray-100">Daftar Mata Kuliah</h2>
                            <a href="mata_kuliah.php" class="text-secondary hover:text-yellow-500 font-medium text-sm inline-flex items-center mt-2 sm:mt-0">
                                Lihat Semua <i class="ri-arrow-right-s-line ml-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[800px]">
                            <thead class="bg-gray-700/50">
                                <tr class="text-left">
                                    <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Kode & Nama</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">SKS</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Semester</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Dosen</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Kuota</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                <?php
                                $mata_kuliah_list_dummy = array_slice($mata_kuliah_list, 0, 3);
                                if (empty($mata_kuliah_list_dummy)): ?>
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <i class="ri-book-search-line text-4xl mb-2"></i>
                                                <span>Tidak ada data mata kuliah yang ditemukan.</span>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else:
                                    foreach ($mata_kuliah_list_dummy as $mk):
                                        $status_color = 'text-green-400 bg-green-500/20';
                                        if (isset($mk['status']) && $mk['status'] == 'Nonaktif') $status_color = 'text-red-400 bg-red-500/20';
                                ?>
                                <tr class="hover:bg-gray-700/60 transition-colors duration-150 ease-in-out">
                                    <td class="px-6 py-4 align-top">
                                        <div>
                                            <div class="text-sm font-semibold text-gray-100"><?= htmlspecialchars($mk['kode']) ?></div>
                                            <div class="text-xs text-gray-400 mt-0.5"><?= htmlspecialchars($mk['nama']) ?></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 align-top">
                                        <?= htmlspecialchars($mk['sks']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 align-top">
                                        <?= htmlspecialchars($mk['semester']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 align-top">
                                        <?= htmlspecialchars($mk['dosen']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 align-top">
                                        <?= htmlspecialchars($mk['kuota']) ?>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $status_color ?> leading-normal">
                                            <?= htmlspecialchars(isset($mk['status']) ? $mk['status'] : 'N/A') ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-gray-700/50 rounded-xl border border-gray-600 overflow-hidden">
                    <div class="p-4 border-b border-gray-600">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                            <h2 class="text-lg font-semibold text-gray-100">Jadwal Wawancara Hari Ini</h2>
                            <a href="jadwal_wawancara.php" class="text-secondary hover:text-yellow-500 font-medium text-sm inline-flex items-center mt-2 sm:mt-0">
                                Lihat Semua <i class="ri-arrow-right-s-line ml-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gray-800/50 rounded-lg hover:bg-gray-800/70 transition-colors duration-150">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-secondary/20 rounded-lg flex items-center justify-center text-secondary shrink-0">
                                        <i class="ri-calendar-check-line text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-100">Wawancara dengan Emily Watson</h3>
                                        <p class="text-xs text-gray-400">Pewawancara: Dr. Indah P.</p>
                                    </div>
                                </div>
                                <div class="text-right shrink-0 ml-4">
                                    <p class="text-sm font-semibold text-gray-100">09:00 WIB</p>
                                    <p class="text-xs text-gray-400">30 menit</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-800/50 rounded-lg hover:bg-gray-800/70 transition-colors duration-150">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-secondary/20 rounded-lg flex items-center justify-center text-secondary shrink-0">
                                        <i class="ri-calendar-check-line text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-100">Wawancara dengan David Kim</h3>
                                        <p class="text-xs text-gray-400">Pewawancara: Prof. Budi S.</p>
                                    </div>
                                </div>
                                <div class="text-right shrink-0 ml-4">
                                    <p class="text-sm font-semibold text-gray-100">11:00 WIB</p>
                                    <p class="text-xs text-gray-400">45 menit</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div> <?php
    require __DIR__ . '/components/notifications_dropdown.php';

    require __DIR__ . '/components/admin_menu_dropdown.php';

    require __DIR__ . '/components/mobile_menu.php';

    require __DIR__ . '/components/footer_scripts.php';
    ?>
</body>

</html>