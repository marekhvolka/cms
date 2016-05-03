<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseHtml;
use yii\bootstrap\Modal;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $model backend\models\Section */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="section-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    Modal::begin([
        'header' => '<h4 class="modal-title" id="myModalLabelBlock">Nastavenia sekcie</h4>',
       // 'toggleButton' => ['label' => 'click me2'],
        'size' => 'modal-lg',
        'id' => 'modal-eee',
    ]);
    
    echo $this->render('/section/_options');

    Modal::end();
    ?>

    <button type="button" data-toggle="modal" data-target="#modal-eee">click me</button>



    <div class="panel panel-default" style="position: relative;">
        <div class="btn-group section-buttons">
            <div class="section-button">
                <button class="btn btn-primary dropdown-toggle btn-xs" >
                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                </button>
            </div>
            <div class="dropdown dropdown-blocks section-button">
                <button type="button" class="btn btn-success dropdown-toggle add-row-btn btn-xs" 
                    title="Vložiť nový blok" data-toggle="dropdown">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Fullwidth blok</a></li>
                    <li><a href="#">2 stĺpcový blok</a></li>
                    <li><a href="#">3 stĺpcový blok</a></li>
                    <li><a href="#">4 stĺpcový blok</a></li>
                    <li><a href="#">2/1 blok</a></li>
                    <li><a href="#">1/2 blok</a></li>
                  </ul>
                </div>
            <div class="section-button">
                <button type="button" class="btn btn-danger btn-xs btn-remove-section" title="Zmazať" >
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
            </div>
        </div>
        
        <div class="panel-heading"><h3 class="panel-title">Sekcia</h3></div>
        <div class="panel-body">
            <div class="col-sm-12"> 
                <div class="col-sm-12 sekcia_master">
                    <ol>
                        <li>
                            <div class="row">
                                <div class="col-md-12 layoutWrap">
                                    <div class="panel panel-default">
                                        <div class="sortableDrag"></div><div class="buttonUser">
                                            <div class="btn-position-user-sett">
                                                <button type="button" onclick="openBlockSettings('12621824', 'blok')" id="sett_butt_12621824" data-target="#settModalAdd" data-toggle="modal" class="btn btn-primary dropdown-toggle btn-xs popover2" title="" data-content="<dl class=&quot;dl-horizontal dl-settings&quot;><dt>id</dt><dd>-</dd><dt>class</dt><dd>-</dd><dt>style</dt><dd>-</dd></dl>" data-original-title="Nastavenia"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></button>
                                            </div>
                                            <div class="btn-group btn-position-user">
                                                <button type="button" class="btn btn-success dropdown-toggle btn-xs" data-toggle="dropdown" aria-expanded="false" title="Pridať"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                                <ul class="dropdown-menu simple_with_no_drag" role="menu">
                                                    <span><a href="#" onclick="addIdBlockToModal('panel_12621824', '2583554', 'header')" data-target="#textModalAdd" data-toggle="modal">Text</a></span>
                                                    <span><a href="#" onclick="addIdBlockToModal('panel_12621824', '2583554', 'header')" data-target="#htmlModalAdd" data-toggle="modal">HTML</a></span>
                                                    <span><a href="#" onclick="addIdBlockToModal('panel_12621824', '2583554', 'header')" data-target="#smartSnippetModalAdd" data-toggle="modal">Smart snippet</a></span>
                                                    <span><a href="#" onclick="addIdBlockToModal('panel_12621824', '2583554', 'header')" data-target="#produktSnippetModalAdd" data-toggle="modal">Produktový snippet</a></span>
                                                    <span><a href="#" onclick="addIdBlockToModal('panel_12621824', '2583554', 'header')" data-target="#portalSnippetModalAdd" data-toggle="modal">Portálový snippet</a></span>
                                                </ul>
                                            </div></div>
                                        <div class="panel-heading">1. stĺpec</div>
                                        <div class="panel-body" id="panel_12621824"><ul id="ul_12621824"><li>
                                                    <div class="btn-group" role="group" id="snippet_1262182460954410" style="margin: 3px 2px; height: 30px; display: block; ">
                                                        <button type="button" class="btn btn-default btn-sm" title="Nastevenie publikovania" onclick="openPublic('12621824_h_60954410')"><span class="glyphicon glyphicon-globe"></span></button>
                                                        <input type="hidden" name="active[header][2583554][12621824][]" id="active_12621824_h_60954410" value="1">
                                                        <input type="hidden" name="timeFrom[header][2583554][12621824][]" id="timeFrom_12621824_h_60954410" value="">
                                                        <input type="hidden" name="timeTo[header][2583554][12621824][]" id="timeTo_12621824_h_60954410" value="">
                                                        <button type="button" class="btn btn-default btn-sm" onclick="openElement('snippet_12621824_h_60954410', 'smart_snippet')">Header - logo + telef. cislo</button>
                                                        <input type="hidden" name="element[header][2583554][12621824][]" id="snippet_12621824_h_60954410" value="18">
                                                        <input type="hidden" name="json[header][2583554][12621824][]" id="snippet_12621824_h_60954410_json" value="{&quot;code_select&quot;:&quot;6&quot;,&quot;snippet&quot;:{&quot;telefonne_cislo&quot;:&quot;800 115 555&quot;,&quot;logo-url&quot;:&quot;\/portal\/nonstoppujcka.cz\/images\/nonstoppujcka_1.png&quot;,&quot;logo-text&quot;:&quot;NonstopP\u016fj\u010dka.cz&quot;,&quot;phone-icon&quot;:&quot;&quot;,&quot;alt&quot;:&quot;&quot;}}">
                                                        <input type="hidden" name="typ[header][2583554][12621824][]" value="smart_snippet">
                                                        <button type="button" class="btn btn-info btn-sm" onclick="linkToSnippet('18')" title="Upraviť smart snippet"><span class="glyphicon glyphicon-link"></span></button>
                                                        <button type="button" class="btn btn-danger btn-sm" title="Zmazať element" onclick="removeSnippet('snippet_1262182460954410')"><span class="glyphicon glyphicon-remove"></span></button>
                                                    </div></li></ul></div>
                                    </div>
                                </div>
                                <input type="hidden" name="block_sett[header][12621824]" id="12621824_sett" value="">
                                
                            </div>
                            <button type="button" class="btn btn-danger btn-sm delete-btn-block" onclick="deleteBlock($(this), '2583554');">Zmazať blok</button><div class="clearfix"></div>
                        </li>
                        <li data-name="1" data-id="master_4865396">
                            <div class="row">
                                <div class="col-md-12 layoutWrap">
                                    <div class="panel panel-default">
                                        <div class="sortableDrag"></div><div class="buttonUser">
                                            <div class="btn-position-user-sett">
                                                <button type="button" onclick="openBlockSettings('14865396', 'blok')" id="sett_butt_14865396" data-target="#settModalAdd" data-toggle="modal" class="btn btn-primary dropdown-toggle btn-xs popover2" title="" data-content="<dl class=&quot;dl-horizontal dl-settings&quot;><dt>id</dt><dd>-</dd><dt>class</dt><dd>-</dd><dt>style</dt><dd>-</dd></dl>" data-original-title="Nastavenia"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></button>
                                            </div>
                                            <div class="btn-group btn-position-user">
                                                <button type="button" class="btn btn-success dropdown-toggle btn-xs" data-toggle="dropdown" aria-expanded="false" title="Pridať"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                                <ul class="dropdown-menu simple_with_no_drag" role="menu">
                                                    <span><a href="#" onclick="addIdBlockToModal('panel_14865396', '2583554', 'header')" data-target="#textModalAdd" data-toggle="modal">Text</a></span>
                                                    <span><a href="#" onclick="addIdBlockToModal('panel_14865396', '2583554', 'header')" data-target="#htmlModalAdd" data-toggle="modal">HTML</a></span>
                                                    <span><a href="#" onclick="addIdBlockToModal('panel_14865396', '2583554', 'header')" data-target="#smartSnippetModalAdd" data-toggle="modal">Smart snippet</a></span>
                                                    <span><a href="#" onclick="addIdBlockToModal('panel_14865396', '2583554', 'header')" data-target="#produktSnippetModalAdd" data-toggle="modal">Produktový snippet</a></span>
                                                    <span><a href="#" onclick="addIdBlockToModal('panel_14865396', '2583554', 'header')" data-target="#portalSnippetModalAdd" data-toggle="modal">Portálový snippet</a></span>
                                                </ul>
                                            </div></div>
                                        <div class="panel-heading">1. stĺpec</div>
                                        <div class="panel-body" id="panel_14865396"><ul id="ul_14865396"><li>
                                                    <div class="btn-group" role="group" id="snippet_1486539660954530" style="margin: 3px 2px; height: 30px; display: block; ">
                                                        <button type="button" class="btn btn-default btn-sm" title="Nastevenie publikovania" onclick="openPublic('14865396_h_60954530')"><span class="glyphicon glyphicon-globe"></span></button>
                                                        <input type="hidden" name="active[header][2583554][14865396][]" id="active_14865396_h_60954530" value="1">
                                                        <input type="hidden" name="timeFrom[header][2583554][14865396][]" id="timeFrom_14865396_h_60954530" value="">
                                                        <input type="hidden" name="timeTo[header][2583554][14865396][]" id="timeTo_14865396_h_60954530" value="">
                                                        <button type="button" class="btn btn-default btn-sm" onclick="openElement('snippet_14865396_h_60954530', 'smart_snippet')">Menu</button>
                                                        <input type="hidden" name="element[header][2583554][14865396][]" id="snippet_14865396_h_60954530" value="35">
                                                        <input type="hidden" name="json[header][2583554][14865396][]" id="snippet_14865396_h_60954530_json" value="{&quot;code_select&quot;:&quot;32&quot;,&quot;snippet&quot;:{&quot;color&quot;:&quot;#ffffff&quot;,&quot;sekcie&quot;:[{&quot;init&quot;:&quot;&quot;,&quot;active&quot;:&quot;1&quot;,&quot;podstranka&quot;:&quot;_i_page_217&quot;,&quot;popisok&quot;:&quot;<i class=\&quot;fa fa-home\&quot;><\/i>&quot;,&quot;popisok_url&quot;:&quot;\/&quot;,&quot;css_class&quot;:&quot;0&quot;,&quot;bg_color&quot;:&quot;&quot;,&quot;css_style&quot;:&quot;height: 36px;\r\nfont-size: 16px;\r\nbackground: #fff;\r\nborder: 1px solid #ccc;\r\ncolor:#000 !important;\&quot;&quot;,&quot;icon&quot;:&quot;&quot;},{&quot;init&quot;:&quot;&quot;,&quot;active&quot;:&quot;1&quot;,&quot;podstranka&quot;:&quot;_i_page_228&quot;,&quot;popisok&quot;:&quot;&quot;,&quot;popisok_url&quot;:&quot;http:\/\/www.nonstoppujcka.cz\/nebankovni-pujcky\/&quot;,&quot;css_class&quot;:&quot;0&quot;,&quot;bg_color&quot;:&quot;#0eaae0&quot;,&quot;css_style&quot;:&quot;&quot;,&quot;icon&quot;:&quot;&quot;,&quot;odkazy&quot;:{&quot;1&quot;:{&quot;init&quot;:&quot;&quot;,&quot;active&quot;:&quot;1&quot;,&quot;podstranka&quot;:&quot;_i_page_231&quot;,&quot;text_odkazu&quot;:&quot;&quot;,&quot;css-class&quot;:&quot;0&quot;},&quot;2&quot;:{&quot;init&quot;:&quot;&quot;,&quot;active&quot;:&quot;1&quot;,&quot;podstranka&quot;:&quot;_i_page_230&quot;,&quot;text_odkazu&quot;:&quot;&quot;,&quot;css-class&quot;:&quot;0&quot;},&quot;0&quot;:{&quot;init&quot;:&quot;&quot;,&quot;active&quot;:&quot;1&quot;,&quot;podstranka&quot;:&quot;_i_page_229&quot;,&quot;text_odkazu&quot;:&quot;&quot;,&quot;css-class&quot;:&quot;0&quot;}}},{&quot;init&quot;:&quot;&quot;,&quot;active&quot;:&quot;1&quot;,&quot;podstranka&quot;:&quot;_i_page_235&quot;,&quot;popisok&quot;:&quot;&quot;,&quot;popisok_url&quot;:&quot;http:\/\/www.nonstoppujcka.cz\/kratkodobe-pujcky\/&quot;,&quot;css_class&quot;:&quot;0&quot;,&quot;bg_color&quot;:&quot;#0eaae0&quot;,&quot;css_style&quot;:&quot;&quot;,&quot;icon&quot;:&quot;&quot;,&quot;odkazy&quot;:[{&quot;init&quot;:&quot;&quot;,&quot;active&quot;:&quot;1&quot;,&quot;podstranka&quot;:&quot;_i_page_237&quot;,&quot;text_odkazu&quot;:&quot;&quot;,&quot;css-class&quot;:&quot;0&quot;},{&quot;init&quot;:&quot;&quot;,&quot;active&quot;:&quot;1&quot;,&quot;podstranka&quot;:&quot;_i_page_238&quot;,&quot;text_odkazu&quot;:&quot;&quot;,&quot;css-class&quot;:&quot;0&quot;},{&quot;init&quot;:&quot;&quot;,&quot;active&quot;:&quot;1&quot;,&quot;podstranka&quot;:&quot;_i_page_250&quot;,&quot;text_odkazu&quot;:&quot;&quot;,&quot;css-class&quot;:&quot;0&quot;},{&quot;init&quot;:&quot;&quot;,&quot;active&quot;:&quot;1&quot;,&quot;podstranka&quot;:&quot;_i_page_220&quot;,&quot;text_odkazu&quot;:&quot;&quot;,&quot;css-class&quot;:&quot;0&quot;}]},{&quot;init&quot;:&quot;&quot;,&quot;active&quot;:&quot;1&quot;,&quot;podstranka&quot;:&quot;_i_page_595&quot;,&quot;popisok&quot;:&quot;&quot;,&quot;popisok_url&quot;:&quot;http:\/\/www.nonstoppujcka.cz\/srovnani-pujcek\/&quot;,&quot;css_class&quot;:&quot;2&quot;,&quot;bg_color&quot;:&quot;&quot;,&quot;css_style&quot;:&quot;&quot;,&quot;icon&quot;:&quot;&quot;}]}}">
                                                        <input type="hidden" name="typ[header][2583554][14865396][]" value="smart_snippet">
                                                        <button type="button" class="btn btn-info btn-sm" onclick="linkToSnippet('35')" title="Upraviť smart snippet"><span class="glyphicon glyphicon-link"></span></button>
                                                        <button type="button" class="btn btn-danger btn-sm" title="Zmazať element" onclick="removeSnippet('snippet_1486539660954530')"><span class="glyphicon glyphicon-remove"></span></button>
                                                    </div></li></ul></div>
                                    </div>
                                </div>
                                <input type="hidden" name="block_sett[header][14865396]" id="14865396_sett" value="">
                                <script>
                                    $(document).ready(function ()
                                    {
                                        var list = document.getElementById("ul_14865396");
                                        new Sortable(list, {
                                            group: "omega",
                                            animation: 150,
                                            onSort: function (evt) {
                                                sortable_new(evt);
                                            }
                                        });
                                    })
                                </script>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm delete-btn-block" onclick="deleteBlock($(this), '2583554');">Zmazať blok</button><div class="clearfix"></div>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<JS

$('#modal-1').modal({"show":false});
        
JS;
$this->registerJs($js);
?>



