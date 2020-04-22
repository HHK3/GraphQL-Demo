<?php

namespace App\GraphQL\Mutation;

use Closure;
use App\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Hash;
use Rebing\GraphQL\Support\Mutation;
//use Rebing\GraphQL\Support\SelectFields;
//use function auth;
//use function collect;
//use function event;

/**
 * Creates a new user
 */
class CreateUserMutation extends Mutation
{

    /**
     * Indicates whether the user is authenticated
     *
     * @var boolean
     */
    protected $authenticated = false;

    /**
     * The logged in user
     *
     * @var User
     */
    protected $user;

    /**
     * Mutation attributes
     *
     * @var array
     */
    protected $attributes = [
        'name'        => 'CreateUserMutation',
        'description' => 'Creates a new user'
    ];

//    /**
//     * Class constructor
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        $this->authenticated = auth('api')->check();
//        $this->user          = auth('api')->user();
//    }

    /**
     * This query returns a a single user
     *
     * @return Type
     */
    public function type(): Type
    {
        return GraphQL::type('user');
    }

    public function args(): array
    {
        return [
            'name'      => [
                'type'  => Type::string(),
                'rules' => ['required'],
            ],
            'email'      => [
                'type'  => Type::string(),
                'rules' => ['required', 'email'],
            ],
            'password'   => [
                'type'  => Type::string(),
                'rules' => ['required'],
            ],
            'locationId' => [
                'type'  => Type::listOf(Type::int()),
                'rules' => ['exists:locations,id'],
            ],
//            'roles'      => [
//                'type'  => Type::listOf(Type::string()),
//                'rules' => ['exists:roles,name']
//            ]
        ];
    }

//    /**
//     * Set authorization rules.
//     *
//     * @param array $args
//     *
//     * @return boolean
//     */
//    public function authorize(array $args): bool
//    {
//        $args = collect($args);
//
//        if (!$this->authenticated) {
//            return false;
//        }
//
//        return $this->user->can('create', [User::class, collect($args->get('locationId'))]);
//    }

    public function resolve($root, $args)
    {
        $args = collect($args);

        // Check and see if the email is already present in the database
        $user = User::where('email', $args->get('email'))->first();

        if (!$user) {
            // If a user does not yet exists, create a new one
            $user = User::create([
                    'name'     => $args->get('name'),
                    'email'    => $args->get('email'),
                    'password' => Hash::make($args->get('password')),
            ]);

            $user->locations()->syncWithoutDetaching($args->get('locationId'));
            return $user;
        }

        else {
            return [
                'Sorry, this email address is already in use',
            ];
        }

        // If a user already exists, we only need to save the given locationIds
        // For users that exist already, we simply save the locationIds

//        $this->addDefaultTasklists($args);

//        $roles = collect($args->get('roles'));

        // Sync the given roles except Admin
//        $user->syncRoles($roles->reject(function ($value) {
//                return $value === 'Admin';
//            }));

//        event(new UserCreated($user));

    }

//    protected function addDefaultTasklists($args)
//    {
//        foreach (DefaultTasklist::all() as $defTasklist) {
//            $tasklist = DB::table('m_tasklist')->where([
//                    ['location_id', current($args->get('locationId'))],
//                    ['name', $defTasklist->name],
//                ])
//                ->get();
//
//            if (!$tasklist->first()) {
//                $this->createDefaultTasks($args, $defTasklist);
//            }
//        }
//    }

//    protected function createDefaultTasks($args, $defTasklist)
//    {
//        $tasklist = new Tasklist;
//
//        $tasklist->location_id   = current($args->get('locationId'));
//        $tasklist->name          = $defTasklist->name;
//        $tasklist->display_order = 0;
//
//        $tasklist->save();
//
//        foreach ($this->getDefaultTaskByTasklistId($defTasklist->id) as $defTask) {
//            $task = new Task([
//                'name'          => $defTask->name,
//                'description'   => $defTask->description,
//                'eligible_on'   => $defTask->eligible_on,
//                'type'          => $defTask->type,
//                'display_order' => $defTask->display_order,
//            ]);
//
//            $tasklist->tasks()->save($task);
//        }
//    }

//    protected function getDefaultTaskByTasklistId($tasklistId)
//    {
//        $tasks = DefaultTask::query();
//
//        $tasks->where('default_tasklist_id', $tasklistId);
//
//        return $tasks->get();
//    }
}
