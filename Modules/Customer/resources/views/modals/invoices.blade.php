<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="author" content="" />

        <title>{{ env('APP_NAME') }}</title>
        <link rel="stylesheet" href="{{ asset('assets/css/invoice.css') }}" />
        <style>
            .watermark {
                position: fixed;
                top: 40%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-45deg);
                font-size: 80px;
                z-index: 9999;
                white-space: nowrap;
                pointer-events: none;
                user-select: none;
                font-weight: bold;
                opacity: 0.15;
                padding: 20px 40px;
                border: 5px solid currentColor;
                border-radius: 10px;
            }
        
            .watermark.paid {
                color: green;
            }
        
            .watermark.cancelled {
                color: red;
            }
        </style>
    </head>

    <body>
        @if($invoice && $invoice->is_refund == 1)
            <div class="watermark cancelled">CANCELLED</div>
        @endif
        <div class="tm_container">
            <div class="tm_invoice_wrap">
                <div class="tm_invoice tm_style2 tm_type1 tm_accent_border tm_radius_0 tm_small_border" id="tm_download_section">
                    <div class="tm_invoice_in">
                        <div class="tm_invoice_head tm_mb20 tm_m0_md">
                            <div class="tm_invoice_left">
                                <div class="tm_logo logo-width"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" /></div>
                            </div>
                            <div class="tm_invoice_right" style="width:70%;margin-left:10px;">
                                <div class="tm_grid_row tm_col_12">
                                    <div class="tm_f14">
                                        <b>{{ env('COMPANY_NAME') }}</b><br />
                                        {{ env('COMPANY_ADDRESS') }}
                                    </div>
                                </div>
                            </div>
                            <div class="tm_shape_bg tm_accent_bg_10 tm_border tm_accent_border_20"></div>
                        </div>
                        <div class="tm_invoice_info tm_mb30 tm_align_center">
                            <div class="tm_invoice_left" style="width:30%;">
                                <div class="tm_f14">
                                    <p class="tm_mb0">
                                        <b class="tm_primary_color">Invoice No: </b>{{ $invoice->inv_prefix.$invoice->inv_number }} <br />
                                        <b class="tm_primary_color">Invoice Date: </b>{{ displayDate($invoice->inv_date) }}
                                    </p>
                                </div>
                            </div>
                            <div class="tm_invoice_right" style="width:37%;">
                                <div class="tm_f14">
                                    <p class="tm_mb0">
                                        <b class="tm_primary_color">CIN No: </b> {{ env('CIN_NO') }}<br />
                                        <b class="tm_primary_color">GST No: </b> {{ env('GST_NO') }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <div class="tm_f14">
                                    <p class="tm_mb0">
                                        <b class="tm_primary_color">Mobile: </b> {{ env('COMPANY_MOBILE') }}<br />
                                        <b class="tm_primary_color">Email: </b> {{ env('INFO_EMAIL') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2 class="tm_f16 tm_section_heading tm_accent_border_20 tm_mb0">
                        <span class="tm_accent_bg_10 tm_radius_0 tm_curve_35 tm_border tm_accent_border_20 tm_border_bottom_0 tm_accent_color"><span>Invoice To</span></span>
                    </h2>
                    <div class="tm_table tm_style1 tm_mb30">
                        <div class="tm_border tm_accent_border_20 tm_border_top_0">
                            <div class="tm_table_responsive">
                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="tm_width_6 tm_border_top_0 tm_f14"><b class="tm_primary_color tm_medium">Name: </b>{{ $users->first_name.' '.$users->last_name }}</td>
                                        <td class="tm_width_6 tm_border_top_0 tm_border_left tm_accent_border_20 tm_f14"><b class="tm_primary_color tm_medium">Phone: </b> {{ $users->mobile }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tm_width_6 tm_accent_border_20 tm_f14"><b class="tm_primary_color tm_medium">Email: </b>{{ $users->email }}</td>
                                        <td class="tm_width_6 tm_border_left tm_accent_border_20 tm_f14"><b class="tm_primary_color tm_medium">Address: </b>{{ $users->city != '' || $users->city != null ? $users->city : 'N/A' }},{{ $users->state != '' || $users->state != null ? $users->state : 'N/A' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tm_table tm_style1">
                        <div class="tm_border tm_accent_border_20">
                            <div class="tm_table_responsive">
                                <table>
                                    <thead>
                                    <tr>
                                        <th class="tm_width_1 tm_semi_bold tm_accent_color tm_accent_bg_10 tm_f14">#</th>
                                        <th class="tm_width_5 tm_semi_bold tm_accent_color tm_accent_bg_10 tm_f14">Items</th>
                                        <th class="tm_width_1 tm_semi_bold tm_accent_color tm_text_right tm_accent_bg_10 tm_f14">Qty</th>
                                        <th class="tm_width_2 tm_semi_bold tm_accent_color tm_text_right tm_accent_bg_10 tm_f14">Amount(&#8377;)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="tm_width_1 tm_accent_border_20 tm_f14">1</td>
                                        <td class="tm_width_5 tm_accent_border_20 tm_f14">
                                            <b>{{ (($users->acc_type == 1) ? 'Self Apply' : 'Loan Agent') }}</b><br />
                                            <span class="tm_f12">Number - {{ $card->card_number }}</span><br />
                                            <span class="tm_f12">Validity - {{ displayDate($card->registration_date)." to ".displayDate($card->expiry_date) }}</span>
                                        </td>
                                        <td class="tm_width_1 tm_accent_border_20 tm_f14 tm_text_center">1</td>
                                        <td class="tm_width_2 tm_accent_border_20 tm_text_right tm_f14">{{ formatePriceIndia($invoice->inv_price) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tm_invoice_footer tm_mb15 tm_m0_md">
                            <div class="tm_left_footer tm_note">
                                <p class="tm_mb2"><b class="tm_primary_color">Payment Details</b></p>
                                <p class="tm_m0 tm_f12">
                                    Payment Method: Online Payment <br />
                                    Payment Id: {{ $card->paymentid }}
                                </p>
                            </div>
                            <div class="tm_right_footer">
                                <table class="tm_mb15 tm_m0_md">
                                    <tbody>
                                    <tr>
                                        <td class="tm_width_3 tm_primary_color tm_border_none tm_medium tm_f14">Subtoal</td>
                                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_medium tm_f14">&#8377;{{ formatePriceIndia($invoice->inv_price) }}</td>
                                    </tr>
                                    @if($invoice->inv_cgst > 0)
                                    <tr>
                                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0 tm_f14">+ 9% CGST</td>
                                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_f14 tm_pt0">&#8377;{{ formatePriceIndia($invoice->inv_cgst) }}</td>
                                    </tr>
                                    @endif
                                    @if($invoice->inv_sgst > 0)
                                    <tr>
                                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0 tm_f14">+ 9% SGST</td>
                                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_f14 tm_pt0">&#8377;{{ formatePriceIndia($invoice->inv_sgst) }}</td>
                                    </tr>
                                    @endif
                                    @if($invoice->inv_igst > 0)
                                    <tr>
                                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0 tm_f14">+ 18% IGST</td>
                                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_f14 tm_pt0">&#8377;{{ formatePriceIndia($invoice->inv_igst) }}</td>
                                    </tr>
                                    @endif
                                    <tr class="tm_accent_border_20 tm_border">
                                        <td class="tm_width_3 tm_bold tm_f16 tm_border_top_0 tm_accent_color tm_accent_bg_10">Grand Total</td>
                                        <td class="tm_width_3 tm_bold tm_f16 tm_border_top_0 tm_accent_color tm_text_right tm_accent_bg_10">&#8377;{{ formatePriceIndia($invoice->inv_grandtotal) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tm_invoice_footer tm_type1">
                            <div class="tm_left_footer">
                                <p class="tm_mb2"><b class="tm_primary_color">Note</b></p>
                                <p class="tm_m0 tm_f12">
                                    Payment is refundable only in accordance with the company's <br />
                                    Cancellation & Refund Policy.
                                </p>
                            </div>
                            <div class="tm_right_footer cust_authorized">
                                <div class="tm_sign tm_text_center">
                                    <p class="tm_m0 tm_ternary_color">{{ env('COMPANY_NAME') }}</p>
                                    <p class="tm_m0 tm_12 tm_primary_color">Authorized Person</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tm_bottom_invoice tm_accent_border_20">
                        <div class="tm_bottom_invoice_center">
                            <p class="tm_m0 tm_f12">This is Computer generated Invoice. Does not require any signature.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tm_invoice_btns tm_hide_print">
                <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
                        <span class="tm_btn_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                                <path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></path>
                                <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></rect>
                                <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></path>
                                <circle cx="392" cy="184" r="24" fill="currentColor"></circle>
                            </svg>
                        </span>
                    <span class="tm_btn_text">Print</span>
                </a>
                {{--<button id="tm_download_btn" class="tm_invoice_btn tm_color2">
                        <span class="tm_btn_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                                <path
                                    d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2-60 5.7-112 35.88-112 98.4S70 336 136 336h56M192 400.1l64 63.9 64-63.9M256 224v224.03"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="32"
                                ></path>
                            </svg>
                        </span>
                    <span class="tm_btn_text">Download</span>
                </button>--}}
            </div>
        </div>
    </body>
</html>
