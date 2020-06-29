@php
    $setting = \App\Models\Setting::first();
@endphp
<div class="sidebar_social">
    <div class="title">
        <img src="{{asset('images/logo.png')}}">
        <p class="h6 text-center">Customer Careline</p>
        <div class="line mb-3"></div>
    </div>
    <ul>
        @if ($setting->whatsapp)
            <li>
                <img src="{{asset('web/images/social/whatsapp.png')}}" alt="">
                <a href="https://api.whatsapp.com/send?phone={{$setting->whatsapp}}&text=Customer" title="WhatsApp" target="_blank">
                    <p class="h5 mb-0">{{$setting->whatsapp}}</p><p class="text-muted">WhatsApp</p>
                </a>
            </li>
        @endif
        @if ($setting->telegram)
            <li><img src="{{asset('web/images/social/telegram.png')}}" alt="">
                <a href="https://t.me/{{$setting->telegram}}" title="Telegram" target="_blank">
                    <p class="h5 mb-0">{{$setting->telegram}}</p>
                    <p class="text-muted">Telegram</p>
                </a>
            </li>
        @endif
        @if ($setting->mobile)
            <li>
                <img src="{{asset('web/images/social/mobile.png')}}" alt="">
                <a href="tel:{{$setting->mobile}}" title="Mobile" target="_blank">
                    <p class="h5 mb-0">{{$setting->mobile}}</p>
                    <p class="text-muted">Mobile</p>
                </a>
            </li>
        @endif
    </ul>
</div>