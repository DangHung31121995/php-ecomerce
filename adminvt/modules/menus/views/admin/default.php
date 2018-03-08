<?php 
include_once '../libraries/tree/tree.php';
$list = Tree::indentRows($list);
$root_total = 0;
$root_last = 0;
$url = $_SERVER['REQUEST_URI'];
foreach ($list as $item){
	if(!@$item->parent_id){
		$root_total ++ ;
		$root_last = $item->id;
	}
}
?>
<ul>
    <?php 
	$num_child = array();
	$parant_close = 0;
	foreach ($list as $item){
		$class = '';
		if($item->link){
			$link = trim($item->link);
			if(strpos($url,$link) !== false)
				$class .= 'selected';
		}else{
			$link = "javascript:void(0)";
		}
        $has_child = '';
        if($item->children > 0)
            $has_child = ' has-child';
		if(!$item->parent_id){
        ?>
            <li class="parent <?php echo $class.$has_child;?>">
                <div class="bound">
                    <a href="<?php echo $link; ?>">
                        <span class="icon fl">
                            <span><img src="templates/default/images/module/<?php echo $item->image;?>" onerror="this.src='templates/default/images/module/no-image.png'" /></span>
                        </span>
                        <span class="name fr">
                            <?php echo FSText::_(trim($item->name)); ?>
                        </span>
                        <div class="clearfix"></div>
                    </a>
                </div><!--end: .bound-->
        <?php }else{ ?>
            <li class="<?php echo $has_child;?> <?php echo $has_child?'li_has_child':''?>">
                <a class="<?php echo $class;?> <?php echo $has_child?'a_has_child':''?>" href="<?php echo $link; ?>"><?php echo FSText::_(trim($item->name)); ?></a>
        <?php } ?>
	    <?php 
		$num_child[$item->id] = $item->children ;
		if($item->children  > 0)
			echo "<ul class='child'>";
		if(@$num_child[$item->parent_id] == 1){
			if($item->children > 0){
				$parant_close ++;
			}else{
				$parant_close ++;
				for($i = 0 ; $i < $parant_close; $i++){
					echo "</ul>";
				}
				$parant_close = 0;
				$num_child[$item->parent_id]--;
			}
			if(@$num_child[$item->parent_id] >= 1) 
				$num_child[$item->parent_id]--;
		}	
		if(isset($num_child[$item->parent_id] ) && ($num_child[$item->parent_id] == 1) )
			echo "</ul>";
		if(isset($num_child[$item->parent_id]) && ($num_child[$item->parent_id] >= 1) )
			$num_child[$item->parent_id]--;
        echo '</li>';
	}
	?>
</ul>