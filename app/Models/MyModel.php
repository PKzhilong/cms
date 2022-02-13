<?php

namespace App\Models;

use App\Helpers\RepositoryHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MyModel extends Model
{
    use HasFactory, RepositoryHelpers;

    /**
     * 单条记录插入
     * @param $data
     * @return mixed
     */
    public static function insert($data)
    {
        $object = new static();
        $object->store($data);

        return $object->{$object->getKeyName()} ?? false;
    }

    /**
     * 批量数据插入
     * @param $data
     */
    public static function insertAll($data)
    {
        if ($data) {

            $object = new static();
            DB::table($object->getTable())->insert($data);
        }
    }

    /**
     * 修改数据
     * @param $condition
     * @param $data
     * @return bool
     */
    public static function modify($condition, $data): bool
    {
        if (is_numeric($condition)) {

            $object = new static();
            $data[$object->getKeyName()] = $condition;

            return $object->up($data);
        }

        if (is_array($condition)) {

            return static::where($condition)->update($data);
        }

        return false;
    }

}
