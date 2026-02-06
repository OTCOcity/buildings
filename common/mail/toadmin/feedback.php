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
                                    <p><b><?=$form->name?></b></p>
                                    <p>Контакты: <?=$form->phone?></p>
                                    <p>Сообщение: <?=$form->text?></p>
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
                                    <em>Copyright © <?=\frontend\components\MiscFunc::getThreadData('options', 'sitename')?> <?= date('Y');?></em><br>
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
