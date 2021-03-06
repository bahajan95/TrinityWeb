<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 * @author Paweł Bizley Brzozowski <pawel@positive.codes>
 * @since 0.1
 */

use common\modules\forum\models\User;
use common\modules\forum\Podium;
use common\modules\forum\rbac\Rbac;
use yii\helpers\Url;

$this->title = $model->name;
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'Main Forum'), 'url' => ['forum/index']];
Yii::$app->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => ['forum/category', 'id' => $model->category->id, 'slug' => $model->category->slug]];
Yii::$app->params['breadcrumbs'][] = $this->title;

?>
<?php if (!Podium::getInstance()->user->isGuest): ?>
<div class="row">
    <div class="col-sm-12 text-right">
        <ul class="list-inline forum-perm-inline">
<?php if (User::can(Rbac::PERM_CREATE_THREAD) && (User::can(Rbac::PERM_CREATE_THREAD_IN_CLOSED_CATEGORY,['category' => $model->category]) || $model->category->create_thread)): ?>
            <li><a href="<?= Url::to(['forum/new-thread', 'cid' => $model->category->id, 'fid' => $model->id]) ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span> <?= Yii::t('podium/view', 'Create new thread') ?></a></li>
<?php endif; ?>
            <li><a href="<?= Url::to(['forum/unread-posts']) ?>" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-flash"></span> <?= Yii::t('podium/view', 'Unread posts') ?></a></li>
        </ul>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel-group" role="tablist">
            <?= $this->render('/elements/forum/_forum_section', ['model' => $model, 'filters' => $filters]) ?>
        </div>
    </div>
</div>
