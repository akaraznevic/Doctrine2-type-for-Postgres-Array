<?php

namespace YouProjectNamespace\Doctrine\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Class PgArrayType
 */
class PgArrayType extends Type
{
    const PG_ARRAY = 'pg_array';

    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getClobTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return array|mixed
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return array();
        }

        $value = (is_resource($value)) ? stream_get_contents($value) : $value;

        return $this->transform($value);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::PG_ARRAY;
    }

    /**
     * @param $inputs
     * @return array
     */
    private function transform($inputs)
    {
        $result = array();

        if ($inputs === null) {
            return $result;
        }

        if (preg_match_all('/{(\d+),(.+?)}/', $inputs, $matches) > 0) {
            if (isset($matches[1])) {
                foreach ($matches[1] as $k => $id) {
                    $value = $matches[2][$k];
                    if ($value === 'NULL') {
                        $value = null;
                    }
                    $result[$id] = $value;
                }
            }
        }
        return $result;
    }
}
