<div class="artikel">
    <h3>DAFTAR REKAM CETAK SURAT</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th align="left">Nomor Surat</th>
                <th align="left">Jenis Surat</th>
                <th align="left">Nama Staf</th>
                <th align="left">Tanggal</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($surat_keluar as $data) : ?>
                <tr>
                    <td align="center" width="2"><?= $data['no'] ?></td>
                    <td><?= $data['no_surat'] ?></td>
                    <td><?= $data['format'] ?></td>
                    <td><?= unpenetration($data['pamong']) ?></td>
                    <td><?= tgl_indo2($data['tanggal']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="teks">



        <?php //$this->load->view('surat/signature.php');
            ?>
    </div>
    <div>
        <ol>
        </ol>
    </div>
</div>
