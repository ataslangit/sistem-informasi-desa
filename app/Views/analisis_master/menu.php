<div id="pageC">
    <?php $this->load->view('analisis_master/left', $data); ?>
    <div id="contentpane">
        <div class="ui-layout-north panel">
            <h3><a href="<?= site_url() ?>analisis_master/menu/<?= $_SESSION['analisis_master'] ?>"><?= $analisis_master['nama'] ?></a></h3>
        </div>
        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
            <div style="max-width:640px;text-align:justify;border:1px solid #cecece;padding:10px 10px 10px 4px;background:#efffef;">
                <?= $analisis_master['deskripsi'] ?><br /><br /><br />
            </div>
        </div>
        <div class="ui-layout-south panel bottom">
            <div class="left">
                <a href="<?= site_url() ?>analisis_master" class="uibutton icon prev">Kembali</a>
            </div>
            <div class="right">
                <div class="uibutton-group">
                </div>
            </div>
        </div>
        </td>
        </tr>
        </table>
    </div>
