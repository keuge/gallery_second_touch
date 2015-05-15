<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="/project/sky_request/gallery/functions/jquery-2.1.3.js"></script>
    <script src="/project/sky_request/gallery/functions/jquery.fakecrop.js"></script>
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
            return ($(confirm("Точно удалить?")))
        }
    </script>
    <!--    Подтверждение удаления картинки-->
</head>
<body>
<?php
session_start();
include  __DIR__.DIRECTORY_SEPARATOR.'/functions/dbconnect.php';
ini_set('display_errors',1);
error_reporting();
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
        <form method="get" action="gallery.php">
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
    header("Location: http://f7u12.ru/project/sky_request/gallery/");
}
else
{
if (isset($_FILES['uploadfile']['name']))
{
    $uploaddir = 'img/';
    $imgtype = $_FILES['uploadfile']['type'];
    $new_file_name = uniqid();
    $fot = $uploaddir.$new_file_name.'.'.end(explode('.', $_FILES['uploadfile']['name']));
    $imgsize = $_FILES['uploadfile']['size'];
    ?>
    <br>
    <?php
    $imgname = $_POST['name'];
    $imgdesc = $_POST['description'];
    $imgcat = $_POST['category'];
    if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $fot))
    {
        $res= mysql_query
        (
            "INSERT INTO images (name, description, img_url, size, mime, category) VALUES ('".$imgname."', '".$imgdesc."','".$fot."','".$imgsize."','".$imgtype."','".$imgcat."');"
        );
        $res2= mysql_query
        (
            "INSERT INTO categories (category) VALUES ('".$imgcat."');"
        );
        if($res AND $res2)
        {
           ?> <div class='upload_success'></div><?php
        }
        else ?> <div class='upload_success'>Путь не добавлен в базу данных, но файл загружен</div><?php
    }}?>
<!--Загрузка картинки в базу и папку-->
<!--Вывод всех категорий в галерее-->
<div class="categories">
    <a href="/project/sky_request/gallery/gallery.php">All</a>
    <?php
    $select_categories = "SELECT DISTINCT category FROM images";
    $all_categories = mysql_query($select_categories);
    while($category = mysql_fetch_array($all_categories))
    {
    ?>
   <a href="/project/sky_request/gallery/gallery.php?category=<?php echo $category['category'];?>"><?php echo $category['category'];?></a>
   <?php }?>
</div>
<!--Вывод всех категорий в галерее-->
<!--Вывести на экран изображения из базы и добавить кнопку удалить к каждой картинке-->
<div class="container">
<br><br>
<?php
if(!empty ($_GET['search_category']))
{
$sql= "SELECT img_url, id FROM `images` WHERE `category`
    LIKE '%".$_GET['search_category']."%'";
}
elseif (!empty($_GET['category']))
{
    $sql= 'SELECT img_url, id FROM images WHERE category="'.$_GET['category'].'"';
}
else
{
    $sql= 'SELECT img_url, id FROM images ';
//Выбираем все картинки
}
            $result = mysql_query($sql);
            while($row = mysql_fetch_array($result))
{
            $_POST['img_url'] = $row['img_url'];
            $_POST['id'] = $row['id'];
?>
            <a href="/project/sky_request/gallery/image_form.php?photo_id=<?php echo $_POST['id'];?>"><img src="<?php echo $_POST['img_url']?>"/> <!-- отображаем картинку на экран и добавляем путь на персанальную страницу для картинки -->
                <form method="POST" enctype="multipart/form-data" >  <!-- форма для удаления картинки -->
                    <input type="hidden" value="<?php echo $_POST['img_url'];?>" name="delete_file" /> <!-- скрытое значение, которое укажет путь для удаления картинки из папки -->
                    <input type="hidden" value="<?php echo $_POST['id'];?>" name="delete_db_file" /> <!-- скрытое значение, которое укажет путь для удаления картинки из базы -->
                    <br>
                    <input name="submit" onclick="return confirmDelete();" type="image" src="img/cross_7.png">
                </form>
                <?php } ?>
</div>
<br>
<?php
if (array_key_exists('delete_file', $_POST) AND array_key_exists('delete_db_file', $_POST))
{
    $image_file_path = $_POST['delete_file'];
    echo '<br>';
    $id_image_from_db = $_POST['delete_db_file'];
    echo '<br>';
    if (file_exists($image_file_path) AND !empty($id_image_from_db))
    {
        unlink($image_file_path);
        $deletefrombase = 'DELETE FROM images WHERE id="'.$id_image_from_db.'"';
        $dosql = mysql_query($deletefrombase);
        echo '<meta http-equiv="Refresh" content="0; url=http://f7u12.ru/project/sky_request/gallery/gallery.php">';
    }
    else
    {
        echo '<br>Не удалилось' . '<br><br>';
        print_r($_POST);
    }
}
}
?>
<!--Вывести на экран изображения из базы и добавить кнопку удалить к каждой картинке-->
</body>
</html>