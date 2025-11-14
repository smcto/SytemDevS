<table class="table">
<thead class="hide">
    <tr>
        <th><a href="#">Numéro borne</a> </th>
        <th class="hide"></th>
        <th><a href="#">Modèle (version)</a></th>
        <th><a href="#">Antenne actuelle</a></th>
        <th><a href="#">Nom</a></th>
        <th class="hide">head info</th>
        <th class="hide">adresse</th>
        <th class="hide">Latitude</th>
        <th class="hide">Longitude</th>
    </tr>
</thead>
<tbody class="hide">
<?php
$i = -1;
foreach ($bornes as $borne) {
    if ($borne->client) {
        $i++;
    ?>
    <tr >
        <td class="hide"><input  id="num_<?= $i ?>" value="<?= h($borne->numero) ?>" /></td>
        <td><input type="text" value="<?= $borne->has('model_borne') ? $borne->model_borne->gamme_borne_id : ""?>"  id="gamme_<?= $i ?>"></td>
        <td><input type="text" value="<?= $borne->parc_id != 2 ? $borne->model_borne->gammes_borne->notation : "B"?>"  id="not_<?= $i ?>"></td>

        <td class="hide"><?php echo $borne->client->nom;?></td>
        <td class="hide"><input id="name_<?= $i ?>" value="<?php echo $borne->client->nom;?>"/></td>
        <td class="hide"><input id="head_<?= $i ?>" value="<?= $borne->has('model_borne') ? $borne->numero .' - ' . $borne->model_borne->gammes_borne->name . ' ' . $borne->model_borne->nom : $borne->numero?>"/></td>
        <td class="hide"><input id="adresse_<?= $i ?>" value="<?php echo $borne->client->cp. ' ' . $borne->client->ville;?>"/></td>
        <td class="hide"><input id="link_<?= $i ?>" value="<?= $this->Url->build(['controller' => 'Bornes','action' => 'view',$borne->id]) ?>"/></td>

        <td class="hide"><input id="lat_<?= $i ?>" value="<?php
            if (!empty($borne->client->addr_lat))
                echo $borne->client->addr_lat;
            if (!empty($borne->latitude))
                echo $borne->latitude;
            ?>"/>
        </td>
        <td class="hide"><input id="lgt_<?= $i ?>" value="<?php
            if (!empty($borne->client->addr_lng)){
                echo $borne->client->addr_lng;
            }elseif (!empty($borne->longitude)){
                echo $borne->longitude;
            }
            ?>"/>
        </td>
        <td class="hide"><input id="nombre_<?= $i ?>"/></td>

        <?php } ?>
    </tr>

<?php } 
foreach ($antennes as $antenne) {
    if(count($antenne->bornes) == 0) continue;
    $borne = $antenne->bornes[0];
    $i++;
    ?>
    <tr >
        <td class="hide"><input  id="num_<?= $i ?>" value="<?= h($borne->numero) ?>" /></td>
        <td><input type="text" value="<?= $borne->has('model_borne') ? $borne->model_borne->gamme_borne_id : ""?>"  id="gamme_<?= $i ?>"></td>
        <td><input type="text" value="B"  id="not_<?= $i ?>"></td>

        <td class="hide"><?php echo $antenne->ville_principale ;?></td>
        <td class="hide"><input id="name_<?= $i ?>" value="Selfizee"/></td>
        <td class="hide"><input id="head_<?= $i ?>" value="<?= $antenne->ville_principale ?>"/></td>
        <td class="hide"><input id="adresse_<?= $i ?>" value="<?php echo $antenne->cp ." ". $antenne->ville_principale?>"/></td>
        <td class="hide"><input id="link_<?= $i ?>" value="<?= $this->Url->build(['controller' => 'Bornes','action' => strtolower('index?antenne=' . $antenne->ville_principale)]) ?>"/></td>

        <td class="hide"><input id="lat_<?= $i ?>" value="<?= $antenne->latitude; ?>"/></td>
        <td class="hide"><input id="lgt_<?= $i ?>" value="<?= $antenne->longitude; ?>"/></td>
        <td class="hide">
            <input id="nombre_<?= $i ?>" value="
                Nombre de bornes au total : <?= count($antenne->bornes) ?> 
                <br> 
                <?php foreach ($gammeBornes as $gameId => $name){ ?>
                                <?php $n = count(array_filter($antenne->bornes,function($k,$v) use($gameId) {
                                    return $k->model_borne->gamme_borne_id == $gameId;
                                },ARRAY_FILTER_USE_BOTH));
                                if($n > 0){ ?>
                                        <?= $name ?> :  <?= $n ?> ;

                <?php } } ?>
                "
            />
        </td>
    </tr>

<?php }?>

<input type="text" class="hide"  id="nbornes" value="<?= ++$i ?>"/>
</tbody>

</table>