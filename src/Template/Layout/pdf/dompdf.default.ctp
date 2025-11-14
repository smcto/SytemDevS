<!DOCTYPE html>
<html>
    <head>
       
        <?= $this->fetch('head') ?>
        <style><?= $this->fetch('style') ?></style>
        <?= $this->Html->meta(array('charset'=>'utf-8')) ?>
    </head>
    <body>
        
        <header><?= $this->fetch('header') ?></header>
        <footer><?= $this->fetch('footer') ?></footer>

        <?= $this->fetch('content') ?>
        
    </body>
</html>