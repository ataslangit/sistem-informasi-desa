<script>
    $(function() {
        var cd_item_width = (parseInt($('#cd_item').width()) / 2);
        var label_width = (parseInt($('#cd_item').width()) / 2) - 32;
        $('#cd_item div').css('clear', 'both');
        $('#cd_item div').css('float', 'left');
        $('#cd_item div').css('width', cd_item_width);
        $('#cd_item label').css('width', label_width);
        $('#cd_item input:checked').parent().css({
            'background': '#c9cdff',
            'border': '1px solid #7a82eb'
        });
        $('#cd_item input').change(function() {
            if ($(this).is('input:checked')) {
                $('#cd_item input').parent().css({
                    'background': '#ffffff',
                    'border': '1px solid #ddd'
                });
                $('#cd_item input:checked').parent().css({
                    'background': '#c9cdff',
                    'border': '1px solid #7a82eb'
                });
                $(this).parent().css({
                    'background': '#c9cdff',
                    'border': '1px solid #7a82eb'
                });
            } else {
                $(this).parent().css({
                    'background': '#fafafa',
                    'border': '1px solid #ddd'
                });
            }
        });
        $('#cd_item label').click(function() {
            $(this).prev().trigger('click');
        })
        $('#kirim button').click(function() {
            $('#' + 'child').submit();
        })
    });
</script>
<style>
    #cd_item div {
        margin: 1px 0;
        background: #fafafa;
        border: 1px solid #ddd;
    }

    #cd_item input {
        vertical-align: middle;
        margin: 0px 2px;
    }

    #cd_item label {
        padding: 4px 10px 0px 2px;
        font-size: 11px;
        line-height: 14px;
        font-weight: normal;
    }

    table.head {
        font-size: 14px;
        font-weight: bold;
    }
</style>
<?= form_open($form_action, ['id' => 'child']) ?>
    <table width="100%">
        <?php foreach ($list_jawab as $data) { ?>
            <tr>
                <td>
                    <hr>
                </td>
            </tr>
            <tr>
                <td><label class='tanya'><?= $data['pertanyaan'] ?></label></td>
            </tr>
            <?php if ($data['id_tipe'] === 1) { ?>

                <tr>
                    <td id="cd_item">
                        <?php foreach ($data['parameter_respon'] as $data2) { ?>
                            <div>
                                <input type="radio" name="rb[<?= $data['id'] ?>]" value="<?= $data['id'] ?>.<?= $data2['id_parameter'] ?>" <?php if ($data2['cek']) {
    echo ' checked';
} ?>><label><?= $data2['kode_jawaban'] ?>. <?= $data2['jawaban'] ?></label>
                            </div>
                        <?php } ?>

                    <?php } elseif ($data['id_tipe'] === 2) { ?>

                        <?php foreach ($data['parameter_respon'] as $data2) { ?>
                <tr>
                    <td id="cd_item">
                        <div>
                            <input type="checkbox" name="cb[<?= $data2['id_parameter'] ?>]" value="<?= $data2['id_parameter'] ?>.<?= $data['id'] ?>" <?php if ($data2['cek']) {
    echo ' checked';
} ?>>
                            <label><?= $data2['kode_jawaban'] ?>. <?= $data2['jawaban'] ?></label>
                        </div>
                    <?php } ?>

                <?php } elseif ($data['id_tipe'] === 3) { ?>

                    <?php if ($data['parameter_respon']) { ?>
                        <?php $data2 = $data['parameter_respon']; ?>
                <tr>
                    <td id="">
                        <div style="display:inline-block;"><input name="ia[<?= $data['id'] ?>]" type="text" class="inputbox number" size="10" value="<?= $data2['jawaban'] ?>" /></div>
                    <?php } else { ?>
                <tr>
                    <td id="">
                        <div style="display:inline-block;"><input name="ia[<?= $data['id'] ?>]" type="text" class="inputbox number" size="10" value="" /></div>
                    <?php } ?>

                <?php } elseif ($data['id_tipe'] === 4) { ?>

                    <?php if ($data['parameter_respon']) { ?>
                        <?php $data2 = $data['parameter_respon']; ?>
                <tr>
                    <td id="">
                        <div style="display:inline-block;"><input name="it[<?= $data['id'] ?>]" type="text" class="inputbox" size="100" value="<?= $data2['jawaban'] ?>" /></div>
                    <?php } else { ?>
                <tr>
                    <td id="">
                        <div style="display:inline-block;"><input name="it[<?= $data['id'] ?>]" type="text" class="inputbox" size="100" value="" /></div>
                    <?php } ?>

                <?php } ?>
            <?php } ?>
                <tr>
                    <td>
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <button class="uibutton confirm" id="kirim">Simpan</button>
                    </td>
                </tr>
    </table>
<?= form_close() ?>
