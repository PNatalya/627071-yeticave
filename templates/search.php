  <div class="container">
    <section class="lots">
      <h2>Результаты поиска по запросу «<span><?=htmlspecialchars($search)?></span>»</h2>
      <ul class="lots__list">
		<?php foreach ($ads as $key=> $val):?> 
			<?=include_template('_lot.php', ['lot' => $val]);?>
		<?php endforeach;?>
      </ul>
		<?php if (!count($ads)): ?>
			<p class="error">По вашему запросу ничего не найдено</p>
		<?php endif; ?>	  
    </section>
	<?=include_template('_pagination.php', ['pages' => $pages, 'pages_count' => $pages_count, 'cur_page' => $cur_page, 'par_url' => $par_url]);?>
  </div>