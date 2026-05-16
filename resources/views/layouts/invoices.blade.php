<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <meta name="robots" content="noindex,nofollow" />
    <title>{{ env('APP_NAME') }}</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <style type="text/css">
        #lineItem tr {
            page-break-inside: avoid;
            page-break-after:auto;
        }
    </style>
</head>
<body>
<div style="font-family: Sans-serif;font-size: 10pt;line-height: 14pt;color: #333333;">
    <div style="padding: 0 0.40in 0 0.55in;">
        <table style="width:100%;margin-top:30px;table-layout:fixed;border-spacing: 0;border-collapse: collapse;">
            <tbody>
            <tr>
                <td style="vertical-align:bottom;word-wrap:break-word;float:left;width:50%;text-align:left;">
                    <b style="font-size:14pt;">{{ env('WEBSITE') }}</b><br>
                    <b>{{ env('COMPANY_NAME') }}</b><br/>
                    <div>
                        <span style="white-space: pre-wrap;" id="tmp_org_address">{{ env('COMPANY_ADDRESS') }} <br/>Mo.: {{ env('COMPANY_MOBILE') }}<br/>Email: {{ env('INFO_EMAIL') }}<br/>CIN No.: {{ env('CIN_NO') }}<br/>GST No.: {{ env('GST_NO') }}</span>
                    </div>
                </td>
                <td style="vertical-align:top;word-wrap:break-word;float:right;text-align:right;width:50%;">
                    <span style="font-size: 28pt;color: #817d7d;">INVOICE</span>
                    <br>
                    <div style="clear:both;margin-top:20px;">
                        <span><b>Invoice No</b></span>
                        <br>
                        <b>{{ $invoice->inv_prefix.$invoice->inv_number }}</b>
                        <br><br>
                        <span><b>Invoice Date</b></span>
                        <br>
                        <b>{{ displayDate($invoice->inv_date) }}</b>
                        <br>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <table style="width:100%;margin-top:30px;table-layout:fixed;border-spacing: 0;border-collapse: collapse;">
            <tbody>
            <tr>
                <td style="vertical-align:bottom;word-wrap: break-word;">
                    <div>
                        <label style="font-size: 10pt;color: #817d7d;" id="tmp_billing_address_label">Bill To</label><br>
                        <strong>{{ $users->first_name.' '.$users->last_name }}</strong><br>
                        <span style="white-space: pre-wrap;" id="tmp_billing_address">
                            {{ $users->city != '' || $users->city != null ? $users->city : 'N/A' }}
                            <br/>
                            (M)&nbsp;{{ $users->mobile }}<br/>
                            (E)&nbsp;{{ $users->email }}<br/>
                        </span>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <div style="margin-top:20px;width:100%;">
            <span></span>
        </div>

        <table style="width:100%;margin-top:20px;table-layout:fixed;border-spacing: 0;border-collapse: collapse;" class="pcs-itemtable" border="0" cellpadding="0" cellspacing="0">
            <thead>
            <tr style="height:32px;">
                <td style="font-size: 10pt;color: #ffffff;background-color: #3c3d3a;padding:5px 10px 5px 10px;word-wrap: break-word;width: 60%;">
                    Item
                </td>
                <td style="font-size: 10pt;color: #ffffff;background-color: #3c3d3a;padding:5px 10px 5px 5px;word-wrap: break-word;width: 15%;" align="right">
                    Qty
                </td>
                <td style="font-size: 10pt;color: #ffffff;background-color: #3c3d3a;padding:5px 10px 5px 5px;word-wrap: break-word;width:25%;" align="right">
                    Amount (<span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>)
                </td>
            </tr>
            </thead>
            <tbody id="lineitem">
            <tr>
                <td style="font-size: 10pt;border-bottom: 1px solid #e3e3e3;color: #000000;padding: 10px 0px 10px 10px;" valign="top">
                    <span style="word-wrap: break-word;" id="tmp_item_name">SelfApply Plan</span>
                    <br>
                    <span style="color: #525252;white-space: pre-wrap;word-wrap: break-word;" id="tmp_item_description">Number - {{ $card->card_number }}</span>
                    <br>
                    <span style="color: #525252;white-space: pre-wrap;word-wrap: break-word;" id="tmp_item_description">Validity - {{ displayDate($card->registration_date)." to ".displayDate($card->expiry_date) }}</span>
                </td>
                <td style="font-size: 10pt;border-bottom: 1px solid #e3e3e3;color: #000000;padding: 10px 10px 5px 10px;text-align:right;word-wrap: break-word;" valign="top">
                    <span id="tmp_item_qty">1</span>
                </td>
                <td style="font-size: 10pt;border-bottom: 1px solid #e3e3e3;color: #000000;text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" valign="top">{{ formatePriceIndia($invoices->inv_price) }} ?>
                </td>
            </tr>
            </tbody>
        </table>

        <table style="width:100%;margin-top:3px;table-layout:fixed;border-spacing: 0;border-collapse: collapse;">
            <tbody>
            <tr>
                <td style="font-size: 10pt;text-align:right;padding:5px 10px 5px 5px;word-wrap:break-word;width:70%;" align="right" valign="middle"><b>SUB TOTAL</b>
                </td>
                <td id="tmp_total" style="font-size: 10pt;text-align:right;padding:5px 10px 5px 5px;word-wrap:break-word;width:30%;" align="right" valign="middle">
                    <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{ formatePriceIndia($invoices->inv_price) }}
                    <br>
                </td>
            </tr>

            @if($invoices->inv_cgst > 0)
            <tr>
                <td style="font-size: 10pt;text-align:right;padding:5px 10px 5px 5px;word-wrap:break-word;width:70%;" align="right" valign="middle"><b>+ 9% CGST</b>
                </td>
                <td id="tmp_total" style="font-size: 10pt;text-align:right;padding:5px 10px 5px 5px;word-wrap:break-word;width:30%;" align="right" valign="middle"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{ formatePriceIndia($invoices->inv_cgst) }}
                    <br>
                </td>
            </tr>
            @endif

            @if($invoices->inv_sgst > 0)
            <tr>
                <td style="font-size: 10pt;text-align:right;padding:5px 10px 5px 5px;word-wrap:break-word;width:70%;" align="right" valign="middle"><b>+ 9% SGST</b>
                </td>
                <td id="tmp_total" style="font-size: 10pt;text-align:right;padding:5px 10px 5px 5px;word-wrap:break-word;width:30%;" align="right" valign="middle">
                    <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{ formatePriceIndia($invoices->inv_sgst) }}
                    <br>
                </td>
            </tr>
            @endif

            @if($invoices->inv_igst > 0)
            <tr>
                <td style="font-size: 10pt;text-align:right;padding:5px 10px 5px 5px;word-wrap:break-word;width:70%;" align="right" valign="middle"><b>+ 18% IGST</b>
                </td>
                <td id="tmp_total" style="font-size: 10pt;text-align:right;padding:5px 10px 5px 5px;word-wrap:break-word;width:30%;" align="right" valign="middle"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{ formatePriceIndia($invoices->inv_igst) }}
                    <br>
                </td>
            </tr>
            @endif

            <tr>
                <td style="font-size: 10pt;border-top: 1px solid #e3e3e3;text-align:right;padding:5px 10px 5px 5px;word-wrap:break-word;width:70%;" align="right" valign="middle"><b>GRAND TOTAL</b>
                </td>
                <td id="tmp_total" style="font-size: 10pt;border-top: 1px solid #e3e3e3;text-align:right;padding:5px 10px 5px 5px;word-wrap:break-word;width:30%;font-size:12pt;" align="right" valign="middle"><b><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{ formatePriceIndia($invoices->inv_grandtotal }}</b>
                    <br>
                </td>
            </tr>
            </tbody>
        </table>

        <table style="width:100%;margin-top:30px;table-layout:fixed;border-spacing: 0;border-collapse: collapse;">
            <tbody>
            <tr>
                <td style="vertical-align:bottom;word-wrap:break-word;float:left;width:50%;text-align:left;">
                    <label style="font-size: 10pt;color: #817d7d;" id="tmp_notes_label">Payment Details</label>
                    <br/>
                    <p style="margin-top:7px;white-space: pre-wrap;word-wrap: break-word;font-size: 8pt;">Payment Method: Online Payment<br>Payment Id: {{ $card->paymentid }}
                    </p>
                    <br/>
                    <label style="font-size: 10pt;color: #817d7d;" id="tmp_terms_label">Note</label>
                    <br/>
                    <p style="margin-top:7px;white-space: pre-wrap;word-wrap: break-word;font-size: 8pt;">Payment is refundable only in accordance with the company's Cancellation & Refund Policy.</p>
                </td>

                <td style="vertical-align:bottom;word-wrap:break-word;float:right;width:50%;text-align:right;">
                    <p style="margin-top:20px;white-space: pre-wrap;word-wrap: break-word;font-size: 8pt;"><em>Authorized person</em><br/><span style="margin-top:20px;margin-bottom:7px;"><strong> {{ env('COMPANY_NAME') }} </strong></span></p>
                </td>
            </tr>
            </tbody>
        </table>

        <table style="width:100%;margin-top:30px;table-layout:fixed;border-spacing: 0;border-collapse: collapse;">
            <tbody>
            <tr>
                <td style="vertical-align:bottom;word-wrap:break-word;float:center;text-align:center;">
                    <p style="font-size:8pt;font-family:monospace;">This is Computer generated Invoice. Does not require any signature.</p>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</div>
</body>
</html>
