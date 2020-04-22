<?php

namespace App;

use App\Modules\Tasklist\Tasklist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    /**
     * None of this model's fields are guarded
     *
     * @var array
     */
    public $guarded = [];

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'city', 'zip', 'phone'
    ];

//    /**
//     * The attributes that should be cast to native types.
//     *
//     * @var array
//     */
//    protected $casts = [
//        'settings' => 'array',
//    ];

    /**
     * Linkage to what modules a location might have
     *
     * @return belongsToMany
     */
    public function modules(): belongsToMany
    {
        return $this->belongsToMany(Module::class);
    }

    /**
     * Linkage to users
     *
     * @return belongsToMany
     */
    public function users(): belongsToMany
    {
        return $this->belongsToMany(User::class, 'user_location');
    }

    /**
     * User responsible for creating the location
     *
     * @return belongsTo
     */
    public function createdBy(): belongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The tasklists that belong to this venue.
     *
     * @return HasMany
     */
    public function tasklists(): HasMany
    {
        return $this->hasMany(Tasklist::class);
    }

//    public function getPreferredLocale()
//    {
//        if (isset($this->settings['preferred_locale']) && in_array($this->settings['preferred_locale'], config('app.supported_locales'))) {
//            return $this->settings['preferred_locale'];
//        }
//
//        return config('app.locale');
//    }
//
//    public function setPreferredLocale($locale)
//    {
//        if (!in_array($locale, config('app.supported_locales'))) {
//            return false;
//        }
//
//        $this->update(['settings' => ['preferred_locale' => $locale]]);
//    }
}
