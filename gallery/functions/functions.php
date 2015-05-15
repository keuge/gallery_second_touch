<meta charset="utf-8">
<?php


function generateArr($arrayHeight,$arrayWidth = null, $and = 1, $from = 3)   //забиваем массив значениями от 1 до 3
{
    $arrayHeight--;

    if($arrayWidth)
    {
        $arrayWidth--;
    }

    $array = array();

    if(!$arrayWidth)
    {
        $arrayWidth = $arrayHeight;
    }

    for ($n=0; $n<=$arrayHeight; $n++)
    {
        for ($m=0; $m<=$arrayWidth;$m++)
        {
            $array[$n][$m] = rand ($and,$from);
        }
    }

    return  $array;
}

function renderArr(array $renArr) //выводим таблицу со значениями массива
{

    $arrayWidth = count($renArr[0]) - 1; //m
    $arrayHeight = count($renArr) - 1; //n

    if($arrayWidth == 0)
    {
        $arrayWidth = $arrayHeight;
    }
    echo '<table border=1>';

    for ($n=0; $n<=$arrayHeight;$n++)
    {
        echo '<tr height =17>';

        for ($m=0; $m<=$arrayWidth;$m++)
        {

            echo '<td width=17>'.$renArr[$n][$m].'</td>';
        }
        echo '</tr>';
    }
    echo '</table>';

}

function generateOneDimensionArray($size,$from = null, $to = null) //заполняем одномерный массив
{
    $n = 0;
    $arr = array();

    if ($from == null && $to == null)
    {
        $from = 0;
        $to = 50;
    }

    while ($n <=$size-1)
    {
        $arr[$n] = rand($from, $to);
        $n++;
    }

    return $arr;
}

function averageArr($arr) //среднее арифметическое
{
    if(is_array($arr))
    {
        foreach ($arr as $number)
        {
            echo  $number. ' ';
        }
    }

    $count = count($arr);
    $average = array_sum($arr)/$count;

    return $average;
}