@extends('template')

@section('main')
    <div class="container-fluid container-fluid-90 margin-top-85 min-height">
        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-12 mb-5 main-panel p-5 border rounded">
                <div class="pb-3 m-0 text-24 font-weight-700">Mobile Banking Payment</div>
                <form action="{{URL::to('payments/mobile-payment')}}" method="post" id="payment-form"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row justify-content-center">
                        <input name="property_id" type="hidden" value="{{ $property_id }}">
                        <input name="checkin" type="hidden" value="{{ $checkin }}">
                        <input name="checkout" type="hidden" value="{{ $checkout }}">
                        <input name="number_of_guests" type="hidden" value="{{ $number_of_guests }}">
                        <input name="nights" type="hidden" value="{{ $nights }}">
                        <input name="currency" type="hidden" value="{{ $result->property_price->code }}">
                        <input name="booking_id" type="hidden" value="{{ $id }}">
                        <input name="booking_type" type="hidden" value="{{ $booking_type }}">

                        <div class="col-sm-12 p-0">
                            <label for="message">Please select a mobile banking account number</label>
                        </div>

                        <div class="col-sm-12 p-0 pb-3">
                            <select id="mobile-select" required name="mobile" class="form-control mb20">
                                @foreach($mobiles as $mobile)
                                    <option value="{{ $mobile->id }}" @if($loop->first) selected @endif>
                                        {{ $mobile->name . " " . $mobile->mobile_no }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-12 p-0 pb-3">
                            @foreach($mobiles as $mobile)
                                <div class="mobiles {{ $loop->first ? '' : 'hide' }}" id="{{ $mobile->id }}">
                                    <p>{{ $mobile->message }}</p>
                                    <img src="{{ asset('public/front/images/mobile_bankings/' . $mobile->image) }}" width="200" height="100">
                                </div>
                            @endforeach
                        </div>

                        <div class="col-sm-12 p-3 my-2 border-ddd border-r-10">
                            <table class="table table-borderless">
                                <tr>
                                    <td>Enter transaction number<span class="danger-text">*</span>:</td>
                                </tr>
                                <tbody>
                                <tr>
                                    <td>
                                        <textarea
                                            class="form-control"
                                            required name="note"
                                            type="text">{{old('note')}}</textarea>
                                        <span class="text-danger">{{ $errors->first('note') }}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12 p-0 text-right mt-4">
                        <button id="payment-form-submit" type="submit"
                                class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3">
                            <i class="spinner fa fa-spinner fa-spin d-none"></i>
                            {{trans('messages.general.confirm')}}
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-md-4 mb-5">
                <div class="card p-3">
                    <a href="{{ url('/') }}/properties/{{$result->slug}}">
                        <img class="card-img-top p-2 rounded" src="{{$result->cover_photo}}" alt="{{$result->name}}"
                             height="180px">
                    </a>
                    <div class="card-body p-2">
                        <a href="{{ url('/') }}/properties/{{$result->slug}}"><p
                                class="text-16 font-weight-700 mb-0">{{ $result->name }}</p></a>
                        <p class="text-14 mt-2 text-muted mb-0">
                            <i class="fas fa-map-marker-alt"></i>
                            {{$result->property_address->address_line_1}}, {{ $result->property_address->state }}
                            , {{ $result->property_address->country_name }}
                        </p>
                        <div class="border p-4 mt-4 text-center">
                            <p class="text-16 mb-0">
                                <strong
                                    class="font-weight-700 secondary-text-color">{{ $result->property_type_name }}</strong>
                                {{trans('messages.payment.for')}}
                                <strong
                                    class="font-weight-700 secondary-text-color">{{ $number_of_guests }} {{trans('messages.payment.guest')}}</strong>
                            </p>
                            <div class="text-14"><strong>{{ date('D, M d, Y', strtotime($checkin)) }}</strong> to
                                <strong>{{ date('D, M d, Y', strtotime($checkout)) }}</strong></div>
                        </div>

                        <div class="border p-4 mt-3">
                            @foreach( $price_list->date_with_price as $date_price)
                                <div class="d-flex justify-content-between text-16">
                                    <div>
                                        <p class="pl-4">{{ $date_price->date }}</p>
                                    </div>
                                    <div>
                                        <p class="pr-4">{!! $date_price->price !!}</p>
                                    </div>
                                </div>
                            @endforeach
                            <hr>
                            <div class="d-flex justify-content-between text-16">
                                <div>
                                    <p class="pl-4">{{trans('messages.payment.night')}}</p>
                                </div>
                                <div>
                                    <p class="pr-4">{{ $nights }}</p>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between text-16">
                                <div>
                                    <p class="pl-4">{!! $price_list->per_night_price_with_symbol !!}
                                        x {{ $nights }} {{trans('messages.payment.nights')}}</p>
                                </div>
                                <div>
                                    <p class="pr-4">{!! $price_list->total_night_price_with_symbol !!}</p>
                                </div>
                            </div>

                            @if($price_list->service_fee)
                                <div class="d-flex justify-content-between text-16">
                                    <div>
                                        <p class="pl-4">{{trans('messages.payment.service_fee')}}</p>
                                    </div>

                                    <div>
                                        <p class="pr-4">{!! $price_list->service_fee_with_symbol !!}</p>
                                    </div>
                                </div>
                            @endif

                            @if($price_list->additional_guest)
                                <div class="d-flex justify-content-between text-16">
                                    <div>
                                        <p class="pl-4">{{trans('messages.payment.additional_guest_fee')}}</p>
                                    </div>

                                    <div>
                                        <p class="pr-4">{!! $price_list->additional_guest_fee_with_symbol !!}</p>
                                    </div>
                                </div>
                            @endif

                            @if($price_list->security_fee)
                                <div class="d-flex justify-content-between text-16">
                                    <div>
                                        <p class="pl-4">{{trans('messages.payment.security_deposit')}}</p>
                                    </div>

                                    <div>
                                        <p class="pr-4">{!! $price_list->security_fee_with_symbol !!}</p>
                                    </div>
                                </div>
                            @endif

                            @if($price_list->cleaning_fee)
                                <div class="d-flex justify-content-between text-16">
                                    <div>
                                        <p class="pl-4">{{trans('messages.payment.cleaning_fee')}}</p>
                                    </div>

                                    <div>
                                        <p class="pr-4">{!! $price_list->cleaning_fee_with_symbol !!}</p>
                                    </div>
                                </div>
                            @endif

                            @if($price_list->iva_tax)
                                <div class="d-flex justify-content-between text-16">
                                    <div>
                                        <p class="pl-4">{{trans('messages.property_single.iva_tax')}}</p>
                                    </div>

                                    <div>
                                        <p class="pr-4">{!!  $price_list->iva_tax_with_symbol !!}</p>
                                    </div>
                                </div>
                            @endif

                            @if($price_list->accomodation_tax)
                                <div class="d-flex justify-content-between text-16">
                                    <div>
                                        <p class="pl-4">{{trans('messages.property_single.accommodatiton_tax')}}</p>
                                    </div>

                                    <div>
                                        <p class="pr-4">{!! $price_list->accomodation_tax_with_symbol !!}</p>
                                    </div>
                                </div>
                            @endif
                            <hr>

                            <div class="d-flex justify-content-between font-weight-700 text-16">
                                <div>
                                    <p class="pl-4">{{trans('messages.payment.total')}}</p>
                                </div>

                                <div>
                                    <p class="pr-4">{!! $price_list->total_with_symbol !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-16">
                        <p class="exfont">
                            {{trans('messages.payment.paying_in')}}
                            <strong><span
                                    id="payment-currency">{!!moneyFormat($currencyDefault->symbol,$currencyDefault->code)!!}</span></strong>.
                            {{trans('messages.payment.your_total_charge')}}
                            <strong><span
                                    id="payment-total-charge">{!! moneyFormat($currencyDefault->org_symbol, $price_eur) !!}</span></strong>.
                            {{trans('messages.payment.exchange_rate_booking')}} {!! $symbol !!} 1
                            to {!! moneyFormat($price_list->property_default->symbol, $price_list->property_default->local_to_propertyRate ) !!} {!! $price_list->property_default->currency_code !!}
                            ( {{trans('messages.listing_book.host_currency')}} ).
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <style>
            .bank-logo {
                margin: 0;
                text-align: left;
                max-height: 50px;
                max-width: 120px;
                object-fit: contain;
            }

            .hide {
                display: none;
            }

            strong {
                font-weight: bold !important;
            }

            td {
                width: 50% !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script type="text/javascript" src="{{ url('public/js/jquery.validate.min.js') }}"></script>
        <script type="text/javascript">
            $(document).on('change', '#mobile-select', () => {
                $('.mobiles').hide();
                $('#' + $('#mobile-select').val()).show();
            })
        </script>
    @endpush
@stop
