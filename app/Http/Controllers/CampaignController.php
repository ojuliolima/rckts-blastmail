<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class CampaignController extends Controller
{
    public function index()
    {
        $search = request()->get('search', null);
        $withTrashed = request()->get('withTrashed', false);

        return view ('campaigns.index', [
            'campaigns' => Campaign::query()
            ->when($withTrashed, fn(Builder $query) => $query->withTrashed())
            ->when($search, fn(Builder $query) => $query->where('name', 'like', "%$search%")->orWhere('id', '=', $search))
            ->paginate(5)
            ->appends(compact('search', 'withTrashed')),
            'search' => $search,
            'withTrashed' => $withTrashed,
        ]);
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return back()->with('message', __('Campaign successfully deleted!'));
    }

    public function restore(Campaign $campaign)
    {
        //por padrão valores deletados não são buscados com soft delete, esse trecho foi resumido na rota
        //$campaign = Campaign::query()->withTrashed()->find($campaign);

        $campaign->restore();

        return back()->with('message', __('Campaign successfully restored!'));
    }
}
