<?php

namespace App\Enums;

enum EntityStatType: string
{
    case ClickInConstructor = "click_in_constructor";
    case ClickInList = "click_in_list";
    case ClickToMore = "click_to_more";
}
