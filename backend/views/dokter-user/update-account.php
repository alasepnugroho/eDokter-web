<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DokterUser */

$this->title = Yii::t('app', 'Update Dokter User: {nameAttribute}', [
    'nameAttribute' => $model->ID_DOKTER,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dokter Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_DOKTER, 'url' => ['view', 'id' => $model->ID_DOKTER]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="dokter-user-update">

<div class="dokter-user-form">
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'USERNAME')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'PASSWORD')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'PASSWORD_REPEAT')->passwordInput(['maxlength' => true]) ?>
        <div class="form-group">
            <?= Html::submitButton('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Save', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
</div>
</div>
