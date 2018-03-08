<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="libraries/uploadify/myuploadify.js"></script>
    <style>
        #sortable { list-style-type: none; margin: 0; padding: 0; }
        #sortable li {  margin: 10px; cursor:move;  float: left; text-align: center;background:#FFFFFF;}
        #sortable li div{ margin:0px auto;}
        #sortable span{ font-family:tahoma, Arial; font-size:11px; color:#cc0000; cursor:pointer; }
        #sortable span:hover{ text-decoration:underline;}
        #sortable font{ padding:0px 2px; color:#000000;}
        #sortable li .image-area-single p{ margin: 0; padding: 0;}
        #sortable li .image-area-single{background-color: #FFF; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.25); padding:10px; position: relative;}
        #sortable li .image-area-single .img{ overflow:hidden;}
        #sortable li .image-area-single .del{ position: absolute; top: -10px; right: -10px;}
        #sortable li .image-area-single .del img{ opacity: 0.5;}
        #sortable li .image-area-single .del img:hover{ opacity: 1;}
    </style>
</head>
<body>
<ul id="sortable">
	<?php foreach($listImages as $item){ ?>
		<li id="sort_<?php echo $item->id;?>">
			<div class="image-area-single">
				<p class="img"><img src="<?php echo URL_ROOT.str_replace('/original/','/tiny/', $item->image)?>" /></p>
				<p class="del" align="center"><span onclick="removeElement('sort_<?php echo $item->id;?>','<?php echo $item->id; ?>')"><img src="libraries/uploadify/delete.png"/></span></p>
			</div>
		</li>
	<?php } ?>
</ul>
</body>
</html>