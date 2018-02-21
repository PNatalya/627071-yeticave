<nav class="nav">
    <ul class="nav__list container">
		<?php if (!isset($cur_cat_id)) {
				$cur_cat_id = 0;
			}
			$valcat = "";?>
			<?php Foreach ($category as $key=> $val): ?> 
			<?php 
				$classname = "" ;
				if ($cur_cat_id == $key) {
					$classname = "nav__item--current";
					$valcat = $val;
				} ?> 
			<li class="nav__item <?=$classname;?> ">
				<a href=<?="history.php?cur_cat_id=".$key;?>><?=$val?></a>
			</li>
		<?php endforeach; ?>			
    </ul>
</nav>
<div class="container">
    <section class="lots">
		<h2>Просмотрено в категории <span>«<?=$valcat;?>»</span></h2>
		<ul class="lots__list">
			<?php foreach ($ads as $key=> $val):?> 
				<?php if ($val['category'] == $valcat):?> 
					<?=include_template('templates/_lot.php', ['lot' => $val, 'lot_id' => $key]);?>
				<?php endif;?>
			<?php endforeach;?>
		</ul>
    </section>
    <ul class="pagination-list">
      <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
      <li class="pagination-item pagination-item-active"><a>1</a></li>
      <li class="pagination-item"><a href="#">2</a></li>
      <li class="pagination-item"><a href="#">3</a></li>
      <li class="pagination-item"><a href="#">4</a></li>
      <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
    </ul>
</div>