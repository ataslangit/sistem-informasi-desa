<?= view('layouts/header.php');?>
<div id="contentwrapper">
    <div id="contentcolumn">
        <div class="innertube">
            <?php
							if($m==1)
								view('partials/mandiri.php');
							elseif($m==2)
								view('partials/layanan.php');
							else
								view('partials/lapor.php');
						?>
        </div>
    </div>
</div>
<div id="rightcolumn">
    <div class="innertube">
        <?= view('partials/side.right.php');?>
    </div>
</div>
<div id="footer">
    <?= view('partials/copywright.tpl.php');?>
</div>
</div>
</body>

</html>
