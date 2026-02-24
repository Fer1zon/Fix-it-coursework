<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $advantages = [
            [
                'title' => 'Скорость доставки',
                'description' => 'Наши склады расположены по всей России. Что гарантирует быструю доставку',
                'img' => 'assets/img/icons/ben.svg'
            ],
            [
                'title' => 'Безопастность сырья',
                'description' => 'Все из чего мы производим свою продукцию проходит тщательную экспертизу и обследования',
                'img' => 'assets/img/icons/Микроскоп.png'
            ],
            [
                'title' => 'Скидка 25%',
                "description" => 'Собери корзину от 3000р а мы подарим тебе скидку на первый заказ',
                'img' => 'assets/img/icons/coins.png'
            ]
        ];
        return view('index', compact('advantages'));
    }
    public function catalog(Request $request)
    {

        $products_query = DB::table("products");
        if ($request->has("categories"))
        {
            $products_query->whereIn("category_id", $request->categories);
        }
        if ($request->has("sort_price"))
        {
            $direction = $request->sort_price === 'desc' ? 'desc' : 'asc';
            $products_query->orderBy("price",$direction);
        }
        if ($request->has("search"))
        {
            $products_query->where("name","ILIKE","%".$request->search."%");
        }
        $products =$products_query->paginate(9);
        $categories = DB::table('category')->get();

        return view('catalog', compact('products', 'categories'));
    }

    public function add_to_cart(Request $request, $id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id]))
        {
            $cart[$id]["quantity"] += 1;
        }
        else
        {
            $product_data = DB::table("products")->where("id", $id)->first();
            $cart[$id] = ["quantity" => 1, "name" => $product_data->name, "description" => $product_data->description, "img" => $product_data->img, "max_quantity" => $product_data->quantity, "price" => $product_data->price, "in_order" => true];
        }

        session()->put('cart', $cart);
        return back();
    }

    public function remove_from_cart(Request $request, $id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id]))
        {
            if($cart[$id]["quantity"] - 1 <= 0)
            {
                unset($cart[$id]);
            }

            else
            {
                $cart[$id]["quantity"] -= 1;
            }
            session()->put('cart', $cart);
        }
        return back();

    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function create_order_c(Request $request)
    {
        $request->validate([
            'address' => 'required|min:10|max:255',
        ], [
            'address.required' => 'Пожалуйста, укажите адрес доставки.',
            'address.min' => 'Адрес слишком короткий, укажите город и улицу.',
            "address.max" => 'Адресс слишком велик, не передавайте лишнюю информацию'
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Ваша корзина пуста!');
        }

        $total_price = 0;
        $change_count = false;
        foreach ($cart as $id => $product)
        {
            $currency_count = DB::table('products')->where("id", $id)->first();
            if ($currency_count->quantity < $product["quantity"]){
                $change_count = true;
                $cart[$id]["quantity"] = $currency_count->quantity;
                $cart[$id]["max_quantity"] = $currency_count->quantity;
            }
            $total_price += $product["price"] * $product["quantity"];

        }
        if($change_count){
            session()->put('cart', $cart);
            return back()->with("error", "Количество товаров в каталоге изменилось и мы уменьшили их количество!");
        }


        $order_id = DB::table("orders")->insertGetId(["user_id" => $request->user()->id, "total_price" => $total_price, "address" => $request->address]);
        foreach ($cart as $id => $product)
        {
            DB::table("products")->where("id", $id)->decrement("quantity", $product["quantity"]);
            DB::table("order_component")->insert(["order_id"=>$order_id, "product_name" => $product["name"], "quantity" => $product["quantity"]]);
        }
        session()->forget('cart');
        return back();
    }


    public function orders(Request $request)
    {
        $orders = DB::table('orders')
            ->where('user_id', $request->user()->id)
            ->join("statuses", "orders.status_id", "=", "statuses.id")
            ->orderBy('create_at', 'desc')
            ->select('orders.*', 'statuses.name as status_name')
            ->get();

        $orderIds = $orders->pluck('id');

        // 3. Получаем все товары для этих заказов одним запросом
        $products = DB::table('order_component') // замените на имя вашей таблицы со связью
        ->whereIn('order_id', $orderIds)
            ->get()
            ->groupBy('order_id'); // Группируем товары по ID заказа

        // 4. Приклеиваем товары к заказам (имитируем связь Eloquent для Blade)
        foreach ($orders as $order) {
            $order->products = $products->get($order->id) ?? [];
        }
        return view('orders', compact('orders'));
    }

}




