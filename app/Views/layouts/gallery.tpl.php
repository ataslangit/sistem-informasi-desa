        <?php echo view('layouts/header.php'); ?>
        <div id="contentwrapper">
            <div id="contentcolumn">
                <div class="innertube">
                    <?php echo view('partials/gallery.php'); ?>
                </div>
            </div>
        </div>
        <div id="rightcolumn">
            <div class="innertube">
                <?php echo view('partials/side.right.php'); ?>
            </div>
        </div>
        <div id="footer">
            <?php echo view('partials/copywright.tpl.php'); ?>
        </div>
    </div>
</body>

</html>
