<?php

use yii\helpers\Html;
use dvizh\cart\widgets\DeleteButton;
use dvizh\cart\widgets\TruncateButton;
use dvizh\cart\widgets\ChangeCount;
use dvizh\cart\widgets\CartInformer;
use dvizh\cart\widgets\ChangeOptions;

/* @var $this yii\web\View */

$this->title = yii::t('cart', 'Cart');

?>

<main class="main-content w-container cart-container">
    <div class="col-sm-9">
        <?=Html::tag('h1', Yii::t("app", "Cart"), ['class' => 'h hm']);?>
        <div class="flex-container v-align-center">
            <?=Html::tag('p', Yii::t("app", "Now in your cart:"), ['class' => 'h nm']);?>
            <?=Html::a(Yii::t("app", "Checkout"), './contact', ['class' => 'button']);?>
        </div>
        <div class="cart-tiles"><?php
            /**
             * FIXME: THIS GOVNOFIX! I used counter for $elements counting.
             * Merge this two models (product and cart-element) is needed.
             */ 
            $i = 0;
            foreach ($products as $product) {?>
                <div class="cart-tile">
                    <div class="cart-subtile">
                        <div class="cart-tile-img">
                            <?=Html::img($product->getMainImage(), ['class' => 'cart-tile-img']);?>
                        </div>
                        <div class="cart-tile-title">
                            <?=Html::tag('h3', Html::encode($product->mineralData->familyData->name), ['class' => 'tile-mineral']);?>
                            <?=Html::tag('p', Yii::t("app", "art.") . " " . Html::encode($product->sku), ['class' => 'tile-sku']);?>
                        </div>
                        <div class="cart-tile-price visible-xs">
                            <?=Html::tag('p', Html::encode($product->price) . " " . Yii::t('app', "uah"), ['class' => 'tile-price']);?>
                        </div>
                    </div>
                    <div class="cart-tile-summary">
                        <?=Html::tag('p', Yii::t("app", "Cut shape") . ": " . Html::encode($product->shapeData->name));?>
                        <?=Html::tag('p', Yii::t("app", "Weight") . ", " . Yii::t("app", "carat") . ": " . Html::encode($product->weight));?>
                        <?=Html::tag('p', Yii::t("app", "Parameters") . ": " . Html::encode($product->length ) . "x" . Html::encode($product->width ) . "x" . Html::encode($product->height) . Yii::t("app", "mm"));?>
                        <?=Html::tag('p', Yii::t("app", "Color") . ": " . Html::encode($product->colorData->name));?>
                        <?=Html::tag('p', Yii::t("app", "Purity") . ": " . Yii::t("product", $product->purities[$product->purity]));?>
                        <?=Html::tag('p', Yii::t("app", "Quantity") . ": " .  Html::encode(intval($product->quantity)));?>
                    </div>
                    <div class="cart-tile-price">
                        <?=Html::tag('p', Html::encode($product->price) . " " . Yii::t('app', "uah"), ['class' => 'tile-price']);?>
                    </div>
                    <div class="cart-tile-close">
                        <?=DeleteButton::widget([
                            'model' => $elements[$i], 
                            'lineSelector' => '.cart-tile',
                            'text' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
                                            <g fill="currentColor" fill-rule="evenodd">
                                                <path d="M15.42 1V.5H6.93L.78 6.651v8.698L6.93 21.5h8.7l6.15-6.151V6.651L15.63.5h-.21V1l-.35.354 5.71 5.711v7.87L15.21 20.5H7.34l-5.56-5.565v-7.87L7.34 1.5h8.08V1l-.35.354.35-.354"/>
                                                <path d="M7.27 14.495l.51.51 3.5-3.495 3.49 3.495.51-.51L11.79 11l3.49-3.495-.51-.51-3.49 3.495-3.5-3.495-.51.51L10.77 11l-3.5 3.495"/>
                                            </g>
                                        </svg>',
                            'cssClass' => '',
                        ]);?>
                    </div>
                </div><?php
                $i++;
            }?>
            <div class="cart-tile cart-tile-total">
                <div class="cart-tile-img"></div>
                <div class="cart-tile-title">
                    <?=Html::tag('h3', Yii::t('app', "Total"), ['class' => 'tile-mineral']);?>
                </div>
                <div class="cart-tile-summary"></div>
                <div class="cart-tile-price">
                    <?=CartInformer::widget(['text' => '{p}', 'htmlTag' => 'p', 'cssClass' => 'tile-price']);?>
                </div>
                <div class="cart-tile-close"></div>
            </div>
        </div>
        <div class="flex-container">
            <?=Html::a(Yii::t("app", "Continue shopping"), './product', ['class' => 'button secondary-button']);?>
            <?=Html::a(Yii::t("app", "Checkout"), './contact', ['class' => 'button']);?>
        </div>
    </div>
    <aside class="col-sm-3 checkout-sidebar">
        <div class="flex-container">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="30" viewBox="0 0 35 30">
                <path fill="#265690" d="M33.9 13.7V7.5a2.7 2.7 0 0 0-2.7-2.7h-.1l-.2-1.7a1 1 0 0 0-.4-.7 1 1 0 0 0-.8-.3l-.5.1-.3-1.4a1 1 0 0 0-1.3-.8L4 4.8H2.8A2.7 2.7 0 0 0 0 7.5v19.8A2.7 2.7 0 0 0 2.7 30h28.5a2.7 2.7 0 0 0 2.7-2.7v-6.2a1.6 1.6 0 0 0 1.1-1.5v-4.4a1.6 1.6 0 0 0-1.1-1.5zm-4-10.5l.1 1.6H14.4zm-2-2.2l.2 1.3-14 1.5zm3.3 28H2.7A1.7 1.7 0 0 1 1 27.2h26.4a.5.5 0 1 0 0-1H1V8.6h26.4a.5.5 0 1 0 0-1H1a1.7 1.7 0 0 1 1.7-1.7h28.5a1.7 1.7 0 0 1 1.7 1.6v6.1h-1.7V8.1a.5.5 0 0 0-.5-.5h-1.1a.5.5 0 1 0 0 1h.5v5h-4.4a1.6 1.6 0 0 0-1.6 1.6v4.4a1.6 1.6 0 0 0 1.6 1.6h4.4v5h-.5a.5.5 0 1 0 0 1h1a.5.5 0 0 0 .6-.5v-5.5h1.7v6a1.7 1.7 0 0 1-1.7 1.7zm2.8-9.4a.6.6 0 0 1-.6.6h-7.7a.6.6 0 0 1-.6-.6v-4.4a.6.6 0 0 1 .6-.6h7.7a.6.6 0 0 1 .6.6v4.4z"/>
                <path fill="#265690" d="M28 15.8a1.6 1.6 0 1 0 1.5 1.6 1.6 1.6 0 0 0-1.6-1.6zm0 2.2a.6.6 0 0 1-.7-.6.6.6 0 0 1 1.2 0 .6.6 0 0 1-.6.6z"/>
            </svg>
            <div>
                <p><?=Yii::t('app', 'Available payment methods')?>:</p>
                <img src="./images/privat-24.png" alt="Приват 24">
                <img src="./images/paypal.svg" alt="PayPal">
                <button class="button secondary-button"><?=Yii::t('app', 'prepayment')?></button>
            </div>
        </div>
        <div class="flex-container">
            <svg xmlns="http://www.w3.org/2000/svg" width="42" height="33.5" viewBox="0 0 42 33.5">
                <path fill="#265690" d="M9.2 28.3a1.3 1.3 0 0 0-1.3 1.3 1.3 1.3 0 0 0 1.3 1.2 1.3 1.3 0 0 0 1.2-1.3 1.3 1.3 0 0 0-1.2-1.2zM35.5 28.3a1.3 1.3 0 0 0-1.3 1.3 1.3 1.3 0 0 0 1.3 1.2 1.3 1.3 0 0 0 1.2-1.3 1.3 1.3 0 0 0-1.2-1.2z"/>
                <path fill="#265690" d="M40.7 20.1l-4.8-1.6-2.2-6a2 2 0 0 0-1.8-1.3h-5.7V9.8A1.3 1.3 0 0 0 25 8.5h-9.5A36.8 36.8 0 0 0 19 6.2a7.1 7.1 0 0 1 1.6.9.6.6 0 0 0 .9-.2.6.6 0 0 0-.2-.8 9.2 9.2 0 0 0-1.3-.8l.3-.3a3.1 3.1 0 0 0-.6-4.4 3.1 3.1 0 0 0-2.3-.6 3 3 0 0 0-2 1.2A24.1 24.1 0 0 0 13.1 7a24.1 24.1 0 0 0-2.3-5.7A3.1 3.1 0 0 0 6.5.6 3 3 0 0 0 5.9 5a3 3 0 0 0 .3.3 8.5 8.5 0 0 0-1.3.8.6.6 0 0 0-.2.8.6.6 0 0 0 1 .2 7.3 7.3 0 0 1 1.5-1 36.9 36.9 0 0 0 3.6 2.5H1.3A1.3 1.3 0 0 0 0 9.8v4.6a.6.6 0 0 0 .6.6v12.6A1.3 1.3 0 0 0 2 28.8h3.4a4 4 0 0 0 0 .7 4 4 0 0 0 3.8 4 4 4 0 0 0 4-4 4 4 0 0 0-.1-.7h18.6a4 4 0 0 0 0 .7 4 4 0 0 0 3.8 4 4 4 0 0 0 4-4 4.2 4.2 0 0 0-.2-.8l1.3-.7a2.6 2.6 0 0 0 1.5-2.3V22a2 2 0 0 0-1.3-1.9zM12.4 25V9.8h1.4V25zM15 15h9.3v10H15zm10.5 0h5.2l1.2 3.4h-6.4V15zm7.7 3.4L32 15h1.3l1.2 3.4zm-1.3-6a.7.7 0 0 1 .6.4l.4 1h-6.7v-1.4zM25 9.8v4H15v-4h10zm-10.6-2A3.6 3.6 0 0 1 16.3 6a3.2 3.2 0 0 1 1.1-.1l-3 1.9zm2-5.8a1.9 1.9 0 0 1 1.2-.8h.2a1.9 1.9 0 0 1 1.2.4 1.8 1.8 0 0 1 .7 1.2 1.9 1.9 0 0 1-.4 1.4 4.8 4.8 0 0 1-.6.6 5 5 0 0 0-2.8 0 3.8 3.8 0 0 0-1 .5A14.4 14.4 0 0 1 16.4 2zM6.8 4.2a1.9 1.9 0 0 1 .4-2.6 1.8 1.8 0 0 1 1.1-.4 1.9 1.9 0 0 1 1.5.8 15.3 15.3 0 0 1 1.4 3.3 4 4 0 0 0-1-.5 5 5 0 0 0-2.8 0 4.2 4.2 0 0 1-.6-.6zM10 6a3.5 3.5 0 0 1 2 1.8c-1-.6-2.2-1.3-3.1-2a3.1 3.1 0 0 1 1.1.2zM1.2 9.8h10v4h-10zm10 5.2v10H1.9V15zM1.9 27.6v-1.3h5.3a4 4 0 0 0-1.4 1.4zm7.3 4.6a2.7 2.7 0 0 1-2.7-2.7A2.7 2.7 0 0 1 9.2 27a2.7 2.7 0 0 1 2.7 2.6 2.7 2.7 0 0 1-2.7 2.7zm2-6h13.1v1.4H12.5a3.9 3.9 0 0 0-1.3-1.4zm24.2 6a2.7 2.7 0 0 1-2.6-2.7 2.7 2.7 0 0 1 2.6-2.6 2.7 2.7 0 0 1 2.7 2.6 2.7 2.7 0 0 1-2.6 2.7zM40 27l-1.2.6a3.9 3.9 0 0 0-3.4-1.9 3.9 3.9 0 0 0-3.3 2h-6.6v-3.3h12a.6.6 0 0 0 .5-.6.6.6 0 0 0-.6-.7H25.5v-3.3h9.8l5 1.6a.7.7 0 0 1 .4.7v1H40a.6.6 0 0 0-.6.6.6.6 0 0 0 .6.6h.7v1.5a1.3 1.3 0 0 1-.7 1.2z"/>
            </svg>
            <div>
                <p><?=Yii::t('app', 'Available delivery methods')?>:</p>
                <img src="./images/fedex.svg" alt="FexEx">
            </div>
        </div>
        <div class="flex-container">
            <svg xmlns="http://www.w3.org/2000/svg" width="33.6" height="36" viewBox="0 0 33.6 36">
                <path fill="#265690" d="M17.4.4a.6.6 0 0 0 0-.1.6.6 0 0 0-.6-.3.6.6 0 0 0-.5.3.5.5 0 0 0 0 .1c-.7 1.1-4.8 7.7-15 5a.6.6 0 0 0-.7.5c0 .2-5.3 21 16 30.1a.7.7 0 0 0 .2 0 .6.6 0 0 0 .3 0C38.3 26.8 33.1 6 33 5.9a.6.6 0 0 0-.7-.5c-10.3 2.7-14.4-4-15-5zM32 6.7c.7 3.4 3.2 20-15.2 28a24.3 24.3 0 0 1-15.1-28c9 2.1 13.6-2.9 15.1-5 1.5 2.1 6.1 7.1 15.2 5z"/>
                <path fill="#265690" d="M27.7 9.6a18.9 18.9 0 0 0 2.3 0c.4 5-.2 16.3-13.2 22.5a30.4 30.4 0 0 1-3.6-2 .6.6 0 0 0-.8.2.6.6 0 0 0 .2.8 30.4 30.4 0 0 0 4 2.3.7.7 0 0 0 .2 0 .8.8 0 0 0 .3 0A23 23 0 0 0 31 8.8a.6.6 0 0 0-.2-.4.6.6 0 0 0-.5-.1 18.6 18.6 0 0 1-2.7.2.6.6 0 0 0-.6.6.6.6 0 0 0 .6.6zM16.4 4.2A14.2 14.2 0 0 1 5.9 8.4a18.5 18.5 0 0 1-2.7-.2.6.6 0 0 0-.4.2.6.6 0 0 0-.3.4A26.2 26.2 0 0 0 3 17a21.4 21.4 0 0 0 5.3 10.4.6.6 0 0 0 .6.2.6.6 0 0 0 .4-.4.6.6 0 0 0-.1-.6 20.3 20.3 0 0 1-5-9.9 25 25 0 0 1-.4-7.2 20.7 20.7 0 0 0 2.2.2 15.3 15.3 0 0 0 11-4.3A15 15 0 0 0 22.6 9a.6.6 0 0 0 .7-.4.6.6 0 0 0-.4-.8 13.8 13.8 0 0 1-5.7-3.5.6.6 0 0 0-1 0z"/>
                <path fill="#265690" d="M22.1 15.8v-1.6a4.8 4.8 0 0 0-5-4.5 4.8 4.8 0 0 0-5 4.5v1.6a2.4 2.4 0 0 0-1.8 2.3V24a2.4 2.4 0 0 0 2.4 2.4h9a2.4 2.4 0 0 0 2.2-2.4v-5.9a2.4 2.4 0 0 0-1.8-2.3zm-9-.1v-1.5a3.8 3.8 0 0 1 4-3.5 3.8 3.8 0 0 1 4 3.5v1.5zm9.8 2.4V24a1.4 1.4 0 0 1-1.4 1.4h-8.9a1.4 1.4 0 0 1-1.3-1.4v-5.9a1.4 1.4 0 0 1 1.3-1.4h9a1.4 1.4 0 0 1 1.3 1.4z"/>
                <path fill="#265690" d="M17 18.1a1.4 1.4 0 0 0-1.3 1.4v1.8a1.4 1.4 0 0 0 1.4 1.5 1.4 1.4 0 0 0 1.4-1.5v-1.8a1.4 1.4 0 0 0-1.4-1.4zm.5 1.4v1.8a.4.4 0 0 1-.4.4.4.4 0 0 1-.4-.4v-1.8a.4.4 0 0 1 .4-.4.4.4 0 0 1 .4.4z"/>
            </svg>
            <div>
                <p><?=Yii::t('app', 'Your data is secure')?>:</p>
                <p class="st"><?=Yii::t('app', 'We use SSL encryption for secure data transfer')?>.</p>
            </div>
        </div>
    </aside>
</main>
