<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>$Title</title>
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
  <form class="form form--add-lot container <?php if(count($errors)) echo 'form--invalid'; ?> " action="add.php" method="post" enctype='multipart/form-data'> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
      <div class="form__item <?php if (isset($errors['name'])) echo 'form__item--invalid';?> "> <!-- form__item--invalid -->
        <label for="lot-name">Наименование</label>
        <input id="lot-name" type="text" name="name" placeholder="Введите наименование лота" required value="<?php if (isset($lot['name'])) echo $lot['name']; else ""; ?>">
        <span class="form__error"><?php if (isset($errors['name'])) echo $errors['name'];?></span>
      </div>
      <div class="form__item <?php if (isset($errors['category'])) echo 'form__item--invalid';?> ">
        <label for="category">Категория</label>
        <select id="category" name="category" required>
          <option>Выберите категорию</option>
          <option>Доски и лыжи</option>
          <option>Крепления</option>
          <option>Ботинки</option>
          <option>Одежда</option>
          <option>Инструменты</option>
          <option>Разное</option>
        </select>
        <span class="form__error"><?php if (isset($errors['category'])) echo $errors['category'];?></span>
      </div>
    </div>
    <div class="form__item form__item--wide <?php if (isset($errors['message'])) echo 'form__item--invalid';?> ">
      <label for="message">Описание</label>
      <textarea id="message" name="message" placeholder="Напишите описание лота" required><?php if (isset($lot['message'])) echo $lot['message']; else ""; ?></textarea>
      <span class="form__error"><?php if (isset($errors['message'])) echo $errors['message'];?></span>
    </div> 
	<?php $classname = isset($errors['img']) ? "" : "form__item--uploaded";
		  $imgname = isset($lot['img']) ? $lot['img'] : ""; ?>
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
    </div>
    <div class="form__container-three">
      <div class="form__item form__item--small <?php if (isset($errors['rate'])) echo 'form__item--invalid';?> ">
        <label for="lot-rate">Начальная цена</label>
        <input id="lot-rate" type="number" name="rate" placeholder="0" required value="<?php if (isset($lot['rate'])) echo $lot['rate']; else ""; ?>">
        <span class="form__error"><?php if (isset($errors['rate'])) echo $errors['rate'];?></span>
      </div>
      <div class="form__item form__item--small <?php if (isset($errors['step'])) echo 'form__item--invalid';?> ">
        <label for="lot-step">Шаг ставки</label>
        <input id="lot-step" type="number" name="step" placeholder="0" required value="<?php if (isset($lot['step'])) echo $lot['step']; else ""; ?>">
        <span class="form__error"><?php if (isset($errors['step'])) echo $errors['step'];?></span>
      </div>
      <div class="form__item <?php if (isset($errors['date'])) echo 'form__item--invalid';?> ">
        <label for="lot-date">Дата окончания торгов</label>
        <input class="form__input-date" id="lot-date" type="date" name="date" required value="<?php if (isset($lot['date'])) echo $lot['date']; else ""; ?>">
        <span class="form__error"><?php if (isset($errors['date'])) echo $errors['date'];?></span>
      </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
	    <?php if (isset($errors)): ?>
      <div class="form__error form__error--bottom">
        <ul>
          <?php foreach($errors as $err => $val): ?>
          <li><strong><?=$dict[$err];?>:</strong> <?=$val;?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
    <button type="submit" name="add" class="button">Добавить лот</button>
  </form>
</main>

</body>
</html>
