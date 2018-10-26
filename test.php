<?php
$fileList = glob('uploads/*.json');
if (!isset($_GET['test'])) {
        http_response_code(404);
?>
     <p>Такого теста не существует</p>
     <p><a href="list.php">Список тестов</a></p>
<?php
    exit;
} 
foreach ($fileList as $key => $file) {
    if (empty(array_key_exists($_GET['test'], $fileList))) {
      http_response_code(404);
      ?>
     <p>Такого теста не существует</p>
     <p><a href="list.php">Список тестов</a></p>
<?php
    exit;
    }
    elseif ($key == $_GET['test']) {
        $fileTest = file_get_contents($fileList[$key]);
        $decodeFile = json_decode($fileTest, true);
        $test = $decodeFile;
    }
}

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <style>
    body {
        padding: 10px 20px;
    }
       fieldset {
        margin-bottom: 10px;          
       }
       .add {
        margin-bottom: 10px;
       }
       h3 {
        margin: 0;
       }
       h4 {
        margin: 5px 0;
       }
       p {
        margin: 0;
       }
       label {
        margin-right: 10px; 
       }
      .sert {
        width: 400px;
        height: 150px;
        background-image: url("https://previews.123rf.com/images/allegretto/allegretto1308/allegretto130800005/21699291-Blank-Template-for-School-or-Gift-Certificate-Stock-Photo.jpg");
        background-size: 440px 190px;
           padding: 20px;
        text-align: center;
       }
    </style>
    <title>Тесты</title>
</head>
<body>
  <form action="" method="post" enctype=multipart/form-data>
    <fieldset>
      <legend><h3><?= $test[0]['question'] ?></h3></legend>
      <p><input type="text" name="name" placeholder="Введите ваше имя"></p>

<?php
for ($i = 0; $i < count($test[0]['items']); $i++) {
?>
     <p><h4><?= $test[0]['items'][$i]['quest'] ?></h4></p>
    <?php
    for ($k = 0; $k < count($test[0]['items'][$i]['answers']); $k++) {
        $arrResultRight[] = $test[0]['items'][$i]['answers'][$k]['result'];
?>
     <label><input type=radio name="<?= $i ?>" value="<?= $test[0]['items'][$i]['answers'][$k]['answer'] ?>"><?= $test[0]['items'][$i]['answers'][$k]['answer'] ?></label>
    <?php
    }
}
?>
   </fieldset>
    <input class="add" type="submit" name="add" value="Отправить">
  </form> 
 <?php
if (empty($_POST['add'])) {
?>
     <p>Введите данные в форму</p>
      <p><a href="list.php">Список тестов</a></li></p>
<?php
    exit;
} else {
    foreach ($test[0]['items'] as $key => $value) {
        for ($i = 0; $i < count($_POST); $i++) {
            if ($i == $key) {
                for ($k = 0; $k < count($test[0]['items'][$i]['answers']); $k++) {
                    if ($_POST[$i] === $test[0]['items'][$i]['answers'][$k]['answer']) {
                        $arrResult[] = $test[0]['items'][$i]['answers'][$k]['result'];
                    }
                }
            }
        }
    }
}
$arrResult = array_sum($arrResult);
$arrResultRight = array_sum($arrResultRight);
if ($arrResult === $arrResultRight) {
?>
    <div class='sert'>
      <h2><?=$_POST['name']?></h2>
                        
      <p>Вы правильно ответили на все вопросы этого теста.<br><br>ПОЗДРАВЛЯЕМ !!!</p>
    </div>
    <p><a href='list.php'>Xочу пройти другой тест</a></p>

<?php
} else {
?>
     <h4>Попробуйте еще раз</h4>
     <p><a href="list.php">Список тестов</a></p>
<?php
}
?>
 

</body>
</html>