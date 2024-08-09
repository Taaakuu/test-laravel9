@extends('layout')

@section('title', '商品列表')

@section('content')
<div class="card mt-5">
    <div class="card-body">
        <h2>商品列表</h2>
        <hr>
        <!-- 搜索表单 -->
        <form action="{{ route('product.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="搜索商品" value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">搜索</button>
            </div>
        </form>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">商品名称</th>
                <th scope="col">商品描述</th>
                <th scope="col">单价</th>
                <th scope="col">库存</th>
                <th scope="col">创建时间</th>
                <th scope="col">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
            <tr>
                <th scope="row">{{ $product->id }}</th>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->created_at }}</td>
                <td>
                    <a href="{{ route('product.show', $product->id) }}" class="btn btn-info btn-sm">详情</a>
                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary btn-sm">编辑</a>
                    <a href="{{ route('product.delete', $product->id) }}" class="btn btn-danger btn-sm">删除</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
