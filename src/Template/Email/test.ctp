<div class="card">
    <div class="card-body">
        <?= $this->Text->autoParagraph($email['headers']); ?>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <?= $email['message'] ?>
    </div>
</div>
