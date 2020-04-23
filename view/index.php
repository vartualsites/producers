<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title><?=isset($title) && $title ? $title : '<Strona główna' ?></title>
    <link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST'].LOCAL_URI?>css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?='http://'.$_SERVER['HTTP_HOST'].LOCAL_URI?>css/style.css" />
</head>
<body>
<?=isset($content) && $content ? $content : 'No content ;-)'?>
</body>
</html>