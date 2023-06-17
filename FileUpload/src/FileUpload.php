<?php

namespace Mizormor\FileUpload;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class FileUpload extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'file-upload';

    /**
     * Set the maximum image size (in KB).
     *
     * @return $this
     */
    public function maxFileSize(int $value = 48)
    {
        return $this->withMeta(['maxFileSize' => $value]);
    }

    /**
     * Indicate if the field is nullable.
     *
     * @param  bool  $nullable
     * @param  mixed|null  $value
     * @return $this
     */
    public function nullable($nullable = true, $value = null)
    {
        return $this->withMeta(['nullable' => $nullable, 'value' => $value]);
    }

    public function fill(NovaRequest $request, $model): void
    {
        //
    }

    public function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute): void
    {
        if ($request->exists('tour_images')) {
            info('we here fillAttributeFromRequest');
            $model->tour_images = $model->getImages();
        }
    }
}
