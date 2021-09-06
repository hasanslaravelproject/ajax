<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'meal_types' => [
        'name' => 'Meal Types',
        'index_title' => 'MealTypes List',
        'new_title' => 'New Meal type',
        'create_title' => 'Create MealType',
        'edit_title' => 'Edit MealType',
        'show_title' => 'Show MealType',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'companies' => [
        'name' => 'Companies',
        'index_title' => 'Companies List',
        'new_title' => 'New Company',
        'create_title' => 'Create Company',
        'edit_title' => 'Edit Company',
        'show_title' => 'Show Company',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'image' => 'Image',
            'company_id' => 'Company',
        ],
    ],

    'all_menu_types' => [
        'name' => 'All Menu Types',
        'index_title' => 'AllMenuTypes List',
        'new_title' => 'New Menu types',
        'create_title' => 'Create MenuTypes',
        'edit_title' => 'Edit MenuTypes',
        'show_title' => 'Show MenuTypes',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'orders' => [
        'name' => 'Orders',
        'index_title' => 'Orders List',
        'new_title' => 'New Order',
        'create_title' => 'Create Order',
        'edit_title' => 'Edit Order',
        'show_title' => 'Show Order',
        'inputs' => [
            'delivery_date' => 'Delivery Date',
            'order_quantity' => 'Order Quantity',
            'customer_id' => 'Customer',
            'menu_id' => 'Menu',
        ],
    ],

    'foods' => [
        'name' => 'Foods',
        'index_title' => 'Foods List',
        'new_title' => 'New Food',
        'create_title' => 'Create Food',
        'edit_title' => 'Edit Food',
        'show_title' => 'Show Food',
        'inputs' => [
            'name' => 'Name',
            'image' => 'Image',
            'food_type_id' => 'Food Type',
        ],
    ],

    'menus' => [
        'name' => 'Menus',
        'index_title' => 'Menus List',
        'new_title' => 'New Menu',
        'create_title' => 'Create Menu',
        'edit_title' => 'Edit Menu',
        'show_title' => 'Show Menu',
        'inputs' => [
            'name' => 'Name',
            'menu_starts' => 'Menu Starts',
            'validity' => 'Validity',
            'image' => 'Image',
            'menu_types_id' => 'Menu Types',
            'meal_type_id' => 'Meal Type',
            'food_id' => 'Food',
            'company_id' => 'Company',
        ],
    ],

    'food_types' => [
        'name' => 'Food Types',
        'index_title' => 'FoodTypes List',
        'new_title' => 'New Food type',
        'create_title' => 'Create FoodType',
        'edit_title' => 'Edit FoodType',
        'show_title' => 'Show FoodType',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'customers' => [
        'name' => 'Customers',
        'index_title' => 'Customers List',
        'new_title' => 'New Customer',
        'create_title' => 'Create Customer',
        'edit_title' => 'Edit Customer',
        'show_title' => 'Show Customer',
        'inputs' => [
            'name' => 'Name',
            'address' => 'Address',
        ],
    ],

    'stocks' => [
        'name' => 'Stocks',
        'index_title' => 'Stocks List',
        'new_title' => 'New Stock',
        'create_title' => 'Create Stock',
        'edit_title' => 'Edit Stock',
        'show_title' => 'Show Stock',
        'inputs' => [
            'name' => 'Name',
            'price' => 'Price',
            'quantity' => 'Quantity',
            'total' => 'Total',
            'stock' => 'Stock',
            'company_id' => 'Company',
        ],
    ],

    'company_stocks' => [
        'name' => 'Company Stocks',
        'index_title' => 'Stocks List',
        'new_title' => 'New Stock',
        'create_title' => 'Create Stock',
        'edit_title' => 'Edit Stock',
        'show_title' => 'Show Stock',
        'inputs' => [
            'name' => 'Name',
            'price' => 'Price',
            'quantity' => 'Quantity',
            'total' => 'Total',
            'stock' => 'Stock',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
