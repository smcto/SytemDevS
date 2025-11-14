<?php $requestScheme = $this->request->getEnv('REQUEST_SCHEME')?>
<?php $httpHost = $this->request->getEnv('HTTP_HOST')?>
<?php $host = $requestScheme.'://'.$httpHost ?>

<?php $link = $host .''. $this->Url->build(['controller' => 'Ventes', 'action' => 'view', $venteEntity->id]); ?>
<?php $this->start('old') ?>
    <?php /*debug($venteEntity);*/ ?>
    Bonjour,
    <p>Une fiche de vente a été créee depuis le CRM. Veuillez vous connecter et aller sur <a href="<?= $host .''. $this->Url->build(['controller' => 'Ventes', 'action' => 'view', $venteEntity->id]) ?>">ce lien</a> pour pouvoir accéder à la fiche de vente</p>
    <p>Client : <?= $venteEntity->client->nom ?></p>
    <p>Commercial : <?= $venteEntity->user->get('FullName') ?></p>
    <p>Type de contrat : <?= $venteEntity->parc->nom ?? '' ?></p>
    <p>Type de borne : <?= $venteEntity->gamme_borne->name ?? '' ?> / <?= $venteEntity->model_borne->nom ?? '' ?></p>
    <p>Livraison : <?= $venteEntity->livraison_date ? $venteEntity->livraison_date->format('d/m/Y') : '' ?></p>
<?php $this->end() ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $this->Html->css(['devis/email/reglement.css'], ['fullBase' => true]); ?>
</head>
<body style="Margin:0;padding:0;background-color:#f6fafd;">
    <center class="wrapper" style="width:100%;table-layout:fixed;padding:30px 0;background-color:#f6fafd;">
        <div class="outer-webkit" style="max-width:800px;padding-bottom:30px;">
            <table class="table-outer-webkit" align="center" style="border-spacing:0;Margin:0 auto;width:100%;max-width:800px;font-size:0;line-height:0;">
                <tr>
                    <td style="padding:0;text-align: center;">
                        <a href="http://selfizee.fr/">
                            <img src="https://www.selfizee.fr/email-images/email-selfizee-logo_cropped.jpg" alt="logo" width="135" style="border:0;" /></a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="webkit" style="max-width:800px;padding:35px 53px 55px 53px;background-color:#ffffff;border-radius:6px;">
            <table class="outer" align="center" style="border-spacing:0;Margin:0 auto;width:100%;max-width:800px;font-family:Arial, Helvetica, sans-serif;color:#000000;">
                <tr>
                    <td style="padding:0;">
                        <table style="width:100%;border-spacing:0;">
                            <tr>
                                <td style="padding:0;">
                                    <div style="text-align: center; Margin-bottom: 45px;">
                                        <h1 style="color: #ff0054;font-size: 22px;font-weight: 800;Margin: 0 0 23px 0;">
                                            Nouvelle acquisition de borne</h1>
                                        <p class="bold label-title" style="font-size:13.4px;Margin:0;font-size:13.5px;font-weight:600;">
                                            Veuillez trouver ci-dessous les détails de la fiche de vente :</p>
                                    </div>
                                    <table class="inner-detail-wrapper" style="width:100%;border-spacing:0;background-color:#f6f4f5;border-radius:4px;">
                                        <tr>
                                            <td style="padding:0;">
                                                <table class="table-section" style="width:100%;border-spacing:0;">
                                                    <tr>
                                                        <td class="outer-content-wrapper middle-section-wrapper" style="padding:0;border-top:1px solid #eceaeb;border-bottom:1px solid #eceaeb;padding:35px 22px 20px 22px;padding-bottom:39px !important;">
                                                            <table style="width:100%;border-spacing:0;">
                                                                <tr>
                                                                    <td class="two-columns" style="padding:0;font-size:0;">
                                                                        <table class="column left-column" style="width:100%;border-spacing:0;width:256px;max-width:300px;display:inline-block;vertical-align:top;font-size:15px;line-height:20px;">
                                                                            <tr>
                                                                                <td class="inner-padding" style="padding:0;padding-bottom:5px;">
                                                                                    <table class="content" style="width:100%;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td class="left-content" style="padding:0;width:235px;text-align:right;">
                                                                                                <p class="bold label-title" style="font-size:13.4px;Margin:0;font-size:13.5px;font-weight:600;">
                                                                                                    Référence :</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <table class="column" style="width:100%;border-spacing:0;max-width:300px;display:inline-block;vertical-align:top;font-size:15px;line-height:20px;">
                                                                            <tr>
                                                                                <td class="inner-padding" style="padding:0;padding-bottom:5px;">
                                                                                    <table class="content" style="width:100%;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td style="padding:0;">
                                                                                                <p class="larger-text extra-bold inner-detail-content amount" style="font-size:13.4px;Margin:0;word-spacing:-1.5px;font-size:15px;Margin-bottom:15px;">
                                                                                                    <?= $venteEntity->id ?>
                                                                                                </p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="two-columns" style="padding:0;font-size:0;">
                                                                        <table class="column left-column" style="width:100%;border-spacing:0;width:256px;max-width:300px;display:inline-block;vertical-align:top;font-size:15px;line-height:20px;">
                                                                            <tr>
                                                                                <td class="inner-padding" style="padding:0;padding-bottom:5px;">
                                                                                    <table class="content" style="width:100%;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td class="left-content" style="padding:0;width:235px;text-align:right;">
                                                                                                <p class="bold label-title" style="font-size:13.4px;Margin:0;font-size:13.5px;font-weight:600;">
                                                                                                    Commercial :</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <table class="column" style="width:100%;border-spacing:0;max-width:300px;display:inline-block;vertical-align:top;font-size:15px;line-height:20px;">
                                                                            <tr>
                                                                                <td class="inner-padding" style="padding:0;padding-bottom:5px;">
                                                                                    <table class="content" style="width:100%;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td style="padding:0;">
                                                                                                <p class="larger-text extra-bold inner-detail-content amount" style="font-size:13.4px;Margin:0;word-spacing:-1.5px;font-size:15px;Margin-bottom:15px;">
                                                                                                    <?= $venteEntity->user->get('FullName') ?>
                                                                                                </p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="two-columns" style="padding:0;font-size:0;border-bottom: 1px solid #ddd;">
                                                                        <table class="column left-column" style="width:100%;border-spacing:0;width:256px;max-width:300px;display:inline-block;vertical-align:top;font-size:15px;line-height:20px;">
                                                                            <tr>
                                                                                <td class="inner-padding" style="padding:0;padding-bottom:5px;">
                                                                                    <table class="content" style="width:100%;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td class="left-content" style="padding:0;width:235px;text-align:right;">
                                                                                                <p class="bold label-title" style="font-size:13.4px;Margin:0;font-size:13.5px;font-weight:600;">
                                                                                                    Voir la commande :</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <table class="column" style="width:100%;border-spacing:0;max-width:360px;display:inline-block;vertical-align:top;font-size:15px;line-height:20px;">
                                                                            <tr>
                                                                                <td class="inner-padding" style="padding:0;padding-bottom:5px;">
                                                                                    <table class="content" style="width:100%;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td style="padding:0;">
                                                                                                <p class="larger-text extra-bold inner-detail-content amount" style="font-size:13.4px;Margin:0;word-spacing:-1.5px;font-size:15px;Margin-bottom:15px;">
                                                                                                    <a href="<?= $link ?>"><?= $link ?></a>
                                                                                                </p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="two-columns" style="padding:0;font-size:0;padding:20px 0 0 0;">
                                                                        <table class="column left-column" style="width:100%;border-spacing:0;width:256px;max-width:300px;display:inline-block;vertical-align:top;font-size:15px;line-height:20px;">
                                                                            <tr>
                                                                                <td class="inner-padding" style="padding:0;padding-bottom:5px;">
                                                                                    <table class="content" style="width:100%;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td class="left-content" style="padding:0;width:235px;text-align:right;">
                                                                                                <p class="bold label-title" style="font-size:13.4px;Margin:0;font-size:13.5px;font-weight:600;">
                                                                                                    Type de borne :</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <table class="column" style="width:100%;border-spacing:0;max-width:300px;display:inline-block;vertical-align:top;font-size:15px;line-height:20px;">
                                                                            <tr>
                                                                                <td class="inner-padding" style="padding:0;padding-bottom:5px;">
                                                                                    <table class="content" style="width:100%;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td style="padding:0;">
                                                                                                <p class="larger-text extra-bold inner-detail-content amount" style="font-size:13.4px;Margin:0;word-spacing:-1.5px;font-size:15px;Margin-bottom:15px;">
                                                                                                    <?= $venteEntity->gamme_borne->name ?? '' ?> <?= $venteEntity->model_borne ? ' / '.$venteEntity->model_borne->nom : '' ?> &nbsp;
                                                                                                </p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="two-columns" style="padding:0;font-size:0;border-bottom: 1px solid #ddd;">
                                                                        <table class="column left-column" style="width:100%;border-spacing:0;width:256px;max-width:300px;display:inline-block;vertical-align:top;font-size:15px;line-height:20px;">
                                                                            <tr>
                                                                                <td class="inner-padding" style="padding:0;padding-bottom:5px;">
                                                                                    <table class="content" style="width:100%;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td class="left-content" style="padding:0;width:235px;text-align:right;">
                                                                                                <p class="bold label-title" style="font-size:13.4px;Margin:0;font-size:13.5px;font-weight:600;">
                                                                                                    Type d’acquisition :</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <table class="column" style="width:100%;border-spacing:0;max-width:300px;display:inline-block;vertical-align:top;font-size:15px;line-height:20px;">
                                                                            <tr>
                                                                                <td class="inner-padding" style="padding:0;padding-bottom:5px;">
                                                                                    <table class="content" style="width:100%;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td style="padding:0;">
                                                                                                <p class="larger-text extra-bold inner-detail-content amount" style="font-size:13.4px;Margin:0;word-spacing:-1.5px;font-size:15px;Margin-bottom:15px;">
                                                                                                    <?= $venteEntity->parc->abreviation ?>
                                                                                                    <?php if ($venteEntity->parc_id == 4 && $venteEntity->parc_duree_id): /*LocFi on affiche la durée*/ ?>
                                                                                                        <?= $venteEntity->parc_duree->valeur ?>
                                                                                                    <?php endif ?>
                                                                                                </p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="two-columns" style="padding:0;font-size:0;padding:20px 0 0 0;">
                                                                        <table class="column left-column" style="width:100%;border-spacing:0;width:256px;max-width:300px;display:inline-block;vertical-align:top;font-size:15px;line-height:20px;">
                                                                            <tr>
                                                                                <td class="inner-padding" style="padding:0;padding-bottom:5px;">
                                                                                    <table class="content" style="width:100%;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td class="left-content" style="padding:0;width:235px;text-align:right;">
                                                                                                <p class="bold label-title" style="font-size:13.4px;Margin:0;font-size:13.5px;font-weight:600;">
                                                                                                    Client :</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <table class="column" style="width:100%;border-spacing:0;max-width:300px;display:inline-block;vertical-align:top;font-size:15px;line-height:20px;">
                                                                            <tr>
                                                                                <td class="inner-padding" style="padding:0;padding-bottom:5px;">
                                                                                    <table class="content" style="width:100%;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td style="padding:0;">
                                                                                                <p class="larger-text extra-bold inner-detail-content amount" style="font-size:13.4px;Margin:0;word-spacing:-1.5px;font-size:15px;Margin-bottom:15px;">
                                                                                                    <?= ($venteEntity->client ? (!empty($venteEntity->client->enseigne) ? $venteEntity->client->enseigne : $venteEntity->client->nom) : "") ?>
                                                                                                </p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="two-columns" style="padding:0;font-size:0;">
                                                                        <table class="column left-column" style="width:100%;border-spacing:0;width:256px;max-width:300px;display:inline-block;vertical-align:top;font-size:15px;line-height:20px;">
                                                                            <tr>
                                                                                <td class="inner-padding" style="padding:0;padding-bottom:5px;">
                                                                                    <table class="content" style="width:100%;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td class="left-content" style="padding:0;width:235px;text-align:right;">
                                                                                                <p class="bold label-title" style="font-size:13.4px;Margin:0;font-size:13.5px;font-weight:600;">
                                                                                                    Adresse :</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <table class="column" style="width:100%;border-spacing:0;max-width:300px;display:inline-block;vertical-align:top;font-size:15px;line-height:20px;">
                                                                            <tr>
                                                                                <td class="inner-padding" style="padding:0;padding-bottom:5px;">
                                                                                    <table class="content" style="width:100%;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td style="padding:0;">
                                                                                                <p class="larger-text extra-bold inner-detail-content amount" style="font-size:13.4px;Margin:0;word-spacing:-1.5px;font-size:15px;Margin-bottom:15px;">
                                                                                                    <?= $venteEntity->client->adresse ? $venteEntity->client->adresse. '<br/>' : ''?>
                                                                                                    <?= $venteEntity->client->cp ? $venteEntity->client->cp. '<br/>' : ''?>
                                                                                                    <?= $venteEntity->client->ville ? $venteEntity->client->ville. '<br/>' : ''?>
                                                                                                    <?= $venteEntity->client->pays ? $venteEntity->client->pays->nicename : '' ?>
                                                                                                </p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>


                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer" style="padding: 50px 0;">
            <table class="outer" align="center" style="border-spacing:0;Margin:0 auto;width:100%;max-width:800px;font-family:Arial, Helvetica, sans-serif;color:#000000;">
                <tr>
                    <td align="center" style="padding:0;">
                        <p class="footer-text" style="font-size:13.4px;Margin:0;font-size:10.49px;">
                            <span class="bold" style="font-weight:600;">Selfizee est une marque de la SAS Konitys au capital de 100 000€. </span>&nbsp;<a href="https://www.selfizee.fr" class="link bold" style="font-weight:600;color:#f95184;text-decoration:underline;text-decoration:none;">Voir le site internet</a>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </center>
</body>

</html>