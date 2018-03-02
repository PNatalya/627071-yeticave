<?php if ($pages_count > 1): ?>    
	<ul class="pagination-list">
		<?php 
			if ($cur_page == 1) {
				$par_txt ='#';
			}
			else {
				$par_txt=$_SERVER["SCRIPT_NAME"].'?page='.($cur_page-1); 
				if (isset($par_url)) {
					$par_txt = $par_txt.$par_url;
				}
			}
		?>
		<li class="pagination-item pagination-item-prev"><a href="<?=$par_txt;?>">Назад</a></li>
		<?php foreach ($pages as $page): ?>
			<li class="pagination-item <?php if ($page == $cur_page): ?>pagination-item-active<?php endif; ?>">
			<?php 
			$par_txt=$_SERVER["SCRIPT_NAME"].'?page='.$page; 
			if (isset($par_url)) {
				$par_txt = $par_txt.$par_url;
			}
			?>
				<a href="<?=$par_txt;?>"><?=$page;?></a>
			</li>
		<?php endforeach; ?>	
		<?php 
			if ($cur_page == count($pages)) {
				$par_txt ='#';
			}
			else {
				$par_txt=$_SERVER["SCRIPT_NAME"].'?page='.($cur_page+1); 
				if (isset($par_url)) {
					$par_txt = $par_txt.$par_url;
				}
			}
		?>
		<li class="pagination-item pagination-item-next"><a href="<?=$par_txt;?>">Вперед</a></li>
    </ul>
<?php endif; ?>