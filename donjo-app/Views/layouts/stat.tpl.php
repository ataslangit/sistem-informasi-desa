<?= view('layouts/header.php'); ?>
<div id="contentwrapper">
    <div id="contentcolumn">
        <div class="innertube">
            <?php
                        if ($tipe === 2) {
                            if ($tipex === 1) {
                                echo view('partials/statistik_sos.php');
                            } elseif ($tipex === 3) {
                                echo view('partials/statistik_ras.php');
                            } else {
                                echo view('partials/statistik_jam.php');
                            }
                        } elseif ($tipe === 3) {
                            echo view('partials/wilayah.php');
                        } else {
                            echo view('partials/statistik.php');
                        }
                        ?>
        </div>
    </div>
</div>
<div id="rightcolumn">
    <div class="innertube">
        <?= view('partials/side.right.stat.php'); ?>
    </div>
</div>

<div id="footer">
    <?= view('partials/copywright.tpl.php'); ?>
</div>
</div>
</body>

</html>
