<?php
use yii\widgets\Breadcrumbs;
?>

<div class="content-wrapper">
    <section class="content-header">
        <!-- <h1><?= $this->title ?></h1> -->
    </section>

    <section class="content custm-cntnt">
    	<?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        
        <?= $content ?>
    </section>
</div>