<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
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

    'categories' => [
        'name' => 'Categories',
        'index_title' => 'Categories List',
        'new_title' => 'New Category',
        'create_title' => 'Create Category',
        'edit_title' => 'Edit Category',
        'show_title' => 'Show Category',
        'inputs' => [
            'name' => 'Name',
            'slug' => 'Slug',
            'cover_path' => 'Cover Path',
        ],
    ],

    'groups' => [
        'name' => 'Groups',
        'index_title' => 'Groups List',
        'new_title' => 'New Group',
        'create_title' => 'Create Group',
        'edit_title' => 'Edit Group',
        'show_title' => 'Show Group',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'jobs' => [
        'name' => 'Jobs',
        'index_title' => 'Jobs List',
        'new_title' => 'New Job',
        'create_title' => 'Create Job',
        'edit_title' => 'Edit Job',
        'show_title' => 'Show Job',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'new_title' => 'New Role',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'support_links' => [
        'name' => 'Support Links',
        'index_title' => 'SupportLinks List',
        'new_title' => 'New Support link',
        'create_title' => 'Create SupportLink',
        'edit_title' => 'Edit SupportLink',
        'show_title' => 'Show SupportLink',
        'inputs' => [
            'name' => 'Name',
            'url' => 'Url',
            'same_tab' => 'Same Tab',
            'cover_path' => 'Cover Path',
        ],
    ],

    'teams' => [
        'name' => 'Teams',
        'index_title' => 'Teams List',
        'new_title' => 'New Team',
        'create_title' => 'Create Team',
        'edit_title' => 'Edit Team',
        'show_title' => 'Show Team',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'certificates' => [
        'name' => 'Certificates',
        'index_title' => 'Certificates List',
        'new_title' => 'New Certificate',
        'create_title' => 'Create Certificate',
        'edit_title' => 'Edit Certificate',
        'show_title' => 'Show Certificate',
        'inputs' => [
            'name' => 'Name',
            'description' => 'Description',
            'background_path' => 'Background Path',
        ],
    ],

    'learning_artifacts' => [
        'name' => 'Learning Artifacts',
        'index_title' => 'LearningArtifacts List',
        'new_title' => 'New Learning artifact',
        'create_title' => 'Create LearningArtifact',
        'edit_title' => 'Edit LearningArtifact',
        'show_title' => 'Show LearningArtifact',
        'inputs' => [
            'name' => 'Name',
            'type' => 'Type',
            'path' => 'Path',
            'size' => 'Size',
            'description' => 'Description',
            'external' => 'External',
            'url' => 'Url',
            'cover_path' => 'Cover Path',
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
            'description' => 'Description',
            'cover_path' => 'Cover Path',
        ],
    ],

    'learning_paths' => [
        'name' => 'Learning Paths',
        'index_title' => 'LearningPaths List',
        'new_title' => 'New Learning path',
        'create_title' => 'Create LearningPath',
        'edit_title' => 'Edit LearningPath',
        'show_title' => 'Show LearningPath',
        'inputs' => [
            'name' => 'Name',
            'description' => 'Description',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'availability_time' => 'Availability Time',
            'cover_path' => 'Cover Path',
            'tries' => 'Tries',
            'passing_score' => 'Passing Score',
            'approval_goal' => 'Approval Goal',
            'certificate_id' => 'Certificate',
        ],
    ],

    'quizzes' => [
        'name' => 'Quizzes',
        'index_title' => 'Quizzes List',
        'new_title' => 'New Quiz',
        'create_title' => 'Create Quiz',
        'edit_title' => 'Edit Quiz',
        'show_title' => 'Show Quiz',
        'inputs' => [
            'name' => 'Name',
            'slug' => 'Slug',
            'description' => 'Description',
            'cover_path' => 'Cover Path',
            'time_limit' => 'Time Limit',
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
            'role_id' => 'Role',
            'job_id' => 'Job',
            'group_id' => 'Group',
        ],
    ],
];
