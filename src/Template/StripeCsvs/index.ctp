<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StripeCsv[]|\Cake\Collection\CollectionInterface $stripeCsvs
 */
?>
<?php
$titrePage = "Fichiers importés" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
'Tableau de bord',
['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <?php echo $filename ;?>
                </div>
            </div>
        </div>
    </div>

</div>


