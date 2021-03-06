@foreach ($products as $product)
<div class="col-12 col-sm-6 col-md-6 col-lg-4">
    <article class="article article-style-b">
        <div class="article-header">
            <div
                class="article-image"
                data-background="https://demo.getstisla.com/assets/img/news/img13.jpg">
            </div>
            <div class="article-badge">
                <div
                    class="article-badge-item bg-{{($product->stock > 0) ? 'success' : 'danger'}}"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Stok Tersedia"
                >
                    <i class="fas fa-layer-group"></i>
                    {{$product->stock}}
                </div>
            </div>
        </div>
        <div class="article-details">
            <div class="article-title">
                <b>{{$product->name}}</b>
            </div>
            <div class="article-cta">
                @if ($transaction)
                <form
                    action="{{ route('admin.transactions.item', ['transaction_id' => (($transaction) ? $transaction->id : ''), 'product_id' => $product->id]) }}"
                    method="post"
                >
                    @csrf
                    @method('PUT')
                    <button
                        class="btn btn-primary"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Tambah ke Cart"
                        type="submit"
                        onclick="showLoading()"
                    >
                        <i class="fas fa-plus"></i>
                    </button>
                </form>
                @endif
            </div>
        </div>
        <div class="article-footer bg-whitesmoke p-2 text-center">
            @php
                \Carbon\Carbon::setLocale('id');
                $carbonated_date = Carbon\Carbon::parse(date('d M Y', strtotime($product->expired_date)));
                $diff_date = $carbonated_date->diffForHumans(Carbon\Carbon::now()->sub(1, 'day'));
            @endphp
            <span
                    class="article-badge-item"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Kedaluwarsa : {{date('d M Y', strtotime($product->expired_date))}}"
                >
                    Kedaluwarsa : {{ change_date_string($diff_date) }}
            </span>
        </div>
    </article>
</div>
@endforeach