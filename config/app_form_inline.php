<?php
return [
    'inputContainer'      => '<div class="form-group row">{{content}}</div>',
    'label'               => '<label{{attrs}} class="col-md-5 col-form-label">{{text}}</label>',
    'input'               => '<div class="col-md-7"> <input type="{{type}}" name="{{name}}"{{attrs}} class="form-control"/> </div>',
    'textarea'            => '<textarea name="{{name}}"{{attrs}} class="form-control" >{{value}}</textarea>',
    'select'              => '<div class="col-md-7"><select name="{{name}}"{{attrs}} class="selectpicker">{{content}}</select></div>',
    'error'               => '<div class="form-control-feedback">{{content}}</div>',
    'inputContainerError' => '<div class="form-group {{type}}{{required}} has-danger">{{content}}{{error}}</div>',
    'checkbox'            => '<input type="checkbox" name="{{name}}" value="{{value}}" class="custom-control-input" {{attrs}}>',
    'nestingLabel'        => '{{hidden}}<label{{attrs}} class="custom-control custom-checkbox">{{input}}<span class="custom-control-label">{{text}}</span></label>',        
];
