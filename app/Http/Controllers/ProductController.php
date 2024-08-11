<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * @var Product|null 产品模型
     */
    public ?Product $model = null;

    public function __construct()
    {
        $this->model = new Product();
    }

    public function showCreateForm(Request $request): Factory|View|Application
    {
        return view('product.create');
    }

    /**
     * 创建新产品
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function create(Request $request): RedirectResponse
    {
        // 获取请求数据
        $data = $request->all();
        try {
            // 验证数据
            $validateData = $this->model->validate($data);
            // 保存到数据库
            Product::create($validateData);
            // 重定向到产品列表
            // 如果成功创建产品，则重定向到产品列表
            return redirect()->route('product.index');
        } catch (ValidationException $e) {
            // 验证失败，返回错误信息
            return redirect()->back()->withErrors($e->errors());
        }
    }

    /**
     * 显示所有产品
     *
     * @return Factory|View|Application
     */
    public function index(Request $request): \Illuminate\View\View
    {

        $products = Product::all();

        return view('product.index', compact('products'));
    }

    /**
     * 显示产品详情
     *
     * @param $id
     * @return Factory|View|Application
     */

    public function show($id): Factory|View|Application
    {
        $product = Product::find($id);
        return view('product.show', ['product' => $product]);
    }

    /**
     * 删除商品
     *
     * @param $id
     * @return RedirectResponse
     */

    public function delete($id): RedirectResponse
    {
        product::destroy($id);
        return redirect()->route('product.index');
    }

    /**
     * 编辑商品
     *
     * @param $id
     * @return Factory|View|Application
     */
    public function edit($id): Factory|View|Application
    {
        $product =Product::find($id);
        return view('product.edit', ['product' => $product]);
    }

    /**
     * 更新商品
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
       // 验证请求数据
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // 绑定数据到 Product 模型
        $product = Product::findOrFail($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');

        // 保存更新后的数据到数据库
        $product->save();

        return redirect()->route('product.index');
    }

    /**
     * 搜索商品
     *
     * @param Request $request
     * @return Application|Factory|View|void
     */
    public function search(Request $request)
    {
        // 处理搜索请求，根据输入搜索产品
        // 然后返回搜索结果页面
        $query = $request->input('search');

        if ($query) {
            $products = Product::where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->get();

            return view('product.search', compact('products', 'query'));
        }
    }




}
