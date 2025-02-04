<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class SubscriberController extends Controller
{
    public function index(EmailList $emailList)
    {
        $search = request()->search;

        return view('subscriber.index', [
            'emailList' => $emailList,
            'subscribers' => $emailList->subscribers()
                ->with('emailList')
                ->when($search, fn (Builder $query) => $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('id', '=', $search)
                )
                ->paginate(),
            'search' => $search,
        ]);
    }

    public function destroy(mixed $list, Subscriber $subscriber)
    {
        $subscriber->delete();

        return back()->with('message', __('Subscriber deleted from the list!'));
    }
}
