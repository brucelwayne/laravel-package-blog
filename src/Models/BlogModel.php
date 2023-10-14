<?php
namespace Brucelwayne\Blog\Models;

use Brucelwayne\Blog\Enums\BlogStatus;
use Illuminate\Database\Eloquent\Model;
use Veelasky\LaravelHashId\Eloquent\HashableId;

/**
 * @property integer $team_id
 * @property integer creator_id
 * @property integer author_id
 * @property integer default_cate_id
 * @property BlogStatus status
 * @property string title
 * @property string slug
 * @property string excerpt
 * @property string content
 * @property string seo_title
 * @property string seo_keywords
 * @property string seo_content
 */
class BlogModel extends Model
{
    use HashableId;

    protected $table = 'blogs';

    //region hash id
    protected $hashKey = self::class;
    protected $appends = [
        'hash'
    ];
    public function getRouteKeyName(): string
    {
        return 'hash';
    }
    //endregion

    protected $hidden = [
        'id',
    ];

    protected $fillable = [
        'team_id',
        'creator_id',
        'author_id',
        'default_cate_id',
        'status',
        'title',
        'slug',
        'excerpt',
        'content',
        'seo_title',
        'seo_keywords',
        'seo_content',
    ];

    protected $casts = [
        'status',
    ];
}