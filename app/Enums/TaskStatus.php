<?php

namespace App\Enums;

enum TaskStatus: string {
    case P = 'pending';
    case IP = 'in_progress';
    case E = 'completed';
}