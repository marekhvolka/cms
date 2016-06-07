<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 06.06.16
 * Time: 11:00
 */

/* @var $model Block */

?>
<style>
    .modal-dialog {
        width: 1000px !important;
    }

</style>

<link href="http://www.hyperfinance.cz/css/bootstrap.min.css" rel="stylesheet" />
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" />
<link href="http://www.hyperfinance.cz/css/bootstrap.min.css" rel="stylesheet" />
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://www.hyperfinance.cz/js/bootstrap.min.js"></script>
<?php
    switch($model->type)
    {
        case 'snippet' :

            echo $this->render('_snippet', ['model' => $model]);

            break;
        case 'text' :

            echo $this->render('_text', ['model' => $model]);

            break;
        case 'html' :

            echo $this->render('_html', ['model' => $model]);

            break;
    }
?>

