<!--<section id="wrapper">
    <div class="login-register" style="background-image:url('http://localhost/crm-selfizee/img/background/login-register.jpg');">        
        <div class="login-box card">
        <div class="card-body">
            <?= $this->Form->create(null, ["class"=>"form-horizontal form-material", "id"=>"loginform"]) ?>
                <h3 class="box-title m-b-20"><?= __('Sign In') ?></h3>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <?= $this->Form->control('email',["label"=>false,"class"=>"form-control", "required"=>true, "placeholder"=>__('E-mail') ]) ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                       <?= $this->Form->control('password',["label"=>false,"class"=>"form-control", "required"=>true, "placeholder"=>__('Password') ]) ?>
                    </div>
                </div>
              
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <?= $this->Form->button('Connexion',["class"=>"btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light"]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                        <div class="social">
                            <?php 
                            $link =  $this->Html->link('<i class="flag-icon flag-icon-us"></i> English',['lang' => 'en'], ['escapeTitle'=> false]); 
                            $code = 'fr';
                            if($this->request->getParam('lang') == 'fr'){
                                $code = 'fr';
                                $link =  $this->Html->link('<i class="flag-icon flag-icon-us"></i> English',['lang'=>'en'], ['escapeTitle'=> false,'class'=>'dropdown-item']); 
                                
                            }else if($this->request->getParam('lang') == 'en'){
                               $code = 'us';
                                $link =  $this->Html->link('<i class="flag-icon flag-icon-fr"></i> Français',['lang' => 'fr'], ['escapeTitle'=> false,'class'=>'dropdown-item']); 
                            }
                        ?>
                            <?= $this->Html->link('<i class="flag-icon flag-icon-us"></i> English',['lang' => 'en'], ['escapeTitle'=> false,"class"=>"btn", "data-toggle"=>"tooltip", "title"=>"English"]); ?>
                            <?= $this->Html->link('<i class="flag-icon flag-icon-fr"></i> Français',['lang' => 'fr'], ['escapeTitle'=> false,"class"=>"btn", "data-toggle"=>"tooltip", "title"=>"Français"]); ?>
                            
                        </div>
                    </div>
                </div>
              
            <?= $this->Form->end() ?>
            
        </div>
      </div>
    </div>
    
</section>-->




<section class="login-wrapper">
    
    <?= $this->Form->create(null, ["class"=>"inner-login-wrapper", "id"=>"loginform"]) ?>
    
        <div class="logo-wrapper">
            <?php echo $this->Html->image('Konitys-LOGO.png', ['alt' => 'Logo']); ?>
        </div>

        <div class="login-detail-wrapper">
            <?= $this->Flash->render() ?>

            <div class="top-label">
                Identification
            </div>

            <div class="data-wrapper">

                <div class="inner-data-wrapper username-data-wrapper">
                    <input type="email" name="email" placeholder="E-mail" />
                </div>
                <div class="inner-data-wrapper password-data-wrapper">
                    <input type="password" name="password" placeholder="Mot de passe" />
                    <i class="fas fa-eye password-text-indicator display"></i>
                    <i class="fas fa-eye-slash password-text-indicator"></i>
                </div>

            </div>

            <div class="bottom-detail-wrapper">
                <div class="forgotten-password">
                    Mot de passe oublié ?
                </div>
                <button type="submit" class="login-button">
                    <div class="text">Se connecter</div>
                    <div class="login-icon">
                        <svg viewBox="0 0 512 512"><path d="M490.667 0h-384C94.885 0 85.333 9.551 85.333 21.333v149.333c0 11.782 9.551 21.333 21.333 21.333 11.782 0 21.333-9.551 21.333-21.333v-128h341.333v426.667H128v-128c0-11.782-9.551-21.333-21.333-21.333-11.782 0-21.333 9.551-21.333 21.333v149.333c0 11.782 9.551 21.333 21.333 21.333h384c11.782 0 21.333-9.551 21.333-21.333V21.333C512 9.551 502.449 0 490.667 0z"/><path d="M198.248 326.251c-8.331 8.331-8.331 21.839 0 30.17 8.331 8.331 21.839 8.331 30.17 0l85.333-85.333.01-.011c.493-.494.96-1.012 1.403-1.552.203-.247.379-.507.569-.761.227-.303.462-.6.673-.916.203-.304.379-.619.565-.931.171-.286.35-.565.508-.859.17-.318.314-.644.467-.969.145-.307.298-.609.429-.923.13-.315.236-.637.35-.957.121-.337.25-.669.354-1.013.097-.32.168-.646.249-.969.089-.351.187-.698.258-1.055.074-.375.119-.753.173-1.13.044-.311.104-.617.135-.933.138-1.4.138-2.811 0-4.211-.031-.315-.09-.621-.135-.933-.054-.377-.098-.756-.173-1.13-.071-.358-.169-.704-.258-1.055-.081-.324-.152-.649-.249-.969-.104-.344-.233-.677-.354-1.013-.115-.32-.22-.642-.35-.957-.13-.315-.284-.616-.429-.923-.153-.324-.297-.651-.467-.969-.158-.294-.337-.573-.508-.859-.186-.312-.362-.627-.565-.931-.211-.316-.446-.612-.673-.916-.19-.254-.366-.514-.569-.761-.443-.54-.91-1.059-1.403-1.552l-.01-.011-85.333-85.333c-8.331-8.331-21.839-8.331-30.17 0s-8.331 21.839 0 30.17l48.915 48.915H21.333C9.551 234.669 0 244.22 0 256.002s9.551 21.333 21.333 21.333h225.83l-48.915 48.916z"/></svg>
                    </div>
                </button>
            </div>

            <div class="error-message"></div>

        </div>

    <?= $this->Form->end() ?>
    
</section>


















