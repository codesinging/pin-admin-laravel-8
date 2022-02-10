<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Model;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use SerializeDate;
    use IdeHelpers;
}