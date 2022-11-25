<?php view('layouts/header.php');?>
<div id="contentwrapper">
    <div id="contentcolumn">
        <div class="innertube">
            <?php view('partials/gallery.php');?>
        </div>
    </div>
</div>
<div id="rightcolumn">
    <div class="innertube">
        <?php view('partials/side.right.php');?>
    </div>
</div>
<div id="footer">
    <?php view('partials/copywright.tpl.php');?>
</div>
</div>
</body>

</html>
