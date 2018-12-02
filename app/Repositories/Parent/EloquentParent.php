<?php

namespace Vanguard\Repositories\Parent;

use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Role;
use Vanguard\Services\Auth\Social\ManagesSocialAvatarSize;
use Vanguard\Services\Upload\UserAvatarManager;
use Vanguard\User;
use Vanguard\Parents;
use Carbon\Carbon;
use DB;
use Illuminate\Database\SQLiteConnection;
use Laravel\Socialite\Contracts\User as SocialUser;

class EloquentParent implements ParentRepository
{
    use ManagesSocialAvatarSize;

    /**
     * @var UserAvatarManager
     */
    private $avatarManager;
    /**
     * @var RoleRepository
     */
    private $roles;

    public function __construct(UserAvatarManager $avatarManager, RoleRepository $roles)
    {
        $this->avatarManager = $avatarManager;
        $this->roles = $roles;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Parents::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findByEmail($email)
    {
        return Parents::where('email', $email)->first();
    }

    public function findIDByEmail($email)
    {
        return Parents::select('id')
                ->where('email', $email)
                ->pluck('id');
    }

    /**
     * {@inheritdoc}
     */
    public function findBySocialId($provider, $providerId)
    {
        return Parents::leftJoin('social_logins', 'parents.id', '=', 'social_logins.user_id')
            ->select('parents.*')
            ->where('social_logins.provider', $provider)
            ->where('social_logins.provider_id', $providerId)
            ->first();
    }

    /**
     * {@inheritdoc}
     */
    public function findBySessionId($sessionId)
    {
        return Parents::leftJoin('sessions', 'parents.id', '=', 'sessions.user_id')
            ->select('parents.*')
            ->where('sessions.id', $sessionId)
            ->first();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        return Parents::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function associateSocialAccountForUser($userId, $provider, SocialUser $user)
    {
        return DB::table('social_logins')->insert([
            'user_id' => $userId,
            'provider' => $provider,
            'provider_id' => $user->getId(),
            'avatar' => $this->getAvatarForProvider($provider, $user),
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $search = null, $status = null, $role = null)
    {
        $query = Parents::query();

        if ($status) {
            $query->where('status', $status);
        }
	if ($role) {
	    $query->where('role_id', $role);
	}

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('username', "like", "%{$search}%");
                $q->orWhere('email', 'like', "%{$search}%");
                $q->orWhere('first_name', 'like', "%{$search}%");
                $q->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        $result = $query->orderBy('id', 'desc')
            ->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }

        if ($status) {
            $result->appends(['status' => $status]);
        }

	if ($role) {
	   $result->appends(['role_id' => $role]);
	}

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        if (isset($data['country_id']) && $data['country_id'] == 0) {
            $data['country_id'] = null;
        }

        $user = $this->find($id);

        $user->update($data);

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $user = $this->find($id);

        $this->avatarManager->deleteAvatarIfUploaded($user);

        return $user->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return Parents::count();
    }

    /**
     * {@inheritdoc}
     */
    public function newUsersCount()
    {
        return User::whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()])
            ->count();
    }

    /**
     * {@inheritdoc}
     */
    public function countByStatus($status)
    {
        return Parents::where('status', $status)->count();
    }

    public function countTeachers($status)
    {
	return Parents::where('role_id', '3')->count();
    }

    public function countParents($status)
    {
        return Parents::where('role_id', '5')->count();
    }

    /**
     * {@inheritdoc}
     */
    public function latest($count = 20)
    {
        return Parents::orderBy('created_at', 'DESC')
            ->limit($count)
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function countOfNewUsersPerMonth(Carbon $from, Carbon $to)
    {
        $result = Parents::whereBetween('created_at', [$from, $to])
            ->orderBy('created_at')
            ->get(['created_at'])
            ->groupBy(function ($user) {
                return $user->created_at->format("Y_n");
            });

        $counts = [];

        while ($from->lt($to)) {
            $key = $from->format("Y_n");

            $counts[$this->parseDate($key)] = count($result->get($key, []));

            $from->addMonth();
        }

        return $counts;
    }

    /**
     * Parse date from "Y_m" format to "{Month Name} {Year}" format.
     * @param $yearMonth
     * @return string
     */
    private function parseDate($yearMonth)
    {
        list($year, $month) = explode("_", $yearMonth);

        $month = trans("app.months.{$month}");

        return "{$month} {$year}";
    }

    /**
     * {@inheritdoc}
     */

    public function lists($column = 'name', $key = 'id')
    {
        return Parents::pluck($column, $key);
    }

    public function getUsersWithRole($roleName)
    {
        return Role::where('name', $roleName)
            ->users;
    }

    public function getUsersWithRoleId($roleId)
    {
	//$items = Items::where('active', true)->orderBy('name')->pluck('name', 'id');
	//return User::where('role_id', $roleId)
	return Parents::select(
            DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')
		->where('role_id', '3')
		->pluck('name', 'id');
    }

    public function getTeachersBySchoolID($school)
    {
	return User::select(
	  DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')
                        ->where([
                                'role_id' => '3',
                                'school_id' => $school
                        ])
		->get();
    }

    public function getTeacherByID($user_id)
    {
        return User::select(
          DB::raw("CONCAT(first_name,' ',last_name) AS name"), 'id')
                ->where('id', $user_id)
                ->pluck('name', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function getUserSocialLogins($userId)
    {
        return DB::table('social_logins')
            ->where('user_id', $userId)
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function setRole($userId, $roleId)
    {
        return $this->find($userId)->setRole($roleId);
    }

    /**
     * {@inheritdoc}
     */
    public function findByConfirmationToken($token)
    {
        return Parents::where('confirmation_token', $token)->first();
    }
    public function byID($teacher_id)
    {
        return Parents::where('id', $teacher_id)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function switchRolesForUsers($fromRoleId, $toRoleId)
    {
        return Parents::where('role_id', $fromRoleId)
            ->update(['role_id' => $toRoleId]);
    }

        public function clearclassroom($classroom_id, $user_id)
        {
		info("GOT QUERY");
		$updated1 = DB::table('classrooms')
				->where('user_id', $user_id)
				->update(['user_id' => null]);

                $updated2 = DB::table('classrooms')
                                ->where('id', $classroom_id)
                                ->update(['user_id' => $user_id]);
        }
}
