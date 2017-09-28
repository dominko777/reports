<?php

use circulon\widgets\ColumnListView;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'My images');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-index">

    <h1 class="no-top-margin"><?= Html::encode($this->title) ?></h1>
    <?php
    echo ColumnListView::widget([
            'dataProvider' => $dataProvider,
            'columns' => 3, 
            'itemView' => '_list', 
            'summary'=>'', 
    ]);
?>
</div>


<div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="image-gallery-title"></h4>
            </div>
            <div class="modal-body">
                <img id="image-gallery-image" class="img-responsive" src="">
            </div>
            <div class="modal-footer">

                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" id="show-previous-image"><?=Yii::t('frontend', 'Previous image')?></button>
                </div>

                <div class="col-md-6 text-justify" id="image-gallery-caption">
                    This text will be overwritten by jQuery
                </div>

                <div class="col-md-3">
                    <button type="button" id="show-next-image" class="btn btn-default"><?=Yii::t('frontend', 'Next image')?></button> 
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$script = <<< JS
    loadGallery(true, 'a.thumbnail');

    //This function disables buttons when needed
    function disableButtons(counter_max, counter_current){
        $('#show-previous-image, #show-next-image').show();
        if(counter_max == counter_current){
            $('#show-next-image').hide();
        } else if (counter_current == 1){
            $('#show-previous-image').hide();
        }
    }

    /**
     *
     * @param setIDs        Sets IDs when DOM is loaded. If using a PHP counter, set to false.
     * @param setClickAttr  Sets the attribute for the click handler.
     */

    function loadGallery(setIDs, setClickAttr){
        var current_image,
            selector,
            counter = 0;

        $('#show-next-image, #show-previous-image').click(function(){
            if($(this).attr('id') == 'show-previous-image'){
                current_image--;
            } else {
                current_image++;
            }

            selector = $('[data-image-id="' + current_image + '"]');
            updateGallery(selector);
        });

        function updateGallery(selector) {
            var sel = selector;
            current_image = sel.data('image-id');
            $('#image-gallery-caption').text(sel.data('caption'));
            $('#image-gallery-title').text(sel.data('title'));
            $('#image-gallery-image').attr('src', sel.data('image'));
            disableButtons(counter, sel.data('image-id'));
        }

        if(setIDs == true){
            $('[data-image-id]').each(function(){
                counter++;
                $(this).attr('data-image-id',counter);
            });
        }
        $(setClickAttr).on('click',function(){
            updateGallery($(this));
        });
    }  
JS;
$this->registerJs($script, yii\web\View::POS_READY);