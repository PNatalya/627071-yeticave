<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Вход</title>
  <link href="css/normalize.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>

<main>
  <nav class="nav">
    <ul class="nav__list container">
		<?php Foreach ($category as $key=> $val): ?> 
			<li class="nav__item">
				<a href=<?="all-lots.php?cur_cat_id=".$key;?>><?=$val?></a>
			</li>
		<?php endforeach; ?>			
    </ul>
  </nav>
  <form class="form container <?php if(count($errors)) echo 'form--invalid'; ?>" action="login.php" method="post"> <!-- form--invalid -->
    <h2>Вход</h2>
  	<?php 
		$classname = "" ;
		$errortext = "";
		if (isset($errors['email'])) {
			$classname = "form__item--invalid" ;
			$errortext = $errors['email']; }
		$value = "";
		if (isset($user['email'])) {
			$value =  $user['email'];}
	?>		
    <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
      <label for="email">E-mail*</label>
      <input id="email" type="text" name="email" placeholder="Введите e-mail" required value=<?=$value;?>>
      <span class="form__error"><?=$errortext;?></span>
    </div>
  	<?php 
		$classname = "" ;
		$errortext = "";
		if (isset($errors['email'])) {
			$classname = "form__item--invalid" ;
			$errortext = $errors['password']; }
	?>		
    <div class="form__item form__item--last <?=$classname;?>">
      <label for="password">Пароль*</label>
      <input id="password" type="password" name="password" placeholder="Введите пароль" required >
      <span class="form__error"><?=$errortext;?></span>
    </div>
    <button type="submit" class="button">Войти</button>
  </form>
</main>

</body>
</html>
