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
				<a href="all-lots.html"><?=$val?></a>
			</li>
		<?php endforeach; ?>			
    </ul>
  </nav>
  <form class="form container <?php if(count($errors)) echo 'form--invalid'; ?>" action="login.php" method="post"> <!-- form--invalid -->
    <h2>Вход</h2>
    <div class="form__item <?php if (isset($errors['email'])) echo 'form__item--invalid';?>"> <!-- form__item--invalid -->
      <label for="email">E-mail*</label>
      <input id="email" type="text" name="email" placeholder="Введите e-mail" required value="<?php if (isset($user['email'])) echo $user['email']; else echo ""; ?>">
      <span class="form__error"><?php if (isset($errors['email'])) echo $errors['email'];?></span>
    </div>
    <div class="form__item form__item--last <?php if (isset($errors['password'])) echo 'form__item--invalid';?>">
      <label for="password">Пароль*</label>
      <input id="password" type="text" name="password" placeholder="Введите пароль" required >
      <span class="form__error"><?php if (isset($errors['password'])) echo $errors['password'];?></span>
    </div>
    <button type="submit" class="button">Войти</button>
  </form>
</main>

</body>
</html>
