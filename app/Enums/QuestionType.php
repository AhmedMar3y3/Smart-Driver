<?php 

namespace App\Enums;
enum QuestionType: string
{
    case TEXT = 'text';
    case IMAGE = 'image';
    case TEXTWITHIMAGE = 'text_with_image';
}