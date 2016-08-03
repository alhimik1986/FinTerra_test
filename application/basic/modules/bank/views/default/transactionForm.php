<?php

use keygenqt\autocompleteAjax\AutocompleteAjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'transaction-form',
    'options' => [],
    'action'=> ['transact'],
    'method'=>'post',
    /*'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-1 control-label'],
    ],*/
]);
?>


<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'user_id_donator')->widget(AutocompleteAjax::classname(), [
            'multiple' => false,
            'url' => ['default/search-user'],
            'options' => ['placeholder' => 'Поиск по имени или ID.'],
        ]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'user_id_acceptor')->widget(AutocompleteAjax::classname(), [
            'multiple' => false,
            'url' => ['default/search-user'],
            'options' => ['placeholder' => 'Поиск по имени или ID.'],
        ]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'balance'); ?>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">&nbsp;</label><br>
            <?= Html::submitButton('Перечислить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>