
<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td class="side-menu">
                <?= view('program_bantuan/menu_kiri.php')

        ?>
            </td>
            <td class="contentpane">
                <legend>Profil Penerima Manfaat Program</legend>
                <?php
            $profil = $program[1];
            echo '
			<div style="margin-bottom:2em;">
				<table class="form">
					<tr><td>Nama</td><td><strong>' . strtoupper($profil['nama']) . '</strong></td></tr>
					<tr><td>Keterangan</td><td><strong>' . $profil['ndesc'] . '</strong></td></tr>
				</table>
			</div>
			';

            $programkerja = $program[0];
            ?>
                <legend>Program yang pernah diikuti</legend>
                <div class="table-panel top">
                    <table class="list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Waktu/Tanggal</th>
                                <th>Nama Program</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
$nomer = 0;

foreach ($programkerja as $item):
    $nomer++;
?>
                            <tr>
                                <td class="angka" style="width:40px;"><?= $nomer; ?></td>
                                <td><?= fTampilTgl($item['sdate'], $item['edate']); ?></td>
                                <td><a href="<?= site_url('program_bantuan/detail/' . $item['id'] . '/')?>"><?= $item['nama'] ?></a></td>
                                <td><?= $item['ndesc']; ?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </td>
            <td style="width:250px;" class="contentpane">
                <?= view('program_bantuan/panduan.php');
        ?>
            </td>
        </tr>
    </table>
</div>
