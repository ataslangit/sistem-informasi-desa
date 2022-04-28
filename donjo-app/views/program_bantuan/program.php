<?php
?>
<div id="pageC">
<table class="inner">
	<tr style="vertical-align:top">
		<td class="side-menu">
		<?php
        $this->load->view('program_bantuan/menu_kiri.php')
        ?>
		</td>
		<td class="contentpane">
			<div id="contentpane">
				<div class="ui-layout-center" id="maincontent">
					<?php
                    if ($tampil === 0) {
                        echo '<legend>Daftar Program Bantuan</legend>';
                    } else {
                        echo '<legend>Daftar Program Bantuan dengan Sasaran ' . $sasaran[$tampil] . '</legend>';
                    }

                    if ($_SESSION['success'] === 1) {
                        echo '
						<div>
						' . $_SESSION['pesan'] . '
						</div>';
                        $_SESSION['success'] === 0;
                    }

                    ?>

					<div class="table-panel top">
						<table class="list">
							<thead><tr><th>#</th><th></th><th>Nama Program</th><th>Masa Berlaku</th><th>Sasaran</th></tr></thead>
							<tbody>
							<?php
                            $nomer = 0;

                            foreach ($program as $item):
                                $nomer++;
                            ?>
								<tr>
									<td class="angka" style="width:40px;"><?= $nomer; ?></td>
									<td style="width:120px;">
										<div class="uibutton-group">
											<a class="uibutton tipsy south" href="<?= site_url('program_bantuan/detail/' . $item['id'] . '/'); ?>" title="Detail"><span class="icon-list icon-large"></span> Detail</a>
											<a class="uibutton tipsy south" href="<?= site_url('program_bantuan/edit/' . $item['id'] . '/'); ?>" title="Ubah"><span class="icon-pencil icon-large"></span></a>
											<a class="uibutton tipsy south" href="<?= site_url('program_bantuan/hapus/' . $item['id'] . '/'); ?>" title="Hapus Data" target="confirm" message="Apakah Anda Yakin?" header="Hapus Data"><span class="icon-trash icon-large"></span></a>
										</div>
									</td>
									<td><a href="<?= site_url('program_bantuan/detail/' . $item['id'] . '/')?>"><?= $item['nama'] ?></a></td>
									<td><?= fTampilTgl($item['sdate'], $item['edate']); ?></td>
									<td><a href="<?= site_url('program_bantuan/sasaran/' . $item['sasaran'] . '/' . $sasaran[$item['sasaran']] . '')?>"><?= $sasaran[$item['sasaran']]?></a></td>
								</tr>
							<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</td>
		<td style="width:250px;" class="contentpane">
		<?php
        $this->load->view('program_bantuan/panduan.php');
        ?>
		</td>
	</tr>
</table>
</div>