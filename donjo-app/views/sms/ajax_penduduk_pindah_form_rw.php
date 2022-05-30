<td>RW</td>
<td>
    <select name="rw" onchange="RWSel('<?= $dusun ?>',this.value)" class="required">
        <option>Pilih RW&nbsp;</option>
        <?php foreach ($rw as $data) { ?>
            <option><?= $data['rw'] ?></option>
        <?php } ?>
    </select>
</td>
