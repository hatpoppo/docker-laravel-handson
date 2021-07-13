<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    /**
     * 状態定義
     */
    const STATUS = [
        1 => ['label' => '未着手'],
        2 => ['label' => '着手中'],
        3 => ['label' => '完了'],
    ];
    /**
     * 状態のラベル
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        $status = $this->attributes['status'];

        //定義されていなければ空文字を返す
        if (!isset(self::STATUS[$status])){
            return '';
        }
        return self::STATUS[$status]['label'];
    }
}
