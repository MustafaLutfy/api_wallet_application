<?php

namespace App\Enums;

enum ExpenseCategory : string
{
  case Fixed = "fixed_expenses";
  case Variable = "variable_expenses";
}
