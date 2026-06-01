<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="font-family: Montserrat, Google Sans, Segoe UI, Roboto, Arial, Ubuntu, sans-serif;">
    <head>
        <meta charset="UTF-8" />
        <meta content="width=device-width,initial-scale=1" name="viewport" />
        <meta name="x-apple-disable-message-reformatting" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="telephone=no" name="format-detection" />
        <title>{{ env('APP_NAME') }}</title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:500,800&display=swap&subset=cyrillic-ext" rel="stylesheet" />
        <style type="text/css">
            .rollover div {
            font-size: 0;
            }
            .rollover:hover .rollover-first {
            max-height: 0 !important;
            display: none !important;
            }
            .rollover:hover .rollover-second {
            max-height: none !important;
            display: block !important;
            }
            #outlook a {
            padding: 0;
            }
            .es-button {
            mso-style-priority: 100 !important;
            text-decoration: none !important;
            }
            a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            }
            .es-desk-hidden {
            display: none;
            float: left;
            overflow: hidden;
            width: 0;
            max-height: 0;
            line-height: 0;
            mso-hide: all;
            }
            @media only screen and (max-width: 600px) {
            a,
            ol li,
            p,
            ul li {
            line-height: 150% !important;
            }
            h1,
            h1 a,
            h2,
            h2 a,
            h3,
            h3 a {
            line-height: 120%;
            }
            h1 {
            font-size: 30px !important;
            text-align: left;
            }
            h2 {
            font-size: 24px !important;
            text-align: left;
            }
            h3 {
            font-size: 20px !important;
            text-align: left;
            }
            .es-content-body h1 a,
            .es-footer-body h1 a,
            .es-header-body h1 a {
            font-size: 30px !important;
            text-align: left;
            }
            .es-content-body h2 a,
            .es-footer-body h2 a,
            .es-header-body h2 a {
            font-size: 24px !important;
            text-align: left;
            }
            .es-content-body h3 a,
            .es-footer-body h3 a,
            .es-header-body h3 a {
            font-size: 20px !important;
            text-align: left;
            }
            .es-menu td a {
            font-size: 14px !important;
            }
            .es-header-body a,
            .es-header-body ol li,
            .es-header-body p,
            .es-header-body ul li {
            font-size: 14px !important;
            }
            .es-content-body a,
            .es-content-body ol li,
            .es-content-body p,
            .es-content-body ul li {
            font-size: 14px !important;
            }
            .es-footer-body a,
            .es-footer-body ol li,
            .es-footer-body p,
            .es-footer-body ul li {
            font-size: 12px !important;
            }
            .es-infoblock a,
            .es-infoblock ol li,
            .es-infoblock p,
            .es-infoblock ul li {
            font-size: 12px !important;
            }
            [class="gmail-fix"] {
            display: none !important;
            }
            .es-m-txt-c,
            .es-m-txt-c h1,
            .es-m-txt-c h2,
            .es-m-txt-c h3 {
            text-align: center !important;
            }
            .es-m-txt-r,
            .es-m-txt-r h1,
            .es-m-txt-r h2,
            .es-m-txt-r h3 {
            text-align: right !important;
            }
            .es-m-txt-l,
            .es-m-txt-l h1,
            .es-m-txt-l h2,
            .es-m-txt-l h3 {
            text-align: left !important;
            }
            .es-m-txt-c img,
            .es-m-txt-l img,
            .es-m-txt-r img {
            display: inline !important;
            }
            .es-button-border {
            display: inline-block !important;
            }
            a.es-button,
            button.es-button {
            font-size: 13px !important;
            display: inline-block !important;
            }
            .es-adaptive table,
            .es-left,
            .es-right {
            width: 100% !important;
            }
            .es-content,
            .es-content table,
            .es-footer,
            .es-footer table,
            .es-header,
            .es-header table {
            width: 100% !important;
            max-width: 600px !important;
            }
            .es-adapt-td {
            display: block !important;
            width: 100% !important;
            }
            .adapt-img {
            width: 100% !important;
            height: auto !important;
            }
            .es-m-p0 {
            padding: 0 !important;
            }
            .es-m-p0r {
            padding-right: 0 !important;
            }
            .es-m-p0l {
            padding-left: 0 !important;
            }
            .es-m-p0t {
            padding-top: 0 !important;
            }
            .es-m-p0b {
            padding-bottom: 0 !important;
            }
            .es-m-p20b {
            padding-bottom: 20px !important;
            }
            .es-hidden,
            .es-mobile-hidden {
            display: none !important;
            }
            table.es-desk-hidden,
            td.es-desk-hidden,
            tr.es-desk-hidden {
            width: auto !important;
            overflow: visible !important;
            float: none !important;
            max-height: inherit !important;
            line-height: inherit !important;
            }
            tr.es-desk-hidden {
            display: table-row !important;
            }
            table.es-desk-hidden {
            display: table !important;
            }
            td.es-desk-menu-hidden {
            display: table-cell !important;
            }
            .es-menu td {
            width: 1% !important;
            }
            .esd-block-html table,
            table.es-table-not-adapt {
            width: auto !important;
            }
            table.es-social {
            display: inline-block !important;
            }
            table.es-social td {
            display: inline-block !important;
            }
            .es-m-p5 {
            padding: 5px !important;
            }
            .es-m-p5t {
            padding-top: 5px !important;
            }
            .es-m-p5b {
            padding-bottom: 5px !important;
            }
            .es-m-p5r {
            padding-right: 5px !important;
            }
            .es-m-p5l {
            padding-left: 5px !important;
            }
            .es-m-p10 {
            padding: 10px !important;
            }
            .es-m-p10t {
            padding-top: 10px !important;
            }
            .es-m-p10b {
            padding-bottom: 10px !important;
            }
            .es-m-p10r {
            padding-right: 10px !important;
            }
            .es-m-p10l {
            padding-left: 10px !important;
            }
            .es-m-p15 {
            padding: 15px !important;
            }
            .es-m-p15t {
            padding-top: 15px !important;
            }
            .es-m-p15b {
            padding-bottom: 15px !important;
            }
            .es-m-p15r {
            padding-right: 15px !important;
            }
            .es-m-p15l {
            padding-left: 15px !important;
            }
            .es-m-p20 {
            padding: 20px !important;
            }
            .es-m-p20t {
            padding-top: 20px !important;
            }
            .es-m-p20r {
            padding-right: 20px !important;
            }
            .es-m-p20l {
            padding-left: 20px !important;
            }
            .es-m-p25 {
            padding: 25px !important;
            }
            .es-m-p25t {
            padding-top: 25px !important;
            }
            .es-m-p25b {
            padding-bottom: 25px !important;
            }
            .es-m-p25r {
            padding-right: 25px !important;
            }
            .es-m-p25l {
            padding-left: 25px !important;
            }
            .es-m-p30 {
            padding: 30px !important;
            }
            .es-m-p30t {
            padding-top: 30px !important;
            }
            .es-m-p30b {
            padding-bottom: 30px !important;
            }
            .es-m-p30r {
            padding-right: 30px !important;
            }
            .es-m-p30l {
            padding-left: 30px !important;
            }
            .es-m-p35 {
            padding: 35px !important;
            }
            .es-m-p35t {
            padding-top: 35px !important;
            }
            .es-m-p35b {
            padding-bottom: 35px !important;
            }
            .es-m-p35r {
            padding-right: 35px !important;
            }
            .es-m-p35l {
            padding-left: 35px !important;
            }
            .es-m-p40 {
            padding: 40px !important;
            }
            .es-m-p40t {
            padding-top: 40px !important;
            }
            .es-m-p40b {
            padding-bottom: 40px !important;
            }
            .es-m-p40r {
            padding-right: 40px !important;
            }
            .es-m-p40l {
            padding-left: 40px !important;
            }
            .es-m-margin {
            padding-left: 20px !important;
            padding-right: 20px !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            }
            .es-desk-hidden {
            display: table-row !important;
            width: auto !important;
            overflow: visible !important;
            max-height: inherit !important;
            }
            }
        </style>
    </head>
    <body style="width: 100%; font-family: Montserrat, Google Sans, Segoe UI, Roboto, Arial, Ubuntu, sans-serif; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; padding: 0; margin: 0;">
        <div class="es-wrapper-color" style="background-color: #f9f9f9;">
            <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="
                mso-table-lspace: 0;
                mso-table-rspace: 0;
                border-collapse: collapse;
                border-spacing: 0;
                padding: 0;
                margin: 0;
                width: 100%;
                height: 100%;
                background-repeat: repeat;
                background-position: center top;
                background-image: url(https://quikborrow.com/assets/images/mail-bgm.png);
                background-color: #f9f9f9;
                " background="https://quikborrow.com/front/images/bg-01.webp">
                <tbody>
                    <tr>
                        <td class="es-m-margin" valign="top" style="padding: 0; margin: 0;">
                            <table class="es-header" cellspacing="0" cellpadding="0" align="center" style="
                                mso-table-lspace: 0;
                                mso-table-rspace: 0;
                                border-collapse: collapse;
                                border-spacing: 0;
                                table-layout: fixed !important;
                                width: 100%;
                                background-color: transparent;
                                background-repeat: repeat;
                                background-position: center top;
                                ">
                                <tbody>
                                    <tr>
                                        <td align="center" style="padding: 0; margin: 0;">
                                            <table class="es-header-body" cellspacing="0" cellpadding="0" align="center"
                                                style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: collapse; border-spacing: 0; background-color: transparent; width: 600px;">
                                                <tbody>
                                                    <tr>
                                                        <td align="center"
                                                            style="padding: 0; margin: 0; padding-top: 10px; padding-bottom: 10px;">
                                                            <table class="es-left" cellspacing="0" cellpadding="0"
                                                                align="center"
                                                                style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: collapse; border-spacing: 0; float: center;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="es-m-p0r" valign="top" align="center"
                                                                            style="padding: 0; margin: 0; width: 300px;">
                                                                            <table width="100%" cellspacing="0"
                                                                                cellpadding="0" role="presentation"
                                                                                style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: collapse; border-spacing: 0;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center"
                                                                                            class="es-m-txt-c"
                                                                                            style="padding: 0; margin: 0; padding-top: 5px; font-size: 0;">
                                                                                            <a target="_blank"
                                                                                                href="https://quikborrow.com/"
                                                                                                style="-webkit-text-size-adjust: none; -ms-text-size-adjust: none; mso-line-height-rule: exactly; text-decoration: underline; color: #000f26; font-size: 14px;">
                                                                                            <img src="https://quikborrow.com/front/images/logo/logo.png"
                                                                                                alt="quikborrow"
                                                                                                style="display: block; border: 0; outline: 0; text-decoration: none; -ms-interpolation-mode: bicubic;"
                                                                                                width="190"
                                                                                                title="quikborrow">
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: collapse; border-spacing: 0; table-layout: fixed !important; width: 100%;">
                                <tr>
                                    <td align="center" style="padding: 0; margin: 0;">
                                        <table
                                            class="es-content-body"
                                            cellspacing="0"
                                            cellpadding="0"
                                            align="center"
                                            style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: collapse; border-spacing: 0; background-color: transparent; width: 600px;"
                                            >
                                            <tr>
                                                <td align="left" style="padding: 0; margin: 0; padding-top: 10px; padding-bottom: 20px;">
                                                    <table cellpadding="0" cellspacing="0" class="es-left" align="left" style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: collapse; border-spacing: 0; float: left;">
                                                        <tr>
                                                            <td class="es-m-p20b" align="left" style="padding: 0; margin: 0; width: 600px;">
                                                                <table
                                                                    cellpadding="0"
                                                                    cellspacing="0"
                                                                    width="100%"
                                                                    bgcolor="#ffffff"
                                                                    style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: separate; border-spacing: 0; background-color: #fff; border-radius: 15px;"
                                                                    role="presentation"
                                                                    >
                                                                    <tr>
                                                                        <td align="left" style="padding: 20px; margin: 0; line-height: 2rem;border: 1px solid green;
                                                                            border-radius: 12px;
                                                                            background-color: #E9F2FB;">
                                                                            @yield('content')
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table class="es-footer" cellspacing="0" cellpadding="0" align="center" style="
                                mso-table-lspace: 0;
                                mso-table-rspace: 0;
                                border-collapse: collapse;
                                border-spacing: 0;
                                table-layout: fixed !important;
                                width: 100%;
                                background-color: transparent;
                                background-repeat: repeat;
                                background-position: center top;
                                ">
                                <tbody>
                                    <tr>
                                        <td align="center" style="padding: 0; margin: 0;">
                                            <table class="es-footer-body" cellspacing="0" cellpadding="0" align="center"
                                                style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: collapse; border-spacing: 0; background-color: transparent; width: 600px;">
                                                <tbody>
                                                    <tr>
                                                        <td align="left"
                                                            style="padding: 20px; margin: 0; border-radius: 15px; background-color: #fff;"
                                                            bgcolor="#ffffff">
                                                            <table cellspacing="0" cellpadding="0" width="100%"
                                                                style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: collapse; border-spacing: 0;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="es-m-p0r" valign="top" align="center"
                                                                            style="padding: 0; margin: 0; width: 560px;">
                                                                            <table width="100%" cellspacing="0"
                                                                                cellpadding="0" role="presentation"
                                                                                style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: collapse; border-spacing: 0;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center"
                                                                                            style="padding: 0; margin: 0;">
                                                                                            <p style="
                                                                                                margin: 0;
                                                                                                -webkit-text-size-adjust: none;
                                                                                                -ms-text-size-adjust: none;
                                                                                                mso-line-height-rule: exactly;
                                                                                                font-family: Montserrat, Google Sans, Segoe UI, Roboto, Arial, Ubuntu, sans-serif;
                                                                                                line-height: 21px;
                                                                                                color: #000f26;
                                                                                                font-size: 14px;
                                                                                                ">
                                                                                                <a target="_blank"
                                                                                                    style="-webkit-text-size-adjust: none; -ms-text-size-adjust: none; mso-line-height-rule: exactly; text-decoration: none; color: #000f26; font-size: 14px;"
                                                                                                    href="https://quikborrow.com/privacy-policy">
                                                                                                Privacy Policy
                                                                                                </a>
                                                                                                &nbsp; | &nbsp;
                                                                                                <a target="_blank"
                                                                                                    style="-webkit-text-size-adjust: none; -ms-text-size-adjust: none; mso-line-height-rule: exactly; text-decoration: none; color: #000f26; font-size: 14px;"
                                                                                                    href="https://quikborrow.com/terms-and-conditions">
                                                                                                Terms &amp; Conditions
                                                                                                </a>
                                                                                                &nbsp; | &nbsp;
                                                                                                <a target="_blank"
                                                                                                    style="-webkit-text-size-adjust: none; -ms-text-size-adjust: none; mso-line-height-rule: exactly; text-decoration: none; color: #000f26; font-size: 14px;"
                                                                                                    href="https://quikborrow.com/contact-us">
                                                                                                Raise a request
                                                                                                </a>
                                                                                                &nbsp; | &nbsp;
                                                                                                <a target="_blank"
                                                                                                    style="-webkit-text-size-adjust: none; -ms-text-size-adjust: none; mso-line-height-rule: exactly; text-decoration: none; color: #000f26; font-size: 14px;"
                                                                                                    href="https://quikborrow.com">
                                                                                                Visit Website
                                                                                                </a>
                                                                                            </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td align="center"
                                                                                            style="padding: 10px; margin: 0; font-size: 0;">
                                                                                            <table border="0" width="80%"
                                                                                                height="100%"
                                                                                                cellpadding="0"
                                                                                                cellspacing="0"
                                                                                                role="presentation"
                                                                                                style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: collapse; border-spacing: 0;">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td
                                                                                                            style="padding: 0; margin: 0; border-bottom: 1px solid #ccc; background: unset; height: 1px; width: 100%; margin: 0;">
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td align="center"
                                                                                            style="padding: 0; margin: 0; padding-top: 10px;">
                                                                                            <p style="
                                                                                                margin: 0;
                                                                                                -webkit-text-size-adjust: none;
                                                                                                -ms-text-size-adjust: none;
                                                                                                mso-line-height-rule: exactly;
                                                                                                font-family: Montserrat, Google Sans, Segoe UI, Roboto, Arial, Ubuntu, sans-serif;
                                                                                                line-height: 21px;
                                                                                                color: #000f26;
                                                                                                font-size: 14px;
                                                                                                line-height: 24px;
                                                                                                ">
                                                                                                <strong>{{ env('COMPANY_NAME') }}</strong><br>{{ env('COMPANY_ADDRESS') }}<br>
                                                                                                Mobile:
                                                                                                <a target="_blank"
                                                                                                    style="-webkit-text-size-adjust: none; -ms-text-size-adjust: none; mso-line-height-rule: exactly; text-decoration: none; color: #000f26; font-size: 14px;"
                                                                                                    href="tel:09429214352">
                                                                                                +91-94292-14352
                                                                                                </a>
                                                                                                | Email:
                                                                                                <a href="mailto:info@quikborrow.com"
                                                                                                    style="-webkit-text-size-adjust: none; -ms-text-size-adjust: none; mso-line-height-rule: exactly; text-decoration: none; color: #000f26; font-size: 14px;">
                                                                                                info@quikborrow.com
                                                                                                </a>
                                                                                            </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td align="center"
                                                                                            style="padding: 0; margin: 0; padding-top: 15px; padding-bottom: 15px; font-size: 0;">
                                                                                            <table cellpadding="0"
                                                                                                cellspacing="0"
                                                                                                class="es-table-not-adapt es-social"
                                                                                                role="presentation"
                                                                                                style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: collapse; border-spacing: 0;">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td align="center"
                                                                                                            valign="top"
                                                                                                            style="padding: 0; margin: 0; padding-right: 10px;">
                                                                                                            <a target="_blank"
                                                                                                                href="https://twitter.com/quikborrow"
                                                                                                                style="
                                                                                                                -webkit-text-size-adjust: none;
                                                                                                                -ms-text-size-adjust: none;
                                                                                                                mso-line-height-rule: exactly;
                                                                                                                text-decoration: underline;
                                                                                                                color: #000f26;
                                                                                                                font-size: 14px;
                                                                                                                ">
                                                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                                    id="Capa_1"
                                                                                                                    data-name="Capa 1"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    height="25"
                                                                                                                    width="25">
                                                                                                                    <polygon
                                                                                                                        points="6.861 6.159 15.737 17.764 17.097 17.764 8.322 6.159 6.861 6.159">
                                                                                                                    </polygon>
                                                                                                                    <path
                                                                                                                        d="m12,0C5.373,0,0,5.373,0,12s5.373,12,12,12,12-5.373,12-12S18.627,0,12,0Zm3.063,19.232l-3.87-5.055-4.422,5.055h-2.458l5.733-6.554-6.046-7.91h5.062l3.494,4.621,4.043-4.621h2.455l-5.361,6.126,6.307,8.337h-4.937Z">
                                                                                                                    </path>
                                                                                                                </svg>
                                                                                                            </a>
                                                                                                        </td>
                                                                                                        <td align="center"
                                                                                                            valign="top"
                                                                                                            style="padding: 0; margin: 0; padding-right: 10px;">
                                                                                                            <a target="_blank"
                                                                                                                href="https://in.pinterest.com/quikborrow/"
                                                                                                                style="
                                                                                                                -webkit-text-size-adjust: none;
                                                                                                                -ms-text-size-adjust: none;
                                                                                                                mso-line-height-rule: exactly;
                                                                                                                text-decoration: underline;
                                                                                                                color: #000f26;
                                                                                                                font-size: 14px;
                                                                                                                ">
                                                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                                                    version="1.1"
                                                                                                                    id="Capa_1"
                                                                                                                    x="0px"
                                                                                                                    y="0px"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    style="enable-background:new 0 0 24 24;"
                                                                                                                    xml:space="preserve"
                                                                                                                    width="25"
                                                                                                                    height="25">
                                                                                                                    <g>
                                                                                                                        <path
                                                                                                                            d="M12.01,0C5.388,0,0.02,5.368,0.02,11.99c0,5.082,3.158,9.424,7.618,11.171c-0.109-0.947-0.197-2.408,0.039-3.444   c0.217-0.938,1.401-5.961,1.401-5.961s-0.355-0.72-0.355-1.776c0-1.668,0.967-2.911,2.171-2.911c1.026,0,1.52,0.77,1.52,1.688   c0,1.026-0.651,2.566-0.997,3.997c-0.286,1.194,0.602,2.171,1.776,2.171c2.132,0,3.77-2.25,3.77-5.487   c0-2.872-2.062-4.875-5.013-4.875c-3.414,0-5.418,2.556-5.418,5.201c0,1.026,0.395,2.132,0.888,2.734   C7.52,14.615,7.53,14.724,7.5,14.842c-0.089,0.375-0.296,1.194-0.336,1.362c-0.049,0.217-0.178,0.266-0.405,0.158   c-1.5-0.701-2.438-2.882-2.438-4.648c0-3.78,2.743-7.253,7.924-7.253c4.155,0,7.391,2.961,7.391,6.928   c0,4.135-2.605,7.461-6.217,7.461c-1.214,0-2.359-0.632-2.743-1.382c0,0-0.602,2.289-0.75,2.852   c-0.266,1.046-0.997,2.349-1.49,3.148C9.562,23.812,10.747,24,11.99,24c6.622,0,11.99-5.368,11.99-11.99C24,5.368,18.632,0,12.01,0   z">
                                                                                                                        </path>
                                                                                                                    </g>
                                                                                                                </svg>
                                                                                                            </a>
                                                                                                        </td>
                                                                                                        <td align="center"
                                                                                                            valign="top"
                                                                                                            style="padding: 0; margin: 0; padding-right:10px">
                                                                                                            <a target="_blank"
                                                                                                                href="http://www.youtube.com/@quikborrow"
                                                                                                                style="
                                                                                                                -webkit-text-size-adjust: none;
                                                                                                                -ms-text-size-adjust: none;
                                                                                                                mso-line-height-rule: exactly;
                                                                                                                text-decoration: underline;
                                                                                                                color: #000f26;
                                                                                                                font-size: 14px;
                                                                                                                ">
                                                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                                                    version="1.1"
                                                                                                                    id="Capa_1"
                                                                                                                    x="0px"
                                                                                                                    y="0px"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    style="enable-background:new 0 0 24 24;"
                                                                                                                    xml:space="preserve"
                                                                                                                    width="25"
                                                                                                                    height="25">
                                                                                                                    <g
                                                                                                                        id="XMLID_184_">
                                                                                                                        <path
                                                                                                                            d="M23.498,6.186c-0.276-1.039-1.089-1.858-2.122-2.136C19.505,3.546,12,3.546,12,3.546s-7.505,0-9.377,0.504   C1.591,4.328,0.778,5.146,0.502,6.186C0,8.07,0,12,0,12s0,3.93,0.502,5.814c0.276,1.039,1.089,1.858,2.122,2.136   C4.495,20.454,12,20.454,12,20.454s7.505,0,9.377-0.504c1.032-0.278,1.845-1.096,2.122-2.136C24,15.93,24,12,24,12   S24,8.07,23.498,6.186z M9.546,15.569V8.431L15.818,12L9.546,15.569z">
                                                                                                                        </path>
                                                                                                                    </g>
                                                                                                                </svg>
                                                                                                            </a>
                                                                                                        </td>
                                                                                                        <td align="center"
                                                                                                            valign="top"
                                                                                                            style="padding: 0; margin: 0;padding-right:10px">
                                                                                                            <a target="_blank"
                                                                                                                href="https://www.facebook.com/@quikborrow.in"
                                                                                                                style="
                                                                                                                -webkit-text-size-adjust: none;
                                                                                                                -ms-text-size-adjust: none;
                                                                                                                mso-line-height-rule: exactly;
                                                                                                                text-decoration: underline;
                                                                                                                color: #000f26;
                                                                                                                font-size: 14px;
                                                                                                                ">
                                                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                                                    version="1.1"
                                                                                                                    id="Capa_1"
                                                                                                                    x="0px"
                                                                                                                    y="0px"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    style="enable-background:new 0 0 24 24;"
                                                                                                                    xml:space="preserve"
                                                                                                                    width="25"
                                                                                                                    height="25">
                                                                                                                    <g>
                                                                                                                        <path
                                                                                                                            d="M24,12.073c0,5.989-4.394,10.954-10.13,11.855v-8.363h2.789l0.531-3.46H13.87V9.86c0-0.947,0.464-1.869,1.95-1.869h1.509   V5.045c0,0-1.37-0.234-2.679-0.234c-2.734,0-4.52,1.657-4.52,4.656v2.637H7.091v3.46h3.039v8.363C4.395,23.025,0,18.061,0,12.073   c0-6.627,5.373-12,12-12S24,5.445,24,12.073z">
                                                                                                                        </path>
                                                                                                                    </g>
                                                                                                                </svg>
                                                                                                            </a>
                                                                                                        </td>
                                                                                                        <td align="center"
                                                                                                            valign="top"
                                                                                                            style="padding: 0; margin: 0;">
                                                                                                            <a target="_blank"
                                                                                                                href="https://www.instagram.com/quikborrow/"
                                                                                                                style="
                                                                                                                -webkit-text-size-adjust: none;
                                                                                                                -ms-text-size-adjust: none;
                                                                                                                mso-line-height-rule: exactly;
                                                                                                                text-decoration: underline;
                                                                                                                color: #000f26;
                                                                                                                font-size: 14px;
                                                                                                                ">
                                                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                                                    version="1.1"
                                                                                                                    id="Capa_1"
                                                                                                                    x="0px"
                                                                                                                    y="0px"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    style="enable-background:new 0 0 24 24;"
                                                                                                                    xml:space="preserve"
                                                                                                                    width="25"
                                                                                                                    height="25">
                                                                                                                    <g>
                                                                                                                        <path
                                                                                                                            d="M12,2.162c3.204,0,3.584,0.012,4.849,0.07c1.308,0.06,2.655,0.358,3.608,1.311c0.962,0.962,1.251,2.296,1.311,3.608   c0.058,1.265,0.07,1.645,0.07,4.849c0,3.204-0.012,3.584-0.07,4.849c-0.059,1.301-0.364,2.661-1.311,3.608   c-0.962,0.962-2.295,1.251-3.608,1.311c-1.265,0.058-1.645,0.07-4.849,0.07s-3.584-0.012-4.849-0.07   c-1.291-0.059-2.669-0.371-3.608-1.311c-0.957-0.957-1.251-2.304-1.311-3.608c-0.058-1.265-0.07-1.645-0.07-4.849   c0-3.204,0.012-3.584,0.07-4.849c0.059-1.296,0.367-2.664,1.311-3.608c0.96-0.96,2.299-1.251,3.608-1.311   C8.416,2.174,8.796,2.162,12,2.162 M12,0C8.741,0,8.332,0.014,7.052,0.072C5.197,0.157,3.355,0.673,2.014,2.014   C0.668,3.36,0.157,5.198,0.072,7.052C0.014,8.332,0,8.741,0,12c0,3.259,0.014,3.668,0.072,4.948c0.085,1.853,0.603,3.7,1.942,5.038   c1.345,1.345,3.186,1.857,5.038,1.942C8.332,23.986,8.741,24,12,24c3.259,0,3.668-0.014,4.948-0.072   c1.854-0.085,3.698-0.602,5.038-1.942c1.347-1.347,1.857-3.184,1.942-5.038C23.986,15.668,24,15.259,24,12   c0-3.259-0.014-3.668-0.072-4.948c-0.085-1.855-0.602-3.698-1.942-5.038c-1.343-1.343-3.189-1.858-5.038-1.942   C15.668,0.014,15.259,0,12,0z">
                                                                                                                        </path>
                                                                                                                        <path
                                                                                                                            d="M12,5.838c-3.403,0-6.162,2.759-6.162,6.162c0,3.403,2.759,6.162,6.162,6.162s6.162-2.759,6.162-6.162   C18.162,8.597,15.403,5.838,12,5.838z M12,16c-2.209,0-4-1.791-4-4s1.791-4,4-4s4,1.791,4,4S14.209,16,12,16z">
                                                                                                                        </path>
                                                                                                                        <circle
                                                                                                                            cx="18.406"
                                                                                                                            cy="5.594"
                                                                                                                            r="1.44">
                                                                                                                        </circle>
                                                                                                                    </g>
                                                                                                                </svg>
                                                                                                            </a>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" style="padding: 10px; margin: 0;">
                                                            <table width="100%" cellspacing="0" cellpadding="0"
                                                                style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: collapse; border-spacing: 0;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td valign="top" align="center"
                                                                            style="padding: 0; margin: 0; width: 580px;">
                                                                            <table width="100%" cellspacing="0"
                                                                                cellpadding="0" role="presentation"
                                                                                style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: collapse; border-spacing: 0;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center"
                                                                                            style="padding: 0; margin: 0;">
                                                                                            <p style="
                                                                                                margin: 0;
                                                                                                -webkit-text-size-adjust: none;
                                                                                                -ms-text-size-adjust: none;
                                                                                                mso-line-height-rule: exactly;
                                                                                                font-family: Montserrat, Google Sans, Segoe UI, Roboto, Arial, Ubuntu, sans-serif;
                                                                                                line-height: 18px;
                                                                                                color: #000f26;
                                                                                                font-size: 12px;
                                                                                                "> 
                                                                                                {{ date('Y') }} © <strong>
                                                                                                {{ env('COMPANY_NAME') }}.
                                                                                                </strong>
                                                                                            </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>