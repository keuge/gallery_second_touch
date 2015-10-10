<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
</head>
<body>
<script src="../js/jquery-2.1.4.js"></script>
<script>
    $(document).ready(function()
    {
        $("#submit").click(function()
        {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "ajax.php",
                data: {'firstQuestion':$('#a').val(), 'secondQuestion':$('#b').val()},
                //=========================
                success: function(data)
                {
                    $('#response').html(data.summ/*result.question_id + ' ' + result.question_answer*/); // $a.' '.$b
                }
                //=========================
            });
        });
    });
</script>


<?php

$inputs = $_POST;
$inputs['printdate']='';
// Инициализация значения, чтобы избежать замечания от PHP о том, что в POST данных нет переменной “printdate”

$assembly = 'Microsoft.Office.Interop.Word, Version=15.0.0.0, Culture=neutral, PublicKeyToken=71e9bce111e9429c';
$class = 'Microsoft.Office.Interop.Word.ApplicationClass';

$w = new DOTNET($assembly, $class);
$w->visible = true;

$fn = __DIR__ . '\\template.docx';

$d = $w->Documents->Open($fn);

echo "Документ открыт.<br><hr>";

$flds = $d->Fields;
$count = $flds->Count;
echo "В документе $count полей.<br>";
echo "<ul>";
$mapping = setupfields();

foreach ($flds as $index => $f)
{
    $f->Select();
    $key = $mapping[$index];
    $value = $inputs[$key];
    if ($key == 'gender')
    {
        if ($value == 'm')
            $value = 'Mr.';
        else
            $value = 'Ms.';
    }

    if($key=='printdate')
        $value=  date ('Y-m-d H:i:s');

    $w->Selection->TypeText($value);
    echo "<li>Назначаю полю $index: $key значение $value</li>";
}
echo "</ul>";

echo "Обработка завершена!<br><hr>";
echo "Печатаю, пожалуйста, подождите...<br>";

$d->PrintOut();
sleep(3);
echo "Готово!";

$w->Quit(false);
$w=null;

function setupfields()
{
    $mapping = array();
    $mapping[0] = 'gender';
    $mapping[1] = 'name';
    $mapping[2] = 'age';
    $mapping[3] = 'msg';
    $mapping[4] = 'printdate';


    return $mapping;
}
$assembly = 'Microsoft.Office.Interop.Word, Version=15.0.0.0, Culture=neutral, PublicKeyToken=71e9bce111e9429c';
$class = 'Microsoft.Office.Interop.Word.ApplicationClass';

$w = new DOTNET($assembly, $class);
$w->visible = true;
?>

</body>
</html>
