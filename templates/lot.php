  <section class="lot-item container">
    <h2><?=htmlspecialchars($lot['name']);?></h2>
    <div class="lot-item__content">
      <div class="lot-item__left">
        <div class="lot-item__image">
          <img src=<?=$lot['img'];?> width="730" height="548" alt=<?=htmlspecialchars($lot['name']);?>>
        </div>
        <p class="lot-item__category">Категория: <span><?=$lot['category'];?></span></p>
        <p class="lot-item__description"><?=htmlspecialchars($lot['description']);?></p>
      </div>
      <div class="lot-item__right">
		<?php if ((isset($user['is_auth'])) && ($user['is_auth']) && ($show_rate) ): ?> 
         <div class="lot-item__state">
          <div class="lot-item__timer timer">
            <?=timelot($lot['dt_close']);?>
          </div>
          <div class="lot-item__cost-state">
            <div class="lot-item__rate">
              <span class="lot-item__amount">Текущая цена</span>
              <span class="lot-item__cost"><?=format_sum(strip_tags($lot['price']));?></span>
            </div>
            <div class="lot-item__min-cost">
              Мин. ставка <span><?=format_sum($lot['minrate']);?></span>
            </div>
          </div>
          <form class="lot-item__form" action="" method="post">
			  <?php 
				$classname = "" ;
				$errortext = "";
				if (isset($errors['cost'])) {
					$classname = "form__item--invalid" ;
					$classname1 = 'class="form__error"' ;
					$errortext = $errors['cost']; }
				if (isset($rescost)) {
					$value =  $rescost;}
			  ?>		
            <p class="lot-item__form-item  <?=$classname;?> ">
              <label <?=$classname1;?> for="cost">Ваша ставка <?=$errortext;?></label>
              <input id="cost" type="number" name="cost" placeholder="<?=$lot['minrate'];?>" value =<?=strip_tags($value);?>>
            </p>
            <button type="submit" class="button">Сделать ставку</button>
          </form>
		 </div>
 		<?php endif; ?>
        <div class="history">
          <h3>История ставок (<span>10</span>)</h3>
          <table class="history__list">
			<?php foreach ($rates as $v):?>
            <tr class="history__item">
              <td class="history__name"><?=strip_tags($v['name']);?></td>
              <td class="history__price"><?=strip_tags($v['summa']);?></td>
              <td class="history__time"><?=passed_time($v['dt_add']);?></td>
            </tr>
			<?php endforeach; ?>			
          </table>
        </div>
      </div>
    </div>
	
  </section>
