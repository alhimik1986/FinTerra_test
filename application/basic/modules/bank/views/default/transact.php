<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->errorSummary($model); ?>

<?php if ($data['success']): ?>
    Перечислиено: <?= $data['balance']; ?> р. <br><br>

    Баланс<br>
    <?= $data['donator']['name'].': '.$data['donator']['balance'].' р.'; ?>
    <br>
    <?= $data['acceptor']['name'].': '.$data['acceptor']['balance'].' р.'; ?>
    <br>
    <br>
<?php endIf; ?>

<?= Html::a('Назад', ['transaction-form']); ?>