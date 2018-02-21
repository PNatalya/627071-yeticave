  <nav class="nav">
    <ul class="nav__list container">
		<?php 
			if (!isset($cur_cat_id)) {
				$cur_cat_id = 0;
			}
			$valcat = "";
			Foreach ($category as $key=> $val): ?> 
				<?php 
				$classname = "" ;
				if ($cur_cat_id == $key) {
					$classname = "nav__item--current";
					$valcat = $val;
				} ?> 
			<li class="nav__item <?=$classname;?>">
				<a href=<?="all-lots.php?cur_cat_id=".$key;?>><?=$val?></a>
			</li>
		<?php EndForeach ?>			
    </ul>
  </nav>
  <div class="container">
    <section class="lots">
      <h2>Все лоты в категории <span>«<?=$valcat?>»</span></h2>
	  <ul class="lots__list">
	  <?php foreach ($ads as $key=> $val):?> 
		<?php if ($val['category'] == $valcat):?> 
			<?=include_template('templates/_lot.php', ['lot' => $val, 'lot_id' => $key]);?>
		<?php endif;?>
	  <?php endforeach;?>
	  </ul>
    </section>
	<?php
		$cur_page = $pages_count = 3;
	?>
	<?/*=include_template('templates/_pagination.php', ['pages' => $pages, 'pages_count' => $pages_count, 'cur_page' => $cur_page]);*/?>
  </div>
