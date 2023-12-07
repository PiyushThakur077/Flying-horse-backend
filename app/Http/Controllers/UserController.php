<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NewUserNotification;
use App\Notifications\PasswordChange;
use Illuminate\Support\Str;
use App\Helpers\HelperFunctions;
use App\Models\TeamUser;
use App\Models\UserStatusLog;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.view');
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function datatable()
    {
        return datatable(User::datatable())
            ->addColumns([
                'actions' => function ($data) {
                    $csrf = csrf_field();
                    $editUrl = route('users.edit', $data->id);
                    $deleteUrl = route('users.destroy', $data->id);
                    $deleteFormId = 'deleteForm_' . $data->id;
                    $isTemMember  = TeamUser::where('user_id', $data->id)->exists();
                    return "<td>
                        <a href='$editUrl' class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i></a>&nbsp
                        <form method='post' id='$deleteFormId' action='$deleteUrl' style='display: inline'>
                        $csrf 
                        <input type='hidden' name='_method' value='DELETE'>
                        <button type='submit'  data-team='$isTemMember' data-form='$deleteFormId' class='btn btn-xs btn-danger delete-warning'>
                            <i class='glyphicon glyphicon-trash'></i>
                        </button>
                        </form>
                    </td>";
                },
                'timer' => function($data) {
                    if( $data->started_at )
                    {
                        $to = Carbon::now();
                        $from = Carbon::parse($data->started_at);
                        $hours = $to->diffInHours($from);
                        $minutes =  $to->diffInMinutes($from) % 60;
                        $seconds =  $to->diffInSeconds($from) % 60 ;
                        return "<span id='$data->id'></span><script>showTimer($hours,$minutes,$seconds, $data->id);</script>";
                    }
                    return "-";
                  
                }
            ])->init();
    }

   
  public function userlist()
    {
        $teams = Team::all();
        $userIdsArray = [];
        foreach ($teams as $team) {
            $userIdsArray[] = json_decode($team->user_ids);
        }

        $extractedNumbers = [];
        foreach ($userIdsArray as $userIds) {
            foreach ($userIds as $userId) {
                $userId = str_replace(['\\', '"'], '', $userId);
                $extractedNumbers[] = $userId;
            }
        }

        return datatable(User::datatable())
            ->addColumns([
                'name' => function ($data) use ($extractedNumbers) {
                    $isDisabled = in_array($data->id, $extractedNumbers);
                    $isChecked = $isDisabled ? 'checked' : '';
                    $disabledClass = $isDisabled ? 'disabled-checkbox' : '';

                    $checkbox = '<input type="checkbox" class="user-checkbox ' . $disabledClass . '" value="' . $data->id . '" ';
                    $checkbox .= $isDisabled ? 'disabled ' : '';
                    $checkbox .= $isChecked . '>';

                    return $checkbox . ' ' . $data->name;
                }
            ])->init();
    }

    public function userlistedit()
    {
        $teams = Team::all();
        $userIdsArray = [];
        foreach ($teams as $team) {
            $userIdsArray= [ ... $userIdsArray, ... json_decode($team->user_ids)];
        }
       

        return datatable(User::datatable())
            ->addColumns([
                'name' => function ($data) use ($userIdsArray)  {
                    $isDisabled = in_array($data->id, $userIdsArray);
                    $isChecked = $isDisabled ? 'checked' : '';
                    $disabledClass = $isDisabled ? 'disabled-checkbox' : '';

                    $checkbox = '<input type="checkbox" class="user-checkbox ' . $disabledClass . '" value="' . $data->id . '" ';
                    $checkbox .= $isDisabled ? 'disabled ' : '';
                    $checkbox .= $isChecked . '>';

                    return $checkbox . ' ' . $data->name;
                    $checkbox = '<input type="checkbox" class="user-checkbox" value="' . $data->id . '">';
                    return $checkbox . ' ' . $data->name;
                }
            ])->init();
    }
    
    public function updateTeam(Request $request, $teamId)
    {
        $teamTitle = $request->input('teamTitle');
        $tmId = $request->input('tmId');
        $selectedUsers = $request->input('selectedUsers');

        $team = Team::find($teamId);

        if (!$team) {
            return response()->json(['error' => 'Team not found'], 404);
        }

        $team = Team::where('id', $tmId)->first();
        $team->update([
            'title' => $teamTitle,
            'user_ids' => json_encode($selectedUsers)
        ]);

        $team->users()->sync($selectedUsers);

        return response()->json(['message' => 'Team updated successfully']);
    }
    


    public function createTeam(Request $request)
    {
        $teamTitle = $request->input('teamTitle');
        $selectedUsers = $request->input('selectedUsers');

        $serializedUsers = json_encode($selectedUsers);
        DB::beginTransaction();
        try {
            $team = new Team([
                'title' => $teamTitle,
                'user_ids' => $serializedUsers, 
            ]);
    
            $team->save();
    
            $team->users()->sync($selectedUsers);

            DB::commit();
        } catch( \Exception $e ){
            DB::rollBack();
            return response()->json(['message' => 'Something Went Wrong Please try again'],500);
        }
      

        return response()->json(['message' => 'Team created successfully']);
    }

    public function showTeams()
    {
        $teams = Team::all();
        
        foreach ($teams as $team) {
            $userIds = json_decode($team->user_ids);
            
            $users = User::whereIn('id', $userIds)
                          ->where('active', 1)
                          ->get();
    
            foreach ($users as $user) {
                $status = Status::where('id', $user->status_id)->first();
                $user->status = $status;
            }
    
            $team->users = $users;
        }
        
        return view('admin.teams.view', compact('teams'));
    }
    


    public function deleteTeam($teamId)
    {
        $team = Team::find($teamId);

        if (!$team) {
            return response()->json(['error' => 'Team not found'], 404);
        }

        TeamUser::where('team_id', $team->id)->delete();

        $team->delete();


        return response()->json(['message' => 'Team deleted successfully']);
    }


    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,NULL,id,active,1',
            'phone' => 'nullable|numeric|digits:10|unique:users,phone,NULL,id,active,1',
        ];
    
        if ($request->filled('password')) {
            $rules['password'] = 'nullable|min:8';
        }
    
        $request->validate($rules);
    
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }
    
        $randomPassword = HelperFunctions::generateRandomPassword(8);
    
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->image = $avatarPath;
    
        $existingUser = User::where('email', $request->email)
        ->where('role', '!=', 'admin')
        ->where('active', 0)
        ->first();

        if ($existingUser) {
            $existingUser->active = 1;
            $existingUser->name = $request->name;
            $existingUser->phone = $request->phone;
            $existingUser->image = $avatarPath;
            $existingUser->status_id = null;
            $existingUser->save();
    
            if ($request->input('password') !== null && $request->input('password') !== '') {
                $user->password = Hash::make($request->input('password'));
                $passwordToSend = $request->input('password');
            } else {
                $user->password = Hash::make($randomPassword);
                $passwordToSend = $randomPassword;
            }
        } else {
            if ($request->input('password') !== null && $request->input('password') !== '') {
                $user->password = Hash::make($request->input('password'));
                $passwordToSend = $request->input('password');
            } else {
                $user->password = Hash::make($randomPassword);
                $passwordToSend = $randomPassword;
            }
            $user->save();
        }
    
        $user->notify(new NewUserNotification($user, $passwordToSend));
    
        return redirect()->route('admin.dashboard')->with('success', 'User added successfully.');
    }
    

    public function destroy(Int $id)
    {
        $user = User::find($id);

        if( $user ) 
        {
            DB::beginTransaction();
            try {
                $teams = TeamUser::where('user_id', $id)->pluck('team_id');
                TeamUser::whereIn('team_id',  $teams)->delete();
                Team::whereIn('id', $teams )->delete();
                // UserStatusLog::where('user_id', $id)->delete();
                $user->tokens()->delete();
                $user->status_id = null;
                $user->active = 0 ;
                $user->update();
                DB::commit();
            } catch( \Exception $e ) {
                DB::rollBack();
                return back()->with('error', 'Something went wrong, please try again');
            } 
            return back()->with('success', 'User Deleted Successfully');
        }
        return back()->with('error', 'User Not Found');
    }

    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'phone' => 'nullable|numeric|digits:10|unique:users,phone,' . $id,
                'password' => 'nullable|min:8|confirmed',
            ]);

            $user = User::findOrFail($id);

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');

            if ($request->has('password') && !empty($request->input('password'))) {
                if ($request->input('password') !== $request->input('password_confirmation')) {
                    return redirect()->back()->withInput();                
                }
                $user->password = Hash::make($request->input('password'));
            }
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $avatarPath = $avatar->storeAs('avatars', $id . '.' . $avatar->getClientOriginalExtension(), 'public');
                $user->image = $avatarPath;
            }

            $user->save();

            if ($request->input('password') != '') {
                $user->notify(new PasswordChange($user, $request->input('password')));
            }


            return redirect()->route('admin.dashboard')->with('success', 'User Updated successfully.');
        }



    public function editTeam($id)
    {
        $team = Team::findOrFail($id);
        $team->users = json_decode($team->user_ids);
        return response()->json(['team' => $team]);
    }
    
}
