<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugTest extends Model
{
    use HasFactory;
    protected $table = 'examlab_drug';
    public $timestamps = false;
    protected $guarded = [];

    public function admission() {
        $this->belongsTo(Admission::class, 'admission_id');
    }
}
