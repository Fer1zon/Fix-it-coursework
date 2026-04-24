<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $masters_count = DB::table('masters')->count();
        $users_count = DB::table('users')->count();
        $calls_count = DB::table('calls_master')->count();
        $average_rating = DB::table('reviews')
        ->selectRaw('AVG(value) as average_rating')
        ->pluck('average_rating')->first();
        $last_call = DB::table('calls_master')->latest()->pluck('created_at')->first();
        return view('admin.index', compact('masters_count', 'users_count', 'calls_count', 'average_rating', 'last_call'));
    }

    public function masters()
    {
        $masters = DB::table('masters')
            ->leftJoin('reviews', 'masters.id', '=', 'reviews.master_id')
            ->leftJoin("calls_master", "masters.id", "=", "calls_master.master_id")
            ->select(
                'masters.*',
                DB::raw('COALESCE(ROUND(AVG(reviews.value), 1), 0) as rating'),
                DB::raw('COALESCE(COUNT(DISTINCT calls_master.*), 0) as calls_count')

            )
            ->groupBy(
                'masters.id',
                'masters.name',
                'masters.img',
            )
            ->get();
        return view('admin.masters', compact('masters'));
    }

    public function update_master(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if($request->hasFile('img')){
            $old = DB::table('masters')->where('id', $request->id)->value('img');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);

            }
            $path = $request->file('img')->store('masters', 'public');
            DB::table('masters')->where('id', $request->id)->update(["name" => $request->name, "img" => $path]);
        }
        else{
            DB::table('masters')->where('id', $request->id)->update(["name" => $request->name]);

        }
        return back();

    }

    public function create_master(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if($request->hasFile('img')){

            $path = $request->file('img')->store('masters', 'public');
            DB::table('masters')->insert(["name" => $request->name, "img" => $path]);
        }
        else{
            DB::table('masters')->insert(["name" => $request->name]);
        }
        return back();

    }

    public function delete_master($id){
        DB::table('masters')->where('id', $id)->delete();
        return back();
    }

    public function master_services($master_id)
    {
        $name = DB::table('masters')->where('id', $master_id)->value('name');
        $master_services = DB::table('service_master_relationship')->where('master_id', $master_id)
            ->leftJoin('services', 'services.id', '=', 'service_master_relationship.service_id')
            ->select(
                [
                    'service_master_relationship.id as relation_id',
                    'services.id',
                    'service_master_relationship.price as price',
                    'services.title',

                    ]
            )
            ->get();

        $available_services = DB::table('services')
            ->select('services.id', 'services.title')
            ->whereNotExists(function ($query) use ($master_id) {
                $query->select(DB::raw(1))
                    ->from('service_master_relationship')
                    ->whereColumn('service_master_relationship.service_id', 'services.id')
                    ->where('service_master_relationship.master_id', '=', $master_id);
            })
            ->get();

        return view('admin.master_services', compact('name', 'master_services', 'available_services', 'master_id'));
    }

    public function update_master_service(Request $request){
        $request->validate([
            'price' => "required|numeric|min:0",
        ]);

        DB::table('service_master_relationship')->where('id', $request->relation_id)->update(["price" => $request->price]);
        return back();

    }
    public function add_master_service(Request $request){

        DB::table("service_master_relationship")->insert(["service_id" => $request->service_id, "master_id" => $request->master_id]);
        return back();
    }

    public function delete_master_service($relation_id){
        DB::table('service_master_relationship')->where('id', $relation_id)->delete();
        return back();
    }


    public function categories(){
        $categories = DB::table('categories')->orderBy('created_at', 'desc')->get();
        return view('admin.categories', compact('categories'));
    }

    public function update_category(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if($request->hasFile('img')){
            $old = DB::table('categories')->where('id', $request->id)->value('img');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);

            }
            $path = $request->file('img')->store('categories', 'public');
            DB::table('categories')->where('id', $request->id)->update(["title" => $request->name, "img" => $path]);
        }
        else{
            DB::table('categories')->where('id', $request->id)->update(["title" => $request->name]);

        }
        return back();
    }

    public function create_category(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('img')->store('categories', 'public');
        DB::table('categories')->insert(["title" => $request->name, "img" => $path]);
        return back();
    }

    public function delete_category($id)
    {
        DB::table('categories')->where('id', $id)->delete();
        return back();
    }




    public function services($category_id){
        $services = DB::table('services')->orderBy('created_at', 'desc')
            ->where('category_id', $category_id)
            ->get();
        $categories = DB::table('categories')->orderBy('created_at', 'desc')->get();
        return view('admin.services', compact('services', 'categories', 'category_id'));
    }

    public function update_service(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|numeric|exists:services,id',
            'title' => 'required|string|max:255',
            'category' => 'required|integer|exists:categories,id',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($request->hasFile('img')){
            $old = DB::table('services')->where('id', $request->id)->value('img');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $path = $request->file('img')->store('services', 'public');
            DB::table('services')->where('id', $request->id)->update(["title" => $request->title, "img" => $path, 'category_id' => $request->category]);
        }
        else{
            DB::table('services')->where('id', $request->id)->update(["title" => $request->title, 'category_id' => $request->category]);
        }
        return back();

    }
    public function create_service(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|integer|exists:categories,id',
            'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $path = $request->file('img')->store('services', 'public');
        DB::table('services')->insert(["title" => $request->title, "img" => $path, 'category_id' => $request->category]);
        return back();
    }

    public function delete_service($category_id, $id)
    {
        DB::table('services')->where('id', $id)->delete();
        return back();
    }


    public function calls_master()
    {
        $calls = DB::table('calls_master')->orderBy('calls_master.created_at', 'desc')
            ->join('services', 'calls_master.service_id', '=', 'services.id')
            ->join('masters', 'calls_master.master_id', '=', 'masters.id')
            ->join('users', 'calls_master.user_id', '=', 'users.id')
            ->select(
                [
                    'calls_master.id as call_id',
                    'calls_master.finish_price',
                    'calls_master.status_id',
                    'calls_master.phone as contact_phone',
                    'calls_master.address as address',
                    'calls_master.preferred_time as preferred_time',
                    'calls_master.date as preferred_date',
                    'users.name as user_name',
                    'masters.name as master_name',
                    'services.title as service_name',
                ]
            )
            ->get();


        $statuses = DB::table('call_status')
            ->select(
                [
                    'call_status.id',
                    'call_status.name',
                ]
            )->get();
        return view('admin.calls_master', compact('calls', 'statuses'));
    }

    public function update_call_master(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|numeric|exists:calls_master,id',
            'status_id' => 'required|numeric|exists:call_status,id',
        ]);
        DB::table('calls_master')->where('id', $request->id)->update(["status_id" => $request->status_id, "finish_price" => $request->finish_price]);
        return back();
    }

    public function delete_call_master($id)
    {
        DB::table('calls_master')->where('id', $id)->delete();
        return back();
    }

    public function users()
    {
        $users = DB::table('users')->orderBy('created_at', 'desc')->get();
        $roles = DB::table('roles')->get();

        return view('admin.users', compact('users', 'roles'));
    }

    public function user_update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|numeric|exists:users,id',
            'role_id' => 'required|numeric|exists:roles,id',
        ]);

        DB::table('users')->where('id', $request->id)->update(["role_id" => $request->role_id]);
        return back();
    }
}
