<?php
global $tmpl; 
if(!$list) 
    return;
?>
<?php 
foreach($list as $item){ 
    $link = FSRoute::_($item->link.'&Itemid='.$item->id);
?>
    <nav class="column span4">
		<h3 class="box-heading c-text"><span><?php echo $item->name; ?></span></h3>
		<ul class="extra">
            <?php
            foreach($item->children as $li){
                $link = FSRoute::_($li->link.'&Itemid='.$li->id);
            ?>
                <li><a rel="nofollow" href="<?php echo $link ?>" title="<?php echo htmlspecialchars($li->name) ?>"><?php echo $li->name ?></a></li>
			<?php } ?>
		</ul>
	</nav> 
<?php } ?>