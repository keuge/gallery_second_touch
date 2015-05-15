<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="/project/sky_request/gallery/functions/jquery-2.1.3.js"></script>
    <script>
        $(document).ready(function() //Скрытие форм редактирования
        {
            $(".reply").click(function()
            {
                if($("#form_edit_image_description").is(":visible"))
                {
                    $("#form_edit_image_description").hide();
                    $("#close_form_link").hide();
                    $("#show_all_info_about_image").show();
                    $("#open_form_link").show();
                } else
                {
                    $("#form_edit_image_description").show();
                    $("#close_form_link").show();
                    $("#show_all_info_about_image").hide();
                    $("#open_form_link").hide();
                }
                return false;
            });
        });
        function confirmDelete()
        {
            return ((confirm("Точно удалить?")))
        }
    </script>
</head>
<?php
session_start();
if (empty($_SESSION['login']) or empty($_SESSION['id'])) //если не зареганы, то предлагаем зарегаться
{
    header("Location: http://f7u12.ru/project/sky_request/gallery/");
}
else
{
include  __DIR__.DIRECTORY_SEPARATOR.'/functions/dbconnect.php';
?>
<!--Запросить из базы все данные о картинке-->
<?php
$sql= 'SELECT img_url, id, name, description, category FROM images where id="'.$_GET['photo_id'].'"';
$result = mysql_query($sql);
$row = mysql_fetch_array($result); //сохранить в массив все данные о картинке
?>
<!--Запросить из базы все данные о картинке-->
<!--Вывести на экран кнопки редактирования, отмены-->
<body>
    <div>
<!--Вывести на экран кнопки редактирования, отмены-->
<!--Форма удаления картинки-->
<div>
    <form method="post" enctype="multipart/form-data" >
        <input type="hidden" value="<?php echo $row['img_url'];?>" name="delete_file" />
        <input type="hidden" value="<?php echo $row['id'];?>" name="delete_db_file" />
        <div id="gallery_link_box"><a class='verdana' href="gallery.php">&#8610;</a></div>
        <input id="delete_link_image" onclick="return confirmDelete();" name="delete_image" type="image" alt="delete_image" src="img/cross_4.png"></div>
    </form>
</div>
    </div>
<!--Форма удаления картинки-->
<!--Блок вывода картинки на экран-->
    <div align="center" class='image_form'>
        <?php
        ?>
        <img id="image_form_image" src="<?php echo $row['img_url'];?>"/>
        <br>
        <div id="open_form_link" ><a class="reply" href="">+</a></div>
        <div id="close_form_link" ><a class="reply" href="">‒</a></div>
        <?php
        echo '<div id="show_all_info_about_image">' . $row['name'].'<br>'.'<div style=" padding-top: 2px;">'.
            $row['description'].'</div>'.'<div style="padding-top:2px;">'.$row['category'].'</div>'.'<br>'.'<br>'.'<br>'.'</div>';
        ?>
        <div id="to_control_form_edit_image_description">
        <form  id="form_edit_image_description" action="" method="post">
            <input class="edit_image_data" type="text" name="picture_name" <?php if (empty($row['name'])){ echo "placeholder='Введите название'";} else{ echo 'value="'.$row['name'].'"';};?>"<br>
            <input class="edit_image_data" type="text" name="picture_description" <?php if (empty($row['description'])){ echo "placeholder='Введите описание'";} else{ echo 'value="'.$row['description'].'"';};?>"><br>
            <input class="edit_image_data"  type="text" name="picture_category" <?php if (empty($row['category'])){ echo "placeholder='Введите категорию'";} else{ echo 'value="'.$row['category'].'"';};?>"><br><br>
            <input name="submit" type="image" alt="submit"  src="img/nike.png">
        </form>
        </div>
        </div>
<!--Блок вывода картинки на экран-->
<!--Блок редактирования имени, описания, категории картинки начался/////////////////////////////////////////////////////-->
        <?php
        if(isset($_POST['submit_x']))
        {

            if(isset($_POST['picture_name']) OR isset($_POST['picture_description']) OR isset($_POST['picture_category']))
            {
                $change_picture_name = 'UPDATE images SET name="'.$_POST['picture_name'].'" , description="'.$_POST['picture_description'].'", category="'.$_POST['picture_category'].'" WHERE id="'.$_GET['photo_id'].'"';
                mysql_query($change_picture_name);
                ?> <meta http-equiv="Refresh" content="0; url=http://f7u12.ru/project/sky_request/gallery/image_form.php?photo_id=<?php echo $_GET['photo_id'];?>">
        <?php
            }
            else
            {
                echo 'Никаких новых данных не поступило!';
            }
        }
        ?>
<!--Блок редактирования имени, описания, категории картинки закончился//////////////////////////////////////////////////////-->
<!--Блок удаления картинки начался//////////////////////////////////////////////-->
        <?php
        if (array_key_exists('delete_file', $_POST))  //Удаление картинки
        {
            $image_file_path = $_POST['delete_file'];
            echo "<br>";
            echo '<br>';
            $id_image_from_db = $_POST['delete_db_file'];
            if (file_exists($image_file_path))
            {
                echo '<br>';
                $delete_from_base = 'DELETE FROM images WHERE id="'.$id_image_from_db.'"';
                mysql_query($delete_from_base);
                unlink($image_file_path);

                echo '<meta http-equiv="Refresh" content="0; url=http://f7u12.ru/project/sky_request/gallery/gallery.php">';
            }
            else
            {
                echo '<br>Не удалилось' . '<br><br>';
            }
        }
        }
        ?>

<!--Блок удаления картинки закончился////////////////////////////////////////-->
</body>
<html>