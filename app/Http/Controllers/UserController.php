<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NewUserNotification;
use Illuminate\Support\Str;
use App\Helpers\HelperFunctions;

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
    
                    return "<td>
                        <a href='$editUrl' class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i></a>&nbsp
                        <form method='post' id='deleteForm' action='$deleteUrl' style='display: inline'>
                            $csrf 
                            <input type='hidden' name='_method' value='DELETE'>
                            <button type='submit' data-form='deleteForm' class='btn btn-xs btn-danger delete-warning'>
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

        \Illuminate\Support\Facades\Log::info(json_encode($extractedNumbers));

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
        return datatable(User::datatable())
            ->addColumns([
                'name' => function ($data) {
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

        Team::where('id', $tmId)
        ->update([
            'title' => $teamTitle,
            'user_ids' => json_encode($selectedUsers)
        ]);

        return response()->json(['message' => 'Team updated successfully']);

        dd($request);
    }
    


    public function createTeam(Request $request)
    {
        $teamTitle = $request->input('teamTitle');
        $selectedUsers = $request->input('selectedUsers');

        $serializedUsers = json_encode($selectedUsers);

        $team = new Team([
            'title' => $teamTitle,
            'user_ids' => $serializedUsers, 
        ]);

        $team->save();

        return response()->json(['message' => 'Team created successfully']);
    }

    public function showTeams()
    {
        $teams = Team::all();

        foreach ($teams as $team) {
            $userIds = json_decode($team->user_ids);

            $users = User::whereIn('id', $userIds)->get();

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

        $team->delete();

        return response()->json(['message' => 'Team deleted successfully']);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
        ]);

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
        $user->password = Hash::make($randomPassword);
        $user->save();

        $user->notify(new NewUserNotification($user, $randomPassword));

        return redirect()->route('admin.dashboard')->with('success', 'User added successfully.');
    }

    public function destroy(Int $id)
    {
        $user = User::find($id);

        if( $user ) {
            $user->active = 0 ;
            $user->update();

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
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarPath = $avatar->storeAs('avatars', $id . '.' . $avatar->getClientOriginalExtension(), 'public');
            $user->image = $avatarPath;
        }

        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User Updated successfully.');
    }

    public function editTeam($id)
    {
        $team = Team::findOrFail($id);
        $team->users = json_decode($team->user_ids);
        return response()->json(['team' => $team]);
    }
    
}
