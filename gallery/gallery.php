<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="/scripts/jquery-2.1.3.js"></script>
    <script src="/scripts/jquery.fakecrop.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!--    Красиво заворачивает картинки-->
    <script>
        $(document).ready(function () {
            $('.container img').fakecrop({wrapperWidth: 300, wrapperHeight: 300});
        });
    </script>
    <!--    Красиво заворачивает картинки-->
    <!--    Подтверждение удаления картинки-->
    <script>
        function confirmDelete()
        {
            return ((confirm("Точно удалить?")))
        }
    </script>
    <!--    Подтверждение удаления картинки-->
</head>
<body>
<?php
session_start();
include  __DIR__.DIRECTORY_SEPARATOR.'/functions/search_errors.php';
include  __DIR__.DIRECTORY_SEPARATOR.'/protected/config/db.php';
?>
<a id="gallery_index_link" class='verdana' href="index.php">&#8610;</a>
<div id="width_hundred_percent">
<div id="upload_form">
<div id="upload_image_form">
<form  action="gallery.php" method="POST" enctype=multipart/form-data>
    <input type="file" id="upload_image_file_image_button" name="uploadfile"/>
    <label id="style_upload_image_file_image_button" for="upload_image_file_image_button">Выбрать файл</label>
    <input id="upload_image" class='verdana' type="text" size="25" name="name" placeholder="Название картинки">
    <input id="upload_image" class='verdana' name="description" placeholder="Описание ее">
    <input id="upload_image" class='verdana' size="25" type="text" name="category" placeholder="Категория">
    <input id="upload_image" class='verdana' type="submit" value="Загрузить">
</form>
</div>
</div>
</div>
<!--Поиск картинок по названию категорий-->
<div id="width_hundred_percent">
    <div id="form_search_picture_category">
        <meta charset="utf-8">
        <form method="get" action="">
            <input id="input_search_picture_category" type="text" name="search_category" placeholder="Из какой категории картинку ищем?" size="40" >
            <input id="upload_image"  type="submit" value="Искать"/>
        </form>
    </div>
</div>
<br>
<!--Поиск картинок по названию категорий-->
<!--Загрузка картинки в базу и папку-->
<?php
if (empty($_SESSION['login']) or empty($_SESSION['id'])) //если не зареганы, то предлагаем зарегаться
{
    header("Location: http://f7u12.ru/");
}
else
{
if (isset($_FILES['uploadfile']['name']))
{
    $uploaddir = 'img/';
    $imgtype = $_FILES['uploadfile']['type'];
    $new_file_name = uniqid();
    $image_name = explode('.', $_FILES['uploadfile']['name']);
    $fot = $uploaddir.$new_file_name.'.'.end($image_name);
    $imgsize = $_FILES['uploadfile']['size'];
    ?>
    <br>
    <?php
    $imgname = $_POST['name'];
    $imgdesc = $_POST['description'];
    $imgcat = $_POST['category'];
    if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $fot))
    {
        $image = "INSERT INTO images (name, description, img_url, size, mime, category) VALUES ('".$imgname."', '".$imgdesc."','".$fot."','".$imgsize."','".$imgtype."','".$imgcat."');";
        $res= mysqli_query($link, $image) or die ('Could not connect: '.mysqli_error($link));
    }}?>
<!--Загрузка картинки в базу и папку-->
<!--Вывод всех категорий в галерее-->
<div class="categories">
    <a href="gallery.php">All</a>

    <?php
    $select_categories = "SELECT DISTINCT category FROM images";
    $all_categories = mysqli_query($link,$select_categories);
    while($category = mysqli_fetch_array($all_categories))
    {
    ?>
   <a href="gallery.php?category=<?php echo $category['category'];?>"><?php echo $category['category'];?></a>
   <?php }?>
</div>
<!--Вывод всех категорий в галерее-->
<!--Вывести на экран изображения из базы и добавить кнопку удалить к каждой картинке-->
<div class="container">
<br><br>
<?php
if(!empty($_GET['search_category']))
{
    $sql= 'SELECT img_url, id FROM images WHERE category="'.$_GET['search_category'].'"';
}
elseif (!empty($_GET['category']))
{
    $sql= 'SELECT img_url, id FROM images WHERE category="'.$_GET['category'].'"';
}
else
{
    $sql= 'SELECT img_url, id FROM images ';
}
            $result = mysqli_query($link,$sql);
            while($row = mysqli_fetch_array($result))
{
?>
            <a href="image_form.php?photo_id=<?php echo $row['id'];?>"><img src="<?php echo $row['img_url']?>"/> <!-- отображаем картинку на экран и добавляем путь на персанальную страницу для картинки -->
                <form method="POST" enctype="multipart/form-data" >  <!-- форма для удаления картинки -->
                    <input type="hidden" value="<?php echo $row['id'];?>" name="delete_db_file" /> <!-- скрытое значение, которое укажет путь для удаления картинки из базы -->
                    <br>
                    <input name="submit" onclick="return confirmDelete();" type="image" src="img/cross_7.png">
                </form>
                <?php } ?>
</div>
<br>
<!--    Удаление файла-->
<?php
if(!empty($_POST['delete_db_file']))
{
    $delete_image_sql = 'SELECT * FROM images WHERE id="'.$_POST['delete_db_file'].'"';
    $delete_image_query = mysqli_query($link,$delete_image_sql);
    $delete_image_array = mysqli_fetch_array($delete_image_query);
    unlink($delete_image_array['img_url']);
    $deleteFromBase = 'DELETE FROM images WHERE id="'.$delete_image_array['id'].'"';
    $dosql = mysqli_query($link, $deleteFromBase);
    header("Location: http://f7u12.ru/gallery.php");
}
}
?>
<!--    Удаление файла-->
<!--Вывести на экран изображения из базы и добавить кнопку удалить к каждой картинке-->
</body>
</html>