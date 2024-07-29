<?php

namespace App\Classes;

class Permissions
{
    // Define permissions for the 'dashboard' module
    private static function dashboardPermissions(): array
    {
        return [
            'dashboard' => [
                'view', // Permission to view the dashboard
            ]
        ];
    }

    private static function associationPermissions(): array
    {
        return [
            'associations' => [
                'create',   // Permission to create an association member
                'index',    // Permission to view the list of association members
                'view',     // Permission to view a single association member
                'update',   // Permission to update an association member
                'destroy',  // Permission to delete an association member
            ]
        ];
    }

    private static function associationUnitPermissions(): array
    {
        return [
            'association units' => [
                'create',   // Permission to create an association member
                'index',    // Permission to view the list of association members
                'view',     // Permission to view a single association member
                'update',   // Permission to update an association member
                'destroy',  // Permission to delete an association member
            ]
        ];
    }

    // Define permissions for the 'association member' module
    private static function associationManagerPermissions(): array
    {
        return [
            'association manager' => [
                'create',   // Permission to create an association member
                'index',    // Permission to view the list of association members
                'view',     // Permission to view a single association member
                'update',   // Permission to update an association member
                'destroy',  // Permission to delete an association member
            ]
        ];
    }

    private static function associationHeadPermissions(): array
    {
        return [
            'association head' => [
                'create',   // Permission to create an association member
                'index',    // Permission to view the list of association members
                'view',     // Permission to view a single association member
                'update',   // Permission to update an association member
                'destroy',  // Permission to delete an association member
            ]
        ];
    }

    private static function associationEmployeePermissions(): array
    {
        return [
            'association employee' => [
                'create',   // Permission to create an association member
                'index',    // Permission to view the list of association members
                'view',     // Permission to view a single association member
                'update',   // Permission to update an association member
                'destroy',  // Permission to delete an association member
            ]
        ];
    }

    private static function associationOutsourceEmployeePermissions(): array
    {
        return [
            'association outsource employee' => [
                'create',   // Permission to create an association member
                'index',    // Permission to view the list of association members
                'view',     // Permission to view a single association member
                'update',   // Permission to update an association member
                'destroy',  // Permission to delete an association member
            ]
        ];
    }

    private static function associationMemberPermissions(): array
    {
        return [
            'association members' => [
                'create',   // Permission to create an association member
                'index',    // Permission to view the list of association members
                'view',     // Permission to view a single association member
                'update',   // Permission to update an association member
                'destroy',  // Permission to delete an association member
            ]
        ];
    }

    private static function associationMemberRequestPermissions(): array
    {
        return [
            'association member requests' => [
                'create',   // Permission to create an association member
                'index',    // Permission to view the list of association members
                'view',     // Permission to view a single association member
                'update',   // Permission to update an association member
                'destroy',  // Permission to delete an association member
            ]
        ];
    }

    // Define permissions for the 'bond' module
    private static function incomeReceiptPermissions(): array
    {
        return [
            'income receipts' => [
                'create',   // Permission to create a bond
                'update',   // Permission to update a bond
                'destroy',  // Permission to delete a bond
                'view'      // Permission to view a bond
            ]
        ];
    }

    private static function paymentReceiptPermissions(): array
    {
        return [
            'payment receipts' => [
                'create',   // Permission to create a payment receipt
                'update',   // Permission to update a payment receipt
                'destroy',  // Permission to delete a payment receipt
                'view'      // Permission to view a payment receipt
            ]
        ];
    }

    private static function paymentReceiptRequestPermissions(): array
    {
        return [
            'payment receipt requests' => [
                'create',   // Permission to create a payment receipt
                'update',   // Permission to update a payment receipt
                'destroy',  // Permission to delete a payment receipt
                'view'      // Permission to view a payment receipt
            ]
        ];
    }

    // Define permissions for the 'gift' module
    private static function giftPermissions(): array
    {
        return [
            'gifts' => [
                'create',   // Permission to create a gift
                'update',   // Permission to update a gift
                'destroy',  // Permission to delete a gift
                'view'      // Permission to view a gift
            ]
        ];
    }

    // Define permissions for the 'investment company contracts' module
    private static function investmentCompanyContractPermissions(): array
    {
        return [
            'investment company contracts' => [
                'create',   // Permission to create an investment company contract
                'update',   // Permission to update an investment company contract
                'destroy',  // Permission to delete an investment company contract
                'view'      // Permission to view an investment company contract
            ]
        ];
    }

    // Define permissions for the 'investment company contracts' module
    private static function serviceCompanyContractPermissions(): array
    {
        return [
            'service company contracts' => [
                'create',   // Permission to create a service company contract
                'update',   // Permission to update a service company contract
                'destroy',  // Permission to delete a service company contract
                'view'      // Permission to view a service company contract
            ]
        ];
    }

    // Define permissions for the 'ad' module
    private static function adPermissions(): array
    {
        return [
            'ads' => [
                'create',   // Permission to create an ad
                'update',   // Permission to update an ad
                'destroy',  // Permission to delete an ad
                'view'      // Permission to view an ad
            ]
        ];
    }

    // Define permissions for the 'association budget' module
    private static function associationBudgetPermissions(): array
    {
        return [
            'association budget' => [
                'view'      // Permission to view the association budget
            ]
        ];
    }

    private static function subscriptionPermissions(): array
    {
        return [
            'subscriptions' => [
                'view'      // Permission to view the association budget
            ]
        ];
    }

    private static function supportTicketPermissions(): array
    {
        return [
            'support tickets' => [
                'view',
                'show',
                'create'
            ]
        ];
    }

    private static function permitsPermissions(): array
    {
        return [
            'permits' => [
                'view',
                'show',
                'create'
            ]
        ];
    }

    private static function policiesPermissions()
    {
        return [
            'policies' => [
                'view',
                'show',
                'create'
            ]
        ];
    }

    private static function meetingsPermissions(): array
    {
        return [
            'meetings' => [
                'view',
                'show',
                'create'
            ]
        ];
    }

    private static function rolePermissions(): array
    {
        return [
            'roles' => [
                'view',
                'show',
                'create',
                'update',
                'delete'
            ]
        ];
    }

    private static function receiptCategoryPermissions(): array
    {
        return [
            'receipt categories' => [
                'view',
                'show',
                'create',
                'update',
                'delete'
            ]
        ];
    }

    // Combine all permissions into a single array
    public static function attributes(): array
    {

        return array_merge(
            self::dashboardPermissions(),
            self::associationPermissions(),
            self::associationUnitPermissions(),
            self::associationMemberPermissions(),
            self::incomeReceiptPermissions(),
            self::paymentReceiptPermissions(),
            self::paymentReceiptRequestPermissions(),
            self::giftPermissions(),
            self::investmentCompanyContractPermissions(),
            self::serviceCompanyContractPermissions(),
            self::adPermissions(),
            self::associationBudgetPermissions(),
            self::subscriptionPermissions(),
            self::associationManagerPermissions(),
//            self::associationHeadPermissions(),
//            self::associationEmployeePermissions(),
            self::associationOutsourceEmployeePermissions(),
            self::associationMemberRequestPermissions(),
            self::supportTicketPermissions(),
            self::permitsPermissions(),
//            self::policiesPermissions(),
            self::meetingsPermissions(),
            self::rolePermissions(),
            self::receiptCategoryPermissions()
        );
    }
}
