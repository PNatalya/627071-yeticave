<?php

?>
<!DOCTYPE html>
<body>
<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="all-lots.php?cur_cat_id=0">Доски и лыжи</a>
            </li>
            <li class="promo__item promo__item--attachment">
                <a class="promo__link" href="all-lots.php?cur_cat_id=1">Крепления</a>
            </li>
            <li class="promo__item promo__item--boots">
                <a class="promo__link" href="all-lots.php?cur_cat_id=2">Ботинки</a>
            </li>
            <li class="promo__item promo__item--clothing">
                <a class="promo__link" href="all-lots.php?cur_cat_id=3">Одежда</a>
            </li>
            <li class="promo__item promo__item--tools">
                <a class="promo__link" href="all-lots.php?cur_cat_id=4">Инструменты</a>
            </li>
            <li class="promo__item promo__item--other">
                <a class="promo__link" href="all-lots.php?cur_cat_id=5">Разное</a>
            </li>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
			<?php foreach ($ads as $key=> $val): ?> 
				<li class="lots__item lot">
					<div class="lot__image">
						<img src=<?=$val['img'];?> width="350" height="260" alt=<?=htmlspecialchars($val['name']);?>>
					</div>
					<div class="lot__info">
						<span class="lot__category"><?=$val['category'];?></span>
						<h3 class="lot__title"><a class="text-link" href=<?=$url="lot.php?lot_id=".$key;?>><?=htmlspecialchars($val['name']);?></a></h3>
						<div class="lot__state">
							<div class="lot__rate">
								<span class="lot__amount">Стартовая цена</span>
								<span class="lot__cost"><?=format_sum(strip_tags($val['price']));?></span>
							</div>
							<div class="lot__timer timer">
								<span><?=timelot((mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"))));?></span>
							</div>
						</div>
					</div>
				</li>
			<?php endforeach; ?>			
        </ul>
    </section>
</main>

</body>
</html>
