<?php
use yii\grid\GridView;

$this->title = 'Задание 1';
$this->params['breadcrumbs'][] = $this->title;
?>

<pre>
    SELECT users.name, comments.text
    FROM users
    LEFT JOIN comments ON comments.user_id = users.id
    GROUP BY comments.user_id
</pre>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],
        ['label' => 'Имя пользователя', 'attribute' => 'name'],
        ['label' => 'Последний комментарий', 'attribute' => 'text'],
        //['label' => 'ID', 'attribute' => 'user_id'],
      //  ['class' => 'yii\grid\ActionColumn'],
    ],
    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
]); ?>
