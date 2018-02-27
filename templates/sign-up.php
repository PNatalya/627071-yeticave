  <form class="form container <?php if(count($errors)) echo 'form--invalid'; ?> " action="sign-up.php" method="post" enctype='multipart/form-data'> <!-- form--invalid -->
    <h2>Регистрация нового аккаунта</h2>
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
		if (isset($errors['password'])) {
			$classname = "form__item--invalid" ;
			$errortext = $errors['password']; }
		$value = "";
		if (isset($user['password'])) {
			$value =  $user['password'];}
	?>		
    <div class="form__item <?=$classname;?>">
      <label for="password">Пароль*</label>
      <input id="password" type="text" name="password" placeholder="Введите пароль" required value=<?=$value;?>>
      <span class="form__error"><?=$errortext;?></span>
    </div>
  	<?php 
		$classname = "" ;
		$errortext = "";
		if (isset($errors['name'])) {
			$classname = "form__item--invalid" ;
			$errortext = $errors['name']; }
		$value = "";
		if (isset($user['name'])) {
			$value =  $user['name'];}
	?>		
    <div class="form__item <?=$classname;?>">
      <label for="name">Имя*</label>
      <input id="name" type="text" name="name" placeholder="Введите имя" required value=<?=$value;?>>
      <span class="form__error"><?=$errortext;?></span>
    </div>
  	<?php 
		$classname = "" ;
		$errortext = "";
		if (isset($errors['message'])) {
			$classname = "form__item--invalid" ;
			$errortext = $errors['message']; }
		$value = "";
		if (isset($user['message'])) {
			$value =  $user['message'];}
	?>		
    <div class="form__item <?=$classname;?>">
      <label for="message">Контактные данные*</label>
      <textarea id="message" name="message" placeholder="Напишите как с вами связаться" required><?=$value;?></textarea>
      <span class="form__error"><?=$errortext;?></span>
    </div>
	<?php 
		$classname = "" ;
		$classname1 = "" ;
		if  ((isset($user['img'])) && (!isset($errors['photo2'])))  {
			$classname ="form__item--uploaded";}
		  $imgname = isset($user['img']) ? $user['img'] : ""; 
		  $errortext = "";
		  if (isset($errors['photo2'])) {
			$errortext = $errors['photo2']; 
			$classname1 = "form__item--invalid" ;}
		  ?>
    <div class="form__item form__item--file form__item--last <?=$classname;?> <?=$classname1;?> ">
      <label>Аватар</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="<?=$imgname;?>" width="113" height="113" alt="Ваш аватар">
        </div>
      </div>
      <div class="form__input-file">
        <input class="visually-hidden" type="file" id="photo2" name="photo2" value="">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      </div>
      <span class="form__error"><?=$errortext;?></span>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="login.php">Уже есть аккаунт</a>
  </form>


