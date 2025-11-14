<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EvenementBriefsFixture
 *
 */
class EvenementBriefsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'evenement_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'adresse_exact' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'batiment' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'num_voie' => ['type' => 'string', 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'code_postal' => ['type' => 'string', 'length' => 15, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'rue' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'acces' => ['type' => 'smallinteger', 'length' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'acces_modalite' => ['type' => 'smallinteger', 'length' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'contact_sp' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Contact sur place', 'precision' => null, 'fixed' => null],
        'nom_sp' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Nom du contact sur place', 'precision' => null, 'fixed' => null],
        'prenom_sp' => ['type' => 'integer', 'length' => 100, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'nb_personnes' => ['type' => 'integer', 'length' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Nombre de personnes évènements', 'precision' => null, 'autoIncrement' => null],
        'horaire_debut' => ['type' => 'string', 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Début de l\'évènement', 'precision' => null, 'fixed' => null],
        'horaire_fin' => ['type' => 'integer', 'length' => 8, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Fin de l\'évènement', 'precision' => null, 'autoIncrement' => null],
        'date_installation' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'date_desinstallation' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'disposition_borne' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'distance_borne_prise' => ['type' => 'integer', 'length' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'date_retrait_ant_locale' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'date_retour_antenne_locale' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'mail_nom_wifi' => ['type' => 'string', 'length' => 120, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'mail_code_wifi' => ['type' => 'string', 'length' => 120, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'mail_expediteur' => ['type' => 'string', 'length' => 120, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'mail_objet' => ['type' => 'string', 'length' => 120, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'mail_message' => ['type' => 'text', 'length' => 4294967295.0, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'form_check' => ['type' => 'tinyinteger', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'Si le client souhaite obtenir les coordonnées', 'precision' => null],
        'form_text' => ['type' => 'text', 'length' => 4294967295.0, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Formulaire de saisie pour le client', 'precision' => null],
        'fb_nom_page' => ['type' => 'string', 'length' => 120, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'fb_titre_album' => ['type' => 'string', 'length' => 120, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'fb_description_album' => ['type' => 'text', 'length' => 4294967295.0, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'fb_admin' => ['type' => 'string', 'length' => 120, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'animation_horaire' => ['type' => 'string', 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'animation_tenue_souhaitée' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'animation_objectifs' => ['type' => 'text', 'length' => 4294967295.0, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'derniere_etape' => ['type' => 'smallinteger', 'length' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'dérnière etape faite par l\'utilisateur', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
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
                'evenement_id' => 1,
                'adresse_exact' => 'Lorem ipsum dolor sit amet',
                'batiment' => 'Lorem ipsum dolor sit amet',
                'num_voie' => 'Lorem ',
                'code_postal' => 'Lorem ipsum d',
                'rue' => 'Lorem ipsum dolor sit amet',
                'acces' => 1,
                'acces_modalite' => 1,
                'contact_sp' => 'Lorem ipsum dolor ',
                'nom_sp' => 'Lorem ipsum dolor sit amet',
                'prenom_sp' => 1,
                'nb_personnes' => 1,
                'horaire_debut' => 'Lorem ',
                'horaire_fin' => 1,
                'date_installation' => '2019-01-25 12:52:15',
                'date_desinstallation' => '2019-01-25 12:52:15',
                'disposition_borne' => 'Lorem ipsum dolor ',
                'distance_borne_prise' => 1,
                'date_retrait_ant_locale' => '2019-01-25 12:52:15',
                'date_retour_antenne_locale' => '2019-01-25 12:52:15',
                'mail_nom_wifi' => 'Lorem ipsum dolor sit amet',
                'mail_code_wifi' => 'Lorem ipsum dolor sit amet',
                'mail_expediteur' => 'Lorem ipsum dolor sit amet',
                'mail_objet' => 'Lorem ipsum dolor sit amet',
                'mail_message' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'form_check' => 1,
                'form_text' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'fb_nom_page' => 'Lorem ipsum dolor sit amet',
                'fb_titre_album' => 'Lorem ipsum dolor sit amet',
                'fb_description_album' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'fb_admin' => 'Lorem ipsum dolor sit amet',
                'animation_horaire' => 'Lorem ',
                'animation_tenue_souhaitée' => 'Lorem ipsum dolor sit amet',
                'animation_objectifs' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'derniere_etape' => 1,
                'created' => '2019-01-25 12:52:15',
                'modified' => '2019-01-25 12:52:15'
            ],
        ];
        parent::init();
    }
}
