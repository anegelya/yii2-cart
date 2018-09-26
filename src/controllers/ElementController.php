<?php
namespace dvizh\cart\controllers;

use yii\helpers\Json;
use app\models\Product;
use app\models\ProductSearch;
use yii\filters\VerbFilter;
use yii;

class ElementController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionDelete()
    {
        $json = ['result' => 'undefined', 'error' => false];
        $elementId = yii::$app->request->post('elementId');

        $cart = yii::$app->cart;

        $elementModel = $cart->getElementById($elementId);

        if($cart->deleteElement($elementModel)) {
            $json['result'] = 'success';
        }
        else {
            $json['result'] = 'fail';
        }

        return $this->_elemJson($json);
    }

    public function actionCreate()
    {
        $json = ['result' => 'undefined', 'error' => false];

        $cart = yii::$app->cart;

        $postData = yii::$app->request->post();

        $model = $postData['CartElement']['model'];
        if($model) {
            $productModel = new $model();
            $productModel = $productModel::findOne($postData['CartElement']['item_id']);

            $options = [];
            if(isset($postData['CartElement']['options'])) {
                $options = $postData['CartElement']['options'];
            }

            if($postData['CartElement']['price'] && $postData['CartElement']['price'] != 'false') {
                $elementModel = $cart->putWithPrice($productModel, $postData['CartElement']['price'], $postData['CartElement']['count'], $options);
            } else {
                $elementModel = $cart->put($productModel, $postData['CartElement']['count'], $options);
            }

            $product = $this->findModel($elementModel->item_id);

            $json['elementId'] = $elementModel->getId();
            $json['elementName'] = $product->mineralData->familyData->name;
            $json['elementPrice'] = $product->price;
            $json['elementImg'] = $product->getMainImage();
            $json['elementSku'] = $product->sku;
            $json['result'] = 'success';
        } else {
            $json['result'] = 'fail';
            $json['error'] = 'empty model';
        }

        return $this->_elemJson($json);
    }

    public function actionUpdate()
    {
        $json = ['result' => 'undefined', 'error' => false];

        $cart = yii::$app->cart;

        $postData = yii::$app->request->post();

        $elementModel = $cart->getElementById($postData['CartElement']['id']);

        if(isset($postData['CartElement']['count'])) {
            $elementModel->setCount($postData['CartElement']['count'], true);
        }

        if(isset($postData['CartElement']['options'])) {
            $elementModel->setOptions($postData['CartElement']['options'], true);
        }

        $json['elementId'] = $elementModel->getId();
        $json['result'] = 'success';

        return $this->_elemJson($json);
    }

    private function _cartJson($json)
    {
        if ($cartModel = yii::$app->cart) {
            if(!$elementsListWidgetParams = yii::$app->request->post('elementsListWidgetParams')) {
                $elementsListWidgetParams = [];
            }

            $json['elementsHTML'] = \dvizh\cart\widgets\ElementsList::widget($elementsListWidgetParams);
            $json['count'] = $cartModel->getCount();
            $json['clear_price'] = $cartModel->getCost(false);
            $json['price'] = $cartModel->getCostFormatted();
        } else {
            $json['count'] = 0;
            $json['price'] = 0;
            $json['clear_price'] = 0;
        }
        return Json::encode($json);
    }

    private function _elemJson($json)
    {
        if ($cartModel = yii::$app->cart) {
            if(!$elementsListWidgetParams = yii::$app->request->post('elementsListWidgetParams')) {
                $elementsListWidgetParams = [];
            }

            $json['elementsHTML'] = \dvizh\cart\widgets\ElementsList::widget($elementsListWidgetParams);
            $json['count'] = $cartModel->getCount();
            $json['clear_price'] = $cartModel->getCost(false);
            $json['price'] = $cartModel->getCostFormatted();
        } else {
            $json['count'] = 0;
            $json['price'] = 0;
            $json['clear_price'] = 0;
        }
        return Json::encode($json);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
