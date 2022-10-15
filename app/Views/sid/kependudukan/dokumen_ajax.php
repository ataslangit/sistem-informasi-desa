<style>
    .bawah {
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 430px;
    }
</style>
<table class="list">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Dokumen</th>
            <th>Tgl Upload</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_dokumen as $data) { ?>
            <tr>
                <td align="center" width="2"><?= $data['no'] ?></td>
                <td><a href="<?= base_url() ?>/assets/files/dokumen/<?= urlencode($data['satuan']) ?>"><?= $data['nama'] ?></a></td>
                <td><?= tanggal($data['tgl_upload']) ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
