<?php

namespace Mizormor\FileUpload;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Http\Requests\NovaRequest;

trait Upload
{
    public static function afterCreate(NovaRequest $request, Model $model): void
    {
        if ($request->hasFile('tour_images')) {
            foreach ($request->file('tour_images') as $file) {
                $fileName = $file->getClientOriginalName();
                $tour = Tour::find($model->id);
                $filePath = $file->storeAs("tours/$tour?->id", $fileName);

                $url = Storage::url((string) $filePath);

                /**
                 * @var Tour $tour
                 */
                $tour->uploads()->create([
                    'url' => $url,
                    'type' => 'tour_image',
                ]);
            }
        }
    }
}
