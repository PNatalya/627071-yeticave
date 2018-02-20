<nav class="nav">
    <ul class="nav__list container">
		<?php Foreach ($category as $key=> $val): ?> 
			<li class="nav__item">
				<a href=<?="all-lots.php?cur_cat_id=".$key;?>><?=$val?></a>
			</li>
		<?php endforeach; ?>			
    </ul>
</nav>
<form class="form form--add-lot container <?php if(count($errors)) echo 'form--invalid'; ?> " action="add.php" method="post" enctype='multipart/form-data'> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
	  <?php 
			$classname = "" ;
			$errortext = "";
			if (isset($errors['name'])) {
				$classname = "form__item--invalid" ;
				$errortext = $errors['name']; }
			$value = "";
			if (isset($lot['name'])) {
				$value =  $lot['name'];}
		?>		
      <div class="form__item <?=$classname;?> "> <!-- form__item--invalid -->
        <label for="lot-name">Наименование</label>
        <input id="lot-name" type="text" name="name" placeholder="Введите наименование лота" required value=<?=$value;?>>
        <span class="form__error"><?=$errortext;?></span>
      </div>
  	  <?php 
			$classname = "" ;
			$errortext = "";
			$optsel = "";
			if (isset($errors['category'])) {
				$classname = "form__item--invalid" ;
				$errortext = $errors['category']; }
			$value = "Выберите категорию";
			if (isset($lot['category'])) {
				$value =  $lot['category'];}
		?>		
      <div class="form__item <?=$classname;?> ">
        <label for="category">Категория</label>
        <select id="category" name="category" required>
          <option>Выберите категорию</option>
			<?php Foreach ($category as $key=> $val) {
					$optsel ="";
					if ($val == $value) {
					$optsel = "selected";
					}
			?> 
				<option <?=$optsel;?>><?=$val?></option>
			<?php } ?>			
        </select>
        <span class="form__error"><?=$errortext;?></span>
      </div>
    </div>
    <?php 
			$classname = "" ;
			$errortext = "";
			if (isset($errors['message'])) {
				$classname = "form__item--invalid" ;
				$errortext = $errors['message']; }
			$value = "";
			if (isset($lot['message'])) {
				$value =  $lot['message'];}
	?>		
    <div class="form__item form__item--wide <?=$classname;?> ">
      <label for="message">Описание</label>
      <textarea id="message" name="message" placeholder="Напишите описание лота" required><?=$value;?></textarea>
      <span class="form__error"><?=$errortext;?></span>
    </div> 
	<?php 
		$classname = "" ;
		if  ((isset($lot['img'])) && (!isset($errors['photo2'])))  {
			$classname ="form__item--uploaded";}
		  $imgname = isset($lot['img']) ? $lot['img'] : ""; 
		  $errortext = "";
		  if (isset($errors['photo2'])) {
			$errortext = $errors['photo2']; }
			$classname1 = "form__item--invalid" ;
		  ?>
    <div class="form__item form__item--file <?=$classname;?>"> <!-- form__item--uploaded -->
      <label>Изображение</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="<?=$imgname;?>" width="113" height="113" alt="Изображение лота">
        </div>
      </div>
      <div class="form__input-file">
        <input class="visually-hidden" type="file" name="photo2" id="photo2" value="">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      </div>
      <span class="form__error"><?=$errortext;?></span>
    </div>
    <div class="form__container-three">
    <?php 
			$classname = "" ;
			$errortext = "";
			if (isset($errors['rate'])) {
				$classname = "form__item--invalid" ;
				$errortext = $errors['rate']; }
			$value = "";
			if (isset($lot['rate'])) {
				$value =  $lot['rate'];}
	?>		
      <div class="form__item form__item--small <?=$classname;?> ">
        <label for="lot-rate">Начальная цена</label>
        <input id="lot-rate" type="number" name="rate" placeholder="0" required value=<?=$value;?>>
        <span class="form__error"><?=$errortext;?></span>
      </div>
    <?php 
			$classname = "" ;
			$errortext = "";
			if (isset($errors['step'])) {
				$classname = "form__item--invalid" ;
				$errortext = $errors['step']; }
			$value = "";
			if (isset($lot['step'])) {
				$value =  $lot['step'];}
	?>		
      <div class="form__item form__item--small <?=$classname;?> ">
        <label for="lot-step">Шаг ставки</label>
        <input id="lot-step" type="number" name="step" placeholder="0" required value=<?=$value;?>>
        <span class="form__error"><?=$errortext;?></span>
      </div>
    <?php 
			$classname = "" ;
			$errortext = "";
			if (isset($errors['date'])) {
				$classname = "form__item--invalid" ;
				$errortext = $errors['date']; }
			$value = "";
			if (isset($lot['date'])) {
				$value =  $lot['date'];}
	?>		
      <div class="form__item <?=$classname;?> ">
        <label for="lot-date">Дата окончания торгов</label>
        <input class="form__input-date" id="lot-date" type="date" name="date" required value=<?=$value;?>>
        <span class="form__error"><?=$errortext;?></span>
      </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" name="add" class="button">Добавить лот</button>
</form>
