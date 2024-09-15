<?php

namespace MyTour\CoreBundle\Form\Custom;

use DateTime;
use MyTour\CoreBundle\Utils\DateTimeUtils;
use Symfony\Component\Form\DataTransformerInterface;

class StringToDateTimeTransformer implements DataTransformerInterface
{
    public function transform($value): ?string
    {
        return $value;
    }

    public function reverseTransform($value): ?DateTime
    {
        return DateTimeUtils::getDateTimeFromMixed($value);
    }
}