<h2><?= $userPagesUser->username ?></h2>
<table>
    <?= $this->Html->tableHeaders(['総合評価']) ?>
    <?= $this->Html->tableCells([$overallRating]) ?>
</table>