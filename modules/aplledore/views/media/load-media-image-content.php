<div class="col-xs-12 imagesContent" id="<?=$pagination['content']?>">
	<?php foreach ($images['content'] as $img): ?>
  	<div class="imageBlock">
  		<figure style="background: url(<?=$img['url']?>) no-repeat 50%;"></figure>
  		<a class="btn btn-success" href="#" data-action="image-add" data-type="<?=$leftcontent['type'];?>" data-label="<?=$leftcontent['input']?>" data-content="<?=$img['url']?>" data-image-id="<?=$img['id']?>">Вставить</a>
  	</div>
  <?php endforeach ?>
</div>
<div class="col-12 imagePagination">
	<nav data-action="pagination" id="<?=$pagination['id']?>" data-limit="<?=$pagination['limit']?>" data-count="<?=$images['count']?>" data-content="#<?=$pagination['content']?>" data-url="<?=$pagination['url']?>" data-preloader=".preloader-imagelist" data-left-content='<?=$pagination['leftcontent']?>'></nav>
</div>