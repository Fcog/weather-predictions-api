<?php

namespace App\Enums;

enum InputFormat: string
{
    case JSON = 'json';
    case XML = 'xml';
    case CSV = 'csv';
}
