<?php

namespace App\Enums;

enum FilterOperators: string
{
  const EQUALS="eq";
  const LESS_THAN="lt";
  const LESS_THAN_EQUALS="lte";
  const GRATER_THAN="gt";
  const GRATER_THAN_EQUALS="gte";
}
