<?php

namespace Mizormor\FileUpload;

use Laravel\Nova\Fields\Field;

class FileUpload extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'file-upload';
}
