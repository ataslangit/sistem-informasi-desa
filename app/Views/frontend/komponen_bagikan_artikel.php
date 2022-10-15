<div class="form-group" style="clear:both;">
    <ul id="pageshare" title="bagikan ke teman anda" class="pagination">
        <?php
        if (isset($artikel->gambar)) {
            $gambar = $artikel->gambar;
        } elseif (isset($artikel->gambar1)) {
            $gambar = $artikel->gambar1;
        } elseif (isset($artikel->gambar2)) {
            $gambar = $artikel->gambar2;
        } elseif (isset($artikel->gambar3)) {
            $gambar = $artikel->gambar4;
        } ?>
        <li class="sbutton" id="FB.Share" name="FB.Share"><a target="_blank" href="https://www.facebook.com/sharer.php?s=100&amp;p[title]=<?= urlencode($artikel->judul); ?>&amp;p[summary]=<?= urlencode($artikel->judul) ?>&amp;p[url]=<?= urlencode(current_url()); ?>&amp;p[images][0]=<?= urlencode(base_url() . '/assets/files/artikel/kecil_' . $gambar); ?>">share on FB</a></li>
        <li class="sbutton" id="rt"><a target="_blank" href="http://twitter.com/share" class="twitter-share-button">Tweet</a></li>
    </ul>
</div>
