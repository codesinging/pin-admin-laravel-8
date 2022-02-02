<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace __DUMMY_NAMESPACE__\Models;

use CodeSinging\PinAdmin\Model\AuthModel;

class __DUMMY_STUDLY_NAME__User extends AuthModel
{
    protected $fillable = [
        'mobile',
        'name',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function setPasswordAttribute($value)
    {
        empty($value) or $this->attributes['password'] = bcrypt($value);
    }
}