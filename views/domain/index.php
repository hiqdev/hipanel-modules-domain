<?php
/**
 * @link    http://hiqdev.com/hipanel-module-domain
 * @license http://hiqdev.com/hipanel-module-domain/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\domain\grid\DomainGridView;
use hipanel\modules\domain\models\Domain;
use hipanel\widgets\ActionBox;
use hipanel\widgets\BulkButtons;
use hipanel\widgets\Pjax;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;

$this->title    = Yii::t('app', 'Domains');
$this->subtitle = Yii::t('app', Yii::$app->request->queryParams ? 'filtered list' : 'full list');
$this->breadcrumbs->setItems([
    $this->title
]);
$this->registerCss(<<<CSS
.editable-unsaved {
  font-weight: normal;
}
CSS
);
?>

<? Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>

    <?php $box = ActionBox::begin(['bulk' => true, 'options' => ['class' => 'box-info']]) ?>
        <?php $box->beginActions() ?>
            <?= Html::a(Yii::t('app', 'Advanced search'), '#', ['class' => 'btn btn-info search-button']) ?>
        <?php $box->endActions() ?>

        <?php $box->beginBulkActions() ?>
            <?= BulkButtons::widget([
                'model' => new Domain,
                'items' => [
                    ButtonDropdown::widget([
                        'label' => Yii::t('app', 'Whois protect'),
                        'dropdown' => [
                            'items' => [
                                [
                                    'label' => Yii::t('app', 'Set protect'),
                                    'url' => '#',
                                    'linkOptions' => [
                                        'class' => 'bulk-action',
                                        'data-attribute' => 'whois_protected',
                                        'data-value' => '1',
                                        'data-url' => 'set-whois-protect'
                                    ],
                                ],
                                [
                                    'label' => Yii::t('app', 'Unset protect'),
                                    'url' => '#',
                                    'linkOptions' => [
                                        'class' => 'bulk-action',
                                        'data-attribute' => 'whois_protected',
                                        'data-value' => '0',
                                        'data-url' => 'set-whois-protect'
                                    ],
                                ],
                            ],
                        ],
                    ]),
                    ButtonDropdown::widget([
                        'label' => Yii::t('app', 'Lock'),
                        'dropdown' => [
                            'items' => [
                                [
                                    'label' => Yii::t('app', 'Set lock'),
                                    'url' => '#',
                                    'linkOptions' => [
                                        'class' => 'bulk-action',
                                        'data-attribute' => 'is_secured',
                                        'data-value' => '1',
                                        'data-url' => 'set-lock'
                                    ]
                                ],
                                [
                                    'label' => Yii::t('app', 'Unset lock'),
                                    'url' => '#',
                                    'linkOptions' => [
                                        'class' => 'bulk-action',
                                        'data-attribute' => 'is_secured',
                                        'data-value' => '0',
                                        'data-url' => 'set-lock'
                                    ]
                                ]
                            ]
                        ]
                    ]),
                    ButtonDropdown::widget([
                        'label' => Yii::t('app', 'Autorenew'),
                        'dropdown' => [
                            'items' => [
                                [
                                    'label' => Yii::t('app', 'On autorenew'),
                                    'url' => '#',
                                    'linkOptions' => [
                                        'class' => 'bulk-action',
                                        'data-attribute' => 'autorenewal',
                                        'data-value' => '1',
                                        'data-url' => 'set-autorenewal'
                                    ]
                                ],
                                [
                                    'label' => Yii::t('app', 'Off autorenew'),
                                    'url' => '#',
                                    'linkOptions' => [
                                        'class' => 'bulk-action',
                                        'data-attribute' => 'autorenewal',
                                        'data-value' => '0',
                                        'data-url' => 'set-autorenewal'
                                    ]
                                ]
                            ]
                        ]
                    ]),
                ],
            ]) ?>

            <?= $this->render('_modalNs') ?>
            <?= $this->render('_modalContacts', ['model' => null]) ?>
            <?php
            //print \hipanel\widgets\BulkButtons::widget([
            //    'model' => new \hipanel\modules\domain\models\Domain,
            //    'items' => [
            //        [
            //            'label' => 'Some actions',
            //            'dropdown' => [
            //                'items' => [
            //                    ['label' => 'Set protect', 'attribute' => 'whois_protected', 'value' => '1', 'url' => 'set-whois-protect'],
            //                    ['label' => 'Remove protect', 'attribute' => 'whois_protected', 'value' => '0', 'url' => 'set-whois-protect']
            //                ]
            //            ],
            //
            //        ],
            //        ['label' => 'Some another action', 'attribute' => 'whois_protected', 'value' => '1', 'url' => 'set-whois-protect'],
            //    ],
            //])
            ?>
            &nbsp;
        <?php $box->endBulkActions() ?>
    <?php $box::end() ?>

    <?= DomainGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            'domain',
            'client_id', 'seller_id',
            'state',
            'whois_protected', 'is_secured',
            'created_date', 'expires',
            'autorenewal',
            'actions',
            'checkbox',
        ],
    ]) ?>

<? Pjax::end() ?>
