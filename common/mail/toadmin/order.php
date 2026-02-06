<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;border:0;max-width:600px!important">
    <tbody><tr>
        <td valign="top" style="background-color:#fafafa;border-top:0;border-bottom:0;padding-top:9px;padding-bottom:9px"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
                <tbody>
                <tr>
                    <td valign="top" style="padding-top:9px;padding-right:18px;padding-bottom:9px;padding-left:18px">
                        <table align="right" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ffffff;border-collapse:collapse">
                            <tbody><tr>
                                <td align="center" valign="top" style="padding-top:18px;padding-right:18px;padding-bottom:0;padding-left:18px">
                                    <h1><?=Yii::$app->params['siteName']?></h1>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding:9px 18px;font-family:Helvetica;font-size:14px;font-weight:normal;word-break:break-word;color:#656565;line-height:150%;text-align:left" width="528">
                                </td>
                            </tr>
                            </tbody></table>
                    </td>
                </tr>
                </tbody>
            </table></td>
    </tr>
    <tr>
        <td valign="top" style="background-color:#ffffff;border-top:0;border-bottom:0;padding-top:9px;padding-bottom:0"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;border-collapse:collapse">
                <tbody>
                <tr>
                    <td valign="top">
                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;border-collapse:collapse">
                            <tbody><tr>
                                <td valign="top" style="padding:9px 18px;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:20px;font-style:normal;font-weight:normal;line-height:100%;text-align:center;word-break:break-word;color:#202020">

                                    <?=$subject?>

                                </td>
                            </tr>
                            </tbody></table>

                    </td>
                </tr>
                </tbody>
            </table><table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;border-collapse:collapse;table-layout:fixed!important">
                <tbody>
                <tr>
                    <td style="min-width:100%;padding:18px">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;border-top-width:2px;border-top-style:solid;border-top-color:#eaeaea;border-collapse:collapse">
                            <tbody><tr>
                                <td>
                                    <span></span>
                                </td>
                            </tr>
                            </tbody></table>
                    </td>
                </tr>
                </tbody>
            </table></td>
    </tr>
    <tr>
        <td valign="top" style="background-color:#ffffff;border-top:0;border-bottom:2px solid #eaeaea;padding-top:0;padding-bottom:9px"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;border-collapse:collapse">
                <tbody>
                <tr>
                    <td valign="top">
                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;border-collapse:collapse">
                            <tbody><tr>
                                <td valign="top" style="padding:9px 18px;font-size:14px;word-break:break-word;color:#202020;font-family:Helvetica;line-height:150%;text-align:left">
                                    <h3>Новый заказ № <?=$order->name?></h3>
                                    <p><b>Стоимость закза:</b> <?=$order->sum_itog?> Р</p>
                                    <br>
                                    <h3>Данные пользователя</h3>
                                    <p><b>Имя:</b> <?=$order->client_name?></p>
                                    <p><b>Телефон:</b> <?=$order->client_phone?></p>
                                    <p><b>Email:</b> <?=$order->client_email?></p>
                                    <br>
                                    <h3>Доставка и оплата</h3>
                                    <p><b>Тип оплаты:</b> <?=$order->pay_type == 1 ? "НАЛИЧЫМИ ПРИ ПОЛУЧЕНИИ" : "НА КАРТУ СБЕРБАНКА"?></p>
                                    <p><b>Адрес доставки:</b> <?=$order->deliv_adres?></p>
                                    <br>
                                    <?php if  ($order->comment): ?>
                                        <h3>Комментарии к заказу</h3>
                                        <p><?=$order->comment?></p>
                                    <?php endif; ?>
                                    <br>
                                    <h3>Список товаров</h3>
                                    <table>
                                        <tr>
                                            <th style="font-size: 12px; text-align: center;padding: 0 5px;">№</th>
                                            <th style="font-size: 12px; text-align: left;padding: 0 5px;">Артикул</th>
                                            <th style="font-size: 12px; text-align: left;padding: 0 5px;">Наименование</th>
                                            <th style="font-size: 12px; text-align: center;padding: 0 5px;">Цена, Р</th>
                                            <th style="font-size: 12px; text-align: center;padding: 0 5px;">Кол</th>
                                            <th style="font-size: 12px; text-align: center;padding: 0 5px;">Стоимость, Р</th>
                                        </tr>
                                        <?php foreach ($cartItems as $key => $item):?>
                                            <tr>
                                                <td style="font-size: 12px; text-align: center;padding: 0 10px;"><?=($key + 1)?>.</td>
                                                <td style="font-size: 12px; text-align: left;padding: 0 10px;"><?=$item->good['article']?></td>
                                                <td style="font-size: 12px; text-align: left;padding: 0 10px;"><?=$item->good['name'];?> (<?=$item->size;?>)</td>
                                                <td style="font-size: 12px; text-align: center;padding: 0 10px;"><?=$item->good['price'];?></td>
                                                <td style="font-size: 12px; text-align: center;padding: 0 10px;"><?=$item->count;?></td>
                                                <td style="font-size: 12px; text-align: center;padding: 0 10px;"><?=$item->count * $item->good['price'];?></td>
                                            </tr>
                                        <?php endforeach;?>
                                    </table>
                                </td>
                            </tr>
                            </tbody></table>

                    </td>
                </tr>
                </tbody>
            </table></td>
    </tr>
    <tr>
        <td valign="top" style="background-color:#fafafa;border-top:0;border-bottom:0;padding-top:9px;padding-bottom:9px"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;border-collapse:collapse">
                <tbody>
                <tr>
                    <td valign="top" style="padding-top:9px">
                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%;min-width:100%;border-collapse:collapse" width="100%">
                            <tbody><tr>
                                <td valign="top" style="padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;word-break:break-word;color:#656565;font-family:Helvetica;font-size:12px;line-height:150%;text-align:center">
                                    <em>Copyright © <?=\frontend\components\MiscFunc::getThreadData('options', 'sitename')?> 2016</em><br>
                                    <strong>Телефон: </strong><?=\frontend\components\MiscFunc::getThreadData('options', 'phone')?><br>
                                    <strong>Email:</strong> <a href="mailto:<?=\frontend\components\MiscFunc::getThreadData('options', 'email')?>" target="_blank"><?=\frontend\components\MiscFunc::getThreadData('options', 'email')?></a>
                                </td>
                            </tr>
                            </tbody></table>
                    </td>
                </tr>
                </tbody>
            </table></td>
    </tr>
    </tbody></table>
