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
                                        <h1 style="color: #ff0054;font-size: 22px;font-weight: 800;Margin: 0 0 23px 0;"> <?= $title ?></h1>
                                        <p class="bold label-title" style="font-size:13.4px;Margin:0;font-size:13.5px;font-weight:600;">
                                            Détail de la réservation
                                        </p>
                                    </div>
                                    <table class="inner-detail-wrapper" style="width:100%;border-spacing:0;background-color:#f6f4f5;border-radius:4px;">
                                        <tr>
                                            <td style="padding:0;">
                                                <table class="table-section" style="width:100%;border-spacing:0;">
                                                    <tr>
                                                        <td class="outer-content-wrapper" style="padding:0;padding:35px 22px 20px 22px;">
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
                                                                                                    Référence : 
                                                                                                </p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <table class="column" style="width:100%;border-spacing:0;max-width:300px;display:inline-block;vertical-align:top;font-size:15px;line-height:20px;">
                                                                            <tr>
                                                                                <td style="padding:0;">
                                                                                    <table class="content" style="width:100%;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td style="padding:0;">
                                                                                                <p class="larger-text extra-bold" style="font-size:13.4px;Margin:0;font-size:15px;font-weight:900;">
                                                                                                    <?= $devisEntity->reglement['reference'] ?>
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
                                                                                                    Montant total :</p>
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
                                                                                                <p class="larger-text extra-bold inner-detail-content amount" style="font-size:13.4px;Margin:0;word-spacing:-1.5px;font-size:15px;font-weight:900;Margin-bottom:15px;">
                                                                                                    <?= $this->Number->currency($devisEntity->get('total_ttc'), 'EUR'); ?> TTC
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
                                                                                                    Total réglé :</p>
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
                                                                                                <p class="inner-detail-content" style="font-size:13.4px;Margin:0;Margin-bottom:15px;">
                                                                                                    <span class="larger-text extra-bold amount" style="word-spacing:-1.5px;font-size:15px;font-weight:900;"><?= $this->Number->currency($devisEntity->reglement['montant'], 'EUR'); ?></span>&nbsp;
                                                                                                    <span class="bold" style="font-weight:600;">(paiement CB reçu le <?= $reglementEntity->created->addHours(2)->format("d/m/Y à H\\hi") ?>)</span>
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
                                                                                                    Restant dû :</p>
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
                                                                                                <p class="larger-text extra-bold amount" style="font-size:13.4px;Margin:0;word-spacing:-1.5px;font-size:15px;font-weight:900;">
                                                                                                    <?= $this->Number->currency($reglementEntity->montant_restant, 'EUR'); ?></p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td style="padding:0;">
                                                                        <table style="width:100%;border-spacing:0;">
                                                                            <tr>
                                                                                <td style="padding:0;text-align: center;padding-top: 30px;">
                                                                                    <p style="font-size:13.4px;Margin:0;">
                                                                                        <span class="bold" style="font-weight:600;"></span>&nbsp;<a href="<?= $this->Url->build($devisEntity->get('EncryptedUrl'), true) ?>" class="link bold" style="font-weight:600;color:#f95184;text-decoration:underline;">Voir la page de la réservation</a>.
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
                                        <tr>
                                            <td style="padding:0;">
                                                <table class="table-section" style="width:100%;border-spacing:0;">
                                                    <tr>
                                                        <td class="outer-content-wrapper" style="padding:0;padding:35px 22px 20px 22px;">
                                                            <table style="width:100%;border-spacing:0;">
                                                                <tr>
                                                                    <td class="two-columns last-section-wrapper" style="padding:0;font-size:0;padding-bottom:25px !important;">
                                                                        <table class="column left-column" style="width:100%;border-spacing:0;width:256px;max-width:300px;display:inline-block;vertical-align:top;font-size:15px;line-height:20px;">
                                                                            <tr>
                                                                                <td class="inner-padding" style="padding:0;padding-bottom:5px;">
                                                                                    <table class="content" style="width:100%;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td class="left-content" style="padding:0;width:235px;text-align:right;">
                                                                                                <p class="bold label-title mobile-recap-label" style="font-size:13.4px;Margin:0;font-size:13.5px;font-weight:600;">
                                                                                                    Récapitulatif :</p>
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
                                                                                                <p class="bold inner-detail-content" style="font-size:13.4px;Margin:0;font-weight:600;Margin-bottom:15px;">
                                                                                                    Location borne photo <?= $devisEntity->get('BorneTypeAsText') ?>
                                                                                                </p>
                                                                                                <p class="bold inner-detail-content" style="font-size:13.4px;Margin:0;font-weight:600;Margin-bottom:15px;">
                                                                                                    Contact réservation : <?= $devisEntity->client->get('FullName2') ?>
                                                                                                </p>
                                                                                                <p class="bold inner-detail-content" style="font-size:13.4px;Margin:0;font-weight:600;Margin-bottom:15px;">
                                                                                                    <?php if ($devisEntity->date_evenement != null && $devisEntity->date_evenement_fin != null): ?>
                                                                                                        Date :  <?= $devisEntity->date_evenement != null ? 'du '.$devisEntity->date_evenement->format('d/m/Y') : '' ?> <?= $devisEntity->date_evenement_fin != null ? 'au '.$devisEntity->date_evenement_fin : '' ?>
                                                                                                    <?php endif ?>
                                                                                                </p>
                                                                                                <p class="bold inner-detail-content" style="font-size:13.4px;Margin:0;font-weight:600;Margin-bottom:15px;">
                                                                                                    <?php if (!empty($devisEntity->get('LieuRetraitFormated'))): ?>
                                                                                                        Lieu de retrait : <?= $devisEntity->get('LieuRetraitFormated') ?>
                                                                                                    <?php endif ?>
                                                                                                </p>
                                                                                                <p class="bold" style="font-size:13.4px;Margin:0;font-weight:600;">
                                                                                                    Date de réservation : <?= $reglementEntity->created->format("d/m/Y") ?>
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
                                        <tr>
                                            <td style="padding:0;">
                                                <table class="table-section" style="width:100%;border-spacing:0;">
                                                    <tr>
                                                        <td class="outer-content-wrapper" style="padding:0;padding:35px 22px 20px 22px;border-top: 1px solid #eceaeb;">
                                                            <table style="width:100%;border-spacing:0;">
                                                                <tr>
                                                                    <td class="two-columns last-section-wrapper" style="padding:0;font-size:0;padding-bottom:25px !important;">
                                                                        <table class="column left-column" style="width:100%;border-spacing:0;width:256px;max-width:300px;display:inline-block;vertical-align:top;font-size:15px;line-height:20px;">
                                                                            <tr>
                                                                                <td class="inner-padding" style="padding:0;padding-bottom:5px;">
                                                                                    <table class="content" style="width:100%;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td class="left-content" style="padding:0;width:235px;text-align:right;">
                                                                                                <p class="bold label-title mobile-recap-label" style="font-size:13.4px;Margin:0;font-size:13.5px;font-weight:600;">
                                                                                                    Informations du client :</p>
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
                                                                                                <p class="bold inner-detail-content" style="font-size:13.4px;Margin:0;font-weight:600;Margin-bottom:15px;">
                                                                                                    <?= $devisEntity->client_nom ?>
                                                                                                </p>
                                                                                                <p class="bold inner-detail-content" style="font-size:13.4px;Margin:0;font-weight:600;Margin-bottom:15px;">
                                                                                                    <?= $devisEntity->client_adresse ?>
                                                                                                </p>
                                                                                                <p class="bold inner-detail-content" style="font-size:13.4px;Margin:0;font-weight:600;Margin-bottom:15px;">
                                                                                                    <?= $devisEntity->client_cp ?> <?= $devisEntity->client_ville ?>
                                                                                                </p>
                                                                                                <p class="bold inner-detail-content" style="font-size:13.4px;Margin:0;font-weight:600;Margin-bottom:15px;">
                                                                                                    <?= $devisEntity->client_country ?>
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
        <div class="footer" style="margin-top: 30px;">
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
