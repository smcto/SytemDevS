<?php use Cake\Collection\Collection; ?>
<?php $this->Html->script('moment.fr', ['block' => 'script']); ?>
<?php $this->Html->script('moment-range', ['block' => 'script']); ?>

<?php $this->Html->css('bootstrap-datepicker/dist/css/bootstrap-datepicker3.css', ['block' => 'css']); ?>
<?php $this->Html->css('bootstrap-datetime-picker/css/bootstrap-datetimepicker.css', ['block' => 'css']); ?>
<?php $this->Html->css('bootstrap-daterangepicker/daterangepicker.css', ['block' => 'css']); ?>

<?php $this->Html->script('vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min', ['block' => 'script']); ?>
<?php $this->Html->script('vendors/custom/components/vendors/bootstrap-datepicker/init', ['block' => 'script']); ?>
<?php $this->Html->script('bootstrap-datepicker/js/locales/bootstrap-datepicker.fr.js', ['block' => 'script']); ?>
<?php $this->Html->script('app/custom/general/crud/forms/widgets/bootstrap-datepicker', ['block' => 'script']); ?>
<?php $this->Html->script('bootstrap-daterangepicker/daterangepicker.js', ['block' => 'script']); ?>

<?php $this->Html->script('bootstrap-datetimepicker.js', ['block' => 'script']); ?>
<?php $this->Html->script('me-bootstrap-weekpicker.min.js', ['block' => 'script']); ?>

<?php $this->assign('title', 'Planning de production') ?>
<?php
    $editionStateModeInput = @$edition_mode['edition_mode'] == 1 ? '' : 'disabled';
    $hideIfDisplayMode = @$edition_mode['edition_mode'] == 1 ? '' : 'd-none';
    $hideIfOnline = $this->request->host() != '127.0.0.1' ? 'd-none' : 'd-none';
?>

<?php
$this->Form->setTemplates([ 
    'inputContainer' => '{{content}}'
]);
?>

<div class="global-planning">
    <div class="content-planning">

        <div class="modal fade" id="uploaded-files" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"aria-hidden="true">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Fichier(s) BAT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body container-uploaded-files">
                        <!-- AJAX -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="commentaire-relicat-vue" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Information sur le relicat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-modal-alert"></div>
                        <!-- JS -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="commentaire-relicat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"aria-hidden="true">
            <div class="modal-dialog  modal-lg" role="document">
                <?= $this->Form->create(false, ['class' => 'form-horizontal modal-product-comment', 'type' => 'file']); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Information sur le relicat</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body container-commentaire-relicat">
                            <div class="container-modal-alert"></div>
                            <div class="form-group">
                                <label for="">Entrez votre commentaire</label>
                                <?= $this->Form->textarea('comment_planning', ['class' => 'form-control comment-planning', 'required']) ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary">Enregistrer</button>
                        </div>
                    </div>
                <?= $this->form->end() ?>   
            </div>
        </div>

        <div class="modal fade" id="report-date" tabindex="-1" role="dialog" aria-labelledby="report-tile"aria-hidden="true">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="report-tile">Reporter la date pour cette commande</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body container-report-date">
                     <?= $this->Form->create(false, ['class' => 'form-vertical kt-form', 'type' => 'file']); ?>

                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group  calendar">
                                        <h5 for="">Choisir la date (*)</h5>
                                        <?php echo $this->Form->text('date_calendar', ['type' => 'date', 'class' => 'form-control',  'id' => 'kt_datepicker_4_3']); ?>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="submit-report" class="btn btn-primary" style="float: right;">Soumettre </button>
                        <?php echo $this->Form->end(); ?>
                    </div>
          
                </div>
            </div>
        </div>

        <div class="modal fade" id="validation-state" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Validation de l'état pour la commande sélectionnée</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body container-validation-state">
                        <!-- AJAX -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>


        <?= $this->Form->create(false, ['class' => 'form-planning', 'type' => 'file']); ?>

        <div class="card">

            <div class="card-header bg-white">
                <h5 class="mt-2">Planning de production <span class="<?= $hideIfDisplayMode ?>"> </span> </h5>
            </div>

            <div class="card-body bg-white border-0">

                <div class="row container-date-range">

                    <div class="col-6 planning-range-infos">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 id="title-date-range"><a href="#">S<?= $planning->number_of_week ?> : <?= $planning->date_from->nice() ?> au <?= $planning->date_to->nice() ?> </a></h4>
                            </div>
                        </div>
                        <input type="text" style="position: absolute; visibility: hidden;" name="range" id="range"class=" form-control pull-left relative"value="<?= $planning->date_from->format('Y-m-d') ?> - <?= $planning->date_to->format('Y-m-d') ?>"/>
                    </div>

                    <div class="col-6">
                        <div class="row-fluid d-block clearfix mb-4">
                            <span class="float-right">Dernière mise à jour : <?= !is_null(@$lastOrderProductModified->modified) ? $lastOrderProductModified->modified->modify('+0 hours')->format('d/m/y à H\\hi') : '' ?></span>
                        </div>
                        <div class="row-fluid d-block clearfix">
                            <div class="btn-group float-right">
                                <button type="button" class="btn btn-secondary change-range">
                                    <span class="fa fa-calendar text-muted"></span> Changer la période
                                </button>
                                <?php if (@$edition_mode['edition_mode'] == 1): ?>
                                    <a href="<?= $this->Url->build(['action' => 'set-display-mode', 0]) ?>"data-url="<?= $this->Url->build([], true) ?>"class="change-mode btn btn-secondary active"><span class="fa fa-eye text-muted"></span> Mode affichage</a>
                                <?php else: ?>
                                    <a href="<?= $this->Url->build(['action' => 'set-display-mode', 1]) ?>"data-url="<?= $this->Url->build([], true) ?>"class="change-mode btn btn-secondary "><span class="la la-pencil-square-o text-muted"></span> Mode édition</a>
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="row-fluid mt-2">
                            <div class="offset-lg-5 col-lg-7  col-md-7">
                                <div class="d-inline planning-bloc-week"> <div id="planning_range" class="my-3 pb-2 "style="width:85%; display: inline-block; padding-left: 8px; padding-right: 8px;"></div> </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-body ">

                <div id="synthese-container">
                    <div id="synthese">
                        <ul class="nav nav-tabs small justify-content-first plannings-tabs" role="tablist">

                            <?php foreach ($marquages as $key => $marquage): 
                                $oMarquage = $marqueById[$marquage->id][0];
                                $nbr = count($oMarquage->orders_products);
                                ?>
                                <li class="nav-item bg">
                                    <a 
                                        class="nav-link <?= $key != 0 ?'': "active" ?>" 
                                        data-id="marquage-<?= $marquage->id ?>" 
                                        data-toggle="pill"href="#marquage-<?= $marquage->id ?>" 
                                        marquage-id="<?= $marquage->id ?>""
                                        role="tab"
                                        aria-selected="<?= $key != 0 ?'': "true" ?>"
                                    >
                                        <span class="text-dark"><?= ucfirst($marquage->name) ?></span>
                                        <span class="icon-rounded-sm bg-darkgrey" data-type="adulte"><?= $nbr ?></span>
                                        <!-- JS -->
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
                <div class="card-body-planning">
                    <div class="content-planning">
                        <div class="tab-content mt-2">
                            <?php foreach ($marquages as $key => $marquage): ?>
                                <div class="tab-pane fade <?= $key == 0 ? "show active" : "" ?>"id="marquage-<?= $marquage->id ?>">
                                    <div class="row-fluid mb-4 clearfix d-block line-projects" style="font-size: 14px;">
                                        <?php //debug($marquage);  ?>
                                        <?php $total = 0 ?>
                                        <div class="text-dark fa-1-2x">
                                            <?php foreach ($marquage['orders_products_status'] as $key => $orders_products_status): 
                                                $oMarquage = $marqueById[$marquage->id][0];
                                                //debug($oMarquage); 
                                            ?>
                                                <?= $orders_products_status->get('status_value') . ' : <span data-nb-prj="'.count($oMarquage->orders_products).'" class="nb_prj">' . count($oMarquage->orders_products) . '</span>' ?> <?= collection($marquage['orders_products_status'])->count()-1 != $key ? ' ,' : '' ?>
                                                <?php $total += count($oMarquage->orders_products) ?>
                                            <?php endforeach ?>
                                        </div>

                                        <div class="d-none nb_totals" marquage-id="<?= $marquage->id ?>" total-by-marquage="<?= $total ?>">
                                            <!-- Lié au js pour afficher le total en haut/marquage -->
                                        </div>
                                    </div>
                                    <table class="table table-bordered ">
                                        <thead class="bg-light">
                                            <tr>
                                                <th width="9%">État</th>
                                                <th width="2%">Marchandise</th>
                                                <th width="8%">Relicat</th>
                                                <th width="12%">Client</th>
                                                <th width="10%">Qté et coul</th>
                                                <th width="7%">Modèles</th>
                                                <th width="5%">Ref</th>
                                                <!-- <th width="7%">Couleurs</th> -->
                                                <th width="7%">Poch</th>
                                                <th width="7%">Poit</th>
                                                <th width="7%">Dos</th>
                                                <th width="7%">Man</th>
                                                <th width="7%">Autre</th>
                                                <th width="7%">Projet</th>
                                                <th width="5%">LIVR</th>
                                                <th width="5%"></th>
                                            </tr>
                                        </thead>

                                        <tbody class="tbody-planning">

                                            <?php $containerRC = [] ?>
                                                <?php /*debug(collection($ordersProducts)->firstMatch(['reference' =>'SAN SIRO 2 - 01221'])->count());*/ ?>
                                            <?php foreach (@$ordersProducts as $ordersProduct): ?>
                                                <?php 
                                                $collection = new Collection($ordersProduct->marquages);
                                                $idMarquages = $collection->extract('id')->toList();
                                                //if ($ordersProduct->marquage_id == $marquage->id): 
                                                if(!empty($idMarquages)):
                                                if(in_array($marquage->id,$idMarquages)):
                                                ?>
                                                    <?php /*debug($marquage->id);*/ ?>
                                                    <?php if (!in_array($ordersProduct['reference_customer'], $containerRC)): ?>
                                                        <?php $list = @$ordersProductsStatusListed[$marquage->name]; ?>

                                                        <?php $orderProductFirst = collection($oPs[$ordersProduct['reference_customer']])->first() ?>
                                                        
                                                        <?php $is_bg_green = $orderProductFirst->is_marchandise == 1 && @$ordersProduct->orders_products_status->status == 'bat_ready'; ?>
                                                        <?php $is_bg_orange = $orderProductFirst->is_relicat == 1 && @$ordersProduct->orders_products_status->status == 'bat_ready'; ?>

                                                        <tr data-id="<?= $opId = $orderProductFirst->id ?>" class="<?= $orderProductFirst->maj_done == 1 ? 'bg-red' : '' ?> lh-low  <?= $is_bg_orange == true ? "bg-warning" : ($is_bg_green == true ? "bg-green" : @$ordersProduct->orders_products_status->bg_color); ?>" id="project-line-tr" data-urlstatus="<?= $this->Url->build(['controller' => 'ajax-planning', 'action' => 'maj-status', $ordersProduct->id]) ?>" data-url="<?= $this->Url->build(['controller' => 'ajax-planning', 'action' => 'edit-orders-products', $ordersProduct->id]) ?>">
                                                            <td>
                                                                <?= $this->Form->select('orders_products_status_id', $list, ['value' => $orderProductFirst->orders_products_status_id, 'class' => 'form-control', 'id' => 'order-product-' . $orderProductFirst->id, 'data-order-product-id' => $orderProductFirst->id]); ?>
                                                            </td>
                                                            <td><?php echo $this->Form->checkbox('is_marchandise', ['hiddenField' => false, 'class' => 'is_marchandise', 'checked' => $orderProductFirst->is_marchandise == 1 ? 'checked' : '', 'url-maj' => $this->Url->build(['controller' => 'ajax-planning', 'action' => 'maj-merchant-status', $orderProductFirst->id])]); ?></td>
                                                            <td>
                                                                <?php echo $this->Form->checkbox('is_relicat', ['hiddenField' => false, 'class' => 'is_relicat', 'checked' => $orderProductFirst->is_relicat == 1 ? 'checked' : '', 'url-maj' => $this->Url->build(['controller' => 'ajax-planning', 'action' => 'maj-merchant-status', $orderProductFirst->id])]); ?>
                                                                <a href="javascript:void(0)" id="note" class="<?= $orderProductFirst->is_relicat == 0 ? 'd-none' : '' ?>" data-toggle="modal" data-id="<?= $orderProductFirst->id ?>" data-target="#commentaire-relicat-vue">note <?= $orderProductFirst->comment_planning != null ? '<span class="fa fa-clipboard"></span>' : '' ?></a>
                                                            </td>
                                                            <td> <?= $orderProductFirst->project->customer->name ?> </td>
                                                            <td class="">
                                                                <?php foreach ($oPs[$ordersProduct['reference_customer']] as $key => $op): ?>
                                                                    <?php 
                                                                    //if ($ordersProduct->marquage_id == $op->marquage_id):
                                                                    if(in_array($op->marquage_id,$idMarquages)):
                                                                    ?>
                                                                        - <?= $op->get('total') .' '. @$op->coloris->name ?> <br>
                                                                    <?php endif; ?>
                                                                <?php endforeach ?>
                                                            </td>
                                                            <td><?= $this->Form->text('modele', ['value' => $orderProductFirst->modele, 'class' => 'form-control ', 'disabled'=>'disabled', 'label' => false]); ?></td>
                                                            <td><?= $orderProductFirst->reference ?></td>
                                                            <td><?= $this->Form->text('poch', ['value' => $orderProductFirst->poch, 'class' => 'form-control ', $editionStateModeInput, 'label' => false]); ?></td>
                                                            <td><?= $this->Form->text('poit', ['value' => $orderProductFirst->poit, 'class' => 'form-control ', $editionStateModeInput, 'label' => false]); ?></td>
                                                            <td><?= $this->Form->text('dos', ['value' => $orderProductFirst->dos, 'class' => 'form-control ', $editionStateModeInput, 'label' => false]); ?></td>
                                                            <td><?= $this->Form->text('man', ['value' => $orderProductFirst->man, 'class' => 'form-control ', $editionStateModeInput, 'label' => false]); ?></td>
                                                            <td><?= $this->Form->text('other', ['value' => $orderProductFirst->other, 'class' => 'form-control ', $editionStateModeInput, 'label' => false]); ?></td>

                                                            <td>
                                                                <!-- <a target="_blank" href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'view-project', $orderProductFirst->project->id]) ?>"><?= $orderProductFirst->project->name ?></a> <br> -->
                                                                <a href="<?= $this->Url->build(['controller' => 'projects', 'action' => 'edit', $orderProductFirst->project->id, 'order', 'edition' => '1']) ?>">Éditer</a>
                                                                <br>
                                                                <a href="javascript:void(0);" data-url="<?= $this->Url->build(['controller' => 'ajax-project', 'action' => 'view-uploaded-files', $orderProductFirst->project->id]) ?>"data-toggle="modal" data-target="#uploaded-files"> Fichiers BAT </a>
                                                            </td>

                                                            <td>
                                                                <div>
                                                                    <p><?= $orderProductFirst->get('delivery_date') != null ? $orderProductFirst->get('delivery_date')->format('d-m-Y') : $orderProductFirst->delivery_date->format('d/m/Y') ?></p>
                                                                    <a target="_blank" href="#"data-url="<?= $this->Url->build(['controller' => 'orders-products', 'action' => 'report', $orderProductFirst->id]) ?>"class="btn btn-default bg-white text-dark mt-0" data-toggle="modal"data-target="#report-date" >Reporter</a>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="#" data-url="<?= $this->Url->build(['controller' => 'ajax-planning', 'action' => 'majMerchantStatus', $orderProductFirst->id]) ?>" class="btn btn-default <?= $hideIfOnline ?> bg-white text-dark mt-0 finish btn-sm" ><span class="fa fa-check "></span></a>
                                                                <div class="container-majdone" >
                                                                    <?php if ($orderProductFirst->maj_done == 0): ?>
                                                                        <a href="javascript:void(0);" data-url="<?= $this->Url->build(['controller' => 'ajax-planning', 'action' => 'majToDone', $orderProductFirst->id]) ?>" class="btn btn-default bg-white text-dark mt-0 majdone btn-sm" >Terminer</a>
                                                                    <?php else: ?>
                                                                        <span class="majdone-ok">Terminé</span>
                                                                        <a href="javascript:void(0);" data-url="<?= $this->Url->build(['controller' => 'ajax-planning', 'action' => 'majToDone', $orderProductFirst->id]) ?>" class="askfor majdone" >(Modifier)</a>
                                                                    <?php endif ?>
                                                                </div>
                                                            </td>

                                                            <script>
                                                                $('#kt_datepicker_4_4-<?= $orderProductFirst->id ?>').datepicker({
                                                                    format: 'yyyy-mm-dd',
                                                                    orientation: "bottom right",
                                                                    todayHighlight: true,
                                                                    language: 'fr',
                                                                });
                                                            </script>
                                                        </tr>
                                                        <?php $containerRC[] = $ordersProduct['reference_customer'] ?>
                                                    <?php endif ?>
                                                <?php 
                                                    endif;
                                                endif; 
                                                ?>

                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->form->end() ?>


        <script>

            /*$('.nav-tabs .nav-item a').each(function(index, el) {
                marquageId = $(this).attr('marquage-id');
                nbTotal = $('.line-projects .nb_totals[marquage-id="'+marquageId+'"]').attr('total-by-marquage');
                $(this).append('<span class="icon-rounded-sm bg-darkgrey" data-type="adulte">'+nbTotal+'</span>');
            });*/
         
            // MAJ DATE RANGE
            $('#title-date-range, .change-range').click(function (event) {
                $('#range').trigger('click');
            });

            function setDateRangePicker() {
                return $('#range').daterangepicker({
                    showCustomRangeLabel: false,
                    opens: "right",
                    locale: {
                        format: 'YYYY-MM-DD',
                        cancelLabel: 'Clear',
                        "separator": " - ",
                        "applyLabel": "Appliquer",
                        "cancelLabel": "Annuler",
                        "fromLabel": "De",
                        "toLabel": "À",
                        "customRangeLabel": "Custom",
                        "weekLabel": "W",
                        "firstDay": 1
                    }
                }).on('apply.daterangepicker', function (ev, picker) {
                    data = {
                        'date_from': picker.startDate.format('YYYY-MM-DD'),
                        'date_to': picker.endDate.format('YYYY-MM-DD'),
                    };

                    $.post('<?= $this->Url->build(['controller' => 'ajax-planning', 'action' => 'maj']) ?>', data, function (data, textStatus, xhr) {
                        if (xhr.status == 200) {
                            $('#title-date-range').load(window.location + ' #title-date-range')
                            reloadFromUrl("<?= $this->Url->build(['edition' => "true"]) ?>");
                        }
                    });
                }).on('show.daterangepicker', function (e, a) {
                    calendarBox = a.container[0];
                    $(calendarBox).css({
                        'top': '200px',
                    });
                });
            };

            setDateRangePicker()

            // Change la couleur quand on choisit un état de la commande F.
            function MajOnSelectChange() {
                $('#project-line-tr select[name="orders_products_status_id"]').unbind('change').on('change', function (event) {

                    event.preventDefault();
                    currentTr = $(this).parents('#project-line-tr');
                    val = $(this).val();
                    order_product_id = $(this).attr('data-order-product-id');
                    urlTr = currentTr.attr('data-urlstatus');

                });
            }

            MajOnSelectChange()

            function reloadSyntheseWithIndex() {
                currentTabIndex = $('.plannings-tabs a.nav-link.active').parent().index();
                // console.log(currentTabIndex)
                url = "<?= $this->Url->build(['edition' => "true"]) ?>&index="+currentTabIndex;
                $.get(url, function (data) {
                    $('.global-planning').html($(data).html())
                    $('.plannings-tabs a.nav-link').eq(currentTabIndex).tab('show');
                });
            }


            // MAJ LIGNE DU TABLEAU 
            $('#project-line-tr input').not('.is_marchandise , .is_relicat').on('keyup change', function (event) {
                event.preventDefault();
                currentTr = $(this).parents('#project-line-tr');
                url = currentTr.attr('data-url');

                data = currentTr.find('input').serialize();
                $.post(url, data, function (data, textStatus, xhr) {
                    console.log(data)
                });
            });

            var weekpicker = $("#planning_range").weekpicker(moment("<?= $planning->date_from->format('Y-m-d') ?>"));

            // Récupère l'intervalle en jours de - à de la semaine choisie, (commencant par lundi)
            var inputField = weekpicker.find("input");
            inputField.datetimepicker().on("dp.change", function () {

                // var fromDate = moment().year(2019).week(22).day(1).get('date');
                var fromDate = moment().year(weekpicker.getYear()).week(weekpicker.getWeek()).day(1).format('YYYY-MM-DD'); // day(1) veut dire le lundi da la semaine
                var toDate = moment().year(weekpicker.getYear()).week(weekpicker.getWeek() + 1).day(1).format('YYYY-MM-DD'); // +1 pour recupérer la semaine prochaine

                data = {
                    'number_of_week': weekpicker.getWeek(),
                    'date_from': fromDate,
                    'date_to': toDate,
                };

                // Reactualise le tableau planning dès quand on joue sur la pagination de la semaine
                $.post('<?= $this->Url->build(['controller' => 'ajax-planning', 'action' => 'maj']) ?>', data, function (data, textStatus, xhr) {
                    if (xhr.status == 200) {
                        $('#title-date-range').load(window.location + ' #title-date-range');
                        $.get('<?= $this->Url->build(['controller' => 'ajax-planning', 'action' => 'get-current-planning']) ?>', function (data) {
                            fromDate = moment(data.date_from).format('YYYY-MM-DD');
                            toDate = moment(data.date_to).format('YYYY-MM-DD');
                            $('#range').val(fromDate + ' - ' + toDate);
                            setDateRangePicker();
                            reloadSyntheseWithIndex();
                        });
                    }
                });

            })


            $('.btn-delivery').click(function (event) {
                $(this).parents('.container-input-delivery').find('input').trigger('focus')
            });

            function setDisplayMode() {

                $('.change-mode').click(function (event) {
                    currentTabIndex = $('.plannings-tabs a.nav-link.active').parent().index();
                    $(this).html('<span class="fa fa-redo"></span> Chargement ...')
                    event.preventDefault()
                    url = $(this).attr('data-url');
                    url2 = $(this).attr('href');
                    $.get(url2, function (data) {
                        $.get(url, function (data) {
                            $('.global-planning').html($(data).html())
                            $('.plannings-tabs a.nav-link').eq(currentTabIndex).tab('show');
                        });
                    });
                });
            }

            setDisplayMode();

            // recharge l'intégralité du tableau après changement de la page semaine en cours
            function reloadFromUrl(url) {
                return $.get(url, function (data) {
                    $('.global-planning').html($(data).html())
                });
            }

            $('#kt_datepicker_4_3, #kt_datepicker').datepicker({
                rtl: KTUtil.isRTL(),
                orientation: "bottom left",
                todayHighlight: true,
                language: 'fr',
                calendarWeeks: true,
                format: 'yyyy-mm-dd'
            }).on("changeDate", function(e) {
                // console.log('lol')
            });

            $('#uploaded-files').on('shown.bs.modal', function (event) {
                link = event.relatedTarget;
                url = $(link).attr('data-url');
                $('.container-uploaded-files').text('Chargement ...');
                $.get(url, function (data) {
                    $('.container-uploaded-files').html(data)
                });
                /* Act on the event */
            });

            $('#report-date').on('shown.bs.modal', function (event) {
                link = event.relatedTarget;
            });


        // Reporter date
        $('#submit-report').click(function(event) {
            $('.report-date').modal('hide');

            url = $(link).attr('data-url');
            data = $('#kt_datepicker_4_3').val();
            currentTabIndex = $('.plannings-tabs a.nav-link.active').parent().index();
            $.post(url, { date_calendar : data }, function (data, textStatus, xhr) {
                
                $('.kt-selectpicker').selectpicker('refresh');
                $('input[name="date_calendar"].kt_datepicker_4_3').selectpicker('refresh');

                reloadUrl = "<?= $this->Url->build(['action' => 'index'], true) ?>";
                $.get(reloadUrl, function(data) {
                    $('.global-planning').html($(data).html())
                    $('.plannings-tabs a.nav-link').eq(currentTabIndex).tab('show');
                    $('#report-date').modal('hide');
                    $('.modal-backdrop').fadeOut(250, function (e) {
                        $(this).remove()
                    })
                });

            });

        });

        // met à jour l'etat à done
        function majDone() {
            
            $('a.majdone').unbind('click');
            $('a.majdone').click(function(event) {
                if ($(this).hasClass('askfor')) {
                    if (!confirm("Remettre à \"non terminé\"?")) {
                        return false;
                    }
                }
                currentTr = $(this).parents('#project-line-tr');
                order_product_id = currentTr.attr('data-id');

                url = $(this).attr('data-url');
                // console.log(order_product_id)
                $.post(url, {}, function(data, textStatus, xhr) {
                    $('a.majdone').unbind('click');
                    if (data.bg_color != null) {
                        currentTr.addClass(data.bg_color);
                        currentTr.find('.container-majdone').html('<span class="majdone-ok">Terminé</span> <a href="javascript:void(0);" data-url="<?= $this->Url->build(['controller' => 'ajax-planning', 'action' => 'majToDone']) ?>/'+order_product_id+'" class="askfor majdone" >(Modifier)</a>')
                    } else {
                        currentTr.addClass('bg-white');
                        currentTr.find('.container-majdone').html('<a href="javascript:void(0);" data-url="<?= $this->Url->build(['controller' => 'ajax-planning', 'action' => 'majToDone']) ?>/'+order_product_id+'" class="btn btn-default bg-white text-dark mt-0 majdone btn-sm" >Terminer</a>')
                        currentTr.removeClass('bg-red');
                    }
                    // reloadSyntheseWithIndex();
                    majDone();
                });
            });
        }

        majDone();

        // Post et save chaque modification 
        $('a.finish').click(function(event) {
            event.preventDefault();

            currentTr = $(this).parents('#project-line-tr');
            marchandiseCheckbox = currentTr.find('input[name="is_marchandise"]');
            relicatCheckbox = currentTr.find('input[name="is_relicat"]');
            url = $(this).attr('data-url');
            data = currentTr.find('input , select').serializeArray();

            $.post(url, data, function(data, textStatus, xhr) {

                if (!currentTr.hasClass('bg-red')) {
                    console.log(data.order_product_status)
                    currentTr.attr('class', data.order_product_status.bg_color);

                    // Inverser l'ordre pour définir la couleur si les 2 cases relicatCheckbox et marchandiseCheckbox sont cochés
                    if (relicatCheckbox.is(':checked') && data.order_product_status.status == 'bat_ready') {
                        currentTr.attr('class', 'bg-warning');
                    } else

                    if (marchandiseCheckbox.is(':checked') && data.order_product_status.status == 'bat_ready') {
                        currentTr.attr('class', 'bg-green');
                    } 

                    $('.container-alert').html(flash('Mise à jour effectuée!', 'success')).promise().then(function (arg) {
                        setTimeout(function (arg) {
                            $('.container-alert').empty();
                        }, 20000);
                    });
                }
            });
        });

        // Affiche popup de commentaire quant relicat est coché
        function addCommentOnOrderProduct() {
            $('input[type="checkbox"].is_relicat').unbind('click').click(function(event) {
                currentTr = $(this).parents('#project-line-tr');
                ordersProductId = currentTr.attr('data-id');

                if ($(this).prop('checked')) { // si coché
                    $('#commentaire-relicat').modal('show');
                    $('.comment-planning').val('');
                    urlComment = "<?= $this->Url->build(['controller' => 'ajax-planning', 'action' => 'orderproductAddComment']) ?>/"+ordersProductId;
                    $('#commentaire-relicat').on('shown.bs.modal', function (a) {
                        $(a.currentTarget).find('form').attr('action', urlComment);

                        $('.modal-product-comment').submit(function(event) {
                            event.preventDefault();
                            url = $(this).attr('action');

                            $.post(url, $(this).serializeArray()).done(function (data) {


                                $('.container-modal-alert').html(flash('Commentaire déposé!', 'success')).promise().then(function (arg) {
                                    setTimeout(function (arg) {
                                        $('#commentaire-relicat').modal('hide');
                                        currentTr.find('a.finish').trigger('click');
                                        if (data.comment_planning != null ) {
                                            currentTr.find('#note').removeClass('d-none');
                                        }
                                    }, 1500);
                                });
                                removeAlert();
                            });
                        });
                    })
                } else {
                    currentTr.find('#note').addClass('d-none');
                }
            });
        }

        addCommentOnOrderProduct();

        // Maj quand relicat ou marchandise cliqué
        $('input.is_marchandise , input.is_relicat').click(function(event) {
            triggerClickOnFinish(this);
        });

        // Maj quand etat changé
        $('select[name="orders_products_status_id"]').change(function(event) {
            triggerClickOnFinish(this);
        });

        function triggerClickOnFinish(el) {
            currentTr = $(el).parents('#project-line-tr');
            currentTr.find('a.finish').trigger('click');
        }

        // affiche le popup commentaire
        function loadCommentOnRelicat() {
            $('#commentaire-relicat-vue').on('shown.bs.modal', function (e) {
                ordersProductId = $(e.relatedTarget).attr('data-id');
                currentTr = $(e.relatedTarget).parents('#project-line-tr');

                innerModal = $(e.currentTarget);
                bodyModal = innerModal.find('.modal-body');
                url = "<?= $this->Url->build(['controller' => 'ajax-planning', 'action' => 'getOrderProduct']) ?>/"+ordersProductId;

                $.get(url, function(data) {
                    var commentContent = data.comment_planning != null  ? data.comment_planning : 'Aucun commentaire';

                    bodyModal.html('<div class="loaded-comment">'+commentContent+' <br /> <a href="javascript:void(0);" class="edit-comment-modal mt-2 d-block"><span class="fa fa-edit fa-1x"></span> Modifier</a></div>');

                    $('.edit-comment-modal').click(function(event) {
                        loadedComment = data.comment_planning !== null ? commentContent : '';
                        $(".loaded-comment").html('<label for="">Modifiez votre commentaire</label> <textarea name="comment_planning" class="form-control new-comment" required="required" rows="5">'+loadedComment+'</textarea> ')
                        $('.loaded-comment').prepend('<div class="container-modal-alert"></div>');
                        $('.loaded-comment').append('<button class="mt-4 btn btn-primary save-updated-comment" >Enregistrer la modification</button>')

                        urlUpdateComment = "<?= $this->Url->build(['controller' => 'ajax-planning', 'action' => 'orderproductAddComment']) ?>/"+ordersProductId;
                        $('.save-updated-comment').click(function(event) {
                            $.post(urlUpdateComment, $('.new-comment').serializeArray()).done(function (data) {
                                $('.container-modal-alert').html(flash('Commentaire modifié!', 'success')).promise().then(function (arg) {
                                    setTimeout(function (arg) {
                                        $('#commentaire-relicat-vue').modal('hide');
                                        reloadSyntheseWithIndex();
                                    }, 1500);
                                });
                                removeAlert();
                            });
                        });
                    });


                });
            });
        }

        loadCommentOnRelicat();

        // Ajout Aucun projet plannifié si 0 produit dans projets
        $('.tbody-planning').each(function(index, el) {
            if ($(this).html().trim() == '') {
                currentTable = $(this).parents('.table')
                currentTable.parents('.tab-pane').append('Aucun projet plannifié');
                currentTable.remove();
            }
        });
        </script>
    </div>
</div>