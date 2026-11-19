<?php

namespace App\Models;

use App\Enums\ReportStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/** Segnalazione di un annuncio, di un utente o di una conversazione. */
class Report extends Model
{
    protected $fillable = ['reporter_id', 'reportable_type', 'reportable_id', 'reason', 'details', 'status', 'resolved_by', 'resolution_note', 'resolved_at'];

    protected function casts(): array
    {
        return ['status' => ReportStatus::class, 'resolved_at' => 'datetime'];
    }

    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
