<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;

class AdmissionCommitteeContactsBlock extends Model
{
    use AsSource, Userable, SoftDeletes, HasFactory;

    protected $table = 'admission_committee_contacts_blocks';

    protected $fillable = [
        'address',
        'email',
        'phone_number',
    ];
}
