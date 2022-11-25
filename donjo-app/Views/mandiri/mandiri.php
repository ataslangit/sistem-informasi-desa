<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:5px;">
                <div id="contentpane">
                    <div class="ui-layout-north panel">
                        <div class="left">
                            <div class="uibutton-group">
                                <a href="<?php echo site_url('mandiri/ajax_pin')?>" target="ajax-modal" rel="window" header="PIN Warga" class="uibutton tipsy south" title="PIN Warga"><span class="fa fa-plus">&nbsp;</span>Hasilkan PIN</a>
                            </div>
                        </div>
                    </div>
                    <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                        <table class="list">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th align="left">NIK</th>
                                    <th align="left">Nama Penduduk</th>
                                    <th align="left" width='160'>Tanggal Buat</th>
                                    <th align="left" width='160'>Login Terakhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($main as $data): ?>
                                <tr>
                                    <td align="center" width="2"><?php echo $data['no']?></td>
                                    <td><?php echo $data['nik']?></td>
                                    <td><?php echo unpenetration($data['nama'])?></td>
                                    <td><?php echo tgl_indo2($data['tanggal_buat'])?></td>
                                    <td><?php echo tgl_indo2($data['last_login'])?></td>
                                </tr>
                                <?php
						endforeach;
						?>
                            </tbody>
                        </table>
                    </div>
                    <div class="ui-layout-south panel bottom">
                        <div class="left">
                            <div class="table-info">
                                <form id="paging" action="<?php echo site_url('mandiri')?>" method="post">
                                    <label>Tampilkan</label>
                                    <select name="per_page" onchange="$('#paging').submit()">
                                        <option value="20" <?php selected($per_page,20); ?>>20</option>
                                        <option value="50" <?php selected($per_page,50); ?>>50</option>
                                        <option value="100" <?php selected($per_page,100); ?>>100</option>
                                    </select>
                                    <label>Dari</label>
                                    <label><strong><?php echo $paging->num_rows?></strong></label>
                                    <label>Total Data</label>
                                </form>
                            </div>
                        </div>
                        <div class="right">
                            <div class="uibutton-group">
                                <?php if($paging->start_link): ?>
                                <a href="<?php echo site_url("mandiri/index/$paging->start_link/$o")?>" class="uibutton">First</a>
                                <?php endif; ?>
                                <?php if($paging->prev): ?>
                                <a href="<?php echo site_url("mandiri/index/$paging->prev/$o")?>" class="uibutton">Prev</a>
                                <?php endif; ?>
                            </div>
                            <div class="uibutton-group">
                                <?php for($i=$paging->start_link;$i<=$paging->end_link;$i++): ?>
                                <a href="<?php echo site_url("mandiri/index/$i/$o")?>" <?php jecho($p,$i,"class='uibutton special'")?> class="uibutton"><?php echo $i?></a>
                                <?php endfor; ?>
                            </div>
                            <div class="uibutton-group">
                                <?php if($paging->next): ?>
                                <a href="<?php echo site_url("mandiri/index/$paging->next/$o")?>" class="uibutton">Next</a>
                                <?php endif; ?>
                                <?php if($paging->end_link): ?>
                                <a href="<?php echo site_url("mandiri/index/$paging->end_link/$o")?>" class="uibutton">Last</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
<script>
    $(function() {
        <?php if($_SESSION['pin']){ ?>
        modalpin('pin', 'PIN WARGA', 'Berikut adalah kode PIN Anda. Sila catat atau ingat dengan baik. Kode PIN ini bersifat rahasia dan hanya bisa dilihat satu kali ini. Jika lupa PIN, lapor kepada perangkat desa untuk dilakukan reset. <br> <h4>Kode PIN : <?php echo $_SESSION['pin']; ?></h4>');
        <?php }?>

        function modalpin(id, title, message, width, height) {
            if (width == null || height == null) {
                width = '500';
                height = 'auto';
            }
            $('#' + id + '').remove();
            $('body').append('<div id="' + id + '" title="' + title + '" style="display:none;">' + message + '</div>');
            $('#' + id + '').dialog({
                resizable: false,
                draggable: true,
                width: width,
                height: height,
                autoOpen: true,
                modal: false,
                dragStart: function(event, ui) {
                    $(this).parent().addClass('drag');
                },
                dragStop: function(event, ui) {
                    $(this).parent().removeClass('drag');
                },
                buttons: {
                    "OK": function() {
                        $('#' + id + '').remove();
                        $(this).dialog("close");
                    }
                }
            });
            $('#' + id + '').dialog('open');
        }
    });

</script>
<?php unset($_SESSION['pin']); ?>
