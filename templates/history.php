<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Все лоты</title>
  <link href="css/normalize.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>

<main>
  <nav class="nav">
    <ul class="nav__list container">
		<?php Foreach ($category as $key=> $val): ?> 
			<li class="nav__item">
				<a href="all-lots.html"><?=$val?></a>
			</li>
		<?php endforeach; ?>			
    </ul>
  </nav>
  <div class="container">
    <section class="lots">
	  <?php Foreach ($category as $keycat=> $valcat): ?> 
      <h2>Все лоты в категории <span>«<?=$valcat;?>»</span></h2>
	<?php foreach ($ads as $key=> $val): ?> 
	<?php if ($val['category'] == $valcat) : ?>
      <ul class="lots__list">
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
      </ul>
		<?php endif; ?>
		<?php endforeach; ?>			
		<?php endforeach; ?>			
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
</main>

</body>
</html>
