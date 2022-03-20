<?php
namespace App\Enums;

enum BookStatus: string
{
  case CHECKED_OUT = "Checked Out";
  case AVAILABLE = "Available";
}