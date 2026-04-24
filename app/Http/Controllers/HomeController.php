<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $services = [
            [
                'title' => 'Сантехники',
                'img' => 'assets/img/icons/water-pipe.png'
            ],
            [
                'title' => 'Электрики',
                'img' => 'assets/img/icons/thunder.png'
            ],
            [
                'title' => 'Мебели',
                'img' => 'assets/img/icons/table.png'
            ],
            [
                'title' => 'Кухонь',
                'img' => 'assets/img/icons/kitchen-table.png'
            ],
            [
                'title' => 'Ванн',
                'img' => 'assets/img/icons/shower.png'
            ],
            [
                'title' => 'Техники',
                'img' => 'assets/img/icons/gears.png'
            ],
        ];
        return view('index', compact('services'));
    }

    public function catalog()
    {

        $categories = DB::table('categories')->get();
        $services = [];

        foreach ($categories as $category) {
            $services_temp = DB::table("services")
                ->where('category_id', $category->id)
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('service_master_relationship')
                        ->whereColumn('service_master_relationship.service_id', 'services.id');
                })
                ->select(
                    'services.*',
                    DB::raw('(
            SELECT MIN(price)
            FROM service_master_relationship
            WHERE service_master_relationship.service_id = services.id
        ) as min_price')
                )
                ->get();
            $services[$category->id] = $services_temp;
        }

        return view('catalog', compact('categories', "services"));
    }

    public function service_masters($service_id)
    {
        $masters = DB::table('service_master_relationship')
            ->join('masters', 'service_master_relationship.master_id', '=', 'masters.id')
            ->leftJoin('reviews', 'masters.id', '=', 'reviews.master_id')
            ->where('service_master_relationship.service_id', $service_id)
            ->select(
                'masters.*',
                'service_master_relationship.price',
                DB::raw('COALESCE(ROUND(AVG(reviews.value), 1), 0) as rating'),
            )
            ->groupBy(
                'masters.id',
                'masters.name',
                'masters.img',
                'service_master_relationship.price'
            )
            ->get();
        return view("masters", compact('masters', 'service_id'));
    }

    public function call_master_page($service_id, $master_id)
    {
        return view('call_master', compact('service_id', 'master_id'));
    }

    public function create_call_master(Request $request)
    {

        $request->validate([
            'phone' => 'required|min:10|max:12',
            'address' => 'required|min:10|max:255',
            'preferred_time' => 'required',
            'date' => 'required',
        ], [
                'phone.required' => 'Пожалуйста, укажите контактный номер.',
                'phone.min' => 'Пожалуйста, укажите корректный контактный номер.',
                'phone.max' => 'Пожалуйста, укажите корректный контактный номер.',

                'address.required' => 'Пожалуйста, укажите адрес на который прибудет специалист.',
                'address.min' => 'Указанный адрес слишком короткий.',
                'address.max' => 'Указанный адрес слишком длинный.',

                'preferred_time.required' => 'Пожалуйста, укажите время когда вам будет удобно что бы подъехал специалист.',
                'date.required' => 'Пожалуйста, укажите дату в которую вам будет удобно принять специалиста.'

            ]
        );
        DB::table('calls_master')->insert(['user_id' => $request->user()->id, 'service_id' => $request->service_id, 'master_id' => $request->master_id, 'phone' => $request->phone, 'address' => $request->address, 'preferred_time' => $request->preferred_time, 'date' => $request->date, 'comment' => $request->comment]);

        return redirect(route('index'));

    }

    public function profile()
    {
        $user = DB::table('users')->where('id', Auth::user()->id)->first();
        $calls_master = DB::table('calls_master')->orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)
            ->join('masters', 'calls_master.master_id', '=', 'masters.id')
            ->join('services', 'calls_master.service_id', '=', 'services.id')
            ->join('call_status', 'calls_master.status_id', '=', 'call_status.id')
            ->select(
                'calls_master.*',
                'masters.name as master_name',
                'services.title as service_title',
                'services.id as service_id',
                'call_status.name as status_name',
                'call_status.id as status_id',
            )
            ->get();

        foreach ($calls_master as $call_master) {
            if ($call_master->status_id == 5) {
                $call_master->opportunity_review = false;
                continue;
            }
            if ($call_master->status_id != 4) {
                $call_master->opportunity_review = false;
                continue;
            }
            $review_existence = DB::table('reviews')->where('master_id', $call_master->master_id)->where('user_id', Auth::user()->id)->first();
            if ($review_existence) {
                $call_master->opportunity_review = false;
                continue;
            }
            $call_master->opportunity_review = true;
        }
        return view('profile', compact('user', 'calls_master'));
    }

    public function decline_call_master(Request $request)
    {
        DB::table('calls_master')->where('id', $request->call_id)->update(['status_id' => 5]);
        return back();
    }

    public function send_review_page($service_id, $master_id, Request $request)
    {

        return view('write_review', compact('master_id', 'service_id'));

    }

    public function send_review(Request $request)
    {
        $request->validate([
            'rating' => 'required|min:1|max:5',
            'message' => 'required',
        ]);

        DB::table('reviews')->insert(['master_id' => $request->master_id, 'user_id' => $request->user()->id, 'comment' => $request->message, 'value' => $request->rating]);
        return redirect(route('profile'));
    }

    public function master_page($master_id)
    {
        $master_data = DB::table('masters')->where('masters.id', $master_id)
            ->leftJoin('reviews', 'masters.id', '=', 'reviews.master_id')
            ->select(
                'masters.*',
                DB::raw('COALESCE(ROUND(AVG(reviews.value), 1), 0) as rating')
            )
            ->groupBy(
                'masters.id',
                'masters.name',
                'masters.img',
            )
            ->first();

        $services = DB::table('service_master_relationship')->where('master_id', $master_id)
            ->join("services", "service_master_relationship.service_id", "=", "services.id")
            ->select(
                'services.title as service_title',
                'services.id as service_id'
            )->get();

        $reviews = DB::table('reviews')->where('master_id', $master_id)
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->select(
                "reviews.comment as review_comment",
                "reviews.value as review_value",
                "users.name as user_name",
                "users.img as user_img",
            )->get();
        return view('master', compact('master_data', 'services', 'reviews'));
    }

    public function our_us_page()
    {
        return view('our_us');
    }

}
