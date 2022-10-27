<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;

class AdmissionCommitteeContacts extends Model
{
    use AsSource, Userable, SoftDeletes;

    protected $table = 'admission_committee_contacts';

    protected $fillable = [
        'address',
        'email',
        'phone_number',
    ];
}
