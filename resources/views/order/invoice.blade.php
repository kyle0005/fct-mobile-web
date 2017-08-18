@extends("layout")
@section('content')
    <div class="invoice-container" id="invoice" v-cloak>
        <section class="list-container">
            @if ($entity->orderInvoice)
            <div class="line">
                <div class="left">申请状态</div>
                <div class="right status">
                    @{{ invoice.statusName }}
                </div>
            </div>
            @endif
            <div class="line">
                <div class="left">发票抬头</div>
                <div class="right">
                    @if ($entity->orderInvoice)
                        @{{ invoice.title }}
                    @else
                    <input type="text" class="right-inp" name="title" v-model="title">
                    @endif
                </div>
            </div>
            <div class="line">
                <div class="left">发票内容</div>
                <div class="right">
                    @if ($entity->orderInvoice)
                        @{{ invoice.content }}
                    @else
                    <select class="select" v-model="content">
                        <option value="工艺礼品">工艺礼品</option>
                    </select>
                    @endif
                </div>
            </div>
        </section>
        <section class="info">
            发票须知：<br>
            1、开票金额为用户实际支付金额（不含优惠）<br>
            2、未随箱寄出的纸质发票会在发货后15-30个工作日单独寄出<br>
            3、单笔订单只支持开具一种发票类型，如须增值税专用发票请联系客服处理
        </section>
        @if (!$entity->orderInvoice)
        <div class="sub-btn">
            <a href="javascript:;">
                <subpost :txt="subText" ref="subpost" @callback="sub" @succhandle="succhandle"></subpost>
            </a>
        </div>
        @endif
    </div>
@endsection
@section('javascript')
    <script>
        @if ($entity->orderInvoice)
        config.invoice = {!! json_encode($entity->orderInvoice, JSON_UNESCAPED_UNICODE) !!};
        @else
        config.invoiceUrl = "{{ url('my/orders/' . $entity->orderId . '/invoice') }}";
        @endif
    </script>
    <script src="{{ fct_cdn('/js/invoice.js') }}"></script>
@endsection