<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use rmrevin\yii\module\Comments;

/* @var $this yii\web\View */
/* @var $model common\models\Report */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Tasks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-view">

    <h1 class="no-top-margin"><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->id == $model->owner_id): ?>
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['update', 'id' => $model->id], ['class' => 'btn btn-default']) ?> 
    </p>
    <?php endif; ?>

    <p>
        <?=Yii::t('app', 'Created')?>: <?php echo $model->owner->profile->getfullName(); ?>  <?php echo date('m.d.Y', $model->created_at); ?>
    </p>


    <div class="panel panel-default">
      <div class="panel-body"><?=$model->text?></div>
    </div>

</div>

<?php if (count($model->images) > 0): ?>
<div class="row">
   <div class="col-lg-12">
   <h4 style="margin-bottom: 10px"><?=Yii::t('frontend', 'Images')?></h4>
        <?php foreach ($model->images as $image): ?>
            <div class="col-lg-3 col-md-4 col-xs-6 thumb" style="padding-left: 0px; padding-right: 0px">
                <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="" data-caption="" data-image="<?php echo Yii::$app->request->baseUrl . '/frontend/web/files/images/task/'. $image->file; ?>" data-target="#image-gallery">
                    <img class="img-responsive" src="<?php echo Yii::$app->request->baseUrl . '/frontend/web/files/images/task/'. $image->file; ?>">
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php if (count($model->documents) > 0): ?>
<div class="row">
   <div class="col-lg-12">
   <h4 style="margin-bottom: 10px"><?=Yii::t('frontend', 'Documents')?></h4>
   <ul style="padding-left: 0px;"  class="list-unstyled"> 
        <?php foreach ($model->documents as $document):     
            echo '<li style="padding-top: 5px"><a download="' . $document->file . '" href="' . Yii::$app->request->baseUrl . '/frontend/web/files/documents/task/'. $document->file . '"  style="padding-right: 10px" class="download-document"><span class="glyphicon glyphicon-download"></span></a>'; 
            echo '<a target="_blank" href="' . Yii::$app->request->baseUrl . '/frontend/web/files/documents/task/'. $document->file . '">' . $document->file . '</a></li>';
            
        endforeach; ?>
    </ul>
</div>
</div>
<?php endif; ?>


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

echo Comments\widgets\CommentListWidget::widget([
    'entity' => (string) 'task-' . $model->id, 
]);

$script = <<< JS
    $(document).ready(function(){


    /*$('.download-document').click(function(){
        window.location.href = $(this).attr('href'); 
        return false;
    })*/

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
});  
JS;
$this->registerJs($script, yii\web\View::POS_READY);
