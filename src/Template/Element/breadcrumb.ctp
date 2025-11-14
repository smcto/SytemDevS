<h3 class="text-themecolor m-b-0 m-t-0"><?= $titrePage ?></h3>
<?php 
    $this->Breadcrumbs->setTemplates([
        'wrapper' => '<ul{{attrs}}>{{content}}</ul>',
        'item' => '<li class="breadcrumb-item"><a href="{{url}}"{{innerAttrs}}>{{title}}</a></li>',
        'itemWithoutLink' => '<li class="breadcrumb-item active" >{{title}}</li>',
        'separator' => null
    ]);

    echo $this->Breadcrumbs->render(
        ['class' => 'breadcrumb']
    );

?>