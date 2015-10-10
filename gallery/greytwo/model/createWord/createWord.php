 <?php

// Выявляем все ошибки
error_reporting( E_ALL | E_NOTICE );


include 'PHPDocx_0.9.2.php';

// Создаем и пишем в файл. Деструктор закрывает
$w = new WordDocument( "14sde.docx" );

$w->assign('image.jpg');
$w->assign('Кто узнал эту же54tfнщину - тот настоящий знаток женской красоты.');

$w->create();
echo 1;

?>