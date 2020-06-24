
            <p> Дорогой <b>{{$name}}!!</b></p>
            <h1> Ваш заказ № {{$order->id}}  @lang('mail.order_created.your_order')
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Кол-во</th>
                    <th>Цена</th>
                    <th>Стоимость</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->products as $product)
                    <tr>
                        <td>
                            <a href="{{route('product',[$product->category->code,$product->code])}}">
                                <img height="56px"
                                     src="{{Storage::url($product->image)}}">
                                {{$product->name}}
                            </a>
                        </td>
                        <td><span class="badge"> {{$product->pivot->count}}</span></td>
                        <td>{{$product->price}} ₽</td>
                        <td>{{$product->getPriceForCount()}} ₽</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">Общая стоимость:</td>
                    <td>{{$order->calculateFullSum()}} ₽</td>
                </tr>
                </tbody>
            </table>




