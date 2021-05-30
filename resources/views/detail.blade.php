@extends('layouts.main')

@section('content')
    <div class="as-accessories-results  as-search-desktop">
        <div class="width:60%">
            <div class="as-producttile-tilehero with-paddlenav " style="float:left;">
                <div class="as-dummy-container as-dummy-img">

                    <img src="{{ asset('assets/wireless-headphones') }}"
                         class="ir ir item-image as-producttile-image  "
                         style="max-width: 70%;max-height: 70%;" alt="" width="445" height="445">
                </div>
                <div class="images mini-gallery gal5 ">


                    <div class="as-isdesktop with-paddlenav with-paddlenav-onhover">
                        <div class="clearfix image-list xs-no-js as-util-relatedlink relatedlink"
                             data-relatedlink="6|Powerbeats3 Wireless Earphones - Neighborhood Collection - Brick Red|MPXP2">
                            <div class="as-tilegallery-element as-image-selected">
                                <div class=""></div>
                                <img src="{{ asset('assets/003.jpg') }}"
                                     class="ir ir item-image as-producttile-image" alt="" width="445"
                                     height="445"
                                     style="content:-webkit-image-set(url({{ $product['img'] }}) 2x);">
                            </div>

                        </div>


                    </div>


                </div>

            </div>
            <div class="as-producttile-info" style="float:left;min-height: 168px;">
                <div class="as-producttile-titlepricewraper" style="min-height: 128px;">
                    <div class="as-producttile-title">
                        <h3 class="as-producttile-name">
                            <p class="as-producttile-tilelink">
                                <span data-ase-truncate="2">{{ $product['title'] }}</span>
                            </p>

                        </h3>
                    </div>
                    <h3>
                        {{ '$' . $product['price'] }}
                    </h3>
                    <h3>
                        {{ $product['unit'] }}
                    </h3>
                </div>
                <div class="payment-button"></div>
                {{--                    <button type="submit" class="" formmethod="post">Pagar</button>--}}
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://www.mercadopago.com/v2/security.js" view="item"></script>
    <script>
        const mp = new MercadoPago('{{ $publicKey }}', {
            'locale': 'pt-BR'
        })

        mp.checkout({
            preference: {
                id: '{{ $preference }}'
            },
            render: {
                container: '.payment-button',
                label: 'Pagar',
            }
        });
    </script>
@endpush
