<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<?php $this->load->view('email/style'); ?>
<body style="background: #D1D2DD;">
    <div class="mj-container" style="background-color:#D1D2DD;">
        <?php $this->load->view('email/header'); ?>
        <div style="margin:0px auto;max-width:600px;background:#244F67;">
            <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#244F67;" align="center" border="0">
                <tbody>
                    <tr>
                        <td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:0px 0px 0px 0px;">
                            <!--[if mso | IE]>      <table role="presentation" border="0" cellpadding="0" cellspacing="0">        <tr>          <td style="vertical-align:top;width:300px;">      <![endif]-->
                            <div class="mj-column-per-50 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100% !important;">
                                <table role="presentation" cellpadding="0" cellspacing="0" style="vertical-align:top;" width="100%" border="0">
                                    <tbody>
                                        <tr>
                                            <td style="word-wrap:break-word;font-size:0px;">
                                                <div style="font-size: 12px;color: #fff;margin: 10px;font-family:Ubuntu, Helvetica, Arial, sans-serif;">
                                                    <?php $this->load->view($page); ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--[if mso | IE]>      </td><td style="vertical-align:top;width:300px;">      <![endif]-->
                            <div class="mj-column-per-50 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%;">
                                <table role="presentation" cellpadding="0" cellspacing="0" style="vertical-align:top;" width="100%" border="0">
                                    <tbody></tbody>
                                </table>
                            </div>
                            <!--[if mso | IE]>      </td></tr></table>      <![endif]-->
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php $this->load->view('email/footer'); ?>
    </div>
</body>

</html>