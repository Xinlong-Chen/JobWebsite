<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmail/src/Exception.php';
require 'phpmail/src/PHPMailer.php';
require 'phpmail/src/SMTP.php';
function send($to,$title)
{
    $mail = new PHPMailer(true);                              // 如果输入true，则开启调试模式
    try {
        //服务器配置
        $mail->CharSet = "UTF-8";                     //设定邮件编码
        $mail->SMTPDebug = 0;                        // 调试模式输出
        $mail->isSMTP();                             // 使用SMTP
        $mail->Host = 'smtp.qq.com';                // SMTP服务器
        $mail->SMTPAuth = true;                      // 允许 SMTP 认证
        $mail->Username = '2815641541@qq.com';                // SMTP 用户名  即邮箱的用户名,有的是邮箱账号
        $mail->Password = '***';             // SMTP 密码  部分邮箱是授权码(例如qq邮箱)
        $mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议,QQ邮箱为ssl
        $mail->Port = 465;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持，QQ邮箱为465

        $mail->setFrom('2815641541@qq.com', '哈理工就业处');  //发件人
        $mail->addAddress($to);  // 收件人，第二个参数传不传无所谓
        $mail->addReplyTo('2815641541@qq.com', '哈理工就业处'); //回复的时候回复给哪个邮箱 建议和发件人一致
        //$mail->addCC('cc@example.com');                    //抄送
        //$mail->addBCC('bcc@example.com');                    //密送

        //发送附件
        // $mail->addAttachment('../xy.zip');         // 添加附件
        // $mail->addAttachment('../thumb-1.jpg', 'new.jpg');    // 发送附件并且重命名

        //Content
        $mail->isHTML(true);                                  // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
        $mail->Subject = $title;
        $mail->Body = '<h1>嘤！你好！</h1>' . date('Y-m-d H:i:s');
        $mail->AltBody = '你好！';

        $mail->send();
        echo '邮件发送成功';
    } catch (Exception $e) {
        echo '邮件发送失败: ', $mail->ErrorInfo;
    }
}
function sendmany($to,$title,$body)
{
    $mail = new PHPMailer(true);
    try {
        $mail->CharSet = "UTF-8";
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.qq.com';
        $mail->SMTPAuth = true;
        $mail->Username = '2815641541@qq.com';
        $mail->Password = '***';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('2815641541@qq.com', '哈理工就业处');

        $arrlength=count($to);

        for($x=0;$x<$arrlength;$x++)
        {
            echo $to[$x];
            $mail->addAddress($to[$x]);
        }
        $mail->addReplyTo('2815641541@qq.com', '哈理工就业处');

        $mail->isHTML(true);
        $mail->Subject = $title;
        $mail->Body = $body ;
        $mail->AltBody = '你好！';

        $mail->send();
        echo '邮件发送成功';
    } catch (Exception $e) {
        echo '邮件发送失败: ', $mail->ErrorInfo;
    }
}
//$too=array("1326803579@qq.com","cxl_17@hrbust.edu.cn");
//sendmany($too,"哈理工招聘会邀请函");
?>

