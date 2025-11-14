<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

<?= $this->Html->css('borne.css?' . time(), ['block' => true]); ?>
<?= $this->Html->css('mapfullscreen.css?' . time(), ['block' => true]); ?>
<?= $this->Html->script('bornes/mapfullscreen.js?' . time(), ['block' => true]); ?>

<?php
    $this->assign('title', 'Carte location');
?>
<div class="mapfullscreen" id="body_borne">
    <input type="hidden" value="<?= $this->Url->build('/', true) ?>" id="base_url">
        <div id="div_map_bornes">
            
                    <div class="filter-2 mapfullscreen-filter">
                        <div class="card">
                            <div class="card-body">
                                    <div class="row">
                                        <div class="total-head">
                                            Carte location
                                            <p id="nombre">
                                                45 bornes
                                            </p>
                                        </div>
                                        <div class="checkbox-map">
                                            <?= $this->Form->control('is_agence', ['type' => 'checkbox',  'label' => 'Antennes Selfizee','id' => 'is_agence' , 'checked' => 'checked']); ?>
                                            <div class="legende-items"><?= $this->Html->image("http://maps.google.com/mapfiles/marker.png", ["alt" => "Brownies"]);?> Nombre d'antennes : <p id="nombre_b"></p></div>
                                        </div>
                                        <div class="checkbox-map">
                                            <?= $this->Form->control('sous_loc_classik', ['type' => 'checkbox',  'label' => 'Sous location Classik','id' => 'sous_loc_classik' , 'checked' => 'checked']); ?>
                                            <div class="legende-items"><?= $this->Html->image("http://maps.google.com/mapfiles/marker_green.png", ["alt" => "Brownies"]);?> Nombre de borne : <p id="nombre_c"></p></div>
                                        </div>
                                        <div class="checkbox-map">
                                            <?= $this->Form->control('sous_loc_spherik', ['type' => 'checkbox',  'label' => 'Sous location Spherik','id' => 'sous_loc_spherik' , 'checked' => 'checked']); ?>
                                            <div class="legende-items"><?= $this->Html->image("http://maps.google.com/mapfiles/marker_purple.png", ["alt" => "Brownies"]);?> Nombre de borne : <p id="nombre_s"></p></div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="search-container mapfullscreen-filter">
                          <input type="text" placeholder="Search.." name="key" id="search_text">
                          <button type="button" id="search"><i class="fa fa-search"></i></button>
                    </div>
                    
                    <div class="fullscreen-button">
                        <form>
                            <button type="button" id="fullscren" class="btn btn-success btn-rounded">Afficher en plein écran</button>
                            <input type="hidden" value="0" id="fullscren_value">
                        </form>
                    </div>
                    
            
                <div id="mapCanvas" class="mapCanvas"></div>
                <div class="kl_infoForm"></div>
        </div>

    
    <div class="hide" id="div_table_bornes">
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
                $nombre_spherik = 0;
                $nombre_classik = 0;
                $nombre_antenne = 0;
                foreach ($bornesSpherik as $borne) {
                    if ($borne->client) {
                    ?>
                    <tr >
                        <td class="hide"><input  id="s_num_<?= $nombre_spherik ?>" value="<?= h($borne->numero) ?>" /></td>
                        <td><input type="text" value="<?= $borne->has('model_borne') ? $borne->model_borne->gamme_borne_id : ""?>"  id="s_gamme_<?= $nombre_spherik ?>"></td>
                        <td><input type="text" value="<?= $borne->parc_id != 2 ? $borne->model_borne->gammes_borne->notation : "B"?>"  id="s_not_<?= $nombre_spherik ?>"></td>

                        <td class="hide"><?php echo $borne->client->nom;?></td>
                        <td class="hide"><input id="s_name_<?= $nombre_spherik ?>" value="<?php echo $borne->client->nom;?>"/></td>
                        <td class="hide"><input id="s_head_<?= $nombre_spherik ?>" value="<?= $borne->has('model_borne') ? $borne->numero .' - ' . $borne->model_borne->gammes_borne->name . ' ' . $borne->model_borne->nom : $borne->numero?>"/></td>
                        <td class="hide"><input id="s_adresse_<?= $nombre_spherik ?>" value="<?php echo $borne->client->cp. ' ' . $borne->client->ville;?>"/></td>
                        <td class="hide"><input id="s_link_<?= $nombre_spherik ?>" value="<?= $this->Url->build(['controller' => 'Bornes','action' => 'view',$borne->id]) ?>"/></td>

                        <td class="hide"><input id="s_lat_<?= $nombre_spherik ?>" value="<?php
                            if (!empty($borne->client->addr_lat))
                                echo $borne->client->addr_lat;
                            if (!empty($borne->latitude))
                                echo $borne->latitude;
                            ?>"/>
                        </td>
                        <td class="hide"><input id="s_lgt_<?= $nombre_spherik ?>" value="<?php
                            if (!empty($borne->client->addr_lng)){
                                echo $borne->client->addr_lng;
                            }elseif (!empty($borne->longitude)){
                                echo $borne->longitude;
                            }
                            ?>"/>
                        </td>
                        <td class="hide"><input id="s_nombre_<?= $nombre_spherik ?>"/></td>
                        <td class="hide"><input id="s_tot_<?= $nombre_spherik ?>" value="1"/></td>

                        <?php $nombre_spherik++; } ?>
                    </tr>

                <?php } 
                
                foreach ($bornesClassik as $borne) {
                    if ($borne->client) {
                    ?>
                    <tr >
                        <td class="hide"><input  id="c_num_<?= $nombre_classik ?>" value="<?= h($borne->numero) ?>" /></td>
                        <td><input type="text" value="<?= $borne->has('model_borne') ? $borne->model_borne->gamme_borne_id : ""?>"  id="c_gamme_<?= $nombre_classik ?>"></td>
                        <td><input type="text" value="<?= $borne->parc_id != 2 ? $borne->model_borne->gammes_borne->notation : "B"?>"  id="c_not_<?= $nombre_classik ?>"></td>

                        <td class="hide"><?php echo $borne->client->nom;?></td>
                        <td class="hide"><input id="c_name_<?= $nombre_classik ?>" value="<?php echo $borne->client->nom;?>"/></td>
                        <td class="hide"><input id="c_head_<?= $nombre_classik ?>" value="<?= $borne->has('model_borne') ? $borne->numero .' - ' . $borne->model_borne->gammes_borne->name . ' ' . $borne->model_borne->nom : $borne->numero?>"/></td>
                        <td class="hide"><input id="c_adresse_<?= $nombre_classik ?>" value="<?php echo $borne->client->cp. ' ' . $borne->client->ville;?>"/></td>
                        <td class="hide"><input id="c_link_<?= $nombre_classik ?>" value="<?= $this->Url->build(['controller' => 'Bornes','action' => 'view',$borne->id]) ?>"/></td>

                        <td class="hide"><input id="c_lat_<?= $nombre_classik ?>" value="<?php
                            if (!empty($borne->client->addr_lat))
                                echo $borne->client->addr_lat;
                            if (!empty($borne->latitude))
                                echo $borne->latitude;
                            ?>"/>
                        </td>
                        <td class="hide"><input id="c_lgt_<?= $nombre_classik ?>" value="<?php
                            if (!empty($borne->client->addr_lng)){
                                echo $borne->client->addr_lng;
                            }elseif (!empty($borne->longitude)){
                                echo $borne->longitude;
                            }
                            ?>"/>
                        </td>
                        <td class="hide"><input id="c_nombre_<?= $nombre_classik ?>"/></td>
                        <td class="hide"><input id="c_tot_<?= $nombre_classik ?>" value="1"/></td>

                        <?php $nombre_classik++; } ?>
                    </tr>

                <?php } 
                foreach ($antennes as $antenne) {
                    if(count($antenne->bornes) == 0) continue;
                    $borne = $antenne->bornes[0];
                    ?>
                    <tr >
                        <td class="hide"><input  id="a_num_<?= $nombre_antenne ?>" value="<?= h($borne->numero) ?>" /></td>
                        <td><input type="text" value="<?= $borne->has('model_borne') ? $borne->model_borne->gamme_borne_id : ""?>"  id="a_gamme_<?= $nombre_antenne ?>"></td>
                        <td><input type="text" value="B"  id="a_not_<?= $nombre_antenne ?>"></td>

                        <td class="hide"><?php echo $antenne->ville_principale ;?></td>
                        <td class="hide"><input id="a_name_<?= $nombre_antenne ?>" value="Selfizee"/></td>
                        <td class="hide"><input id="a_head_<?= $nombre_antenne ?>" value="<?= count($antenne->bornes) == 1?$borne->has('model_borne') ? "#".$borne->numero .' - ' . $borne->model_borne->gammes_borne->name . ' ' . $borne->model_borne->nom : "#".$borne->numero:$antenne->ville_principale ?>"/></td>
                        <td class="hide"><input id="a_adresse_<?= $nombre_antenne ?>" value="<?php echo $antenne->cp ." ". $antenne->ville_principale?>"/></td>
                        <td class="hide"><input id="a_link_<?= $nombre_antenne ?>" value="<?= count($antenne->bornes) > 1 ? $this->Url->build(['controller' => 'Bornes','action' => strtolower('index?antenne=' . $antenne->ville_principale)]):$this->Url->build(['controller' => 'Bornes','action' => 'view',$borne->id]) ?>"/></td>

                        <td class="hide"><input id="a_lat_<?= $nombre_antenne ?>" value="<?= $antenne->latitude; ?>"/></td>
                        <td class="hide"><input id="a_lgt_<?= $nombre_antenne ?>" value="<?= $antenne->longitude; ?>"/></td>
                        <td class="hide">
                            <input id="a_nombre_<?= $nombre_antenne ?>" value=" 
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
                        <td class="hide"><input id="a_tot_<?= $nombre_antenne ?>" value="<?= count($antenne->bornes) ?>"/></td>
                    </tr>

                <?php $nombre_antenne++ ; }?>
                    
                <input type="text" class="hide"  id="nbornes_antenne" value="<?= $nombre_antenne ?>"/>
                <input type="text" class="hide"  id="nbornes_classik" value="<?= $nombre_antenne ?>"/>
                <input type="text" class="hide"  id="nbornes_spherik" value="<?= $nombre_antenne ?>"/>
                </tbody>

            </table>
        </div>
    
</div>
