<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Afficher le tableau de bord admin
     */
    public function index()
    {
        $user = auth()->user();

        // Statistiques générales
        $stats = [
            'total_users' => User::count(),
            'total_candidates' => User::where('role', 'candidate')->count(),
            'total_recruiters' => User::where('role', 'recruiter')->count(),
            'pending_recruiters' => User::where('role', 'recruiter')->where('is_validated', false)->count(),
            'total_jobs' => 0, // TODO: Ajouter quand le modèle Job sera créé
            'total_applications' => 0, // TODO: Ajouter quand le modèle Application sera créé
        ];

        return view('admin.dashboard', compact('user', 'stats'));
    }

    /**
     * Afficher la liste des recruteurs en attente de validation
     */
    public function pendingRecruiters()
    {
        $recruiters = User::where('role', 'recruiter')
            ->where('is_validated', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.recruiters.pending', compact('recruiters'));
    }

    /**
     * Valider un recruteur
     */
    public function validateRecruiter($id)
    {
        $recruiter = User::findOrFail($id);

        if ($recruiter->role !== 'recruiter') {
            return back()->withErrors(['error' => 'Cet utilisateur n\'est pas un recruteur.']);
        }

        $recruiter->update(['is_validated' => true]);

        return back()->with('success', 'Le recruteur a été validé avec succès.');
    }

    /**
     * Gérer tous les utilisateurs
     */
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }
}
