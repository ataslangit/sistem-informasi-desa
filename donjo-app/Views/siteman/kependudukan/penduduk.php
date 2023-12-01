<?= $this->extend('siteman/template') ?>

<?= $this->section('content') ?>

<?= $this->include('siteman/partials/sidebar') ?>
<?= $this->include('siteman/partials/navbar') ?>

<!-- Main Container -->
<main id="main-container">
    <!-- Page Content -->
    <div class="content">

        <nav class="breadcrumb push bg-body-extra-light rounded-pill px-4 py-2">
            <a class="breadcrumb-item" href="<?= site_url(route_to('siteman.dashboard.view')) ?>">SiteMan</a>
            <a class="breadcrumb-item" href="<?= site_url(route_to('siteman.penduduk.view')) ?>">Kependudukan</a>
            <span class="breadcrumb-item active">Manajemen Penduduk</span>
        </nav>

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Blank <small>Get Started</small></h3>
            </div>
            <div class="block-content block-content-full">
                <!-- DataTables functionality is initialized with .js-dataTable-responsive class in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="checkall"></th>
                            <th>No</th>
                            <th width="156">Aksi</th>
                            <th>NIK</th>
                            <th>Nomor KK</th>
                            <th>Nomor Rumah Tangga</th>
                            <th>Nama</th>
                            <th>L/P</th>
                            <th>Umur</th>
                            <th>Tanggal Lahir</th>
                            <th>Dusun</th>
                            <th>RW</th>
                            <th>RT</th>
                            <th>Pendidikan dalam KK</th>
                            <th>Pekerjaan</th>
                            <th>Kawin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" class="checkall"></td>
                            <td>1</td>
                            <th width="156">Aksi</td>
                            <td>NIK</td>
                            <td>Nomor KK</td>
                            <td>Nomor Rumah Tangga</td>
                            <td>Nama</td>
                            <td>L/P</td>
                            <td>Umur</td>
                            <td>Tanggal Lahir</td>
                            <td>Dusun</td>
                            <td>RW</td>
                            <td>RT</td>
                            <td>Pendidikan dalam KK</td>
                            <td>Pekerjaan</td>
                            <td>Kawin</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?= $this->include('siteman/partials/footer') ?>

<?= $this->endSection() ?>

<?= $this->section('css') ?>

<link rel="stylesheet" href="<?= base_url('build/plugins/datatables/dataTables.bootstrap5.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('build/plugins/datatables/responsive.bootstrap5.min.css') ?>">

<?= $this->endSection() ?>

<?= $this->section('js') ?>

<script src="<?= base_url('build/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('build/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('build/plugins/datatables/dataTables.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('build/plugins/datatables/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('build/plugins/datatables/responsive.bootstrap5.min.js') ?>"></script>

<script>
    <?php /*
    $(function() {
        var keyword = <?= $keyword ?? '' ?>;
        $("#cari").autocomplete({
            source: keyword
        });
    });
    */ ?>

    // datatables
    document.addEventListener('DOMContentLoaded', function() {
        let table = new DataTable('.js-dataTable-responsive', {
            pagingType: "full_numbers",
            pageLength: 5,
            lengthMenu: [
                [5, 10, 20],
                [5, 10, 20]
            ],
            autoWidth: false,
            responsive: true
        });
    });
</script>
<?= $this->endSection() ?>
