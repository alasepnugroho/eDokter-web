<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserManajemen */

$this->title = 'Add User';
$this->params['breadcrumbs'][] = ['label' => 'User Manajemens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-manajemen-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
