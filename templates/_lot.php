<li class="lots__item lot">
	<div class="lot__image">
		<img src=<?=$lot['img'];?> width="350" height="260" alt=<?=htmlspecialchars($lot['name']);?>>
	</div>
	<div class="lot__info">
		<span class="lot__category"><?=$lot['category'];?></span>
		<h3 class="lot__title"><a class="text-link" href=<?=$url="lot.php?lot_id=".$lot['id'];?>><?=htmlspecialchars($lot['name']);?></a></h3>
		<div class="lot__state">
			<div class="lot__rate">
				<span class="lot__amount">Стартовая цена</span>
				<span class="lot__cost"><?=format_sum(strip_tags($lot['price']));?></span>
			</div> 
			<div class="lot__timer timer"><!-- timer--finishing-->
				<span><?=timelot($lot['dt_close']);?></span>
			</div>
		</div>
	</div>
</li>