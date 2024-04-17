<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'Register',
        'Login',
        'AddList',
        'AddNote',
        'AddNote/{idList}',
        'NoteList',
        'NoteList/{id}',
        'AddChecked',
        'AddNoteTag',
        'DeleteNote',
        'DeleteImageNote',
        'AddImageNote',
        'DeleteTag',
        'DeleteImage',
        'UpdateImage',
        'FilterList',
        'AddFilterList',
        'UpdateName',
        'ImageNameModel'
    ];
}
