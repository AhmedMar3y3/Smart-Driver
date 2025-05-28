<?php 

namespace App\Enums;
enum ChoiceType: string
{
    case TEXT = 'text';
    case IMAGE = 'image';
    case TEXTWITHIMAGE = 'text_with_image';
}