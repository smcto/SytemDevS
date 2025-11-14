<div class="comment-wrap">

    <div class="comment-header">

        <div class="toggle-option-block">
            <i class="material-icons">more_vert</i>
        </div>

        <div class="right-section">

            <div class="popup-comment-title">
                <?= $commentaire->user->full_name ?>
            </div>

            <div class="popup-comment-date"><?= $commentaire->ilya ?></div>

        </div>

    </div>

    <div class="comment-content"><?= $commentaire->commentaire ?></div>

</div>