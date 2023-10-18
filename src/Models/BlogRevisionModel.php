<?php

namespace Brucelwayne\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property integer blog_id
 * @property array payload
 */
class BlogRevisionModel extends Model
{
    protected $table = 'blog_revisions';

    protected $casts = [
        'payload' => 'array',
    ];

    public function saveRevision(BlogModel $blog_model)
    {
        $blog_id = $blog_model->getKey();
        $last_revision = static::getLatestRevision($blog_id);

        if (empty($last_revision)){
            return static::create([
                'blog_id' => $blog_id,
                'payload' => $blog_model->toArray(),
            ]);
        }

        $diff= array_diff($last_revision->payload,$blog_model->toArray());
        if (empty($diff)){
            //no changes
            return $last_revision;
        }else{
            $last_revision->payload = $blog_model->toArray();
            $last_revision->save();
            return $last_revision;
        }
    }

    /**
     * @param $blog_id
     * @return BlogRevisionModel
     */
    public static function getLatestRevision($blog_id){
        return static::where('blog_id',$blog_id)
            ->orderBy('id','desc')
            ->first();
    }
}