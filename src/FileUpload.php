<?php

namespace Mizormor\FileUpload;

use App\Models\Tour;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class FileUpload extends Field
{
    public $uploadUrl = 'https://example.com/api/uploads';

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
        if ($request->hasFile('tour_image')) {
            $file = $request->file('tour_image');
            $fileName = $file->getClientOriginalName();
            $tour = Tour::find($this->resource->id);
            $filePath = $file->storeAs("tours/$tour?->id", $fileName);

            $url = Storage::url((string) $filePath);

            /**
             * @var Tour $tour
             */
            $tour->uploads()->create([
                'url' => $url,
                'type' => 'tour_image',
            ]);
        } else {
//            $model->{$attribute} = null;
            Log::error($request->input('name'));
        }
    }
}
