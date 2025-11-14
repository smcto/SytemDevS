<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OpportunitesFixture
 *
 */
class OpportunitesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'id_in_sellsy' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'numero' => ['type' => 'string', 'length' => 250, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'nom' => ['type' => 'string', 'length' => 500, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'opportunite_statut_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'montant_potentiel' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'date_echeance' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'pipeline_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pipeline_etape_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'probabilite' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'note' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'brief' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'type_client_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'source_lead_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'contact_raison_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'type_evenement_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'type_demande' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'antenne_retrait' => ['type' => 'string', 'length' => 500, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'antenne_retrait_secondaire' => ['type' => 'string', 'length' => 500, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'FK_opportunites' => ['type' => 'index', 'columns' => ['pipeline_id'], 'length' => []],
            'FK_opportunites_status' => ['type' => 'index', 'columns' => ['opportunite_statut_id'], 'length' => []],
            'FK_opportunites_etape' => ['type' => 'index', 'columns' => ['pipeline_etape_id'], 'length' => []],
            'FK_opportunites_type_client' => ['type' => 'index', 'columns' => ['type_client_id'], 'length' => []],
            'FK_opportunites_source_lead' => ['type' => 'index', 'columns' => ['source_lead_id'], 'length' => []],
            'FK_opportunites_raison' => ['type' => 'index', 'columns' => ['contact_raison_id'], 'length' => []],
            'FK_opportunites_type_evenement' => ['type' => 'index', 'columns' => ['type_evenement_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_opportunites' => ['type' => 'foreign', 'columns' => ['pipeline_id'], 'references' => ['pipelines', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'FK_opportunites_etape' => ['type' => 'foreign', 'columns' => ['pipeline_etape_id'], 'references' => ['pipeline_etapes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'FK_opportunites_raison' => ['type' => 'foreign', 'columns' => ['contact_raison_id'], 'references' => ['contact_raisons', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'FK_opportunites_source_lead' => ['type' => 'foreign', 'columns' => ['source_lead_id'], 'references' => ['source_leads', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'FK_opportunites_status' => ['type' => 'foreign', 'columns' => ['opportunite_statut_id'], 'references' => ['opportunite_statuts', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'FK_opportunites_type_client' => ['type' => 'foreign', 'columns' => ['type_client_id'], 'references' => ['type_clients', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'FK_opportunites_type_evenement' => ['type' => 'foreign', 'columns' => ['type_evenement_id'], 'references' => ['type_evenements', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'id_in_sellsy' => 1,
                'numero' => 'Lorem ipsum dolor sit amet',
                'nom' => 'Lorem ipsum dolor sit amet',
                'opportunite_statut_id' => 1,
                'montant_potentiel' => 1.5,
                'date_echeance' => '2020-07-01',
                'pipeline_id' => 1,
                'pipeline_etape_id' => 1,
                'probabilite' => 1.5,
                'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'brief' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'type_client_id' => 1,
                'source_lead_id' => 1,
                'contact_raison_id' => 1,
                'type_evenement_id' => 1,
                'type_demande' => 'Lorem ipsum dolor sit amet',
                'antenne_retrait' => 'Lorem ipsum dolor sit amet',
                'antenne_retrait_secondaire' => 'Lorem ipsum dolor sit amet',
                'created' => '2020-07-01 14:00:22',
                'modified' => '2020-07-01 14:00:22'
            ],
        ];
        parent::init();
    }
}
