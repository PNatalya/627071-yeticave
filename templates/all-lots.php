<div class="container">
    <section class="lots">
		<h2>Все лоты в категории <span>«<?=$cur_cat_name;?>»</span></h2>
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
