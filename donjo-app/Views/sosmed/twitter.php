<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td class="side-menu">
                <div class="lmenu">
                    <ul>
                        <li><a href="<?php echo site_url('sosmed')?>">Facebook</a></li>
                    </ul>
                    <ul>
                        <li class="selected"><a href="<?php echo site_url('sosmed/twitter')?>">Twitter</a></li>
                    </ul>
                    <ul>
                        <li><a href="<?php echo site_url('sosmed/google')?>">Google</a></li>
                    </ul>
                    <ul>
                        <li><a href="<?php echo site_url('sosmed/youtube')?>">Youtube</a></li>
                    </ul>
                    <ul>
                        <li><a href="<?php echo site_url('sosmed/instagram')?>">Instagram</li></a>
                    </ul>
                </div>

            </td>
            <td style="background:#fff;padding:5px;">
                <div class="content-header">
                    <h3>Pengaturan Twitter</h3>
                </div>
                <div id="contentpane">
                    <form id="validasi" action="<?php echo $form_action?>" method="POST" enctype="multipart/form-data">
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <table class="form">
                                <tr>
                                    <td width="150">Link Akun Twitter</td>
                                    <td><textarea name="link" class=" required" style="resize: none; height:100px; width:250px;" size="300" maxlength='160'><?php if($main){echo $main['link'];} ?></textarea></td>
                                </tr>
                                <tr>
                                    <th>Aktif</th>
                                    <td>
                                        <div class="uiradio">
                                            <?php $ch='checked';?>
                                            <input type="radio" id="g1" name="enabled" value="1" /<?php if($main['enabled'] == '1'){echo $ch;}?>><label for="g1">Ya</label>
                                            <input type="radio" id="g2" name="enabled" value="2" /<?php if($main['enabled'] == '2'){echo $ch;}?>><label for="g2">Tidak</label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="ui-layout-south panel bottom">

                            <div class="right">
                                <div class="uibutton-group">

                                    <button class="uibutton confirm" type="submit">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </td>
        </tr>
    </table>
</div>
