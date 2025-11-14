<div class="activity-block">

    <?php //echo $this->Html->image('pipeline/avatar-female-1.jpg', ["alt" => "Claire", "class" => "avatar"]); ?>

    <div class="right-section">

        <div class="top-description">
            <span class="name"><?= !empty($opportuniteTimeline->user->full_name) ?  $opportuniteTimeline->user->full_name : 'Auto' ?></span> <?= $opportuniteTimeline->opportunite_action->phrase ?>
                <a href="#">
                    <?php 
                    if($opportuniteTimeline->opportunite_action_id == 1 ||$opportuniteTimeline->opportunite_action_id == 3){
                        //debug($opportuniteTimeline);
                        echo $opportuniteTimeline->pipeline_etape->nom;
                    }else if($opportuniteTimeline->opportunite_action_id == 9){
                        //debug($opportuniteTimeline);
                        echo $opportuniteTimeline->opportunite_statut->nom;
                    } 
                    ?>
                </a>
        </div>

        <div class="bottom-description">
            <?= $opportuniteTimeline->ilya ?>
        </div>

    </div>

</div>