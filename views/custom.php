<?php if( isset($debug) && ($debug) ): ?>
<ul>
    <li>Title: <?php echo $title; ?></li>
    <li>Template: <?php echo $template; ?></li>
    <li>Color: <?php echo $color; ?></li>
    <li>Size: <?php echo $size; ?></li>
    <li>Sites: <?php var_dump($sites); ?></li>
</ul>
<?php endif; ?>
<?php
$i = 0;
if( ! empty($sites) && is_array($sites) ): 
?>
<ul class="social-media-icons circle <?php echo $color; ?> size-<?php echo $size; ?>">
    <?php foreach($sites as $site): ?> 
    <li class="<?php echo $site; ?> sm-site"><a href="<?php echo $urls[$i]; ?>" target="_blank"></a></li>
    <?php    $i++; endforeach; ?>
</ul>
<?php endif;