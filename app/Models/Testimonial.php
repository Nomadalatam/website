<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

/**
 * App\Models\Testimonial
 *
 * @property int $id
 * @property string $customer_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $customer_image_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonial query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonial whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonial whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonial whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Testimonial extends Model implements HasMedia
{
    use HasMediaTrait;

    public const PATH = 'testimonials';
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'customer_name' => 'required',
        'customer_image' => 'required',
    ];
    public $table = 'testimonials';
    public $fillable = [
        'customer_name',
        'description',
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'customer_name' => 'string',
        'description'   => 'string',
    ];

    /**
     * @var array
     */
    protected $appends = ['customer_image_url'];

    /**
     * @return mixed
     */
    public function getCustomerImageUrlAttribute()
    {
        /** @var Media $media */
        $media = $this->media->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return asset('assets/img/nomada-logo.png');
    }
}
