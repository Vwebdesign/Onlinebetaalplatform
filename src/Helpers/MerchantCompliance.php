<?php

namespace OBP\Helpers;

/**
 * Class Merchant
 *
 * @package OBP\Merchants\Helpers
 */
class MerchantCompliance
{
    /**
     * Get compliance requirements for merchant where requirement type is array key
     *
     * @param   array $merchant OBP merchant array from GetMerchant
     * @return  array
     */
    public static function getComplianceRequirements(array $merchant): array
    {
        // Check if merchant has compliance requirements, this will also make sure the merchant param is in correct structure
        if (!isset($merchant['compliance']['requirements'])) {
            return [];
        }

        // Create empty requirement array
        $requirements = [];

        // Fill array with requirements and set requirement type as key
        foreach ($merchant['compliance']['requirements'] as $requirement) {
            $requirements[$requirement['type']] = $requirement;
        }

        return $requirements;
    }
}