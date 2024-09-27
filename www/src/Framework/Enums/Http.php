<?php

namespace Framework\Enums;

enum Http: int
{
    case OK_STATUS_CODE = 200;
    case REDIRECT_STATUS_CODE = 302;
}
