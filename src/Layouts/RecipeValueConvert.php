<?php

namespace App\Layouts;

use App\Entity\Recipe;
use Netgen\Layouts\Item\ValueConverterInterface;

class RecipeValueConvert implements ValueConverterInterface
{

    public function supports(object $object): bool
    {
        return $object instanceof Recipe;
    }

    public function getValueType(object $object): string
    {
        return 'doctrine_recipe';
    }

    public function getId(object $object): int|string
    {
        return $object->getId();
    }

    public function getRemoteId(object $object): int|string
    {
        return $this->getId($object);
    }

    public function getName(object $object): string
    {
        assert($object instanceof Recipe);
        return $object->getName();
    }

    public function getIsVisible(object $object): bool
    {
        return true;
    }

    public function getObject(object $object): object
    {
        return $object;
    }
}