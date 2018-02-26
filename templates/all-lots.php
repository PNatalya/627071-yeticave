<nav class="nav">
    <ul class="nav__list container">
		<?php $valcat = "";
			foreach ($category as $key=> $val): ?> 
				<?php 
				$classname = "" ;
				if ($cur_cat_id == $val['id']) {
					$classname = "nav__item--current";
					$valcat = $val['name'];
				} ?> 
			<li class="nav__item <?=$classname;?>">
				<a href=<?="all-lots.php?cur_cat_id=".$val['id'];?>><?=$val['name']?></a>
			</li>
		<?php endforeach; ?>			
    </ul>
</nav>
<div class="container">
    <section class="lots">
		<h2>Все лоты в категории <span>«<?=$valcat?>»</span></h2>
		<ul class="lots__list">
		<?php foreach ($ads as $key=> $val):?> 
			<?=include_template('_lot.php', ['lot' => $val]);?>
		<?php endforeach;?>
		</ul>
    </section>
	<?php
		$cur_page = $pages_count = 3;
	?>
	<?/*=include_template('_pagination.php', ['pages' => $pages, 'pages_count' => $pages_count, 'cur_page' => $cur_page]);*/?>
</div>
