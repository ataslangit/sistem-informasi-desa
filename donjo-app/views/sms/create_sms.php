<script>
    $(function() {
        var keyword = <?= $keyword ?>;
        $("#cari").autocomplete({
            source: keyword
        });
    });
</script>
<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td class="side-menu">
                <fieldset>
                    <div class="lmenu">
                        <ul>
                            <li><a href="<?= site_url('sms/clear') ?>">Kotak Masuk</a></li>
                            <li class="selected"><a href="<?= site_url('sms/outbox') ?>">Tulis Pesan</a></li>
                            <li><a href="<?= site_url('sms/sentitem') ?>">Berita Terkirim</a></li>
                            <li><a href="<?= site_url('sms/pending') ?>">Pesan Tertunda</a></li>
                        </ul>
                    </div>
                </fieldset>

            </td>
            </td>
            <td style="background:#fff;padding:5px;">
                <div class="content-header">
                    <h3>Kirim Pesan</h3>
                </div>
                <div id="contentpane">
                    <?= form_open('', ['id' => 'mainform', 'name' => 'mainform']) ?>
                    <div class="ui-layout-north panel">
                        <div class="left">
                            <div class="uibutton-group">
                                <a href="<?= site_url('sms/form/0/0/4') ?>" class="uibutton tipsy south" title="Tulis Pesan Baru" target="ajax-modalx" rel="window" header="Tulis Pesan Baru"><span class="icon-comment icon-large">&nbsp;</span>Tulis Pesan Baru</a>
                                <a href="<?= site_url('sms/broadcast/0/0/2') ?>" class="uibutton tipsy south" title="Broadcast Pesan" target="ajax-modalx" rel="window" header="Tulis Pesan Broadcast"><span class="icon-comments icon-large">&nbsp;</span>Kirim Pesan ke Banyak</a>
                            </div>
                        </div>
                    </div>
                    <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                        <table class="list">
                            <thead>
                                <tr>
                                    <th width="20">No</th>
                                    <th width="150">Nama</th>
                                    <?php if ($o === 2) : ?>
                                        <th align="left" width='100'><a href="<?= site_url("sms/index/{$p}/1") ?>">Nomor HP<span class="ui-icon ui-icon-triangle-1-n"></span></a></th>
                                    <?php elseif ($o === 1) : ?>
                                        <th align="left" width='100'><a href="<?= site_url("sms/index/{$p}/2") ?>">Nomor HP<span class="ui-icon ui-icon-triangle-1-s"></span></a></th>
                                    <?php else : ?>
                                        <th align="left" width='100'><a href="<?= site_url("sms/index/{$p}/1") ?>">Nomor HP<span class="ui-icon ui-icon-triangle-2-n-s"></span></a></th>
                                    <?php endif; ?>

                                    <th align="left">Isi Pesan</th>


                                    <?php if ($o === 6) : ?>
                                        <th align="left" width='160'><a href="<?= site_url("sms/index/{$p}/5") ?>">Dikirim<span class="ui-icon ui-icon-triangle-1-n">&nbsp;</span></a></th>
                                    <?php elseif ($o === 5) : ?>
                                        <th align="left" width='160'><a href="<?= site_url("sms/index/{$p}/6") ?>">Dikirim<span class="ui-icon ui-icon-triangle-1-s">&nbsp;</span></a></th>
                                    <?php else : ?>
                                        <th align="left" width='160'><a href="<?= site_url("sms/index/{$p}/5") ?>">Dikirim<span class="ui-icon ui-icon-triangle-2-n-s">&nbsp;</span></a></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;

        foreach ($main as $data) : ?>
                                    <tr>
                                        <td align="center" width="2"><?= $no;
            $no++; ?></td>

                                        <td><?= unpenetration($data['nama']) ?></td>
                                        <td><?= $data['DestinationNumber'] ?></td>
                                        <td><?= $data['TextDecoded'] ?></td>

                                        <td><?= tgl_indo2($data['SendingDateTime']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?= form_close() ?>
                    <div class="ui-layout-south panel bottom">
                        <div class="left">
                            <div class="table-info">
                                <?= form_open('sms/outbox', ['id' => 'paging']) ?>
                                    <label>Tampilkan</label>
                                    <select name="per_page" onchange="$('#paging').submit()">
                                        <option value="20" <?php selected($per_page, 20); ?>>20</option>
                                        <option value="50" <?php selected($per_page, 50); ?>>50</option>
                                        <option value="100" <?php selected($per_page, 100); ?>>100</option>
                                    </select>
                                    <label>Dari</label>
                                    <label><strong><?= $paging->num_rows ?></strong></label>
                                    <label>Total Data</label>
                                    <?= form_close() ?>
                            </div>
                        </div>
                        <div class="right">
                            <div class="uibutton-group">
                                <?php if ($paging->start_link) : ?>
                                    <a href="<?= site_url("sms/outbox/{$paging->start_link}/{$o}") ?>" class="uibutton">Awal</a>
                                <?php endif; ?>
                                <?php if ($paging->prev) : ?>
                                    <a href="<?= site_url("sms/outbox/{$paging->prev}/{$o}") ?>" class="uibutton">Prev</a>
                                <?php endif; ?>
                            </div>
                            <div class="uibutton-group">

                                <?php for ($i = $paging->start_link; $i <= $paging->end_link; $i++) : ?>
                                    <a href="<?= site_url("sms/outbox/{$i}/{$o}") ?>" <?php jecho($p, $i, "class='uibutton special'") ?> class="uibutton"><?= $i ?></a>
                                <?php endfor; ?>
                            </div>
                            <div class="uibutton-group">
                                <?php if ($paging->next) : ?>
                                    <a href="<?= site_url("sms/outbox/{$paging->next}/{$o}") ?>" class="uibutton">Next</a>
                                <?php endif; ?>
                                <?php if ($paging->end_link) : ?>
                                    <a href="<?= site_url("sms/outbox/{$paging->end_link}/{$o}") ?>" class="uibutton">Akhir</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>