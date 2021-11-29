<?php

namespace App\Models;

use App\API\Serializers\CustomArraySerializer;
use App\API\Transformers\IDTransformer;
use App\Constants\Attributes;
use App\Helpers;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


/**
 * Custom Model
 * @package App\Models
 *
 * @property int id
 * @property int status
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 */
class CustomModel extends Model
{
    use SoftDeletes, CrudTrait;

    const TRANSFORMER_NAME = IDTransformer::class;

    protected $primaryKey = Attributes::ID;

    /**
     * Create or Update
     * @param array $data
     * @param array|null $find_by
     * @return static|null
     */
    public static function createOrUpdate(array $data, $find_by = null)
    {
        try {
            $item = null;
            if(!is_null($find_by)){
                $q = static::query();
                foreach ($find_by as $key){
                    if ($key == Attributes::EMAIL) {
                        $value = Str::lower($data[$key]);
                    }else{
                        $value = $data[$key];
                    }
                    $q = $q->where($key, $value);
                }
                $item = $q->withTrashed()->first();
            }
            if (is_null($item)) {
                $item = new static();
            }else if (!is_null($item->deleted_at)) {
                $item->restore();
            }
            $item->fill($data);
            if ($item->save()) {
                return $item;
            }
            return null;
        } catch (Exception $e) {
            Helpers::captureException($e);
            return null;
        }
    }

    /**
     * Return Transformed Items
     * @param $items
     * @param string|null $class_name
     * @return array
     */
    static function returnTransformedItems($items, $class_name = null): array
    {
        if(is_null($class_name)){
            $class_name = static::TRANSFORMER_NAME;
        }
        return fractal($items, new $class_name(), new CustomArraySerializer())->toArray();
    }
}
