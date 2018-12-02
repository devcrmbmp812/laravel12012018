<?php

namespace Vanguard\Http\Controllers\Web;

use Vanguard\Events\User\Banned;
use Vanguard\Events\User\Deleted;
use Vanguard\Events\User\UpdatedByAdmin;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\User\CreateUserRequest;
use Vanguard\Http\Requests\User\UpdateParentDetailsRequest;
use Vanguard\Http\Requests\User\UpdateTeacherDetailsRequest;
use Vanguard\Http\Requests\User\UpdateDetailsRequest;
use Vanguard\Http\Requests\User\UpdateLoginDetailsRequest;
use Vanguard\Repositories\Activity\ActivityRepository;
use Vanguard\Repositories\Country\CountryRepository;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\Session\SessionRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Repositories\School\SchoolRepository;
use Vanguard\Repositories\Classroom\ClassroomRepository;
use Vanguard\Repositories\Parent\ParentRepository;
use Vanguard\Repositories\Position\PositionRepository;
use Vanguard\Services\Upload\UserAvatarManager;
use Vanguard\Support\Enum\UserStatus;
use Vanguard\User;
use Vanguard\Parents;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/**
 * Class ParentsController
 * @package Vanguard\Http\Controllers
 */
class ParentsController extends Controller
{
    /**
     * @var ParentRepository
     */
    private $parents;

    /**
     * ParentsController constructor.
     * @param ParentRepository $parents
     */
    public function __construct(ParentRepository $parents)
    {
        $this->middleware('auth');
        $this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
        $this->middleware('permission:parents.manage');
        $this->parents = $parents;
    }

    /**
     * Display paginated list of all users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(RoleRepository $roleRepository)
    {
        $parents = $this->parents->paginate(
            $perPage = 20,
            Input::get('search'),
            Input::get('status'),
            Input::get('role')
        );

        $statuses = ['' => trans('app.all')] + UserStatus::lists();
        $roles1[] = ['0' => 'All'];
        $roles2[] = json_decode($roleRepository->lists(), TRUE);
        $roles = array_merge($roles1, $roles2);
        return view('user.list-parents', compact('parents', 'statuses', 'roles'));
    }

    /**
     * Displays user profile page.
     *
     * @param User $user
     * @param ActivityRepository $activities
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Parents $parents, UserRepository $userRepository, ParentRepository $parentRepository, ActivityRepository $activities, SchoolRepository $schoolRepository, PositionRepository $positionRepository, ClassroomRepository $classroomRepository)
    {
        $userActivities = $activities->getLatestActivitiesForUser($parents->id, 10);
	$teacher = $userRepository->byID($parents->teacher_id);
	$school_name = $schoolRepository->byID($parents->school_id);
	$position = $positionRepository->byID($parents->position_id);
	$classroom = $classroomRepository->byID($parents->classroom_id);

        return view('user.view-parent', compact('parents', 'userActivities', 'school_name', 'position', 'classroom', 'teacher'));
    }

    /**
     * Displays form for creating a new user.
     *
     * @param CountryRepository $countryRepository
     * @param RoleRepository $roleRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(CountryRepository $countryRepository, RoleRepository $roleRepository, UserRepository $userRepository, SchoolRepository $schoolRepository, PositionRepository $positionRepository)
    {
        $countries = $this->parseCountries($countryRepository);
        $roles = $roleRepository->lists();
        $statuses = UserStatus::lists();
        $teachers = $userRepository->getUsersWithRoleId('3');
      	$schools = $schoolRepository->listall();
      	$positions = $positionRepository->listall();
        return view('user.add', compact('countries', 'roles', 'statuses', 'teachers','schools','positions'));
    }

    /**
    * Custom Teacher Functions
     */

     public function teachers($school, UserRepository $userRepository)
     {
       $schools = $userRepository->getTeachersBySchoolID($school);
       return $schools;
     }

     public function classrooms($teacher, ClassroomRepository $classroomRepository)
     {
             $classrooms = $classroomRepository->getClassroomsByTeacherID($teacher);
             return $classrooms;
     }

     public function schoolclassrooms($school, ClassroomRepository $classroomRepository)
     {
             $classrooms = $classroomRepository->getEmptyClassroomsBySchoolID($school);
             return $classrooms;
     }

     public function parentclassrooms($school, ClassroomRepository $classroomRepository)
     {
             $classrooms = $classroomRepository->getClassroomsBySchoolID($school);
             return $classrooms;
     }

    /**
     * Parse countries into an array that also has a blank
     * item as first element, which will allow users to
     * leave the country field unpopulated.
     * @param CountryRepository $countryRepository
     * @return array
     */
    private function parseCountries(CountryRepository $countryRepository)
    {
        return [0 => 'Select a Country'] + $countryRepository->lists()->toArray();
    }

    /**
     * Stores new user into the database.
     *
     * @param CreateUserRequest $request
     * @return mixed
     */
    public function store(CreateUserRequest $request)
    {
        // When user is created by administrator, we will set his
        // status to Active by default.
        $data = $request->all() + ['status' => UserStatus::ACTIVE];

        if (! array_get($data, 'country_id')) {
            $data['country_id'] = null;
        }

        // Username should be updated only if it is provided.
        // So, if it is an empty string, then we just leave it as it is.
        if (trim($data['username']) == '') {
            $data['username'] = null;
        }

        $user = $this->users->create($data);
        $user_id = $this->users->findIDByEmail($data['email']);
        return redirect()->route('parent.list')
            ->withSuccess(trans('app.user_created'));
    }

    /**
     * Displays edit user form.
     *
     * @param User $user
     * @param CountryRepository $countryRepository
     * @param RoleRepository $roleRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user, CountryRepository $countryRepository, RoleRepository $roleRepository, SchoolRepository $schoolRepository, UserRepository $userRepository, PositionRepository $positionRepository, ClassroomRepository $classroomRepository)
    {
        $edit = true;
        $countries = $this->parseCountries($countryRepository);
        $roles = $roleRepository->lists();
        $statuses = UserStatus::lists();
        $socialLogins = $this->users->getUserSocialLogins($user->id);
        $teachers = $userRepository->getUsersWithRoleId('3');
        $schools = $schoolRepository->listall();
        $positions = $positionRepository->listall();
        $currentTeacher = $userRepository->getTeacherByID($user->teacher_id);
        $classrooms = $classroomRepository->getClassroomsBySchoolID($user->school_id);

        return view(
            'parent.edit',
            compact('edit', 'user', 'countries', 'socialLogins', 'roles', 'statuses', 'schools', 'teachers', 'positions', 'currentTeacher', 'classrooms')
        );
    }

    /**
     * Updates user details.
     *
     * @param User $user
     * @param UpdateDetailsRequest $request
     * @return mixed
     */
    public function updateDetails(User $user, UpdateDetailsRequest $request)
    {
        $data = $request->all();

        if (! array_get($data, 'country_id')) {
            $data['country_id'] = null;
        }

        $this->users->update($user->id, $data);
        $this->users->setRole($user->id, $request->role_id);

        event(new UpdatedByAdmin($user));

        // If user status was updated to "Banned",
        // fire the appropriate event.
        if ($this->userIsBanned($user, $request)) {
            event(new Banned($user));
        }

        return redirect()->back()
            ->withSuccess(trans('app.user_updated'));
    }

    /**
     * Check if user is banned during last update.
     *
     * @param User $user
     * @param Request $request
     * @return bool
     */
    private function userIsBanned(User $user, Request $request)
    {
        return $user->status != $request->status && $request->status == UserStatus::BANNED;
    }

    /**
     * Update user's avatar from uploaded image.
     *
     * @param User $user
     * @param UserAvatarManager $avatarManager
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateAvatar(User $user, UserAvatarManager $avatarManager, Request $request)
    {
        $this->validate($request, ['avatar' => 'image']);

        $name = $avatarManager->uploadAndCropAvatar(
            $user,
            $request->file('avatar'),
            $request->get('points')
        );

        if ($name) {
            $this->users->update($user->id, ['avatar' => $name]);

            event(new UpdatedByAdmin($user));

            return redirect()->route('user.edit', $user->id)
                ->withSuccess(trans('app.avatar_changed'));
        }

        return redirect()->route('user.edit', $user->id)
            ->withErrors(trans('app.avatar_not_changed'));
    }

    /**
     * Custom Update Details
     *
     */
     public function updateParentDetails(User $user, UpdateParentDetailsRequest $request)
     {
         $data = $request->all();

         if (! array_get($data, 'classroom_id')) {
             $data['classroom_id'] = null;
         }

         $this->users->update($user->id, $data);
         //$this->users->setRole($user->id, $request->role_id);

         event(new UpdatedByAdmin($user));

         // If user status was updated to "Banned",
         // fire the appropriate event.
         //// if ($this->userIsBanned($user, $request)) {
         ////    event(new Banned($user));
         //// }

         return redirect()->back()
             ->withSuccess(trans('app.user_updated'));
     }


     public function updateTeacherDetails(User $user, UpdateTeacherDetailsRequest $request)
     {
         $data = $request->all();

         if (! array_get($data, 'classroom_id')) {
             $data['classroom_id'] = null;
         }

         $this->users->update($user->id, $data);
         //$this->users->setRole($user->id, $request->role_id);

         info("USER LOG");
         info($user->id);
  //      info("CONSOLE LOG ");
  //      info($data['classroom_id']);
       if ($user->role_id == '3') {
               $thisthing = $this->users->clearclassroom($data['classroom_id'], $user->id);
       }

         event(new UpdatedByAdmin($user));

         // If user status was updated to "Banned",
         // fire the appropriate event.
         //// if ($this->userIsBanned($user, $request)) {
         ////    event(new Banned($user));
         //// }

         return redirect()->back()
             ->withSuccess(trans('app.user_updated'));
     }

    /**
     * Update user's avatar from some external source (Gravatar, Facebook, Twitter...)
     *
     * @param User $user
     * @param Request $request
     * @param UserAvatarManager $avatarManager
     * @return mixed
     */
    public function updateAvatarExternal(User $user, Request $request, UserAvatarManager $avatarManager)
    {
        $avatarManager->deleteAvatarIfUploaded($user);

        $this->users->update($user->id, ['avatar' => $request->get('url')]);

        event(new UpdatedByAdmin($user));

        return redirect()->route('user.edit', $user->id)
            ->withSuccess(trans('app.avatar_changed'));
    }

    /**
     * Update user's login details.
     *
     * @param User $user
     * @param UpdateLoginDetailsRequest $request
     * @return mixed
     */
    public function updateLoginDetails(User $user, UpdateLoginDetailsRequest $request)
    {
        $data = $request->all();

        if (trim($data['password']) == '') {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        $this->users->update($user->id, $data);

        event(new UpdatedByAdmin($user));

        return redirect()->route('user.edit', $user->id)
            ->withSuccess(trans('app.login_updated'));
    }

    /**
     * Removes the user from database.
     *
     * @param User $user
     * @return $this
     */
    public function delete(User $user)
    {
        if ($user->id == Auth::id()) {
            return redirect()->route('user.list')
                ->withErrors(trans('app.you_cannot_delete_yourself'));
        }

        $this->users->delete($user->id);

        event(new Deleted($user));

        return redirect()->route('user.list')
            ->withSuccess(trans('app.user_deleted'));
    }

    /**
     * Displays the list with all active sessions for selected user.
     *
     * @param User $user
     * @param SessionRepository $sessionRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sessions(User $user, SessionRepository $sessionRepository)
    {
        $adminView = true;
        $sessions = $sessionRepository->getUserSessions($user->id);

        return view('user.sessions', compact('sessions', 'user', 'adminView'));
    }

    /**
     * Invalidate specified session for selected user.
     *
     * @param User $user
     * @param $session
     * @param SessionRepository $sessionRepository
     * @return mixed
     */
    public function invalidateSession(User $user, $session, SessionRepository $sessionRepository)
    {
        $sessionRepository->invalidateSession($session->id);

        return redirect()->route('user.sessions', $user->id)
            ->withSuccess(trans('app.session_invalidated'));
    }
}

