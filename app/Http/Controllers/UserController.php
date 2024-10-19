<?php

namespace App\Http\Controllers;

use App\Models\Coordinator;
use App\Models\User;
use App\Service\IndicadoresProjetos;
use App\Utils\DashboardObserver\ProcessarDados;
use App\Utils\DashboardObserver\QueryDashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use function PHPSTORM_META\map;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'coordinator'])->get();
        return Inertia::render('User/Index', compact('users'));
    }

    public function store(Request $request)
    {
        //TODO:Fazer validação
        DB::beginTransaction();
        try {
            if (User::where('email', $request->email)->exists())
                return back()->withErrors(['message' => 'O e-mail já está sendo usado por outro usuário.']);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'password' => Hash::make($request->password)
            ]);
            $user->assignRole($request->role);

            if ($request->role === "Coordenador") {
                Coordinator::create([
                    'user_id' => $user->id,
                    'ppg_id' => $request->ppg
                ]);
            }
            DB::commit();
            return back()->with('success', 'Usuario criado com sucesso!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors('Erro ao criar usuario!');
        }
    }

    public function update(User $user, Request $request, )
    {
        //TODO:FAZER VALIDAÇÂO
        $data = $request->all();
        if (!$data['password']) {
            unset($data['password']);
        }
        $user->update($data);

        if ($data['role'] === "Coordenador") {
            $user->coordinator->update(
                [
                    'user_id' => $user->id,
                    'ppg_id' => $data['ppg']
                ]
            );
        }

        return back()->with('success', 'Usuário atualizado com sucesso');
    }
    public function destroy(User $user, Request $request)
    {
        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();
            return back()->with('success', 'Usuário excluído com sucesso');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'Não foi possível deletar o usuário']);
        }
    }
}
